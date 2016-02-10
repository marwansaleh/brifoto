<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Read from log file
 *
 * @author marwansaleh
 */
class Readlog extends MY_BaseController {
    function __construct() {
        parent::__construct();
        if (!$this->input->get('key')=='log'){
            show_404();
            exit;
        }
    }
    
    function index($lines=5,$date=NULL){
        echo '<pre>';
        print $this->read_log($date, $lines);
        echo '</pre>';
    }
    
    function apache(){
        echo '<pre>';
        print $this->read_log($date, $lines, BASEPATH . 'error_log');
        echo '</pre>';
    }
}
