<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Gallery
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Gallery extends MY_Admin_controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model(array('upload_m','member_m','competition_m','nominee_m'));
        $this->data['menu_active'] = 'gallery';
        
        $this->data['page_title'] = 'Galeri Foto';
        $this->REC_PER_PAGE = 20;
    }
    
    function index(){     
        $competition_id = $this->competition_ID();
        $competition_stage = 0;
        $rec_per_page= 20;
        
        $this->data['rec_per_page'] = $rec_per_page;
        $this->data['competition_id'] = $competition_id;
        $this->data['competition_stage'] = $competition_stage;
        
        $this->data['competitions'] = $this->competition_m->get();
        
        //set breadcumb
        breadcumb_add($this->data['breadcumb'], 'Dashboard', site_url(config_item('ctl_dashboard')));
        breadcumb_add($this->data['breadcumb'], 'Gallery', current_url(), TRUE);
        //Load view
        $this->data['page_title'] = 'Photo Gallery';
        $this->data['subview'] = 'cms/gallery/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function load_images(){
        $competitionID = $this->input->get('competitionID') ? $this->input->get('competitionID') : 0;
        $stage = $this->input->get('stage') ? $this->input->get('stage') : 0;
        $rec_per_page = $this->input->get('num') ? $this->input->get('num') : 20;
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        
        //setup conditions
        $condition = array();
        if ($competitionID){
            $condition['comp_id'] = $competitionID;
        }
        if ($stage){
            $condition['stage'] = $stage;
        }
        
        $result = array('items'=>array(),'paging'=>array());
        
        //setup paging
        $result['paging']['currentPage'] = $page;
        $result['paging']['recPerPage'] = $rec_per_page;
        $result['paging']['offset'] = ($page-1) * $rec_per_page;
        $result['paging']['totalRecords'] = $this->nominee_m->get_count(count($condition)==0?NULL:$condition);
        $result['paging']['totalPages'] = ceil ($result['paging']['totalRecords'] / $rec_per_page);
        
        if ($result['paging']['totalRecords']>0){
            $items = $this->nominee_m->get_offset('*',count($condition)==0?NULL:$condition, $result['paging']['offset'],  $rec_per_page);
            foreach ($items as $item){
                if (isset($result['items'][$item->item_id])){
                    continue;
                }
                $competition = $this->competition_m->get($item->comp_id);
                $upload = $items = $this->upload_m->get($item->item_id);
                $upload->image_url = site_url(config_item('uploads').  $competition->name .'/'. $upload->file_name);
                $upload->member_name = $this->member_m->get_value('nama', array('id'=>$upload->member_id));
                $upload->competition_title = $competition->title;
                $result['items'][$item->item_id] = $upload;
            }
        }
        
        echo json_encode($result);
    }
    
    function load_nominee_attribute($image_id){
        $result = array('success' => FALSE);
        $nominee = $this->nominee_m->get_by(array('item_id'=>$image_id), TRUE);
        if ($nominee){
            $nominee->competition = $this->competition_m->get($nominee->comp_id);
            $nominee->upload = $this->upload_m->get($nominee->item_id);
            $nominee->upload->datetime = date('d-M-Y H:i:s', $nominee->upload->upload_time);
            $nominee->member = $this->member_m->get($nominee->upload->member_id);
            $nominee->image_url = site_url(config_item('uploads').  $nominee->competition->name .'/'. $nominee->upload->file_name);
            $nominee->nominee = $this->nominee_m->get_by(array('item_id'=>$image_id));
            
            //set other attribute
            $nominee->competition->status = $nominee->competition->final_stage==1 ? 'Final' : 'Staging';
            $nominee->current_stage = 1;
            foreach ($nominee->nominee as $nm){
                if ($nm->stage > $nominee->current_stage){
                    $nominee->current_stage = $nm->stage;
                }
            }
            
            if ($nominee->competition->active==1){
                //is able to promote
                if ($nominee->competition->current_stage > $nominee->current_stage){
                    $nominee->promote_enabled = TRUE;
                    $nominee->promote_stage = $nominee->current_stage + 1;
                }else{
                    $nominee->promote_enabled = FALSE;
                }
                //is able to demote ?
                if ($nominee->current_stage > 1){
                    $nominee->demote_enabled = TRUE;
                    $nominee->demote_stage = $nominee->current_stage - 1;
                }else{
                    $nominee->demote_enabled = FALSE;
                }
            }else{
                $nominee->promote_enabled = FALSE;
                $nominee->demote_enabled = FALSE;
            }
            
            $result['success'] = TRUE;
            $result['nominee'] = $nominee;
        }else{
            $result['message'] = 'No image with ID:'. $image_id;
        }
        echo json_encode($result);
    }
    
    function demote(){
        $image_id = $this->input->get('image_id');
        $stage = $this->input->get('stage');
        $comp_id = $this->input->get('comp_id');
        
        $result = array('success' => false);
        
        if ($this->nominee_m->delete_where(array('item_id'=>$image_id, 'stage'=>$stage, 'comp_id'=>$comp_id))){
            $result['success'] = TRUE;
        }else{
            $result['message'] = 'No nominee stage records has been deleted for demote';
        }
        
        echo json_encode($result);
    }
    
    function promote(){
        $image_id = $this->input->get('image_id');
        $stage = $this->input->get('stage');
        $score = $this->input->get('score');
        $rank = $this->input->get('rank');
        $comp_id = $this->input->get('comp_id');
        
        $result = array('success' => FALSE);
        
        if ($this->nominee_m->save(array(
            'item_id'   => $image_id,
            'stage'     => $stage,
            'score'     => $score,
            'rank'      => $rank,
            'comp_id'   => $comp_id
        ))){
            $result['success'] = TRUE;
        }else{
            $result['message'] = 'Failed to insert new nominee record for image promotion';
        }
        
        echo json_encode($result);
    }
        
    function get_competition_stage($competition_id){
        $competition = $this->competition_m->get($competition_id);
        
        echo json_encode($competition);
    }
    
    function image_delete($imageID){
        $result = array('success' => false);
        
        $item = $this->upload_m->get($imageID);
        
        if ($item){
            if($this->upload_m->delete($imageID)){
                //get competition name from comp_id
                $comp = $this->competition_m->get($item->comp_id);
                if ($comp && file_exists(config_item('uploads').$comp->name.'/'.$item->file_name)){
                    unlink(config_item('uploads').$comp->name.'/'.$item->file_name);
                }
            }
            
            //remove in nominee
            $this->nominee_m->delete_where(array('item_id'=>$imageID));
            
            $result['success'] = TRUE;
        }else{
            $result['message'] = 'No record found for image with ID:'.$imageID;
        }

        echo json_encode($result);
    }
    
    function images_delete(){
        $result = array('success' => false);
        
        $imageIDList = explode(',', $this->input->get('list_id'));
        
        $success = 0;
        for ($i=0; $i<count($imageIDList); $i++){
            $item = $this->upload_m->get($imageIDList[$i]);
            if ($item){
                //remove from upload table
                $this->upload_m->delete($imageIDList[$i]);
                //remove in nominee table
                $this->nominee_m->delete_where(array('item_id'=>$imageIDList[$i]));
                //remove the file
                //get competition name from comp_id
                $comp = $this->competition_m->get($item->comp_id);
                if ($comp && file_exists(config_item('uploads').$comp->name.'/'.$item->file_name)){
                    unlink(config_item('uploads').$comp->name.'/'.$item->file_name);
                }
                
                $success++;
            }
        }
        if ($success > 0){
            $result['success'] = TRUE;
        }else{
            $result['message'] = 'Failed to delete selected images';
        }

        echo json_encode($result);
    }
    
    function image_download($image_id){
        $item = $this->upload_m->get($image_id);
        
        if ($item){
            $comp = $this->competition_m->get($item->comp_id);
            $filename = config_item('uploads').$comp->name.'/'.$item->file_name; 
            
            header('Content-Description: File Transfer');
            header('Content-Type: '.$item->mime_type);
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        }
    }
    
    function images_download($images_id_list){
        $id_list = explode('-', $images_id_list);
        
        //get all items based on id
        $this->db->where_in('id',$id_list);
        $items = $this->upload_m->get();
        
        if ($items){
            $zip_filename = sys_get_temp_dir() . date('YmdHis') . '-selection.zip';
            
            $zip = new ZipArchive;
            if ($zip->open($zip_filename, ZipArchive::CREATE)!==FALSE){
                foreach ($items as $item){
                    $comp_name = $this->competition_m->get_value('name',array('id'=>$item->comp_id));
                    $image_file = config_item('uploads').$comp_name . '/'. $item->file_name;
                    if (file_exists($image_file)){
                        $zip->addFile($image_file, $image_file);
                    }
                }
                
                if ($zip->numFiles==0){
                    $zip->close();
                    exit('No files to be zipped');
                }
                $zip->close();
                
                header('Content-Description: File Transfer');
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename='.basename($zip_filename));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($zip_filename));
                readfile($zip_filename);
                exit;
            }
        }
    }
    
    function create_zip($comp_id=NULL){
        $condition = NULL;
        $temp_path = sys_get_temp_dir() .'/';
        $zip_filename = $temp_path . time().'_gallery_all.zip';
        if ($comp_id){
            //get competition name
            $competition_name = $this->competition_m->get_value('name', array('id'=>$comp_id));
            if ($competition_name){
                $zip_filename = $temp_path . time().'_'. str_replace(' ', '_', $competition_name) . '.zip';
            }
            $condition = array('comp_id'=>$comp_id);
        }
        
        //get all gallery
        $galleries = $this->upload_m->get_by($condition);
        
        if ($galleries){
            $zip = new ZipArchive;
            if ($zip->open($zip_filename, ZipArchive::CREATE)){
                foreach($galleries as $item){
                    $comp_name = $this->competition_m->get_value('name',array('id'=>$item->comp_id));
                    
                    if (file_exists(config_item('uploads').$comp_name . '/'. $item->file_name)){
                        
                        $ext = file_extension($item->file_name);
                        $image_title = str_replace(' ', '-', $item->description);
                        $new_image_name = sprintf('%d_%s.%s',$item->id,$image_title,$ext);
                        
                        $zip->addFile(config_item('uploads') . $comp_name .'/' . $item->file_name, $new_image_name);
                    }
                }
                $zip->close();
                redirect(config_item('ctl_home').'download?file='.  base64_encode($zip_filename));
            }else{
                echo 'Failed to create compressed filed';
            }
        }else{
            echo 'No file to download';
        }
    }
}

/* End of file gallery.php */
/* Location: ./application/controllers/cms/gallery.php */