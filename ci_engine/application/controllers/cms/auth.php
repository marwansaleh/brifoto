<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Auth
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Auth extends MY_Controller {
    function __construct() {
        parent::__construct();        
        
        $this->load->model('users/user_m','user_m');
        $this->data['page_title'] = 'Authentication';
    }
    
    function index(){
        if ($this->user_m->isLoggedin()){
            redirect(config_item('ctl_dashboard'));
            exit;
        }
        
        if ($this->session->flashdata('message_text')){
            $this->data['message_box'] = create_alert_box($this->session->flashdata('message_text'), 
                    $this->session->flashdata('message_type'));
        }
        $this->data['subview'] = 'cms/login/index';        
        $this->load->view('cms/_layout_login', $this->data);
    }
    
    function login(){
        //check if any submittted form data
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules($this->user_m->rules_login);
        
        if ($this->form_validation->run() == TRUE){
            $user_name = $this->input->post('user_name',TRUE);
            $password = $this->input->post('password',TRUE);
            if ($this->user_m->login($user_name, $password)){            
                redirect('cms/dashboard');
                exit;
            }else{
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text','Login failed ! Please make sure your username and password typed correctly');
            }
        }else{
            $this->session->set_flashdata('message_type','error');
            $this->session->set_flashdata('message_text','No data sent to login');
        }
        
        redirect(config_item('ctl_auth'));
    }
    
    function logout(){
        $this->user_m->logout();
        redirect(config_item('ctl_auth'));
    }
    
    function hash($input){
        echo $this->user_m->hash($input);
    }
}

/* End of file main.php */
/* Location: ./application/controllers/auth.php */