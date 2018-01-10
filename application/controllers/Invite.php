<?php

/**
 * Description of Battle
 * 
 * @author Chhanda
 */
class Invite extends CI_Controller {

    //put your code here
    public $sessionData;

    public function __construct() {
        parent::__construct();
        $this->load->model('Friendsmodel', 'friends');
        $this->load->model('Usermodel', 'user');
        $this->load->model('Notificationmodel', 'notification');
        $this->load->library('Common_lib');
        $this->load->library('email');
        $this->sessionData = get_session_data();
        
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

    public function index() {
        $user_id = $this->sessionData['id'];

        //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }

        $this->form_validation->set_rules('friend_email', 'Friend Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == TRUE) {

            foreach ($this->input->post() as $key => $val)
                $$key = $val;

            $inputData['refer_user'] = $sessionData['id'];
            $inputData['friend_email'] = $friend_email;
            $inputData['friend_user'] = 0;
            $inputData['created_on'] = date('Y-m-d H:i:s');
            //echo '<pre>'; print_r($inputData); die();

            $request_id = $this->user->inviteFriend($inputData);
            if ($request_id > 0) {
                //$this->session->set_flashdata('class', 'alert-danger');
                //$this->session->set_flashdata('message', $filename['error']);
                // for sending mail section
                $msg = 'Your friend ' . $sessionData['name'] . ' has invited you to join Battleme portal ';
                $msg .= 'Please click <a href="' . base_url('user/registration') . '">Here</a>';
                $this->email->from('noreply@mydevfactory.com', 'Your Battleme Team');
                $this->email->to($friend_email);
                $this->email->set_mailtype("html");
                $this->email->subject('Invitation from Battleme Team');
                $this->email->message($msg);
                $this->email->send();

                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'You have successfully invited to your friend!');
            }
            redirect('invite');
        }

        $arrData['userId'] = $user_id;
        $arrData['middle'] = 'invite_friend';
        $arrData['div_col_unit'] = 'col-md-12';
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);

        $this->load->view('templates/template', $arrData);
    }

    public function start_notification($battle_id = null) {
        $battle_id = $this->input->post('battle_id');
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }

        $battle_id = (int) base64_decode($battle_id);
        if (!empty($battle_id) && is_int($battle_id) && $battle_id > 0) {
            if ($this->battles->is_notify($battle_id) == FALSE) {

                $result_array = $this->battles->get_timediff($battle_id);
                if ($result_array != false) {

                    if ($result_array['date_diff'] >= 0 && $result_array['date_diff'] < 1) {
                        if ($result_array['time_diff'] <= 5) {

                            $battle_details = $this->battles->get_battle_details($battle_id);
                            $msg = 'battle will begin in 5 mins';
                            //add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $msg, $type = 'battle_request', $battle_id);
                            //add_notification($battle_details[0]['friend_user_id'], $battle_details[0]['user_id'], $msg, $type = 'battle_request', $battle_id);
                            add_notification($battle_details[0]['friend_user_id'], $battle_details[0]['user_id'], $msg, $type = 'battle_request', $battle_id);
                            add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $msg, $type = 'battle_request', $battle_id);

                            $this->battles->set_notify($battle_id);
                        }
                    }
                }
            }
        }
    }

    

}