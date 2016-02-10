<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Config_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Config_m extends MY_Model {
    protected $_table_name = 'bfc_competition_config';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'comp_id';
    
    function get_config_upload($comp_id){
        $config_db =  $this->get_by(array('comp_id'=>$comp_id), TRUE);
        
        if ($config_db){
            $config = new stdClass();
            $config->upload_start = $config_db->upload_start;
            $config->upload_end = $config_db->upload_end;
            $config->max_upload = $config_db->max_upload;
            $config->elements = explode('|',$config_db->filename_element_count);
            $config->upload = array(
                'upload_path'   => '/tmp',
                'remove_spaces'  => FALSE,
                'allowed_types' => $config_db->allowed_extensions,
                'max_size'  => $config_db->max_file_size,
                'max_width' => $config_db->max_image_width,
                'max_height'    => $config_db->max_image_height
            );
            
            return $config;
        }
        
        return NULL;
    }
}

/*
 * file location: /application/models/config_m.php
 */
