<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Stage_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Stage_m extends MY_Model {
    protected $_table_name = 'bfc_comp_stages';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'comp_id, stage';
    
    public $rules = array(
        'comp_id' => array(
            'field' => 'competition_id', 
            'label' => 'Competition name', 
            'rules' => 'required|trim|xss_clean'
        ),
        'stage' => array(
            'field' => 'stage', 
            'label' => 'stage title', 
            'rules' => 'trim|xss_clean'
        )
    );
}

/*
 * file location: /application/models/stage_m.php
 */
