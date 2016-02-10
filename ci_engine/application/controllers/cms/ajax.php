<?php
/**
 * Description of Ajax
 *
 * @author marwansaleh
 */
class Ajax extends MY_Ajax {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('competition_m','upload_m','member_m','nominee_m'));
    }
    public function deletePhoto($id){
        $result = array();
        $item = $this->upload_m->get($id);
        if ($item){
            if ($this->upload_m->delete($id)){
                //get competition name from comp_id
                $comp = $this->competition_m->get($item->comp_id);
                if ($comp && file_exists(config_item('uploads').$comp->name.'/'.$item->file_name)){
                    unlink(config_item('uploads').$comp->name.'/'.$item->file_name);
                }
                //remove in nominee
                $this->nominee_m->delete_where(array('item_id'=>$id));
            
                $result['status'] = TRUE;
            }else{
                $result['status'] = FALSE;
                $result['message'] = 'Failed to delete data item';
            }
        }else{
            $result['status'] = FALSE;
            $result['message'] = 'Data item not found';
        }
        
        $this->send_output($result);
    }
    
    public function search_photos(){
        $search_by = $this->input->get('search_by');
        $search_value = $this->input->get('search_value');
        
        $photos = array();
        
        switch ($search_by){
            case 'id': $photos = $this->_search_photo_by_id($search_value); break;
            case 'name': $photos = $this->_search_photo_by_name($search_value); break;
            case 'pn': $photos = $this->_search_photo_by_pn($search_value); break;
            case 'description': $photos = $this->_search_photo_by_description($search_value); break;
        }
        
        $result = array();
        
        foreach ($photos as $image_rec){
            //set upload datetime
            $image_rec->upload_datetime = date('D, d-M-Y H:i', $image_rec->upload_time);
            //get competition
            $competition = $this->competition_m->get($image_rec->comp_id);
            $image_base_url = config_item('uploads');
            if ($competition){
                $image_base_url .= $competition->name.'/';
            }
            $image_rec->competition = $competition->title;
            $image_rec->file_url = site_url($image_base_url . $image_rec->file_name);
            //get member from image rec
            $member = $this->member_m->get($image_rec->member_id);
            if ($member){
                $image_rec->member_name = $member->nama;
                $image_rec->member_hp = $member->hp;
                $image_rec->member_pn = $member->pn;
                $image_rec->member_unit = $member->unit;
            }

            //generate download image url
            $download_url = base64_encode($image_base_url . $image_rec->file_name);
            $download_name = base64_encode(time() . '.' . file_extension($image_rec->file_name));

            $image_rec->download_url = site_url('home/download?file=' . $download_url.'&filename='.$download_name);
            
            $result [] = $image_rec;
        }
        
        $this->send_output($result);
    }
    
    private function _search_photo_by_id($id){
        $result = array();
        
        //get image record
        $image_rec = $this->upload_m->get($id);
        if ($image_rec){
            $result [] = $image_rec;
        }
        
        return $result;
    }
    
    private function _search_photo_by_name($name){
        $result = array();
        
        //search member id where name like $name
        $this->db->like('nama', $name);
        $members = $this->member_m->get_select_where('id',NULL);
        if ($members){
            $members_id = array();
            foreach ($members as $member){
                $members_id [] = $member->id;
            }
            
            //search upload where member_id IN $members_id
            $this->db->where_in('member_id', $members_id);
            $uploads = $this->upload_m->get();
            
            if($uploads){
                $result = $uploads;
            }
        }
        
        return $result;
    }
    
    private function _search_photo_by_pn($pn){
        $result = array();
        $members = $this->member_m->get_select_where('id',array('pn'=>$pn));
        if ($members){
            $members_id = array();
            foreach ($members as $member){
                $members_id [] = $member->id;
            }
            
            //search upload where member_id IN $members_id
            $this->db->where_in('member_id', $members_id);
            $uploads = $this->upload_m->get();
            
            if($uploads){
                $result = $uploads;
            }
        }
        
        return $result;
    }
    
    private function _search_photo_by_description($description){
        $result = array();
        
        //get image record
        $this->db->like('description', $description);
        $image_rec = $this->upload_m->get();
        if ($image_rec){
            $result = $image_rec;
        }
        
        return $result;
    }
}
