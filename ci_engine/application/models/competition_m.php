<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Competition_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Competition_m extends MY_Model {
    protected $_table_name = 'bfc_competition';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'name';
    
    public $rules = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Competition name', 
            'rules' => 'required|trim|xss_clean'
        ),
        'title' => array(
            'field' => 'title', 
            'label' => 'Competition title', 
            'rules' => 'trim|xss_clean'
        )
    );
}

/*
 * file location: /application/models/competition_m.php
 */
