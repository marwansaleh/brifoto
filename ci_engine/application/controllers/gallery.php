<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Gallery
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Gallery extends MY_Controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model(array('upload_m','member_m'));
        $this->data['menu_active'] = 'gallery';
        
        $this->data['page_title'] = 'Galeri Foto';
        $this->REC_PER_PAGE = 40;
    }
    
    function index($page=1){     
        if ($page<1){$page =1; }
        
        $this->data['page'] = $page;
        $this->data['offset'] = ($this->data['page']-1) * $this->REC_PER_PAGE;
        
        $where = array('comp_id'=>  $this->competition_ID());
        //count totalRecords
        $this->data['totalRecords'] = $this->upload_m->get_count($where);
        //count totalPages
        $this->data['totalPages'] = ceil ($this->data['totalRecords']/$this->REC_PER_PAGE);
        
        $items = $this->upload_m->get_offset('*',$where, $this->data['offset'],  $this->REC_PER_PAGE);
        $this->data['items'] = array();
        foreach($items as $item){
            $item->image_url = site_url(config_item('uploads').  $this->competition_NAME() .'/'. $item->file_name);
            $member = $this->member_m->get($item->member_id);
            $item->member_name = $member ? $member->nama:'unknown';
            $item->member_unit = $member ? $member->unit:'unknown';
            $this->data['items'][] = $item;
        }
        $url_format = site_url(config_item('ctl_gallery').'index/%i');
        $this->data['pagination'] = smart_paging($this->data['totalPages'], $this->data['page'], $this->_pagination_adjacent, $url_format, $this->_pagination_pages, array('records'=>count($items),'total'=>$this->data['totalRecords']));
        
        
        $this->data['subview'] = $this->competition_TMPL() . '/gallery/index';
        $this->load->view($this->competition_TMPL() . '/_layout_main', $this->data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */