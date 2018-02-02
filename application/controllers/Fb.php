<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'libraries/Facebook.php';

class Fb extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load('config_facebook');
    }

    public function logout() {
        $signed_request_cookie = 'fbsr_' . $this->config->item('appID');
        setcookie($signed_request_cookie, '', time() - 3600, "/");
        $this->session->sess_destroy();  //session destroy
        redirect('/', 'refresh');  //redirect to the home page
    }

    public function fblogin() {

        $facebook = new Facebook(array(
            'appId' => $this->config->item('appID'),
            'secret' => $this->config->item('appSecret'),));

        $user = $facebook->getUser(); // Get the facebook user id
        $profile = NULL;
        $logout = NULL;
        
        if ($user) {
            try {
                $profile = $facebook->api('/me');  //Get the facebook user profile data
                $access_token = $facebook->getAccessToken();
                $params = array('next' => base_url('fb/logout/'), 'access_token' => $access_token);
                $logout = $facebook->getLogoutUrl($params);
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
            }
            //echo '<pre>';        print_r($profile); die;
            
            $this->load->model('Usermodel');
            $this->load->model('UserMemberships');

            $array = array('firstname' => $profile['name'],
                'lastname' => '',
                'email' => '',
                'fb_id' => $profile['id'],
                'user_type' => 'fan',
                'created_on' => date("Y-m-d"));

            $result = $this->Usermodel->adduser($array);

            $data['fb_id'] = $user;
            $data['id'] = $result[0]['id'];
            $data['profile_picture'] = '';
            $data['cover_picture'] = '';
            $data['logout'] = $logout;

            $data['user_type'] = $result[0]['user_type'];

            $membership = $this->UserMemberships->get_membership_user(array('user_id' => $result[0]['id']));
            if (!empty($membership)) {
                $data['membership_id'] = $membership[0]['memberships_id'];
                $data['membership_name'] = $membership[0]['membership'];
            }

            $this->session->set_userdata('logged_in', $data);

            redirect('home');
        }
    }
    
    public function fb_api_login(){
        $data = $this->input->post('data');
        
        //echo '<pre>';        print_r($data); die;
        
        if(isset($data['id'])) {
            $this->load->model('Usermodel');
            $this->load->model('UserMemberships');
            
            $firstname = $data['name'];
            $lastname = '';
            if (strpos($data['name'], ' ') !== false) {
                $name = explode(' ', $data['name']);
                $firstname = $name[0];
                $lastname = $name[1];
            } 

            $array = array('firstname' => $firstname,
                'lastname' => $lastname,
                'email' => isset($data['email'])?$data['email']:'',
                'fb_id' => $data['id'],
                'user_type' => 'fan',
                'created_on' => date("Y-m-d"));

            $result = $this->Usermodel->fb_api_adduser($array);

            $return['fb_id'] = $data['id'];
            $return['id'] = $result['id'];
            $return['profile_picture'] = '';
            $return['cover_picture'] = '';
            $return['user_type'] = $result['user_type'];
            $return['name'] = ucwords($result['firstname'].' '.$result['lastname']);

            $membership = $this->UserMemberships->get_membership_fb(array('user_id' => $result['id']));
            if (!empty($membership)) {
                $return['membership_id'] = $membership['memberships_id'];
                $return['membership_name'] = '';
            }
            $this->session->set_userdata('logged_in', $return);
            echo 1; 
        }
    }

    public function test() {

        echo '<pre>';
        print_r($this->session->all_userdata());
        
        die;
    }

}

/* End of file fb.php */
/* Location: ./application/controllers/fb.php */