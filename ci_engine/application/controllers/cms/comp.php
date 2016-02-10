<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Comp
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Comp extends MY_Admin_controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model(array('upload_m','member_m','config_m'));
        $this->data['menu_active'] = 'competition';
        
        $this->data['page_title'] = 'Competition';
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
    
    function setactive(){
        $id = $this->input->get('id', TRUE);
        $page = $this->input->get('page', TRUE);
        $active = $this->input->get('active',TRUE);
        
        $item = $this->competition_m->get($id);
        if ($item){
            if ($this->competition_m->save(array('active'=>$active), $id)){
                $this->session->set_flashdata('message_type','info');
                $this->session->set_flashdata('message_text', 'Berhasil merubah status "'.$item->title.'" ke '.($active==1?'"Active"':'"Inactive"'));
            }else{
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text', 'Gagal merubah status "'.$item->title.'": '.$this->competition_m->get_last_message());
            }
        }
        redirect(config_item('ctl_cms_comp').'index?page='.$page);
    }
    
    function setup(){
        $id = $this->input->get('id', TRUE);
        $page = $this->input->get('page', TRUE);

        $competition = $this->competition_m->get($id);
        
        if (!$competition){
            $this->session->set_flashdata('message_type','error');
            $this->session->set_flashdata('message_text', 'Tidak ada data competition dengan ID:'.$id.' di database');
            redirect(config_item('ctl_cms_comp').'index?page=' . $page);
        }
        $this->data['competition'] = $competition;
        
        //get parameter
        $params = $this->config_m->get_by(array('comp_id'=>$id),TRUE);
        if (!$params){
            $params = new stdClass();
            $params->id = 0;
            $params->comp_id = $id;
            $params->max_file_size = 500;
            $params->min_file_size = 0;
            $params->allowed_extensions = 'jpg';
            $params->max_image_width = 1024;
            $params->min_image_width = 0;
            $params->max_image_height = 700;
            $params->min_image_height = 0;
            $params->create_thumbnail = 0;
            $params->max_upload = 3;
            $params->filename_element_count = 'nama|hp|pn|unit|judul';
            $params->upload_start = date('Y-m-d H:i:s');
            $params->upload_end = date('Y-m-d H:i:s', strtotime("+1 months"));
            $params->upload_path = '';
        }
        $this->data['params'] = $params;
        //set breadcumb
        breadcumb_add($this->data['breadcumb'], 'Dashboard', site_url(config_item('ctl_dashboard')));
        breadcumb_add($this->data['breadcumb'], 'Competition', site_url(config_item('ctl_cms_comp')));
        breadcumb_add($this->data['breadcumb'], 'Competition Params', current_url(), TRUE);
        $this->data['page_title'] = 'Competition Setup';
        $this->data['submit_url'] = site_url(config_item('ctl_cms_comp').'setup_save?page='.$page.'&id='.$id);
        $this->data['back_url'] = site_url(config_item('ctl_cms_comp').'index?page='.$page);
        $this->data['subview'] = 'cms/competition/setup';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function setup_save(){
        $page = $this->input->get('page', TRUE);
        
        //update competition value
        if ($this->input->post('active')==1){
            $this->competition_m->save_where(array('active'=>0), array('active'=>1));
        }
        $competition_id = $this->competition_m->save(array(
            'name'      => $this->input->post('name'),
            'title'     => $this->input->post('title'),
            'active'    => $this->input->post('active'),
            'template'  => $this->input->post('template'),
            'current_stage' => $this->input->post('current_stage'),
            'total_stage' => $this->input->post('total_stage'),
            'final_stage'   => $this->input->post('current_stage') == $this->input->post('total_stage')?1:0
        ), $this->input->post('competition_id'));
        
        //update params
        if ($competition_id){
            $this->config_m->save(array(
                'comp_id'           => $competition_id,
                'max_file_size'     => $this->input->post('max_file_size'),
                'min_file_size'     => $this->input->post('min_file_size'),
                'allowed_extensions'=> $this->input->post('allowed_extensions'),
                'max_image_width'   => $this->input->post('max_image_width'),
                'min_image_width'   => $this->input->post('min_image_width'),
                'max_image_height'  => $this->input->post('max_image_height'),
                'min_image_height'  => $this->input->post('min_image_height'),
                'max_upload'        => $this->input->post('max_upload'),
                'upload_start'      => $this->input->post('upload_start'),
                'upload_end'        => $this->input->post('upload_end'),
                'upload_path'       => $this->input->post('upload_path'),
                'filename_element_count'  => $this->input->post('filename_element_count'),
                'create_thumbnail'  => $this->input->post('create_thumbnail')
            ), $this->input->post('competition_param_id'));
        }
        
        redirect(config_item('ctl_cms_comp').'index?page='.$page);
    }
    
}

/* End of file gallery.php */
/* Location: ./application/controllers/cms/comp.php */