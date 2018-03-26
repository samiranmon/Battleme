<?php
/**
 * this class has functions that perform Chalange a Artist operation
 * @package Artist_registry
 * @subpackage controller
 * @author 
 * */
class Page extends CI_Controller {

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
        /* if (empty($data)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        } */
        $this->load->model('Friendsmodel', 'friends');
        $this->load->model('Song_library_model' , 'library');
        $this->load->model('Usermodel', 'user');
        $this->load->model('battle_model', 'battles');
        $this->sessionData = get_session_data();
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function terms_and_conditions() {
        
        $user_id = $this->sessionData['id'];
        $arrData['middle'] = 'cms_page';
        $arrData['div_col_unit'] = 'col-md-12';
        $arrData['page_details'] = $this->user->getCmsPage(1);
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
        
    }     
    
       public function how_it_works() {
        
        $user_id = $this->sessionData['id'];
        $arrData['middle'] = 'cms_page';
        $arrData['div_col_unit'] = 'col-md-12';
        $arrData['page_details'] = $this->user->getCmsPage(8);
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
        
    } 

   
}