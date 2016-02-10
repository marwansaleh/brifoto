<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Upload
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Upload extends MY_Controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model(array('member_m','upload_m'));
        
        $this->data['menu_active'] = 'upload';
        
        $this->data['page_title'] = 'Unggah Photo';
    }
    
    function index($pn=NULL, $admin=NULL){        
        if ($pn || $pn=  $this->session->flashdata('uploader_pn')){
            //get member info
            $member = $this->member_m->get_by(array('pn'=>$pn),TRUE);
            $this->data['member'] = $member;
            $items = $this->upload_m->get_by(array('comp_id'=>  $this->competition_ID(),'member_id'=>$member->id));
            if ($items){
                $this->data['items'] = array();
                foreach($items as $item){
                    $item->member_name = $member->nama;
                    $item->image_url = site_url(config_item('uploads').  $this->competition_NAME() .'/' . $item->file_name);
                    $this->data['items'] [] = $item;
                }
            }
            $this->session->set_flashdata('uploader_pn',$pn);
        }
        
        if ($admin=='myadmin'){
            $this->data['admin'] = TRUE;
        }
        $this->data['submit_url'] = site_url(config_item('ctl_upload').'do_upload');
        $this->data['subview'] = $this->competition_TMPL() . '/upload/index';
        $this->load->view($this->competition_TMPL() . '/_layout_main', $this->data);
    }
    
    function do_upload(){
        $this->load->model('config_m');
        $config = $this->config_m->get_config_upload($this->competition_ID());
        
        //check upload date validity
        $start_date = strtotime($config->upload_start);
        $end_date = strtotime($config->upload_end);
        $now = time();
        
        if ($now < $start_date || $now > $end_date){
            $this->session->set_flashdata('message_type','error');
            $this->session->set_flashdata('message_text',  'Masa upload foto telah berakhir');
            redirect('upload/index');
        }
        
        //load upload library
        $this->load->library('upload', $config->upload);
        if (!$this->upload->do_upload()){
            $this->session->set_flashdata('message_type','error');
            $this->session->set_flashdata('message_text',  $this->upload->display_errors('<p>','</p>'));
            
            $this->write_log('Trying to upload '. $this->upload->display_errors('',''));
            redirect('upload/index');
        }else{
            $upload_data = $this->upload->data();
            $err_extract_msg = '';
            //extract file info based on filename
            $extracted_info = $this->_extract_upload_info($upload_data, $config, $err_extract_msg);
            
            if (!$extracted_info){
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text', $err_extract_msg);
                
                $this->write_log('Upload error because filename info is not match: '. $err_extract_msg);
                redirect ('upload/index');
            }
            
            //check if member already registered in our table member
            $member = $this->member_m->get_by(array('pn'=>$extracted_info->pn),TRUE);
            //if not, register
            if (!$member){
                $member_id = $this->member_m->save(array(
                    'nama'  =>  trim($extracted_info->nama),
                    'hp'    =>  trim($extracted_info->hp),
                    'unit'  => trim($extracted_info->unit),
                    'pn'    =>  trim($extracted_info->pn),
                    'reg_time' => time()
                ));
            }else{
                //update data
                $member_id= $member->id;
                
                $this->member_m->save(array(
                    'nama'  =>  trim($extracted_info->nama),
                    'hp'    =>  trim($extracted_info->hp),
                    'unit'  => trim($extracted_info->unit)
                ),$member_id);
            }
            $upload_count = $this->upload_m->get_count(array('member_id'=>$member_id, 'comp_id'=>  $this->competition_ID()));
            //count how many upload the user (identified by personal number "pn") has done
            if ($upload_count>=$config->max_upload){
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text',  'Maaf. Anda telah mengunggah foto sebanyak '.$config->max_upload.' kali (maksimal)');
                //remove the old file
                unlink($upload_data['full_path']);
                
                $this->write_log('Upload error: Maximum upload exceed');
                redirect ('upload/index/'.$extracted_info->pn);
            }
            
            //generate registration_id
            $registration_id = $member_id .'-'. date('YmdHis').'-'.$this->competition_ID().'-'.($upload_count+1);
            $new_filename = $registration_id . $upload_data['file_ext']; 
            //OK, save the file to our competition folder
            if (!copy($upload_data['full_path'], config_item('uploads').$this->competition_NAME() .'/'. $new_filename)){
                $this->session->set_flashdata('message_type','error');
                $this->session->set_flashdata('message_text',  'Sistem gagal menyalin file dari temporary folder');
                
                $this->write_log('Upload error: Failed to copy uploaded file to upload folder');
                redirect ('upload/index/'.$extracted_info->pn);
            }
            //remove the old file
            unlink($upload_data['full_path']);
            //save the file info into database
            
            $data_update = array(
                'registration_id' => $registration_id,
                'comp_id'   => $this->competition_ID(),
                'member_id' => $member_id,
                'upload_time'   => time(),
                'upload_ip' => $this->input->ip_address(),
                'original_filename' => $upload_data['file_name'],
                'file_name' => $new_filename,
                'file_type' => $upload_data['file_ext'],
                'mime_type' => $upload_data['file_type'],
                'file_size' => $upload_data['file_size'],
                'image_width' => $upload_data['image_width'],
                'image_height' => $upload_data['image_height'],
                'description' => $extracted_info->judul
            );
            $item_upload_id = $this->upload_m->save($data_update);
            
            $this->session->set_flashdata('message_type','info');
            $this->session->set_flashdata('message_text',  'Success upload '.$extracted_info->judul);
            
            $this->write_log('Upload success: '. json_encode($data_update));
            
            //create copy record to nominee table
            if (!isset($this->nominee_m)){
                $this->load->model('nominee_m');
            }
            $this->nominee_m->save(array(
                'comp_id'   => $this->competition_ID(),
                'stage'     => 1,
                'item_id'   => $item_upload_id,
                'score'     => 0,
                'rank'      => 0
            ));
            
            //redirect to upload index page
            redirect ('upload/index/'.$extracted_info->pn);
        }
        redirect ('upload/index');
    }
    
    function check_format(){
        $result = array();
        $filename = basename($this->input->get('filename'));
        
        if (!$this->_check_format_name($filename)){
            $result['success'] = 0;
            $result['message'] = 'Nama file tidak sesuai dengan format yang ditetapkan ('.$filename.')';
        }else{
            $result['success'] = 1;
        }
        
        echo json_encode($result);
    }
    
    private function _extract_upload_info($upload_data, $config, &$err_message=NULL){
        if ($upload_data['is_image']!=1){
            $err_message = 'File yang diunggah haruslah file image';
            return FALSE;
        }
        
        if (!$this->_check_format_name($upload_data['client_name'])){
            $err_message = 'Nama file tidak sesuai dengan format yang ditetapkan ('.$upload_data['client_name'].')';
            
            //remove the file
            unlink($upload_data['full_path']);
            return FALSE;
        }
        
        $info = new stdClass();
        
        $exploded = explode('_', $upload_data['file_name']);
                
        for($i=0; $i<count($config->elements); $i++){
            $element= $config->elements[$i];
            if ($i==count($config->elements)-1){
                $last_el = explode('.', $exploded[$i]);
                $info->$element = $last_el[0];
            }else{
                $info->$element = $exploded[$i]; 
            }
        }
        
        return $info;
    }
    
    private function _check_format_name($filename){
        if (!isset($this->config_m)){
            $this->load->model('config_m');
        }
        $config = $this->config_m->get_config_upload($this->competition_ID());
        $exploded = explode('_', $filename);
        if (count($exploded)!=count($config->elements)){
            return FALSE;
        }
        
        return TRUE;
    }
}

/* End of file home.php */
/* Location: ./application/controllers/upload.php */