<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Comp
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Account extends MY_Admin_controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model('config_m');
        $this->data['menu_active'] = 'account';
        
        $this->data['page_title'] = 'Account Setup';
    }
    
    function index(){     
        $this->data['page'] = $this->input->get('page',TRUE);
        if (!$this->data['page'] || $this->data['page']<1) {$this->data['page']=1;}
        
        $is_searching = FALSE;
        if (!$this->input->post('is_searching') && $this->session->flashdata('is_searching')){
            $is_searching = TRUE;
            $search = array('is_searching'=>TRUE, 'search_text'=>$this->session->flashdata('search_text'));
        }elseif($this->input->post('is_searching')){
            $this->data['page'] = 1;
            if ($this->input->post('search')==''){
                $is_searching = FALSE;
                $search = array('is_searching'=>FALSE,'search_text'=>'');
            }else{
                $is_searching = TRUE;
                $search = array('is_searching'=>TRUE, 'search_text'=>$this->input->post('search'));
            }
        }else{
            $is_searching = FALSE;
            $search = array('is_searching'=>FALSE,'search_text'=>'');
        }
        //set to flash data
        $this->session->set_flashdata($search);
        $this->data = array_merge($this->data, $search);
        
        //start query
        if ($is_searching && $search['search_text']){
            $this->db->like('name',$search['search_text']);
            $this->db->or_like('title',$search['search_text']);
        }
        
        $this->data['offset'] = ($this->data['page']-1) * $this->REC_PER_PAGE;
        
        //count totalRecords
        $this->data['totalRecords'] = $this->competition_m->get_count();
        //count totalPages
        $this->data['totalPages'] = ceil ($this->data['totalRecords']/$this->REC_PER_PAGE);
        
        if ($is_searching && $search['search_text']){
            $this->db->like('name',$search['search_text']);
            $this->db->or_like('title',$search['search_text']);
        }
        $items = $this->competition_m->get_offset('*',NULL, $this->data['offset'],  $this->REC_PER_PAGE);
        $this->data['items'] = array();
        foreach($items as $item){
            $item->upload_count = $this->upload_m->get_count(array('comp_id'=>$item->id));
            $this->data['items'][] = $item;
        }
        $url_format = site_url(config_item('crl_cms_comp').'index?page=%i');
        $this->data['pagination'] = smart_paging($this->data['totalPages'], $this->data['page'], $this->_pagination_adjacent, $url_format, $this->_pagination_pages, array('records'=>count($items),'total'=>$this->data['totalRecords']));
        
        //set breadcumb
        breadcumb_add($this->data['breadcumb'], 'Dashboard', site_url(config_item('ctl_dashboard')));
        breadcumb_add($this->data['breadcumb'], 'Competition', current_url(), TRUE);
        //Load view
        $this->data['page_title'] = 'Competition List';
        $this->data['subview'] = 'cms/competition/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function change_password($redirect=0){
        if ($redirect){
            if ($this->session->userdata('modal_redirect')){
                redirect($this->session->userdata('modal_redirect'));
            }else{
                redirect('cms/dashboard');
            }
            
            exit;
        }
        //get referer
        $this->load->library('user_agent');
        if ($this->agent->is_referral() && strpos($this->agent->referrer(), 'change_password')===FALSE)
        {
            $this->session->set_userdata('modal_redirect', $this->agent->referrer());
        }
        
        //if update password / form submitted
        $this->form_validation->set_rules(array(
            'old_password'  => array(
                'field' => 'old_password', 
                'label' => 'Old password', 
                'rules' => 'required|xss_clean'
            ),
            'new_password'  => array(
                'field' => 'new_password', 
                'label' => 'New password', 
                'rules' => 'required|xss_clean'
            ),
            'confirm_password'  => array(
                'field' => 'confirm_password', 
                'label' => 'Confirmation new password', 
                'rules' => 'required|matches[new_password]|xss_clean'
            ),
        ));
        if ($this->form_validation->run() == TRUE){
            //check if old password ok
            if ($this->user_m->get_user_info($this->session->userdata('userid'), 'password')==$this->user_m->hash($this->input->post('old_password'))){
                
                if ($this->user_m->save(array('password'=>  $this->user_m->hash($this->input->post('new_password'))), $this->session->userdata('userid'))){
                    $this->data['message_box'] = create_alert_box('Password has changed successfully!', 'success');
                }else{
                    $this->data['message_box'] = create_alert_box('Failed to update new password', 'error');
                }
            }else{
                $this->data['message_box'] = create_alert_box('Old password does not match', 'error');
            }
        }else if ($this->input->post('submit_change')){
            $this->data['message_box'] = create_alert_box(validation_errors(), 'error');
        }
        
        $this->data['page_title'] = 'Change Password';
        $this->data['subview'] = 'cms/account/change_password';
        $this->load->view('cms/_layout_modal', $this->data);
    }
}

/* End of file account.php */
/* Location: ./application/controllers/cms/account.php */