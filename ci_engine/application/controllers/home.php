<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Home
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Home extends MY_Controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->data['menu_active'] = 'home';
        
        $this->data['page_title'] = $this->competition_title();
    }
    
    function index(){        
        $this->load->model('file_m');
        $files = $this->file_m->get_by(array('comp_id'=>  $this->competition_ID()));
        //get file spm
        $this->data['files'] = array();
        foreach($files as $file){
            $this->data['files'] [$file->name] = base64_encode(config_item('attachments').$file->file_name);
        }
        
        $this->data['subview'] = $this->competition_TMPL() . '/home/index';
        $this->load->view($this->competition_TMPL() .'/_layout_main', $this->data);
    }
    
    public function download(){
        $file_name = $this->input->get('file',TRUE);
        $download_name = $this->input->get('filename',TRUE);
        
        if (!$file_name){
            exit('No file defined');
        }else{
            $file_name = base64_decode($file_name);
        }
        
        if (!file_exists($file_name)){
            exit('The file "'.$file_name.'" is not exists in the server any more');
        }
        
        //get file extension
        $file_arr = explode('.', $file_name);
                
        if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}
        
        // get the file mime type using the file extension
	$mime = $this->_mime_extensions[end($file_arr)];
        
        $target_filename = $download_name ? base64_decode($download_name):basename($file_name);
        
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.$target_filename.'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($file_name));	// provide file size
	header('Connection: close');
	readfile($file_name);		// push it out
	exit();
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */