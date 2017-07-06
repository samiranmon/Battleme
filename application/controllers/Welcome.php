<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Welcome extends CI_Controller {

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
         $this->load->model('Friendsmodel');
         
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
        $data['middle'] = 'welcome';
        $data['div_col_unit'] = 'col-md-12';
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $this->load->view('templates/template', $data);
    }       

   
}