<?php

/**
 * Friendsmodel class
 * @package battleme
 * @subpackage model
 * @author 
 * */
class Friendsmodel extends CI_Model {

    /**
     * __construct
     * 
     * this function loads the database
     * @access public
     * @return void
     * @author 
     * */
    public function __construct() {
        $this->load->database();
    }

    /**
     * send_frnd_req function
     * @access public
     * @param $data
     * @return void
     * @author 
     * */
    public function send_frnd_req($data) {
        $this->db->insert('friend_list', $data);
    }

    /**
     * get_frnd_req function
     * this function retrieves all friend request
     * @access public
     * @param $userid
     * @return request_array
     * @author 
     * */
    public function get_frnd_req($userid) {
        $sql = "SELECT user.* FROM friend_list 
               JOIN user ON user.id = friend_list.user_id
                WHERE  (friend_list.active = 0) 
                AND (friend_list.resourse_approved = 0) 
                AND (friend_list.resource_id = " . $userid . ")";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * accept_frnd_req
     * this function is used to accept the friend request
     * @access public
     * @param type $id
     * @param type $data
     * @return void
     * @author 
     */
    public function accept_frnd_req($frndid, $myid, $data) {
        $this->db->where('resource_id', $frndid);
        $this->db->where('user_id', $myid);
        $this->db->update('friend_list', $data);
    }

    /**
     * get_all_frnds
     * this function retreives all friends of user
     * @param type $userid
     * @return friendlist
     * @author 
     */
    public function get_all_frnds($userid = NULL) {
	if(!is_null($userid)){
	    $sql = "SELECT user.* FROM user "
                . " JOIN friend_list ON user.id = friend_list.resource_id"
                . " WHERE friend_list.user_id = " . $userid . " AND (friend_list.active = 1)";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	else
	    return array();
        
    }
    
        /**
     * get_rest_frnds
     * this function retreives all friends of user not in the tournament
     * @param type $userid
     * @return friendlist
     * @author 
     */
    public function get_rest_frnds($userid = NULL, $tournament_request_id = NULL) {
	if(!is_null($userid) && !is_null($tournament_request_id)){
	    $sql = "SELECT user.* FROM user "
                . " JOIN friend_list ON user.id = friend_list.resource_id"
                . " WHERE friend_list.user_id = " . $userid . " AND (friend_list.active = 1)"
                . "AND user.id NOT IN (select friend_user_id from tournament_members where tournament_request_id =".$tournament_request_id." )";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	else
	    return array();
        
    }
    
    /**
     * 
     * @param type $data
     * @param type $id
     */
    public function follow_friend($data, $id) {
        $query = $this->db->get_where('user_follow', array('user_id' => $this->session->userdata('logged_in')['id'], 'following_frnd_id' => $id))->result_array();
        if (empty($query)) {
            $this->db->insert('user_follow', $data);
        } else {
            $this->db->delete('user_follow', array('user_id' => $this->session->userdata('logged_in')['id'], 'following_frnd_id' => $id));
        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function follow_status($id) {
        return $this->db->get_where('user_follow', array('user_id' => $this->session->userdata('logged_in')['id'], 'following_frnd_id' => $id))->result_array();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function get_followers($id) {
        return $this->db->query('SELECT user.*,user.id as userid  FROM user JOIN user_follow ON user.id = user_follow.user_id  WHERE user_follow.following_frnd_id = ' . $id)->result_array();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function get_following_friends($id) {
        return $this->db->query('SELECT user. *,user.id as userid FROM user JOIN user_follow ON user.id = user_follow.following_frnd_id WHERE user_follow.user_id =' . $id)->result_array();
    }

    /**
     * 
     * @param type $userid
     * @param type $frndid
     * @return type
     */
    public function friend_details($userid, $frndid) {
        $sql = "SELECT active,user_approved,resourse_approved FROM `friend_list` WHERE user_id = " . $userid . " AND resource_id  = " . $frndid;
        return $this->db->query($sql)->result();
    }
    
    
    /**
     * 
     * @param type $userid
     * @param type $frndid
     */
    public function remove_friend($userid, $frndid) {
        $this->db->delete('friend_list', array('user_id' => $userid, 'resource_id' => $frndid));
    }

    /**
     * 
     * @param type $userid
     * @param type $data
     * @return type
     */
    public function search_friend($userid, $data) {
        
        $sql = "SELECT user.* FROM user JOIN friend_list ON user.id = friend_list.resource_id WHERE friend_list.user_id =".$userid." AND (friend_list.active = 1) AND (user.firstname like '%".$data."%' OR user.lastname like '%".$data."%')";
        return $this->db->query($sql)->result_array();
        
    }
    
      /**
     * get_all_frnds
     * this function retreives all friends of user
     * @param type $userid
     * @return friendlist
     * @author 
     */
    public function get_connected_frnds($userid = NULL) {
	if(!is_null($userid)){
	    $sql = "SELECT user.id, user.profile_picture, user.firstname, user.lastname, user.country,"
                    . " TIMESTAMPDIFF(SECOND,updated_on,now()) as time_diff"
                    . " FROM user "
                . " JOIN friend_list ON user.id = friend_list.resource_id"
                . " WHERE friend_list.user_id = " . $userid . " AND (friend_list.active = 1)";
            //echo $sql; die;
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	else
	    return array();
        
    }

}
