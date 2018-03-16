<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class ContactUs extends CI_Controller {

    public $sessionData;
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
        $this->load->model('Friendsmodel', 'friends');
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->sessionData = get_session_data();
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
                
                $this->session->set_flashdata('message', 'Your message has been send to the site administrator');
                $_siteSetting = getSiteSettingById(6);
                
                $msg = 'A user contact to with you, please login the site admin';
                $this->email->from('noreply@battleme.hiphop', 'Your Battleme Team');
                $this->email->to($_siteSetting['value']);
                $this->email->set_mailtype("html");
                $this->email->subject('Contact Us your Battleme Team');
                $this->email->message($msg);
                $this->email->send();
                
                 redirect('contactUs');
        }
    }

    
    public function get_in_touch() {
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
            $arrData['middle'] = 'touch_us';
            $arrData['div_col_unit'] = 'col-md-12';
            $arrData['user_dtl'] = $this->sessionData;
            $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
            $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
            $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
            $arrData['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
            $this->load->view('templates/template', $arrData);
            
        } else {
            $_siteSetting = getSiteSettingById(6);
            
            $email =  $this->input->post('email');
            $subject =  $this->input->post('subject');
            $message =  $this->input->post('message');
            $this->db->insert('contact_us', ['email'=>$email,'subject'=>$subject,'message'=>$message,'time'=>date('Y-m-d H:i:s')]); 

            $this->session->set_flashdata('class', 'alert-success');
            $this->session->set_flashdata('message', 'Your message has been sent successfully. Admin will contact you shortly');

            $this->email->from('noreply@battleme.hiphop', 'Your Battleme Team');
            $this->email->to($_siteSetting['value']);
            $this->email->set_mailtype("html");
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();

            redirect('contactUs/get_in_touch');
        }
    }

}