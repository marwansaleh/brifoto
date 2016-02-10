<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of User_m
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Usergroup_m extends MY_Model {
    protected $_table_name = 'bfc_comp_user_groups';
    protected $_primary_key = 'group_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'group_name';
    
    private $_ADMIN_GROUP_ID = 1;
    
    public $rules = array(
        'group_name' => array(
            'field' => 'group_name', 
            'label' => 'group name', 
            'rules' => 'trim|required|xss_clean'
        ),
        'is_removable' => array(
            'field' => 'is_removable', 
            'label' => 'removable', 
            'rules' => 'trim|numeric|xss_clean'
        )
    );
    
    public function delete($id) {
        $is_removable = $this->get_value('is_removable', array('group_id'=>$id));
        if ($is_removable == 0){
            $this->_last_message = 'This group can not be deleted';
            return FALSE;
        }
        return parent::delete($id);
    }
    
    public function save($data, $id = NULL) {
        
        if (isset($data['group_name'])){
            $check = array('group_name'=>$data['group_name']);
            if ($id){
                $check['group_id !='] = $id;
            }
            if ($this->get_count($check)){
                $this->_last_message = 'Duplicate entry for group name '.$data['group_name'];
                
                return FALSE;
            }
        }
        
        return parent::save($data, $id);
    }
}

/*
 * file location: engine/application/models/users/user_m.php
 */