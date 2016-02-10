<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of File_m
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class File_m extends MY_Model {
    protected $_table_name = 'bfc_competition_files';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'upload_time desc';
}

/*
 * file location: /application/models/file_m.php
 */
