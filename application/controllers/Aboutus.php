<?php
/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Aboutus extends CI_Controller {

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
        if (empty($data)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        }
        $this->load->model('Friendsmodel');
        $this->load->model('Song_library_model' , 'songs');
        $this->load->model('Usermodel');
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function index() {
        $this->load->helper('form');
        $data['top_songs'] = $this->songs->get_top_songs();
	$data['top_user'] = $this->Usermodel->get_top_user();
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $this->load->view('aboutus', $data);
        
    }       

   
}