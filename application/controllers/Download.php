<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Download extends CI_Controller {

    /**
     * __construct
     * 
     * this function calls the parent constructor.
     * @access public
     * @return void
     * @author 
     * */
    public function __construct() {
        parent::__construct();
        $data = $this->session->userdata('logged_in');
        $this->load->model('Usermodel');
        $this->load->model('Battle_model','battle');
        $this->load->model('Song_library_model', 'media');
        $this->load->library('encrypt');
        $this->load->helper('download');
        $this->config->load('battleme_config');
         
        //$this->load->model('Friendsmodel');
       // $this->load->model('Usermodel');
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function index() {
        $file_name = $this->uri->segment(3);
        $file_path = base64_decode($this->uri->segment(4));
        force_download($file_name, file_get_contents($file_path));
    }       
    
    /**
     * medai function
     * Download the media songs
     * @return file
     * @author Samiran
     * */
    public function media() {
        $param = $this->uri->segment(3); 
        if(isset($param)) {
            $params = $this->encrypt->decode(base64_decode($param));
            $params = explode('-', $params);
            $userId = $params[0];
            $mediaId = $params[1];
            
            $updateData = ['status' => 1];
            $this->db->set('number_of_times_download', 'number_of_times_download+1', FALSE);
            $this->db->update('media_download', $updateData, array('user_id' => $userId, 'media_id' => $mediaId));
            
            // get media file
            $fileName = null;
            $filePath = null;
            $mediaData = $this->media->getMediaDetails($mediaId);
            //echo '<pre>';            print_r($mediaData); echo $this->config->item('battle_media_path'); die;
            if(!is_null($mediaData['media']) && file_exists($this->config->item('library_media_path').$mediaData['media'])) {
                
                $fileName = str_replace(' ', '_', $mediaData['title']).'.'.pathinfo($mediaData['media'], PATHINFO_EXTENSION);
                $filePath = $this->config->item('library_media_path').$mediaData['media'];
                //force_download($fileName, file_get_contents($this->config->item('battle_media_path').$mediaData['media'])); 
            }
           
        }
        
        $data['file_name'] = $fileName;
        $data['file_path'] = $filePath;
        $data['middle'] = 'download';
        $data['div_col_unit'] = 'col-md-12';
        $this->load->view('templates/template', $data);
        
    }      
    
    public function cover_song() {
        $param = base64_decode($this->uri->segment(3)); 
        if(isset($param)) {
            $mediaId = $this->encrypt->decode($param); 
            // get media file
            $fileName = null;
            $filePath = null;
            $mediaData = $this->media->getMediaDetails($mediaId);
            //echo '<pre>';            print_r($mediaData); echo $this->config->item('battle_media_path'); die;
            if(!is_null($mediaData['media']) && file_exists($this->config->item('library_media_path').$mediaData['media'])) {
                
                $fileName = str_replace(' ', '_', $mediaData['title']).'.'.pathinfo($mediaData['media'], PATHINFO_EXTENSION);
                $filePath = $this->config->item('library_media_path').$mediaData['media'];
                force_download($fileName, file_get_contents($this->config->item('battle_media_path').$mediaData['media'])); 
                
            }
           
        }
    }
    
    public function freestyleLibrary() {
        
        $library_id = $this->uri->segment(3);
        $lib_dtl = $this->battle->getSingleLibrary($library_id);
        if(!empty($lib_dtl)) {
            $file_name = str_replace(' ', '_', strtolower($lib_dtl['title'])).'.'.pathinfo($lib_dtl['media'], PATHINFO_EXTENSION);
            if($lib_dtl['media'] != '' && file_exists(getcwd().'/uploads/freestyle_library/'.$lib_dtl['media'])) { 
                force_download($file_name, file_get_contents(getcwd().'/uploads/freestyle_library/'.$lib_dtl['media']));
            }
        }
        
    } 

   
}