<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Friends extends CI_Controller {

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
        $data = $this->session->userdata('logged_in');
        if (empty($data)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        }
        $this->load->model('Usermodel');
        $this->load->model('Friendsmodel');
        $this->load->helper('randomstring_helper');
    }

    /**
     * send_frnd_req function
     * this function is used to send friend request
     * @return void
     * @param $frnd_id
     * @author 
     * */
    public function send_frnd_req($frnd_id) {
        $user_id = $this->session->userdata('logged_in')['id'];
        $data = array(
            'resource_id' => $user_id,
            'user_id' => $frnd_id,
            'resourse_approved' => 1,
            'req_sent' => date('Y-m-d H:i:s')
        );
        $this->Friendsmodel->send_frnd_req($data);
        $data = array(
            'resource_id' => $frnd_id,
            'user_id' => $user_id,
            'user_approved' => 1,
            'req_sent' => date('Y-m-d H:i:s')
        );
        $this->Friendsmodel->send_frnd_req($data);
        $msg = 'has sent you a friend request';
        add_notification($frnd_id,$user_id,$msg);
    }

    /**
     * getall_frnd_req
     * this function retrieves all the friend request for user
     * @access public
     * @param type $userid
     * @return frnd_req_array
     * @author 
     */
    public function getall_frnd_req($userid) {
        $data['frnd_reqs'] = $this->Friendsmodel->get_frnd_req($userid);
        $data['frnd_req_html'] = $this->load->view('friend_req', $data, TRUE);
        print_r($data['frnd_req_html']);
        return $data['frnd_req_html'];
    }

    /**
     * accept_frnd_req
     * this function accepts the friend request
     * @access public
     * @return void
     * @param type $frnd_id
     */
    public function accept_frnd_req($frnd_id) {
        $userid = $this->session->userdata('logged_in')['id'];
        $data = array(
            'user_approved' => 1,
            'active' => 1,
            'req_accepted' => date('Y-m-d H:i:s')
        );
        $this->Friendsmodel->accept_frnd_req($frnd_id, $userid, $data);
        $data1 = array(
            'resourse_approved' => 1,
            'active' => 1,
            'req_accepted' => date('Y-m-d H:i:s')
        );
        $this->Friendsmodel->accept_frnd_req($userid, $frnd_id, $data1);
        add_notification($frnd_id, $userid,'has accepted your friend request');
    }
    /**
     * follow_friend
     * this function is used to follow a friend
     * @param type $frndid
     */
    public function follow_friend($frndid) {
        $userid = $this->session->userdata('logged_in')['id'];
        $data = array(
            'user_id' => $userid,
            'following_frnd_id' => $frndid
        );
        $this->Friendsmodel->follow_friend($data, $frndid);
        add_notification($frndid, $userid,'has started following you');
        redirect('profile/view/' . $frndid);
    }
    
    public function remove_friend($frndid){
        $userid = $this->session->userdata('logged_in')['id'];
        $this->Friendsmodel->remove_friend($userid, $frndid);
        $this->Friendsmodel->remove_friend($frndid, $userid);
        
    } 

}