<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Admin_dashboard extends CI_Controller {

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
        $this->load->model('Adminusermodel');
         $this->load->model('Usermodel');
        $this->load->helper('randomstring_helper');
        $this->load->library('user_agent');

        $this->load->library('Common_lib');

        $this->load->library('Paypal_lib');
    }
    public function index() {
        if ($this->session->userdata('admin_logged_in')) {
                $email = $this->input->post('email');
                $session_data = $this->session->userdata('admin_logged_in');
                $data['email'] = $session_data['email'];
               
                $data = $this->Adminusermodel->get_count_user_battle();
                
                foreach($data['allmember_count'] as $key => $value)
                {
                    $data1[$key] = $value;
                    
                }
                //print_r(sizeof($data['activebattle']));
                if(sizeof($data['activebattle'])<=0){
                    $activebattle=0;
                }else{
                    $activebattle=$data['activebattle'][0]['count'];
                }
                $newdata=array('user'=>$data['user'],'battle'=>$data['battle'],'tournament'=>$data['tournament'],'allmember_count'=>$data1,'activebattle'=>$activebattle);
                
                //print_r($newdata);
                $this->load->view('admin_dashboard',$newdata);
            } else {
                $this->session->set_flashdata('error', 'session not found');
                
                redirect('login');
            }
        
        
    }
     public function get_user_details() {
       $data=$this->Usermodel->get_all_user();
       
                foreach($data as $key => $value)
                {
                    $data[$key] = (array) $value;
                }
                $data=array('user'=>$data);
        $this->load->view('userdetails',$data);
        //print_r($data);
    }
    public function edit_user_details($id) {
       echo $id;
       $data=$this->Adminusermodel->get_user_details($id);
       print_r($data);
       $this->load->view('edituser');
    }
    
}