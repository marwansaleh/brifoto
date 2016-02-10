<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_BaseController extends CI_Controller {
    private $_cookie = '__ns';
    private $_log_filename = '';
    
    protected $_log_folder = 'log';
    protected $_log_filename_template = '%s.log';
    protected $REC_PER_PAGE = 8;
    protected $_ip_address = NULL;
    protected $_mime_extensions = array(
        'jpg'   => 'image/jpg',
        'jpeg'  => 'image/jpg',
        'png'   => 'image/png',
        'gif'   => 'image/gif',
        'pdf'   => 'application/pdf',
        'doc'   => 'application/msword',
        'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls'   => 'application/vnd.ms-excel',
        'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'zip'   => 'application/x-zip-compressed'
    );
    
    protected $_pagination_adjacent = 2;
    protected $_pagination_pages = 5;
    
    public $data = array();
    
    function __construct() {
        parent::__construct();
        
        //Load helper
        $this->load->helper('general');
        
        //Iniatiate process
        $this->__initialisation();        
        
        $this->load->model('competition_m');
        
        $this->get_default_competition();
        
    }
    
    private function __initialisation(){
        //Create unique id for unique visitor
        //$this->_create_unique_visitor();
        
        //set variables
        $this->_ip_address = $this->input->ip_address();
        
        //ensure log folder exists
        $this->_create_log_folder();
        
        //create log filename based on date
        $this->_log_filename = sprintf($this->_log_filename_template, date('Ymd'));
        
        //create init log
        //$this->write_log('Init application is running');
    }
    
    /**
     * Create unique visitor cookie
     */
    protected function _create_unique_visitor(){
        //check if cookie for this visitor exists, if not create one
        if (!$this->input->cookie($this->_cookie)){
            $cookie = array(
                'name'   => $this->_cookie,
                'value'  => sha1(microtime(1).rand()),
                'expire' => strtotime('December 31 2020')
            );
            
            $this->input->set_cookie($cookie);
        }
    }
    
    /**
     * Get unique visitor ID from cookie created by function create_unique_visitor
     * @return string unique visitor id
     */
    protected function _get_unique_visitor(){
        return $this->input->cookie($this->_cookie);
    }
    
    private function _create_log_folder(){
        if (!file_exists($this->_log_folder)){
            if (mkdir ($this->_log_folder, 0777)){
                //create gitignore for git use
                //$this->_create_gitignore($this->_log_folder .'/');
            }
        }
    }
    
    private function _create_gitignore($file_path){
        $gitignore = '.gitignore';
        $handle = fopen($gitignore, 'a');
        if ($handle){
            fwrite($handle, PHP_EOL. $file_path);
            fclose($handle);
        }
    }
    
    protected function write_log($event){
        $handle = fopen($this->_log_folder .'/'. $this->_log_filename, 'a');
        if ($handle){
            $data = array(
                date('Y-m-d H:i:s'),
                $this->input->ip_address(),
                $event
            );
            
            fputcsv($handle, $data, "\t");
            
            fclose($handle);
        }
    }
    
    protected function read_log($date=NULL, $lines=5, $file_name=NULL, $adaptive = true){
        if ($file_name && file_exists($file_name)){
            $filepath = $file_name;
        }else{
            if ($date){
                $filepath = $this->_log_folder .'/' . sprintf($this->_log_filename_template, date('Ymd', strtotime($date)));
            }else{
                $filepath = $this->_log_folder .'/' . $this->_log_filename;
            }
        }
        
        // Open file
        $f = @fopen($filepath, "rb");
        if ($f === false) return false;

        // Sets buffer size
        if (!$adaptive) $buffer = 4096;
        else $buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));

        // Jump to last character
        fseek($f, -1, SEEK_END);

        // Read it and adjust line number if necessary
        // (Otherwise the result would be wrong if file doesn't end with a blank line)
        if (fread($f, 1) != "\n") $lines -= 1;
        // Start reading
        $output = '';
        $chunk = '';

        // While we would like more
        while (ftell($f) > 0 && $lines >= 0) {

        // Figure out how far back we should jump
        $seek = min(ftell($f), $buffer);

        // Do the jump (backwards, relative to where we are)
        fseek($f, -$seek, SEEK_CUR);

        // Read a chunk and prepend it to our output
        $output = ($chunk = fread($f, $seek)) . $output;

        // Jump back to where we started reading
        fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);

        // Decrease our line counter
        $lines -= substr_count($chunk, "\n");

        }

        // While we have too many lines
        // (Because of buffer size we might have read too many)
        while ($lines++ < 0) {

        // Find first newline and remove all text before that
        $output = substr($output, strpos($output, "\n") + 1);

        }

        // Close file and return
        fclose($f);
        return trim($output);
    }
    
    protected function get_file_extension($filename){
        $filename = basename($filename);
        $file_info_arr = explode('.', $filename);
        
        if (count($file_info_arr)>1){
            return strtolower(end($file_info_arr));
        }else{
            return 'unknown';
        }
    }
    
    protected function get_default_competition(){
        if (!$this->session->userdata('competition_ID')){
            //load from database
            $comp = $this->competition_m->get_by(array('active'=>1), TRUE);
            if ($comp){
                $this->session->set_userdata('competition', $comp);
                $this->session->set_userdata('competition_ID',$comp->id);
                $this->session->set_userdata('competition_name', $comp->name);
                $this->session->set_userdata('competition_title', $comp->title);
                $this->session->set_userdata('competition_template', $comp->template);
                $this->session->set_userdata('competition_finalstage', $comp->final_stage);
                
                //check if folder exist
                if (!file_exists(config_item('uploads').$comp->name)){
                    mkdir(config_item('uploads').$comp->name, 0777);
                }
            }
        }
    }
    
    protected function competition_ID(){
        $comp_ID = $this->session->userdata('competition_ID');
        if (!$comp_ID){
            exit('Sorry. No competition open yet');
        }
        return $comp_ID;
    }
    
    protected function competition_NAME(){
        $comp_name = $this->session->userdata('competition_name');
        if (!$comp_name){
            exit('Sorry. No competition name exists in memory');
        }
        return $comp_name;
    }
    
    protected function competition_TITLE(){
        $comp_title = $this->session->userdata('competition_title');
        if (!$comp_title){
            exit('Sorry. No competition title exists in memory');
        }
        return $comp_title;
    }
    
    protected function competition_TMPL(){
        $comp_tmpl = $this->session->userdata('competition_template');
        if (!$comp_tmpl){
            exit('Sorry. No competition name exists in memory');
        }
        return $comp_tmpl;
    }
    
    protected function competition_isfinal(){
        $comp_tmpl = $this->session->userdata('competition_finalstage');
        
        return (bool) $comp_tmpl;
    }
}

/**
 * Description of MY_Controller
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class MY_Controller extends MY_BaseController {
    function __construct() {
        parent::__construct();    
        
        $this->data['meta_title'] = $this->competition_TITLE() ? $this->competition_TITLE() : 'BFC - Photo Competition';
        $this->data['menu_active'] = 'home';
        
        $this->data['template'] = $this->competition_TMPL();
        $this->data['is_final'] = $this->competition_isfinal();
    }
}

class MY_Admin_controller extends MY_BaseController{
            
    function __construct() {
        parent::__construct();    
        
        $this->data['meta_title'] = 'BFC Competition - CMS';
        $this->data['menu_active'] = 'dashboard';
        $this->data['breadcumb'] = array();
        
        $this->load->model('users/user_m', 'user_m');
        
        //check if any submittted form data
        $this->load->library('form_validation');
        $this->load->helper(array('form','url'));
        
        if (!$this->user_m->isLoggedin()){
            redirect(config_item('ctl_auth'));
        }
    }
}
/**
 * Description of MY_Ajax
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class MY_Ajax extends MY_BaseController {
    
    function __construct() {
        parent::__construct();
        
        //check if ajax request
        $this->_exit_not_ajax_request();
    }
    
    function send_output($data=NULL){
        $this->output->set_content_type('application/json');
        $this->output->set_header('Cache-Control: no-cache, must-revalidate');
        $this->output->set_header('Expires: '.date('r', time()+(86400*365)));

        $output = json_encode($data);

        $this->output->set_output($output);
    }
    
    private function _exit_not_ajax_request(){
        if (!$this->input->is_ajax_request()){
            show_error('The requested page is not allowed to access', 401);
            exit;
        }
    }
}


/*
 * file location: engine/application/core/MY_Controller.php
 */