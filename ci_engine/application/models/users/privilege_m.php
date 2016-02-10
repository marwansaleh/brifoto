<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Privilege_m
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Privilege_m extends MY_Model {
    protected $_table_name = 'bfc_comp_user_roles';
    protected $_primary_key = 'role_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'role_name';
    
    private $_table_useraccess = 'bfc_comp_user_access';
    
    public $rules = array(
        'role_name' => array(
            'field' => 'role_name', 
            'label' => 'role_name name', 
            'rules' => 'trim|required|xss_clean'
        )
    );
    
    public function delete($id) {
        $result = parent::delete($id);
        if ($result){
            $this->db->delete($this->_table_useraccess, array('role_id' => $id)); 
        }
        
        return $result;
    }
}

/*
 * file location: engine/application/models/users/privilege_m.php
 */