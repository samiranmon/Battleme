<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Changeadminpassword extends CI_Controller {

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
        $this->load->model('Adminusermodel');
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
        if ($this->session->userdata('admin_logged_in')) {

            $session_data = $this->session->userdata('admin_logged_in');
        } else {
            $this->session->set_flashdata('error', 'session not found');

            redirect('login');
        }
        $this->load->view('adminpassword');
    }

    public function reset() {
         if ($this->session->userdata('admin_logged_in')) {

            $session_data = $this->session->userdata('admin_logged_in');
        } else {
            $this->session->set_flashdata('error', 'session not found');

            redirect('login');
        }
        
        $data = $this->Adminusermodel->get_admindetails($session_data['id']);
        
        $this->load->library('form_validation');
        $validate_rule = array(
            array(
                'field' => 'cpassword',
                'label' => 'current password',
                'rules' => 'required|alpha_numeric'
            ),
            array(
                'field' => 'npassword',
                'label' => 'new password',
                'rules' => 'required|alpha_numeric'
            ),
            array(
                'field' => 'cnpassword',
                'label' => 'confirm-password',
                'rules' => 'required|matches[npassword]'
            )
        );
        $this->form_validation->set_rules($validate_rule);

        if ($this->form_validation->run() == False) {
            $this->load->view('adminpassword');
        } else {
            
            if (md5($this->input->post('cpassword')) != $data['password']) {
                $this->session->set_flashdata('error', 'Please provide correct password');
                redirect('changeadminpassword');
            } else {
                $admindata = array(
                            'password' => md5($this->input->post('npassword'))
                        );
                        $this->Adminusermodel->updateadminprofile($admindata,$session_data['id']);
                        $this->session->set_flashdata('Success', 'Password Chnaged');
                redirect('changeadminpassword');
            }

//            $data = array(
//                'password' => md5($this->input->post('password1'))
//                );
//            $this->Usermodel->update_user_data($data,$id);
//            $data = array(
//                    'secret_key' => '',
//                    'keycreated' => '' 
//                );
//            $this->Usermodel->update_user_data($data, $id);
//            redirect('user/login');
        }
    }

}
