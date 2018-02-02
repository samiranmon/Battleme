<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Forgetpassword extends CI_Controller {


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
        $this->load->library('form_validation');
        $validate_rule = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            )
        );
        $this->form_validation->set_rules($validate_rule);

        if ($this->form_validation->run() == False) {
            $this->load->view('forget_password');
        }
        else{
            $email =  $this->input->post('email');
            $result = $this->Adminusermodel->check_user_data($email);
            if(empty($result)){
                $this->session->set_flashdata('message', 'Wrong Admin Panel User name');
                redirect('forgetpassword');
            }
            else{ 
                $this->load->model('Sendmailmodel');
                $this->session->set_flashdata('message', 'Mail has been send to your email id');
                $key = randomstring();
                $data = array(
                    'secret_key' => $key,
                    'keycreated' => date('Y-m-d H:i:s') 
                );
                $this->Adminusermodel->update_user_data($data,$result[0]->id);
                $subject = "Battleme Admin Password reset";
                $body = "Hi ".$result[0]->firstname."<br>";
                $body .= "please click on link to reset your admin panel password.<br>";
                $body .= "<a target='_blank' href='".base_url()."forgetpassword/reset/".$result[0]->id."/".$key."'>reset yout password by clicking here</a><br><br>";
                $body .= "Thankyou.";
                $this->Sendmailmodel->sendmail($result[0]->email, $subject, $body);
                 redirect('forgetpassword');
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
                $this->Adminusermodel->update_user_data($data, $id);
            $this->session->set_flashdata('success', 'Password Reset successfully');
            //$this->session->set_flashdata('error', ' ');
            
            redirect('user/reset_success');
        }
     }


}       

    ?>