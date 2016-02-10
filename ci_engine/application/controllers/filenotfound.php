<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of filenotfound
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Filenotfound extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->data['page_title'] = 'Error - File not found';
    }
    
    public function index(){
        //Basic layout
        //$this->data['active_menu'] = 'filenotfound';
        $this->data['subview'] = $this->competition_TMPL() . '/errors/err_404';
        
        $this->load->view( $this->competition_TMPL() . '/_layout_main', $this->data );
    }
}

/* End of file filenotfound.php */
/* Location: ./application/controllers/filenotfound.php */