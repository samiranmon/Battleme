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
    /*User Management start*/
     public function get_user_details() {
       $data=$this->Usermodel->get_all_user();
       
                foreach($data as $key => $value)
                {
                    $data[$key] = (array) $value;
                   //$data[$key]['id']
                    $membership=$this->Usermodel->get_user_membership($data[$key]['id']);
                    if($membership['membership']){
                        $data[$key]['member_type']=$membership['membership'];
                    }else{
                        $data[$key]['member_type']='Not Subscribed';
                    }
                    
                }
                $data=array('user'=>$data);
               //print_r($data['user'][0]['member_type']);
        $this->load->view('userdetails',$data);
        //print_r($data);
    }
    public function edit_user_details($id) {
       
       $data=$this->Adminusermodel->get_user_details($id);
       
       $this->load->view('edituser',$data);
    }
    public function delete_user_details($id) {
       
       $data=$this->Adminusermodel->delete_user_details($id);
        if($data){
           redirect('admin_dashboard/get_user_details');
       }
       //$this->load->view('edituser',$data);
    }
    public function view_user_details($id) {
       
       $data=$this->Adminusermodel->get_user_details($id);
       
       $this->load->view('viewuser',$data);
    }
    public function save_user_details($id) {
        $this->load->library('form_validation');
        
        $data=$this->Adminusermodel->get_user_details($id);
        $validate_rule = array(
            array(
                'field' => 'firstname',
                'label' => 'Firstname',
                'rules' => 'required'
            ),
            array(
                'field' => 'lastname',
                'label' => 'Lastname',
                'rules' => 'required'
            ),
            array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'required'
            ),
            array(
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'aboutme',
                'label' => 'About me',
                'rules' => 'required'
            ),
            array(
                'field' => 'info',
                'label' => 'Info',
                'rules' => 'required'
            ),
            array(
                'field' => 'paypal',
                'label' => 'Paypal Account Id',
                'rules' => 'trim|valid_email'
            ),
        );
        
         $this->form_validation->set_rules($validate_rule);
         
         if ($this->form_validation->run() == False) {
            //$data = $this->Adminusermodel->get_admindetails($session_data['id']);
                     $this->load->view('edituser',$data);
        }else{
             $filename = $data['profile_picture'];
            $cover_imagename = $data['cover_picture'] ;
            if ($_FILES['profilepicture']['name'] != '') {
                if ($data['profile_picture'] != '') {
                    unlink( '/home2/pranay/public_html/samiran/battleme/uploads/profile_picture/' . $data['profile_picture']);
                    unlink( '/home2/pranay/public_html/samiran/battleme/uploads/profile_picture/thumb_' . $data['profile_picture']);
                }
                $filename = $this->upload_image('profilepicture');
            }
            if ($_FILES['cover_picture']['name'] != '') {
                if ($data['cover_picture'] != '') {
                    unlink('/home2/pranay/public_html/samiran/battleme/uploads/cover_picture/' . $data['cover_picture']);
                }
                $cover_imagename = $this->upload_cover_image('cover_picture');
            } 
            
            $savedata = array(
                'firstname' => ucfirst(strtolower($this->input->post('firstname'))),
                'lastname' => ucfirst(strtolower($this->input->post('lastname'))),
                'phone_no' => ucfirst(strtolower($this->input->post('phone_no'))),
                'city' => ucfirst(strtolower($this->input->post('city'))),
                'profile_picture' => $filename,
                'cover_picture' => $cover_imagename,
                'country' => ucfirst(strtolower($this->input->post('country'))),
                'aboutme' => $this->input->post('aboutme'),
                'info' => $this->input->post('info'),
                'paypal_account_id' => $this->input->post('paypal')
            );
            //print_r($this->input->post('lastname'));
            $status = $this->Usermodel->admin_update_user_profile($data['id'], $savedata);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('Success', "Profile has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('Success', "Unable to update. Please try again!");
            }
            redirect('admin_dashboard/edit_user_details/'.$data['id']);
         }
         
    }
     /**
     * upload_image function
     * this function uploads the image
     * @access public
     * @param name of input type 
     * @return void
     * @author 
     * */
    function upload_image($name) {
        $target_dir = '/home2/pranay/public_html/samiran/battleme/uploads/profile_picture/';
        
        $config['upload_path'] = $target_dir;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
        $config['encrypt_name'] = TRUE;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 225;
        $config['height'] = 225;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        //if dir doesnot exist create it with 0755 permission
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        if (!$this->upload->do_upload($name)) {
            $error = array('error' => $this->upload->display_errors());
            echo "<pre>";
            print_r($error);
            exit;
        } else {
            $data = array('upload_data' => $this->upload->data());
            // $thumbnail = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
            $this->resize_image($data['upload_data']['file_name']);
            $this->big_resize_image($data['upload_data']['file_name']);
            return $data['upload_data']['file_name'];
        }
    }

    /**
     * upload_image function
     * this function uploads the image
     * @access public
     * @param name of input type 
     * @return void
     * @author 
     * */
    function upload_cover_image($name) {
        $target_dir = '/home2/pranay/public_html/samiran/battleme/uploads/cover_picture/';
        $config['upload_path'] = $target_dir;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
       // $config['max_size']             = 70000;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        //if dir doesnot exist create it with 0755 permission
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        if (!$this->upload->do_upload($name)) {
            $error = array('error' => $this->upload->display_errors());
            echo "<pre>";
            print_r($error);
            exit;
        } else {
            $data = array('upload_data' => $this->upload->data());
            //echo '<pre>'; print_r($data); die(); 
            // $thumbnail = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
            $this->cover_resize_image($data['upload_data']['file_name']);
            return 'resize_'.$data['upload_data']['file_name'];
        }
    }
     public function resize_image($image_name) {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = '/home2/pranay/public_html/samiran/battleme/uploads/profile_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'thumb_' . $image_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 80;
        $config['height'] = 80;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    public function big_resize_image($image_name) {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = '/home2/pranay/public_html/samiran/battleme/uploads/profile_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'medium_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 565;
        $config['height'] = 441;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    
    public function cover_resize_image($image_name) {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = '/home2/pranay/public_html/samiran/battleme/uploads/cover_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'resize_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 800;
        $config['height'] = 250;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()) {
            unlink('/home2/pranay/public_html/samiran/battleme/uploads/cover_picture/' .$image_name);
        }
    }
    /*user Management end*/
    /*membership management start*/
    public function get_membership_details() {
       $data=$this->Usermodel->get_membership();
       
                foreach($data as $key => $value)
                {
                    $data[$key] = (array) $value;
                }
                $data=array('user'=>$data);
        $this->load->view('membershipdetails',$data);
        //print_r($data);
    }
    public function edit_membership_details($id) {
       
       $data=$this->Adminusermodel->get_member_details($id);
       
       $this->load->view('editmembership',$data);
    }
    public function save_membership_details($id) {
        $this->load->library('form_validation');
        
        $data=$this->Adminusermodel->get_member_details($id);
        $validate_rule = array(
            array(
                'field' => 'membership',
                'label' => 'Membership',
                'rules' => 'required'
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'required'
            ),
            array(
                'field' => 'membership_days',
                'label' => 'Membership Days',
                'rules' => 'required'
            ),
            array(
                'field' => 'membership_amount',
                'label' => 'Membership Amount',
                'rules' => 'required'
            ),
            
        );
        
         $this->form_validation->set_rules($validate_rule);
         
         if ($this->form_validation->run() == False) {
            //$data = $this->Adminusermodel->get_admindetails($session_data['id']);
                     $this->load->view('editmembership',$data);
        }else{
            $savedata = array(
                'membership' => ucfirst(strtolower($this->input->post('membership'))),
                'description' => ucfirst(strtolower($this->input->post('description'))),
                'membership_days' => ucfirst(strtolower($this->input->post('membership_days'))),
                'membership_amount' => ucfirst(strtolower($this->input->post('membership_amount')))
            );
            //print_r($this->input->post('lastname'));
            $status = $this->Usermodel->admin_update_membership($id, $savedata);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('Success', "Membership details has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('Success', "Unable to update. Please try again!");
            }
            redirect('admin_dashboard/edit_membership_details/'.$id);
         }
         
    }
    /*membership management end*/
    /*site Setting Management start*/
    public function get_sitesetting_details() {
       $data=$this->Usermodel->sitesetting();
       
                foreach($data as $key => $value)
                {
                    $data[$key] = (array) $value;
                }
                $data=array('user'=>$data);
        $this->load->view('sitesetting',$data);
        //print_r($data);
    }
    public function edit_sitesetting_details($id) {
       
       $data=$this->Adminusermodel->get_sitesetting_details($id);
       
       $this->load->view('editsitesetting',$data);
    }
     public function save_sitesetting_details($id) {
        $this->load->library('form_validation');
        
        $data=$this->Adminusermodel->get_sitesetting_details($id);
            $savedata = array(
                'value' => trim($this->input->post('value')),
                'status' => trim($this->input->post('status'))
            );
            //print_r($this->input->post('lastname'));
            $status = $this->Usermodel->admin_update_sitesetting($id, $savedata);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('Success', "Site Setting has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('Success', "Unable to update. Please try again!");
            }
            redirect('admin_dashboard/edit_sitesetting_details/'.$id);
         
         
    }
    /*Site setting management end*/
    
}