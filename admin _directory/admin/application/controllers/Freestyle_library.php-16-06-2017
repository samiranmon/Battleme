<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Freestyle_library extends CI_Controller {

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
        $this->load->model('Freestyle_model','freestyle');
        $this->load->helper('randomstring_helper');
        $this->load->library('user_agent');
        $this->load->library('Common_lib');
    }
    
    public function index() {
        
        $_session = $this->session->userdata('admin_logged_in');
        if (empty($_session)) {
                $this->session->set_flashdata('error', 'session not found');
                redirect('login');
        }
            
             $data['library_details'] = $this->freestyle->getFerrstyleList();
             //echo '<pre>'; print_r($data); die();
                
        $this->load->view('freestyle_library',$data);
        
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
    
    public function update_library($id) {
       
       $data['freestyle']=$this->freestyle->getSingleLibrary($id);
       
       $this->load->view('freestyle_library_update',$data);
    }
    
    public function add_library($id=null) {
       
       $data['freestyle']=$this->freestyle->getSingleLibrary($id);
       
       $this->load->view('freestyle_library_update',$data);
    }
    
    public function delete_library($id) {
       
       $data=$this->freestyle->deleteLibrary($id);
        if($data){
           redirect('freestyle_library');
       }
       //$this->load->view('edituser',$data);
    }
    
    public function view_user_details($id) {
       
       $data=$this->Adminusermodel->get_user_details($id);
       
       $this->load->view('viewuser',$data);
    }
    
    public function update_freestyle_library($id =null) { 
         
        $data['freestyle'] = $this->freestyle->getSingleLibrary($id);
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
            
        if($id ==null ) {
            if (empty($_FILES['media']['name'])) {
               $this->form_validation->set_rules('media', 'Media File', 'trim|required');
            }
        }  
        
         if ($this->form_validation->run() == False) {
            //$data = $this->Adminusermodel->get_admindetails($session_data['id']);
                     $this->load->view('freestyle_library_update',$data);
        } else {
            
             $filename = $data['freestyle']['media'];
             $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
             
            if ($_FILES['media']['name'] != '') {
                 if($filename != '' && file_exists($getcwd.'/uploads/freestyle_library/'.$filename)) {
                     unlink($getcwd.'/uploads/freestyle_library/'.$filename);
                 }
                $filename = $this->upload_image('media');
            }
            
            $savedata = array(
                'title' => ucfirst($this->input->post('title')),
                'status' => $this->input->post('status'),
                'media' => $filename,
            );
            
            if($id ==null ) {
                
                $status = $this->freestyle->addFreestyleLibrary($savedata);
                if ($status) {
                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('Success', "Library has been added successfully");
                } else {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('Success', "Unable to add. Please try again!");
                }
                redirect('freestyle_library/');
                
            } else {
                $status = $this->freestyle->updateFreestyleLibrary($data['freestyle']['id'], $savedata);
                if ($status) {
                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('Success', "Library has been updated successfully");
                } else {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('Success', "Unable to update. Please try again!");
                }
                redirect('freestyle_library/update_library/'.$data['freestyle']['id']);
            }
            
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
        $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
        $target_dir = $getcwd.'/uploads/freestyle_library/';
        
        $config['upload_path'] = $target_dir;
        $config['allowed_types'] = 'mp3|wma|wav|ra|ram|rm|mid|ogg';
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