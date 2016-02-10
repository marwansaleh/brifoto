<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Nominee_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Nominee_m extends MY_Model {
    protected $_table_name = 'bfc_comp_nominee';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'comp_id desc, stage desc';
    
    public $rules = array(
        'comp_id' => array(
            'field' => 'competition_id', 
            'label' => 'Competition name', 
            'rules' => 'required|trim|xss_clean'
        ),
        'stage_id' => array(
            'field' => 'stage_id', 
            'label' => 'stage title', 
            'rules' => 'trim|xss_clean'
        ),
        'item_id' => array(
            'field' => 'item_id', 
            'label' => 'item id', 
            'rules' => 'trim|xss_clean'
        )
    );
}

/*
 * file location: /application/models/nominee_m.php
 */
