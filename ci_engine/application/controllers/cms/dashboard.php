<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Dasboard
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Dashboard extends MY_Admin_controller {
    function __construct() {
        parent::__construct();        
        
        //set breadcumb
        breadcumb_add($this->data['breadcumb'], 'Dashboard', site_url(config_item('ctl_dashboard')), TRUE);
        
        $this->data['page_title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
    }
    
    function index(){
        //Load upload model
        $this->load->model('upload_m');
        //get active competition
        $competition = $this->competition_m->get_by(array('active'=>1), TRUE);
        if ($competition){
            $competition->photo_count = $this->upload_m->get_count(array('comp_id'=>$competition->id));
        }
        $this->data['competition'] = $competition;
        
        //get other competition
        $this->data['competitions'] = array();
        $competitions = $this->competition_m->get();
        foreach ($competitions as $comp){
            if ($comp->id != $competition->id){
                $comp->photo_count = $this->upload_m->get_count(array('comp_id'=>$comp->id));
                $this->data['competitions'][] = $comp;
            }
        }
        
        $this->data['subview'] = 'cms/dashboard/index';        
        $this->load->view('cms/_layout_main', $this->data);
    }
}

/* End of file main.php */
/* Location: ./application/controllers/cms/dashboard.php */