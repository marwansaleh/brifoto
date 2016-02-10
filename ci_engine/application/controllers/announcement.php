<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Announcement
 *
 * @author Marwan Saleh <marwan.saleh@ymail.com>
 */
class Announcement extends MY_Controller {
    function __construct() {
        parent::__construct();        
        //Load models
        $this->load->model(array('upload_m','member_m'));
        
        $this->data['menu_active'] = 'announcement';
    }
    
    function index(){      
        //get champion image
        
        
        
        
        $champ01 = new stdClass();
        $champ01->image_url = 'bfc_2015-06.jpg';
        $champ01->description = 'Akrabnya BRI';
        $champ01->name = 'Juara I: Reza Erry Sadewa';
        $champ01->uker = 'Unit Pandangan';
        
        $champ02 = new stdClass();
        $champ02->image_url = 'bfc_2015-03.jpg';
        $champ02->description = 'Saya Mau Menabung di BRI';
        $champ02->name = 'Juara II: Muh.Rifki Arsyad';
        $champ02->uker = 'Kanwil Makassar';
        
        $champ03 = new stdClass();
        $champ03->image_url = 'bfc_2015-02.jpg';
        $champ03->description = 'Menuai Hasil Bersama BRI';
        $champ03->name = 'Juara III: JoellyPrasetyo';
        $champ03->uker = 'Uker Persahabatan';
        
        $champs = array($champ01,$champ02,$champ03);
        $this->data['champs'] = array();
        foreach ($champs as $item){
            $item->image_url = 'userfiles/champs/competition_'. $this->competition_TMPL() . '/' . $item->image_url;
            $this->data['champs'] [] = $item;
        }
        
        $this->data['subview'] = $this->competition_TMPL() . '/announcement/index';
        $this->load->view($this->competition_TMPL() . '/_layout_main', $this->data);
    }
    
}

/* End of file home.php */
/* Location: ./application/controllers/announcement.php */