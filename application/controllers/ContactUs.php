<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class ContactUs extends CI_Controller {


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
        $this->load->helper('randomstring_helper');
        $this->load->model('Usermodel');
        $this->load->library('email');
    }

    /**
     * index
     * 
     * this function is calls the loginpage
     * @access public
     * @return void
     * @author 
     * */
    public function index() {
        $this->load->library('form_validation');
        $validate_rule = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'subject',
                'label' => 'Subject',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'trim|required'
            ),
        );
        $this->form_validation->set_rules($validate_rule);

        if ($this->form_validation->run() == False) {
            $this->load->view('contact_us');
        } else {
                $email =  $this->input->post('email');
                $subject =  $this->input->post('subject');
                $message =  $this->input->post('message');
                $this->db->insert('contact_us', ['email'=>$email,'subject'=>$subject,'message'=>$message,'time'=>date('Y-m-d H:i:s')]); 
                
                $this->load->model('Sendmailmodel');
                $this->session->set_flashdata('message', 'Your message has been send to the site administrator');
                
                $_siteSetting = getSiteSettingById(6);
                
                $msg = 'A user contact to with you, please login the site admin';
                $this->email->from('noreply@mydevfactory.com', 'Your Battleme Team');
                $this->email->to($_siteSetting['value']);
                $this->email->set_mailtype("html");
                $this->email->subject('Contact Us your Battleme Team');
                $this->email->message($msg);
                $this->email->send();
                
                 redirect('contactUs');
            
        }
    }

    


}