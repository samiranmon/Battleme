<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class User extends CI_Controller {

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
        $this->load->model('Usermodel');
        $this->load->model('Song_library_model' , 'songs');
        $this->load->model('Friendsmodel', 'friends');
         
        $this->load->helper('randomstring_helper');
        $this->load->library('user_agent');
        $this->load->library('Common_lib');
        $this->load->library('Paypal_lib');
        $this->load->library('email');
        
        $this->config->load('paypal');
         $config = array(
            'Sandbox' => $this->config->item('Sandbox'), // Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsername'), // PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPassword'), // PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignature'), // PayPal API signature of the API caller
            'APISubject' => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion'), // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => $this->config->item('DeviceID'),
            'ApplicationID' => $this->config->item('ApplicationID'),
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );
         
        $this->load->library('paypal/Paypal_pro', $config, 'paypal_pro');
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

        $sessino_array = $this->session->userdata('logged_in');
        if (isset($sessino_array['id'])) {
            redirect('home');
        }
        //echo 'hello';

        if ($this->session->userdata('referrer') != '' && $this->agent->referrer() != '')
            $this->session->set_userdata(array('referrer' => $this->agent->referrer()));
        $this->load->view('login');
    }

    /**
     * register_user function
     *
     * @return void
     * @author 
     * */
    public function registration() {
        
        $membershipArr = $this->UserMemberships->get_memberships();
        $memberOpt[0] = 'Select Membership';
        foreach ($membershipArr as $key => $value) {
            $memberOpt[$value['id']] = $value['membership'];
            $toolTipOption[$value['id']] = $value['description'];
        }
        $arrData = array();
        $arrData['membershipOpt'] = $memberOpt;
        $arrData['membershipTooltip'] = $toolTipOption;
        
        $battleCat = $this->Usermodel->getBattleCategoryList();
        $battleCatArray = [];
        foreach ($battleCat as $value) {
            $battleCatArray[0]            =  'Select the battle categories that you will be battling in';
            $battleCatArray[$value['id']] = $value['name'];
        }
        $arrData['battleCategory'] = $battleCatArray;
        
        //$this->load->library('form_validation');
        $validate_rule = array(
            array(
                'field' => 'fname',
                'label' => 'Firstname',
                'rules' => 'trim|required|min_length[2]|alpha'
            ),
            array(
                'field' => 'lname',
                'label' => 'Lastname',
                'rules' => 'trim|required|min_length[2]|alpha'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email|is_unique[user.email]'
            ),
            array(
                'field' => 'password1',
                'label' => 'password',
                'rules' => 'required|alpha_numeric'
            ),
            array(
                'field' => 'password2',
                'label' => 'confirm-password',
                'rules' => 'required|matches[password1]'
            ),
            array(
                'field' => 'membership',
                'label' => 'Membership',
                'rules' => 'required|greater_than[0]'
            ),
            array(
                'field' => 'terms',
                'label' => 'T&C',
                'rules' => 'required'
            ),
           /* array(
                'field' => 'battle_category[]',
                'label' => 'Battle Category',
                'rules' => 'required'
            ) */
        );
        
        $this->form_validation->set_rules($validate_rule);

        if ($this->form_validation->run() == False) {
            $this->load->view('register', $arrData);
        } else {
            $current_date = date("Y-m-d");

            if ($this->input->post('membership') == 3)
                $reg_type = 'fan';
            else
                $reg_type = 'artist';
            
            $data = array(
                'firstname' => ucfirst(strtolower($this->input->post('fname'))),
                'lastname' => ucfirst(strtolower($this->input->post('lname'))),
                'user_type' => $reg_type,
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password1')),
                'created_on' => $current_date
            );

            if ($this->input->post('membership') == 2) {
                $data['battle_category'] = $this->input->post('battle_category');
                $this->Usermodel->addPremiumUser($data); 
                exit();
            }

            $result = $this->Usermodel->checkuser($data);
            if (!is_int($result)) {
                $this->session->set_flashdata('success', 'user already exist');
                redirect('user/registration');
            } else {
                /* add user_memberships */
                $user_info = $this->Usermodel->check_user_data($this->input->post('email'));
                //print_r($user_info);
                
                // Update invitation table 
                    $this->db->update('invitation', ['friend_user'=>$user_info[0]->id], array('friend_email' =>  $this->input->post('email')));
                // End of update invitation table
                
                 $battle_category = $this->input->post('battle_category');
                    if(!empty($battle_category)) {
                        foreach ($battle_category as $k=>$catVal){
                            if($battle_category[$k] > 0)
                            $this->db->insert('artist_registry', ['user_id'=>$user_info[0]->id, 'battle_category'=>$battle_category[$k],'created_on'=>date('Y-m-d H:i:s')]); 
                        }
                    }

                $user_memberships_info['user_id'] = $user_info[0]->id;
                $user_memberships_info['memberships_id'] = $this->input->post('membership');
                $user_memberships_info['status'] = '1';
                $this->UserMemberships->add($user_memberships_info);


                $this->load->model('Sendmailmodel');
                $subject = "registration for battleme was successful";
                $body = "Hello <b>" . $this->input->post('fname') . "</b><br><br>";
                $body .= "You successfully created account for battleme.<br>";
                $body .= "your pasword for same is: <b>" . $this->input->post('password1') . "</b><br><br>";
                $body .= "Thank you";
                $this->Sendmailmodel->sendmail($this->input->post('email'), $subject, $body);
                $this->session->set_flashdata('success', 'Please login to continue');
                redirect('user');
            }
        }
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
    public function login() {
        // $this->load->model('Usermodel');
        //$this->session->set_userdata(array('referrer' => $this->agent->referrer())) ;
        if ($this->session->userdata('referrer') != '')
            $referrer_url = $this->session->userdata('referrer');
        else
            $referrer_url = base_url('home');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            //redirect('user');
            $this->load->view('login');
        } else {

            if ($this->session->userdata('logged_in')) {
                $email = $this->input->post('email');
                $session_data = $this->session->userdata('logged_in');
                $data['email'] = $session_data['email'];
                redirect($referrer_url);
            } else {
                $this->session->set_flashdata('error', 'session not found');
                return false;
                redirect('user');
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
        $result = $this->Usermodel->login($email, md5($password));

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {

                $sess_array = array(
                    'id' => $row->id,
                    'name' => ucwords($row->firstname.' '.$row->lastname),
                    'email' => $row->email,
                    'user_type' => $row->user_type,
                    'gender' => $row->gender,
                    'profile_picture' => $row->profile_picture,
                    'cover_picture' => $row->cover_picture,
                    'coins' => $row->coins,
                    'paypal_account_id' => $row->paypal_account_id,
                );
                $membership = $this->UserMemberships->get_membership_user(array('user_id' => $row->id));
                if (!empty($membership)) {
                    $sess_array['membership_id'] = $membership[0]['memberships_id'];
                    $sess_array['membership_name'] = $membership[0]['membership'];
                }
            }
            $this->session->set_userdata('logged_in', $sess_array);
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
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect();
        //$this->load->view('login');
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
    public function notifications() {
        $sesData = $this->session->userdata('logged_in');
        if (empty($sesData)) {
            redirect('user');
        }

        $this->load->helper('form');
        $this->load->model('Notificationmodel');
        $this->load->model('Friendsmodel');
        $data['title'] = 'Notifications';
        $data['get_result'] = $this->Notificationmodel->get_all_notification($this->session->userdata('logged_in')['id']);
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['top_songs'] = $this->songs->get_top_songs();
	$data['top_user'] = $this->Usermodel->get_top_user();
        $this->load->view('list_home_content', $data);
    }

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
    function mark_as_read() {
        $this->load->model('Notificationmodel');
        $this->Notificationmodel->mark_as_read($this->session->userdata('logged_in')['id'], date('Y-m-d H:i:s'));
    }

    function premiumsuccess() {

        //get the transaction data
        $token = $this->input->get('token');
        
        //Get express checkout details
        $PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($token);
		
            if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
            {
                    //$errors = array('Errors'=>$PayPalResult['ERRORS']);
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('message', $PayPalResult['ERRORS']);
                    redirect(base_url('user/premiumcancel'));
            }
            else
            {
                 // Success block
                //[CUSTOM] => one-samiran.brainium@gmail.com|1|2|3|8|9
                
                if(isset($PayPalResult['BILLINGAGREEMENTACCEPTEDSTATUS']) && $PayPalResult['BILLINGAGREEMENTACCEPTEDSTATUS'] == 1 && $PayPalResult['PAYERSTATUS'] == 'verified') {
                    $buyerData = ['TOKEN' => $PayPalResult['TOKEN'], 'PAYERID'=>$PayPalResult['PAYERID'], 'EMAIL'=>$PayPalResult['EMAIL'], 'NAME'=>$PayPalResult['FIRSTNAME'].' '.$PayPalResult['LASTNAME'], 'BUSINESS'=>$PayPalResult['BUSINESS']];
                    
                    $profileDetails = $this->Create_recurring_payments_profile($buyerData);
                    if(!empty($profileDetails) && isset($profileDetails['PROFILEID'])) {
                        /* [PROFILESTATUS] => ActiveProfile*/
                        
                        // Insert user into the table
                        $custom_data = explode('|', $PayPalResult['CUSTOM']);
                        $user_data = ['firstname'=>$custom_data[0], 'lastname'=>$custom_data[1], 'email'=>$custom_data[2], 'password'=>$custom_data[3], 'user_type'=>'artist', 'created_on'=>date('Y-m-d')];
                        $userId = $this->Usermodel->checkuser($user_data);
                        
                        // Insert membership table
                        $memberships_info['user_id'] = $userId;
                        $memberships_info['memberships_id'] = 2;
                        $memberships_info['status'] = 1;
                        $this->UserMemberships->add($memberships_info);
                        
                        // Insert payment details into 
                        $recurring_data = ['user_id'=>$userId, 'profile_id'=>$profileDetails['PROFILEID'], 
                            'token'=>$profileDetails['REQUESTDATA']['TOKEN'], 'payer_id'=> $profileDetails['REQUESTDATA']['PAYERID'],
                            'payer_name'=>$profileDetails['REQUESTDATA']['SUBSCRIBERNAME'], 'payer_email'=>$profileDetails['REQUESTDATA']['EMAIL'],
                            'business'=>$profileDetails['REQUESTDATA']['BUSINESS'], 'payer_status'=> $profileDetails['REQUESTDATA']['PAYERSTATUS'],
                            'amount'=>$profileDetails['REQUESTDATA']['AMT'], 'currency_code'=> $profileDetails['REQUESTDATA']['CURRENCYCODE'],
                            'profile_start_date'=>$profileDetails['REQUESTDATA']['PROFILESTARTDATE'], 'profile_status'=>1, 'created_on'=>date('Y-m-d H:i:s')];
                         $this->db->insert('recurring_payments', $recurring_data);
                         
                        // Update invitation table 
                        $this->db->update('invitation', ['friend_user'=>$userId], array('friend_email' =>$custom_data[2]));
                        
                        // End of update invitation table
                        $battle_category = $custom_data;
                            if(!empty($battle_category)) {
                                foreach ($battle_category as $k=>$catVal){
                                    if($battle_category[$k] > 0)
                                        $this->db->insert('artist_registry', ['user_id'=>$userId, 'battle_category'=>$battle_category[$k],'created_on'=>date('Y-m-d H:i:s')]); 
                            }
                        } 
                        
                        // Send mail to register user
                        $body = "Hello <b>" . $custom_data[0] . "</b><br><br>";
                        $body .= "Your account has been credited successfully. Wellcome to Your Battleme Team.<br>";
                        $body .= "Please login and manage your account. Please click <a href='".  base_url()."'>Here</a><br>";
                        //  $body .= "your pasword for same is: <b>" . $this->input->post('password1') . "</b><br><br>";
                        $body .= "Thank you";
                        
                        $this->email->from('noreply@mydevfactory.com', 'Your Battleme Team');
                        $this->email->to($custom_data[2]);
                        $this->email->set_mailtype("html");
                        $this->email->subject('Registered successfully');
                        $this->email->message($body);
                        $this->email->send();
                         
                         
                    }
                }
            }
        

        $data['payment_amt'] = $PayPalResult['AMT'];
        $data['currency_code'] = $PayPalResult['CURRENCYCODE'];
        $data['status'] = "Active";

        //pass the transaction data to view
        $data['middle'] = 'payment_success';
        $this->session->set_flashdata('success', 'Please login to continue');
        $this->load->view('templates/template', $data);
    }
    
    function Create_recurring_payments_profile($buyerData = []) {
            /* echo gmdate('Y-m-d H:i:s'); 
            echo date("Y-d-mTG:i:sz",  strtotime(date('Y-m-d H:i:s')));
            gmdate('Y-m-d H:i:s', strtotime("+30 days"))
            die; */
        
            $CRPPFields = array(
                                'token' => $buyerData['TOKEN'], 								// Token returned from PayPal SetExpressCheckout.  Can also use token returned from SetCustomerBillingAgreement.
                                        );

            $ProfileDetails = array(
                                    'subscribername' => $buyerData['NAME'], 		    // Full name of the person receiving the product or service paid for by the recurring payment.  32 char max.
                                    'profilestartdate' => gmdate('Y-m-d H:i:s', strtotime("+30 days")), // Required.  The date when the billing for this profiile begins.  Must be a valid date in UTC/GMT format.
                                    'profilereference' => '' 				    // The merchant's own unique invoice number or reference ID.  127 char max.
                            );

            $ScheduleDetails = array(
                                    'desc' => 'BattlemeMembership', 			// Required.  Description of the recurring payment.  This field must match the corresponding billing agreement description included in SetExpressCheckout.
                                    'maxfailedpayments' => '', 				// The number of scheduled payment periods that can fail before the profile is automatically suspended.  
                                    'autobilloutamt' => '' 				// This field indiciates whether you would like PayPal to automatically bill the outstanding balance amount in the next billing cycle.  Values can be: NoAutoBill or AddToNextBilling
                            );

            $BillingPeriod = array(
                                    'trialbillingperiod' => '', 
                                    'trialbillingfrequency' => '', 
                                    'trialtotalbillingcycles' => '', 
                                    'trialamt' => '', 
                                    'billingperiod' => 'Month', 			// Required.  Unit for billing during this subscription period.  One of the following: Day, Week, SemiMonth, Month, Year
                                    'billingfrequency' => 1, 				// Required.  Number of billing periods that make up one billing cycle.  The combination of billing freq. and billing period must be less than or equal to one year. 
                                    'totalbillingcycles' => 0, 				// the number of billing cycles for the payment period (regular or trial).  For trial period it must be greater than 0.  For regular payments 0 means indefinite...until canceled.  
                                    'amt' => 10, 					// Required.  Billing amount for each billing cycle during the payment period.  This does not include shipping and tax. 
                                    'currencycode' => 'USD', 				// Required.  Three-letter currency code.
                                    'shippingamt' => '', 				// Shipping amount for each billing cycle during the payment period.
                                    'taxamt' => '' 					// Tax amount for each billing cycle during the payment period.
                            );

            $ActivationDetails = array(
                                    'initamt' => '', 					// Initial non-recurring payment amount due immediatly upon profile creation.  Use an initial amount for enrolment or set-up fees.
                                    'failedinitamtaction' => '', 			// By default, PayPal will suspend the pending profile in the event that the initial payment fails.  You can override this.  Values are: ContinueOnFailure or CancelOnFailure
                            );

            $CCDetails = array(
                                'creditcardtype' => '', 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
                                'acct' => '', 								// Required.  Credit card number.  No spaces or punctuation.  
                                'expdate' => '', 							// Required.  Credit card expiration date.  Format is MMYYYY
                                'cvv2' => '', 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
                                'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
                                'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
                        );

            $PayerInfo = array(
                                'email' => $buyerData['EMAIL'], 			// Email address of payer.
                                'payerid' => $buyerData['PAYERID'], 			// Unique PayPal customer ID for payer.
                                'payerstatus' => 'verified', 				// Status of payer.  Values are verified or unverified
                                'business' => $buyerData['BUSINESS']                    // Payer's business name.
                        );

            $PayerName = array(
                                'salutation' => '', 						// Payer's salutation.  20 char max.
                                'firstname' => '', 							// Payer's first name.  25 char max.
                                'middlename' => '', 						// Payer's middle name.  25 char max.
                                'lastname' => '', 							// Payer's last name.  25 char max.
                                'suffix' => ''								// Payer's suffix.  12 char max.
                        );

            $BillingAddress = array(
                                    'street' => '', 					// Required.  First street address.
                                    'street2' => '', 					// Second street address.
                                    'city' => '', 					// Required.  Name of City.
                                    'state' => '', 					// Required. Name of State or Province.
                                    'countrycode' => '', 				// Required.  Country code.
                                    'zip' => '', 					// Required.  Postal code of payer.
                                    'phonenum' => '' 					// Phone Number of payer.  20 char max.
                            );

            $ShippingAddress = array(
                                    'shiptoname' => '', 				// Required if shipping is included.  Person's name associated with this address.  32 char max.
                                    'shiptostreet' => '', 				// Required if shipping is included.  First street address.  100 char max.
                                    'shiptostreet2' => '', 				// Second street address.  100 char max.
                                    'shiptocity' => '', 				// Required if shipping is included.  Name of city.  40 char max.
                                    'shiptostate' => '', 				// Required if shipping is included.  Name of state or province.  40 char max.
                                    'shiptozip' => '', 					// Required if shipping is included.  Postal code of shipping address.  20 char max.
                                    'shiptocountry' => '', 				// Required if shipping is included.  Country code of shipping address.  2 char max.
                                    'shiptophonenum' => ''			        // Phone number for shipping address.  20 char max.
                                    );

            $PayPalRequestData = array(
                                    'CRPPFields' => $CRPPFields, 
                                    'ProfileDetails' => $ProfileDetails, 
                                    'ScheduleDetails' => $ScheduleDetails, 
                                    'BillingPeriod' => $BillingPeriod, 
                                    'ActivationDetails' => $ActivationDetails, 
                                    'CCDetails' => $CCDetails, 
                                    'PayerInfo' => $PayerInfo, 
                                    'PayerName' => $PayerName, 
                                    'BillingAddress' => $BillingAddress, 
                                    'ShippingAddress' => $ShippingAddress
                            );	

            $PayPalResult = $this->paypal_pro->CreateRecurringPaymentsProfile($PayPalRequestData);

            if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
            {
                    //$errors = array('Errors'=>$PayPalResult['ERRORS']);
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('message', $PayPalResult['ERRORS']);
                    redirect(base_url('user/premiumcancel'));
            }
            else
            {
                return $PayPalResult;
                    // Successful call.  Load view or whatever you need to do here.	
            }	
	}

    function premiumipn() {
        
        $paypalInfo = $this->input->post();
        $this->email->from('noreply@mydevfactory.com', 'Your Battleme Team');
        $this->email->to('samiran.brainium@gmail.com');
        $this->email->set_mailtype("html");
        $this->email->subject('Test instant payment notification');
        $this->email->message(json_encode($paypalInfo));
        $this->email->send(); 
        
        die();
        
        //get the transaction data
        $postData = $this->input->post();
        if(!empty($postData) && isset($postData['TOKEN'])) {
            
        //Get express checkout details
        $PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($postData['TOKEN']);
		
            if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
            {
                $errors = array('Errors'=>$PayPalResult['ERRORS']);
                     
            }
            else
            {
                 echo '<pre>';
                print_r($PayPalResult);
                    // Successful call.  Load view or whatever you need to do here.	
            }
            
        }
        
       
        
        
        
        // Update invitation table 
            //$this->db->update('invitation', ['friend_user'=>$user_info[0]->id], array('friend_email' =>  $this->input->post('email')));
        // End of update invitation table

         /* $battle_category = $this->input->post('battle_category');
            if(!empty($battle_category)) {
                foreach ($battle_category as $k=>$catVal){
                    if($battle_category[$k] > 0)
                    $this->db->insert('artist_registry', ['user_id'=>$user_info[0]->id, 'battle_category'=>$battle_category[$k],'created_on'=>date('Y-m-d H:i:s')]); 
                }
            } */

        //paypal return transaction details array
        $paypalInfo = $this->input->post();

        $data['product_id'] = $paypalInfo["item_number"];
        $data['txn_id'] = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["payment_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;
        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

        //check whether the payment is verified
        if (eregi("VERIFIED", $result)) {
            //insert the transaction data into the database
            $this->load->model('wallet_model', 'wallet');
            $transactionId = $this->wallet->insertTransaction($data);

            $user = unserialize($paypalInfo['custom']);

            /* add user_memberships */

            $result = $this->Usermodel->checkuser($user);

            $user_info = $this->Usermodel->check_user_data($user['email']);
            $user_memberships_info['user_id'] = $user_info[0]->id;
            $user_memberships_info['memberships_id'] = 2;
            $user_memberships_info['status'] = '1';
            $this->UserMemberships->add($user_memberships_info);

            $this->wallet->updateTransaction(['user_id' => $user_info[0]->id], $transactionId);

            $this->load->model('Sendmailmodel');
            $subject = "registration for battleme was successful";
            $body = "Hello <b>" . $user['firstname'] . "</b><br><br>";
            $body .= "You successfully created account for battleme.<br>";
            //  $body .= "your pasword for same is: <b>" . $this->input->post('password1') . "</b><br><br>";
            $body .= "Thank you";
            $this->Sendmailmodel->sendmail($user['email'], $subject, $body);
        }
    }
    
    function premiumcancel() {
        $data['middle'] = 'payment_cancel';
        $this->load->view('templates/template', $data);
    }
    
    function recurring_profile_details() {
        
        $sessino_array = $this->session->userdata('logged_in');
        if (is_null($sessino_array['id']) && !isset($sessino_array['id'])) {
            redirect(base_url());
        }
        
        $profileInfo = $this->Usermodel->getRecurringProfileInfo($sessino_array['id']);
        if(is_array($profileInfo) && !empty($profileInfo)) {
            //echo '<pre>'; print_r($profileInfo); die;
        
            $GRPPDFields = array(
                               'profileid' => $profileInfo['profile_id'] // Profile ID of the profile you want to get details for.
                               );

            $PayPalRequestData = array('GRPPDFields' => $GRPPDFields);
            $PayPalResult = $this->paypal_pro->GetRecurringPaymentsProfileDetails($PayPalRequestData);

            if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
            {
                //$PayPalResult['ERRORS'];
                $arrData['recurring_info'] = $PayPalResult;
            }
            else
            {
                $arrData['recurring_info'] = $PayPalResult;
            }	
        } else {
                $arrData['recurring_info'] = 'Your profile has not created yet.';
        }
        
        $arrData['middle'] = 'recurring_profile_info';
        $arrData['div_col_unit'] = 'col-md-12';
        
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        
        $this->load->view('templates/template', $arrData);
        
    }
    
    
    function change_profile_status() {
        
        $sessino_array = $this->session->userdata('logged_in');
        if (is_null($sessino_array['id']) && !isset($sessino_array['id'])) {
            redirect(base_url());
        }
        
        $action = $this->uri->segment(3);
        if($action=='reactivate') {
            $action = 'Reactivate';
        }elseif ($action=='cancel') {
            $action = 'Cancel';
        }else {
            redirect('user/recurring_profile_details');
        }
        
        $profileInfo = $this->Usermodel->getRecurringProfileInfo($sessino_array['id']);
        if(is_array($profileInfo) && !empty($profileInfo)) {
            
            $MRPPSFields = array(
                                'profileid' => $profileInfo['profile_id'], 	// Required. Recurring payments profile ID returned from CreateRecurring...
                                'action' => $action, 			// Required. The action to be performed.  Mest be: Cancel, Suspend, Reactivate
                                'note' => ''				// The reason for the change in status.  For express checkout the message will be included in email to buyers.  Can also be seen in both accounts in the status history.
                                );

            $PayPalRequestData = array('MRPPSFields' => $MRPPSFields);

            $PayPalResult = $this->paypal_pro->ManageRecurringPaymentsProfileStatus($PayPalRequestData);
            if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
            {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', $PayPalResult['ERRORS']);
                redirect(base_url('user/recurring_profile_details'));
            }
            else
            {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'Your recurring profile status has been changed successfully');
                redirect('user/recurring_profile_details');
            }
        }
    }
	
        
    function Update_recurring_payments_profile() {

        $URPPFields = array(
                           'profileid' => '', 		// Required.  Recurring payments ID.
                           'note' => '', 		// Note about the reason for the update to the profile.  Included in EC profile notification emails and in details pages.
                           'desc' => '', 		// Description of the recurring payment profile.
                           'subscribername' => '', 	// Full name of the person receiving the product or service paid for by the recurring payment profile.
                           'profilereference' => '', 		// The merchant's own unique reference or invoice number.
                           'additionalbillingcycles' => '', 	// The number of additional billing cycles to add to this profile.
                           'amt' => '', 			// Billing amount for each cycle in the subscription, not including shipping and tax.  Express Checkout profiles can only be updated by 20% every 180 days.
                           'shippingamt' => '', 		// Shipping amount for each billing cycle during the payment period.
                           'taxamt' => '',  			// Tax amount for each billing cycle during the payment period.
                           'outstandingamt' => '', 		// The current past-due or outstanding amount.  You can only decrease this amount.  
                           'autobilloutamt' => '', 		// This field indiciates whether you would like PayPal to automatically bill the outstanding balance amount in the next billing cycle.
                           'maxfailedpayments' => '', 		// The number of failed payments allowed before the profile is automatically suspended.  The specified value cannot be less than the current number of failed payments for the profile.
                           'profilestartdate' => ''		// The date when the billing for this profile begins.  UTC/GMT format.
                           );

        $BillingAddress = array(
                                'street' => '', 		// Required.  First street address.
                                'street2' => '', 		// Second street address.
                                'city' => '', 			// Required.  Name of City.
                                'state' => '', 			// Required. Name of State or Province.
                                'countrycode' => '', 		// Required.  Country code.
                                'zip' => '', 			// Required.  Postal code of payer.
                                'phonenum' => '' 		// Phone Number of payer.  20 char max.
                        );

        $ShippingAddress = array(
                                'shiptoname' => '', 		// Required if shipping is included.  Person's name associated with this address.  32 char max.
                                'shiptostreet' => '', 		// Required if shipping is included.  First street address.  100 char max.
                                'shiptostreet2' => '', 		// Second street address.  100 char max.
                                'shiptocity' => '', 		// Required if shipping is included.  Name of city.  40 char max.
                                'shiptostate' => '', 		// Required if shipping is included.  Name of state or province.  40 char max.
                                'shiptozip' => '', 		// Required if shipping is included.  Postal code of shipping address.  20 char max.
                                'shiptocountry' => '', 		// Required if shipping is included.  Country code of shipping address.  2 char max.
                                'shiptophonenum' => ''		// Phone number for shipping address.  20 char max.
                                );

        $BillingPeriod = array(
                                'trialbillingperiod' => '', 
                                'trialbillingfrequency' => '', 
                                'trialtotalbillingcycles' => '', 
                                'trialamt' => '', 
                                'billingperiod' => '', 		// Required.  Unit for billing during this subscription period.  One of the following: Day, Week, SemiMonth, Month, Year
                                'billingfrequency' => '', 	// Required.  Number of billing periods that make up one billing cycle.  The combination of billing freq. and billing period must be less than or equal to one year. 
                                'totalbillingcycles' => '', 	// the number of billing cycles for the payment period (regular or trial).  For trial period it must be greater than 0.  For regular payments 0 means indefinite...until canceled.  
                                'amt' => '', 			// Required.  Billing amount for each billing cycle during the payment period.  This does not include shipping and tax. 
                                'currencycode' => '', 		// Required.  Three-letter currency code.
                        );

        $CCDetails = array(
                            'creditcardtype' => '', 		// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
                            'acct' => '', 			// Required.  Credit card number.  No spaces or punctuation.  
                            'expdate' => '', 			// Required.  Credit card expiration date.  Format is MMYYYY
                            'cvv2' => '', 			// Requirements determined by your PayPal account settings.  Security digits for credit card.
                            'startdate' => '', 			// Month and year that Maestro or Solo card was issued.  MMYYYY
                            'issuenumber' => ''			// Issue number of Maestro or Solo card.  Two numeric digits max.
                    );

        $PayerInfo = array(
                            'email' => '', 			// Payer's email address.
                            'firstname' => '', 			// Required.  Payer's first name.
                            'lastname' => ''			// Required.  Payer's last name.
                    );	

        $PayPalRequestData = array(
                                    'URPPFields' => $URPPFields, 
                                    'BillingAddress' => $BillingAddress, 
                                    'ShippingAddress' => $ShippingAddress, 
                                    'BillingPeriod' => $BillingPeriod, 
                                    'CCDetails' => $CCDetails, 
                                    'PayerInfo' => $PayerInfo
                            );

        $PayPalResult = $this->paypal_pro->UpdateRecurringPaymentsProfile($PayPalRequestData);

        if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
        {
                $errors = array('Errors'=>$PayPalResult['ERRORS']);
                $this->load->view('paypal/samples/error',$errors);
        }
        else
        {
                // Successful call.  Load view or whatever you need to do here.	
        }	
    }
    
    
    function Do_express_checkout_payment() {
        
            $DECPFields = array(
                                'token' => '', 								// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
                                'payerid' => '', 							// Required.  Unique PayPal customer id of the payer.  Returned by GetExpressCheckoutDetails, or if you used SKIPDETAILS it's returned in the URL back to your RETURNURL.
                                'returnfmfdetails' => '', 					// Flag to indiciate whether you want the results returned by Fraud Management Filters or not.  1 or 0.
                                'giftmessage' => '', 						// The gift message entered by the buyer on the PayPal Review page.  150 char max.
                                'giftreceiptenable' => '', 					// Pass true if a gift receipt was selected by the buyer on the PayPal Review page. Otherwise pass false.
                                'giftwrapname' => '', 						// The gift wrap name only if the gift option on the PayPal Review page was selected by the buyer.
                                'giftwrapamount' => '', 					// The amount only if the gift option on the PayPal Review page was selected by the buyer.
                                'buyermarketingemail' => '', 				// The buyer email address opted in by the buyer on the PayPal Review page.
                                'surveyquestion' => '', 					// The survey question on the PayPal Review page.  50 char max.
                                'surveychoiceselected' => '',  				// The survey response selected by the buyer on the PayPal Review page.  15 char max.
                                'allowedpaymentmethod' => '' 				// The payment method type. Specify the value InstantPaymentOnly.
                        );

            // You can now utlize parallel payments (split payments) within Express Checkout.
            // Here we'll gather all the payment data for each payment included in this checkout 
            // and pass them into a $Payments array.  

            // Keep in mind that each payment will ahve its own set of OrderItems
            // so don't get confused along the way.	

            $Payments = array();
            $Payment = array(
                    'amt' => '', 							// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
                    'currencycode' => '', 					// A three-character currency code.  Default is USD.
                    'itemamt' => '', 						// Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
                    'shippingamt' => '', 					// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
                    'shipdiscamt' => '', 					// Shipping discount for this order, specified as a negative number.
                    'insuranceoptionoffered' => '', 		// If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
                    'handlingamt' => '', 					// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
                    'taxamt' => '', 						// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
                    'desc' => '', 							// Description of items on the order.  127 char max.
                    'custom' => '', 						// Free-form field for your own use.  256 char max.
                    'invnum' => '', 						// Your own invoice or tracking number.  127 char max.
                    'notifyurl' => '', 						// URL for receiving Instant Payment Notifications
                    'shiptoname' => '', 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
                    'shiptostreet' => '', 					// Required if shipping is included.  First street address.  100 char max.
                    'shiptostreet2' => '', 					// Second street address.  100 char max.
                    'shiptocity' => '', 					// Required if shipping is included.  Name of city.  40 char max.
                    'shiptostate' => '', 					// Required if shipping is included.  Name of state or province.  40 char max.
                    'shiptozip' => '', 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
                    'shiptocountrycode' => '', 				// Required if shipping is included.  Country code of shipping address.  2 char max.
                    'shiptophonenum' => '',  				// Phone number for shipping address.  20 char max.
                    'notetext' => '', 						// Note to the merchant.  255 char max.  
                    'allowedpaymentmethod' => '', 			// The payment method type.  Specify the value InstantPaymentOnly.
                    'paymentaction' => '', 					// How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order. 
                    'paymentrequestid' => '',  				// A unique identifier of the specific payment request, which is required for parallel payments. 
                    'sellerid' => '', 						// The unique non-changing identifier for the seller at the marketplace site.  This ID is not displayed.
                    'sellerusername' => '', 				// The current name of the seller or business at the marketplace site.  This name be shown to the buyer.
                    'sellerregistrationdate' => '', 		// Date when the seller registered with the marketplace.
                    'softdescriptor' => '', 				// A per transaction description of the payment that is passed to the buyer's credit card statement.
                    'transactionid' => ''					// Tranaction identification number of the tranasction that was created.  NOTE:  This field is only returned after a successful transaction for DoExpressCheckout has occurred. 
                    );

            // For order items you populate a nested array with multiple $Item arrays.  
            // Normally you'll be looping through cart items to populate the $Item array
            // Then push it into the $OrderItems array at the end of each loop for an entire 
            // collection of all items in $OrderItems.

            $PaymentOrderItems = array();
            $Item = array(
                        'name' => '', 								// Item name. 127 char max.
                        'desc' => '', 								// Item description. 127 char max.
                        'amt' => '', 								// Cost of item.
                        'number' => '', 							// Item number.  127 char max.
                        'qty' => '', 								// Item qty on order.  Any positive integer.
                        'taxamt' => '', 							// Item sales tax
                        'itemurl' => '', 							// URL for the item.
                        'itemweightvalue' => '', 					// The weight value of the item.
                        'itemweightunit' => '', 					// The weight unit of the item.
                        'itemheightvalue' => '', 					// The height value of the item.
                        'itemheightunit' => '', 					// The height unit of the item.
                        'itemwidthvalue' => '', 					// The width value of the item.
                        'itemwidthunit' => '', 						// The width unit of the item.
                        'itemlengthvalue' => '', 					// The length value of the item.
                        'itemlengthunit' => '',  					// The length unit of the item.
                        'itemurl' => '', 							// The URL for the item.
                        'itemcategory' => '', 						// Must be one of the following:  Digital, Physical
                        'ebayitemnumber' => '', 					// Auction item number.  
                        'ebayitemauctiontxnid' => '', 				// Auction transaction ID number.  
                        'ebayitemorderid' => '',  					// Auction order ID number.
                        'ebayitemcartid' => ''						// The unique identifier provided by eBay for this order from the buyer. These parameters must be ordered sequentially beginning with 0 (for example L_EBAYITEMCARTID0, L_EBAYITEMCARTID1). Character length: 255 single-byte characters
                        );
            array_push($PaymentOrderItems, $Item);

            // Now we've got our OrderItems for this individual payment, 
            // so we'll load them into the $Payment array
            $Payment['order_items'] = $PaymentOrderItems;

            // Now we add the current $Payment array into the $Payments array collection
            array_push($Payments, $Payment);

            $UserSelectedOptions = array(
                                         'shippingcalculationmode' => '', 	// Describes how the options that were presented to the user were determined.  values are:  API - Callback   or   API - Flatrate.
                                         'insuranceoptionselected' => '', 	// The Yes/No option that you chose for insurance.
                                         'shippingoptionisdefault' => '', 	// Is true if the buyer chose the default shipping option.  
                                         'shippingoptionamount' => '', 		// The shipping amount that was chosen by the buyer.
                                         'shippingoptionname' => '', 		// Is true if the buyer chose the default shipping option...??  Maybe this is supposed to show the name..??
                                         );

            $PayPalRequestData = array(
                                        'DECPFields' => $DECPFields, 
                                        'Payments' => $Payments, 
                                        'UserSelectedOptions' => $UserSelectedOptions
                                );

            $PayPalResult = $this->paypal_pro->DoExpressCheckoutPayment($PayPalRequestData);

            if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
            {
                    $errors = array('Errors'=>$PayPalResult['ERRORS']);
                    $this->load->view('paypal/samples/error',$errors);
            }
            else
            {
                    // Successful call.  Load view or whatever you need to do here.	
            }
    }
    

}
