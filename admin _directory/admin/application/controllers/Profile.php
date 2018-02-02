<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Profile extends CI_Controller {


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
      $this->session->set_flashdata('message', '');
      if ($this->session->userdata('admin_logged_in')) {
               
                 $session_data = $this->session->userdata('admin_logged_in');
               //print_r($session_data['id']);
                 $data = $this->Adminusermodel->get_admindetails($session_data['id']);
                
                     $this->load->view('profile',$data);
                ;
            } else {
                $this->session->set_flashdata('error', 'session not found');
                
                redirect('login');
            }
        
        
        
    }
    /**
     Profile details
     **/
   public function saveprofile() {
       $this->session->set_flashdata('message', '');
       
   if ($this->session->userdata('admin_logged_in')) {
       
                $session_data = $this->session->userdata('admin_logged_in');
               
            } else {
                $this->session->set_flashdata('error', 'session not found');
                
                redirect('login');
            }
            //$data = $this->Adminusermodel->get_admindetails($session_data['id']);
        $this->load->library('form_validation');
        $validate_rule = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            ),
        
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($validate_rule);

        if ($this->form_validation->run() == False) {
            $data = $this->Adminusermodel->get_admindetails($session_data['id']);
                     $this->load->view('profile',$data);
        }
        else{
            if($_FILES['userfile']['name']!=''){
                 $_FILES['userfile']['name']=  uniqid().$_FILES['userfile']['name'];
             $config['upload_path']          = getcwd().'/uploads';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))    
                {       
                        
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('message', $error);
                        $data = $this->Adminusermodel->get_admindetails($session_data['id']);
                     $this->load->view('profile',$data);
                        
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                          $admindata = array(
                            'name' => ucfirst(strtolower($this->input->post('name'))),
                            'email' => $this->input->post('email'),
                            'logo' => $data['upload_data']['file_name'],
                            'phone' => $this->input->post('phone')
                        );
                        $this->Adminusermodel->updateadminprofile($admindata,$session_data['id']);
                        $this->session->set_flashdata('Success', 'Profile Details updated');
                        redirect('profile');
                }
            }else{
                
                          $admindata = array(
                            'name' => $this->input->post('name'),
                            'email' => $this->input->post('email'),
                            'phone' => $this->input->post('phone')
                        );
                        
                        $this->Adminusermodel->updateadminprofile($admindata,$session_data['id']);
                        $this->session->set_flashdata('Success', 'Profile Details updated');
                        redirect('profile');
            }
            
                 
        }
   }
    /**
      * reset_passord function
      *
      * @return void
      * @author 
      **/
     public function reset($id,$key){
        $result = $this->Adminusermodel->get_user_data($id,$key);
        if($result){ 
          $d1 = new DateTime($result[0]->keycreated);
          $d2 = new DateTime(date('Y-m-d H:i:s'));
          $interval = $d1->diff($d2);
          if($interval->i < 5 ){ 
              $data['id'] = $id;
              $this->load->view('reset_password',$data);
          }else{
            $this->session->set_flashdata('error', 'recovery link expired!');
            redirect('login');
          }

        }else{
          $this->session->set_flashdata('error', 'unable to process your request!');
          redirect('login');
        }

     } 
     
     /**
      * update_password function
      * this function provides form to update user data
      * @return void
      * @author 
      **/
     public function update_password($id)
     {
        $this->load->library('form_validation');
        $validate_rule = array(
            array(
                'field' => 'password1',
                'label' => 'password',
                'rules' => 'required|alpha_numeric'
            ),
            array(
                'field' => 'password2',
                'label' => 'confirm-password',
                'rules' => 'required|matches[password1]'
            )
        );
        $this->form_validation->set_rules($validate_rule);

        if ($this->form_validation->run() == False) {
            $this->load->view('reset_password');
        }
        else{
            $data = array(
                'password' => md5($this->input->post('password1'))
                );
            $this->Adminusermodel->update_user_data($data,$id);
            $data = array(
                    'secret_key' => '',
                    'keycreated' => '' 
                );
            $this->session->set_flashdata('error', '');
            $this->Adminusermodel->update_user_data($data, $id);
            redirect('user/login');
        }
     }


}       

    ?>