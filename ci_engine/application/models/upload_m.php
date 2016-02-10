<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Upload_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Upload_m extends MY_Model {
    protected $_table_name = 'bfc_competition_uploads';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'comp_id, upload_time desc';
    
    public $rules = array(
        'comp_id' => array(
            'field' => 'comp_id', 
            'label' => 'Competition ID', 
            'rules' => 'required|numeric|xss_clean'
        ), 
        'member_id' => array(
            'field' => 'member_id', 
            'label' => 'Member ID', 
            'rules' => 'required|numeric|xss_clean'
        )
    );
}

/*
 * file location: /application/models/upload_m.php
 */
