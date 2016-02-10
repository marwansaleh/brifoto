<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Member_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Member_m extends MY_Model {
    protected $_table_name = 'bfc_competition_members';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'reg_time desc';
    
    public $rules = array(
        'nama' => array(
            'field' => 'nama', 
            'label' => 'Member name', 
            'rules' => 'required|trim|xss_clean'
        ),
        'hp' => array(
            'field' => 'hp', 
            'label' => 'Mobile no', 
            'rules' => 'trim|xss_clean'
        ),
        'pn' => array(
            'field' => 'pn', 
            'label' => 'Personal no', 
            'rules' => 'trim|xss_clean'
        ),
        'unit' => array(
            'field' => 'unit', 
            'label' => 'Unit', 
            'rules' => 'trim|xss_clean'
        )
    );
}

/*
 * file location: /application/models/member_m.php
 */
