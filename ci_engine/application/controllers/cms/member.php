<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Comp
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Member extends MY_Admin_controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model(array('upload_m','member_m','competition_m','nominee_m'));
        $this->data['menu_active'] = 'member';
        
        $this->data['page_title'] = 'Members of Competition';
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
            $this->db->like('nama',$search['search_text']);
            $this->db->or_like('unit',$search['search_text']);
        }
        
        $this->data['offset'] = ($this->data['page']-1) * $this->REC_PER_PAGE;
        
        //count totalRecords
        $this->data['totalRecords'] = $this->member_m->get_count();
        //count totalPages
        $this->data['totalPages'] = ceil ($this->data['totalRecords']/$this->REC_PER_PAGE);
        
        if ($is_searching && $search['search_text']){
            $this->db->like('nama',$search['search_text']);
            $this->db->or_like('unit',$search['search_text']);
        }
        $items = $this->member_m->get_offset('*',NULL, $this->data['offset'],  $this->REC_PER_PAGE);
        $this->data['items'] = array();
        foreach($items as $item){
            $item->upload_count = $this->upload_m->get_count(array('member_id'=>$item->id));
            $this->data['items'][] = $item;
        }
        $url_format = site_url('cms/member/index?page=%i');
        $this->data['pagination'] = smart_paging($this->data['totalPages'], $this->data['page'], $this->_pagination_adjacent, $url_format, $this->_pagination_pages, array('records'=>count($items),'total'=>$this->data['totalRecords']));
        
        //set breadcumb
        breadcumb_add($this->data['breadcumb'], 'Dashboard', site_url(config_item('ctl_dashboard')));
        breadcumb_add($this->data['breadcumb'], 'Member', current_url(), TRUE);
        //Load view
        $this->data['page_title'] = 'Members of Competition';
        $this->data['subview'] = 'cms/member/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function edit(){
        $id = $this->input->get('id', TRUE);
        $page = $this->input->get('page', TRUE);
        
        $item = $id ? $this->member_m->get($id) : $this->member_m->get_new();
        
        $this->data['item'] = $item;
        
        //set breadcumb
        breadcumb_add($this->data['breadcumb'], 'Dashboard', site_url(config_item('ctl_dashboard')));
        breadcumb_add($this->data['breadcumb'], 'Member', site_url('cms/member'), FALSE);
        breadcumb_add($this->data['breadcumb'], 'Update', site_url('cms/member/edit'), TRUE);
        
        $this->data['submit_url'] = site_url('cms/member/save?page='.$page.'&id='.$id);
        $this->data['back_url'] = site_url('cms/member/index?page='.$page);
        //Load view
        $this->data['page_title'] = 'Members of Competition - Update';
        $this->data['subview'] = 'cms/member/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function save(){
        $id = $this->input->get('id', TRUE);
        $page = $this->input->get('page', TRUE);
        $rules = $this->member_m->rules;
        
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run() == TRUE){
            $post_data = $this->member_m->array_from_post(array('nama','pn','hp','unit','email'));
            if ($this->member_m->save($post_data, $id)){  
                $this->session->set_flashdata('message_type','success');
                $this->session->set_flashdata('message_text','Data has been update successfully!');
            }else{
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text','Failed to update data item');
            }
            
            redirect('cms/member/index?page='.$page);
        }else{
            $this->session->set_flashdata('message_type','error');
            $this->session->set_flashdata('message_text',  validation_errors());
        }
        
        redirect('cms/member/edit?id='.$id.'&page='.$page);
    }
    
    function delete(){
        $id = $this->input->get('id', TRUE);
        $page = $this->input->get('page', TRUE);
        
        $item = $this->member_m->get($id);
        if ($item){
            if ($this->member_m->delete($id)){
                $this->_delete_photo_member($id);
                
                $this->session->set_flashdata('message_type','success');
                $this->session->set_flashdata('message_text','Data has been deleted successfully!');
            }else{
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text','Failed to delete data item');
            }
        }else{
            $this->session->set_flashdata('message_type','error');
            $this->session->set_flashdata('message_text','Data item not found');
        }
        
        redirect('cms/member/index?page='.$page);
    }
    
    private function _delete_photo_member($member_id){
        //get all upload from this member
        $uploads = $this->upload_m->get_select_where('id,comp_id,file_name', array('member_id'=>$member_id));
        if ($uploads){
            foreach ($uploads as $item){
                //get competition name from comp_id
                $comp = $this->competition_m->get($item->comp_id);
                if ($comp && file_exists(config_item('uploads').$comp->name.'/'.$item->file_name)){
                    unlink(config_item('uploads').$comp->name.'/'.$item->file_name);
                }
                //remove in nominee
                $this->nominee_m->delete_where(array('item_id'=>$item->id));
            }
            
            return count($uploads);
        }
        
        return 0;
    }
}

/* End of file member.php */
/* Location: ./application/controllers/cms/member.php */