<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of User_m
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class User_m extends MY_Model {
    protected $_table_name = 'bfc_comp_users';
    protected $_primary_key = 'user_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'full_name';
    
    private $_table_roles = 'bfc_comp_user_roles';
    private $_table_access = 'bfc_comp_user_access';
    private $_table_groups = 'bfc_comp_user_groups';
    private $_ADMIN_GROUP_ID = 1;
    private $_prefix_session_access = '_BFC_';
    
    public $rules_login = array(
        'user_name' => array(
            'field' => 'user_name', 
            'label' => 'User name', 
            'rules' => 'trim|required|xss_clean'
        ),
        'password' => array(
            'field' => 'password', 
            'label' => 'Password', 
            'rules' => 'trim|required|xss_clean'
        )
    );
    
    public $rules_update = array(
        'user_name' => array(
            'field' => 'user_name', 
            'label' => 'User name', 
            'rules' => 'trim|required|xss_clean'
        ),
        'group_id' => array(
            'field' => 'group_id', 
            'label' => 'Privilege', 
            'rules' => 'trim|numeric|required|xss_clean'
        )
    );
    
    public $rules_profile = array(
        'user_name' => array(
            'field' => 'user_name', 
            'label' => 'User name', 
            'rules' => 'trim|xss_clean'
        ),
        'group_id' => array(
            'field' => 'group_id', 
            'label' => 'Privilege', 
            'rules' => 'trim|numeric|xss_clean'
        )
    );
    
    public function __construct() {
        parent::__construct();
        $this->last_access();
    }
    
    public function last_access(){
        if ($this->isLoggedin()){
            $sql = 'UPDATE '. $this->db->dbprefix($this->_table_name).' SET last_access='.time().',is_loggedin=1 WHERE user_id='.$this->session->userdata('userid');
            $this->db->simple_query($sql);
        }
    }
    
    public function save($data, $id = NULL) {
        
        if (isset($data['user_name'])){
            $check = array('user_name'=>$data['user_name']);
            if ($id){
                $check['user_id !='] = $id;
            }
            if ($this->get_count($check)){
                $this->_last_message = 'Duplicate entry for username '.$data['user_name'];
                
                return FALSE;
            }
        }
        
        return parent::save($data, $id);
    }
    
    public function isLoggedin(){
        if ($this->session->userdata('isloggedin')){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function get_user_info($user_id, $info='user_name'){
        $user = $this->get_select_where($info, array($this->_primary_key=>$user_id), TRUE);
        if ($user){
            return $user->$info;
        }
        
        return 'none';
    }
    
    public function login($user_name, $password){
        //get user specific
        $user = $this->get_by(array('user_name'=>$user_name, 'is_active'=>1), TRUE);
        
        if ($user){
            if ($user->password == $this->hash($password)){
                
                //get user type privileges
                $group = $this->db->select('group_name')->from($this->_table_groups)->where('group_id', $user->group_id)->get()->row();
                if ($group){
                    $user->group_name = $group->group_name;
                }else{
                    $user->group_name = 'Unknown';
                }
                
                //create user loggedin session
                $this->_create_login_session($user);
                //create user privileges session
                $this->_set_user_access_session($user->group_id);
                
                return $user;
            }
        }
        
        return FALSE;
    }
    
    public function logout(){
        if ($this->isLoggedin()){
            $user_id = $this->session->userdata('userid');
            
            //update database
            $this->save(array(
                'is_loggedin'   => 0
            ), $user_id);
            
            $this->session->sess_destroy();
        }
        
        return TRUE;
    }
    
    private function _create_login_session($user){
        //Update database
        $this->save(array(
            'last_login'    => time(),
            'last_ip'       => $this->input->ip_address(),
            'is_loggedin'   => 1
        ), $user->user_id);
        
        //create session for detail user
        $user_session = array(
            'isloggedin'        => TRUE,
            'group_id'          => $user->group_id,
            'group_name'        => $user->group_name,
            'is_administrator'  => $this->is_admin($user->group_id),
            'user_name'         => $user->user_name,
            'userid'            => $user->user_id,
            'full_name'        => $user->full_name,
            'last_login'        => $user->last_login>0 ? $user->last_login : time(),
            'last_ip'           => $user->last_ip
        );
        
        $this->session->set_userdata($user_session);
    }
    
    private function _set_user_access_session($group_id){
        //get roles defined for this group
        foreach ($this->get_group_access($group_id) as $g_role){
            $group_roles [$g_role->role_id] = $g_role->has_access == 1?TRUE:FALSE;
        }
        
        //get all roles
        $access_roles = array();
        foreach ($this->get_all_roles() as $role){
            if ($group_id == $this->_ADMIN_GROUP_ID){
                $access_roles[$this->_prefix_session_access . $role->role_name] = TRUE;
            }else{
                $access_roles[$this->_prefix_session_access . $role->role_name] = isset($group_roles[$role->role_id]) ? $group_roles[$role->role_id] : FALSE;
            }
        }
        
        $this->session->set_userdata($access_roles);
    }
    
    public function has_access($role_name){
        return $this->session->userdata($this->_prefix_session_access . $role_name);
    }
    
    public function is_email_exists($email_addr){
        return $this->get_count(array('email'=>$email_addr)) > 0;
    }
    
    public function is_username_exists($user_name){
        return $this->get_count(array('user_name'=>$user_name)) > 0;
    }
    
    public function hash($subject){
        return hash('sha512', config_item('encryption_key') . $subject);
    }
    
    public function get_all_roles(){
        return $this->db->select('*')->from($this->_table_roles)->get()->result();
    }
    
    public function get_group_access($group_id){
        return $this->db->select('*')->from($this->_table_access)->where('group_id', $group_id)->get()->result();
    }
    
    public function is_admin($group_id=NULL){
        if (!$group_id){
            return $this->session->userdata('is_administrator');
        }else{
            return ($group_id == $this->_ADMIN_GROUP_ID);
        }
    }
}

/*
 * file location: engine/application/models/users/user_m.php
 */