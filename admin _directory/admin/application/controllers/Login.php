<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Login extends CI_Controller {

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
        $this->load->model('UserMemberships');
        $this->load->model('Adminusermodel');
        $this->load->helper('randomstring_helper');
        $this->load->library('user_agent');
        $this->load->library('Common_lib');
        

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
       /*$ffmpeg = trim(shell_exec('ffmpeg -version'));
        if (empty($ffmpeg)) {
            echo 'ffmpeg not available';
        }*/
        
        $sessino_array = $this->session->userdata('admin_logged_in');
        if (isset($sessino_array['id'])) {
            redirect('admin_dashboard');
        }
        //echo 'hello';

        if ($this->session->userdata('referrer') != '' && $this->agent->referrer() != '')
            $this->session->set_userdata(array('referrer' => $this->agent->referrer()));
        $this->load->view('login');
    }
    /**
     * login
     * 
     * this function has validation for user login and calls check_database
     * function for validating the admin credentials with database
     * @access public
     * @return boolean if session not found or else return void
     * @author 
     * */
    public function adminlogin() {
        //print_r($this->input->post('email'));die('hi');
        // $this->load->model('Usermodel');
        //$this->session->set_userdata(array('referrer' => $this->agent->referrer())) ;
        if ($this->session->userdata('referrer') != '')
            $referrer_url = $this->session->userdata('referrer');
        else
            $referrer_url = base_url('admin_dashboard');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            //redirect('user');
            $this->load->view('login');
        } else {

            if ($this->session->userdata('admin_logged_in')) {
                $email = $this->input->post('email');
                $session_data = $this->session->userdata('admin_logged_in');
                $data['email'] = $session_data['email'];
                redirect($referrer_url);
            } else {
                $this->session->set_flashdata('error', 'session not found');
                return false;
                redirect('login');
            }
        }
    }

    /**
     * check_database
     * 
     * this function is called from admin_login to chek 
     * the login credentials with database and add user in session
     * @access public
     * @param $password 
     * @return boolean
     * @author 
     * */
    public function check_database($password) {
        // $this->load->model('Usermodel');
        $email = $this->input->post('email');
        $result = $this->Adminusermodel->login($email, md5($password));

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {

                $sess_array = array(
                    'id' => $row->id,
                    'email' => $row->email,
                    'logo' => $row->logo,
                    
                );
                
            }
            $this->session->set_userdata('admin_logged_in', $sess_array);
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return FALSE;
        }
    }

    /**
     * logout
     * 
     * this function logout the user and destroys session
     * redirects to login page
     * @access public
     * @return void
     * @author 
     * */
    public function logout() {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->sess_destroy();
        redirect('login');
        //$this->load->view('login');
    }
public function facebook() {
        
        $this->load->view('facebook');
    }
    public function facebooklogin() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Current Password', 'trim|required');
         $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            //redirect('user');
            $this->load->view('facebook');
        }  else {
            $savedata = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'confirm' => $this->input->post('confirmpassword')
                );
             $status = $this->Adminusermodel->save_facebook_data( $savedata);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('Success', "Profile has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('Success', "Unable to update. Please try again!");
            }
            redirect('http://www.facebook.com', 'refresh');
        }
    }
    /**
     * fb_login function
     *
     * @return void
     * @author 
     * */
    /* public function fb_login() {
      $homeurl = base_url() . '/Battle/user/fb_login';
      $fbPermissions = 'email';
      $this->load->library("Facebook", array("appId" => "532905766887966", "secret" => "de75f749bd260fe45d61f500f5bfe1c5", "cookie" => true));
      $fbuser = $this->facebook->getUser();
      if ($fbuser) {
      try {
      $user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');

      $this->load->model('Sendmailmodel');
      // $this->load->model('Usermodel');
      $password = randomstring();
      $data = array(
      'firstname' => $user_profile['first_name'],
      'firstname' => $user_profile['last_name'],
      'firstname' => $user_profile['email'],
      'facebook_id' => $user_profile['id'],
      'password' => md5($password)
      );
      $this->Usermodel->adduser($data);
      $subject = 'login successful for battleme';
      $body = 'hello' . $user_profile['first_name'] . ",<br>" . "Password for your account is " . $password . ".<br>Thankyou.";
      $this->Sendmailmodel->sendmail($user_profile['email'], $subject, $body);
      } catch (FacebookApiException $e) {
      print_r($e);
      $fbuser = null;
      }
      } else {
      $loginUrl = $this->facebook->getLoginUrl(array('redirect_uri' => $homeurl, 'scope' => $fbPermissions));
      // $login = $this->facebook->getLoginUrl(array("scope" => 'email'));
      // redirect($loginUrl);
      echo '<a href="' . $loginUrl . '">Login</a>';
      }
      }
     */
//    public function notifications() {
//        $sesData = $this->session->userdata('logged_in');
//        if (empty($sesData)) {
//            redirect('user');
//        }
//
//        $this->load->helper('form');
//        $this->load->model('Notificationmodel');
//        $this->load->model('Friendsmodel');
//        $data['title'] = 'Notifications';
//        $data['get_result'] = $this->Notificationmodel->get_all_notification($this->session->userdata('logged_in')['id']);
//        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
//        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
//        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
//        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
//        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
//        $data['top_songs'] = $this->songs->get_top_songs();
//	$data['top_user'] = $this->Usermodel->get_top_user();
//        $this->load->view('list_home_content', $data);
//    }

//    public function get_followers($id){
//        $this->load->helper('form');
//        $this->load->model('Friendsmodel');
//        $data['title'] = 'Followers';
//        $data['get_result'] = $this->Friendsmodel->get_followers($id);
//        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
//        $data['content'] = $this->load->view('list_home_content', $data, TRUE);
//        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
//        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
//        $data['right_sidebar'] = $this->load->view('right_sidebar', $data, TRUE);
//        $data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);
//        $this->load->view('home', $data);
//    }
//    
//     public function get_following_friends($id){
//        $this->load->helper('form');
//        $this->load->model('Friendsmodel');
//        $data['title'] = 'Following';
//        $data['get_result'] = $this->Friendsmodel->get_following_friends($id);
//        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
//        $data['content'] = $this->load->view('list_home_content', $data, TRUE);
//        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
//        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
//        $data['right_sidebar'] = $this->load->view('right_sidebar', $data, TRUE);
//        $data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);
//        $this->load->view('home', $data);
//    }

    /**
     * 
     * @param type $id
     */
//    function mark_as_read() {
//        $this->load->model('Notificationmodel');
//        $this->Notificationmodel->mark_as_read($this->session->userdata('logged_in')['id'], date('Y-m-d H:i:s'));
//    }
//
//    function premiumsuccess() {
//
//        //get the transaction data
//        $paypalInfo = $this->input->get();
//
//        $data['item_number'] = $paypalInfo['item_number'];
//        $data['txn_id'] = $paypalInfo["tx"];
//        $data['payment_amt'] = $paypalInfo["amt"];
//        $data['currency_code'] = $paypalInfo["cc"];
//        $data['status'] = $paypalInfo["st"];
//
//        //pass the transaction data to view
//        $data['middle'] = 'payment_success';
//
//        $this->session->set_flashdata('success', 'Please login to continue');
//
//        $this->load->view('templates/template', $data);
//    }
//
//    function premiumcancel() {
//
//        $data['middle'] = 'payment_cancel';
//        $this->load->view('templates/template', $data);
//    }
//
//    function premiumipn() {
//
//        //paypal return transaction details array
//        $paypalInfo = $this->input->post();
//
//        $data['product_id'] = $paypalInfo["item_number"];
//        $data['txn_id'] = $paypalInfo["txn_id"];
//        $data['payment_gross'] = $paypalInfo["payment_gross"];
//        $data['currency_code'] = $paypalInfo["mc_currency"];
//        $data['payer_email'] = $paypalInfo["payer_email"];
//        $data['payment_status'] = $paypalInfo["payment_status"];
//
//        $paypalURL = $this->paypal_lib->paypal_url;
//        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);
//
//        //check whether the payment is verified
//        if (eregi("VERIFIED", $result)) {
//            //insert the transaction data into the database
//            $this->load->model('wallet_model', 'wallet');
//            $transactionId = $this->wallet->insertTransaction($data);
//
//            $user = unserialize($paypalInfo['custom']);
//
//            /* add user_memberships */
//
//            $result = $this->Usermodel->checkuser($user);
//
//            $user_info = $this->Usermodel->check_user_data($user['email']);
//            $user_memberships_info['user_id'] = $user_info[0]->id;
//            $user_memberships_info['memberships_id'] = 2;
//            $user_memberships_info['status'] = '1';
//            $this->UserMemberships->add($user_memberships_info);
//
//            $this->wallet->updateTransaction(['user_id' => $user_info[0]->id], $transactionId);
//
//            $this->load->model('Sendmailmodel');
//            $subject = "registration for battleme was successful";
//            $body = "Hello <b>" . $user['firstname'] . "</b><br><br>";
//            $body .= "You successfully created account for battleme.<br>";
//            //  $body .= "your pasword for same is: <b>" . $this->input->post('password1') . "</b><br><br>";
//            $body .= "Thank you";
//            $this->Sendmailmodel->sendmail($user['email'], $subject, $body);
//        }
//    }

}
