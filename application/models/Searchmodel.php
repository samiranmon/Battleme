<?php

/**
 * Searchmodel class
 * @package battleme
 * @subpackage model
 * @author 
 * */
class Searchmodel extends CI_Model {

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
     * search_home function
     * @param $string
     * @return result array
     * @author 
     **/
    public function search_home($string)  
    {
//        $query = $this->db->query("SELECT DISTINCT (
//            user.email
//            ) AS useremail, (
//
//            SELECT IF( resourse_approved !=1, resourse_approved, user_approved ) 
//            FROM friend_list
//            WHERE user_id = user.id
//            AND resource_id = ".$this->session->userdata('logged_in')['id']."
//            ) AS check1, user. * , friend_list.active, friend_list.resourse_approved, friend_list.user_approved
//            FROM user
//            LEFT JOIN friend_list ON user.id = friend_list.resource_id
//            WHERE user.firstname LIKE  '%".$string."%'");
        /*
        $query = $this->db->query("SELECT distinct(u.id),u.*,b.battle_name 
                FROM battle_request AS b,user AS u
                LEFT JOIN friend_list AS f ON f.user_id = u.id
                WHERE u.id != ". $this->session->userdata('logged_in')['id']." AND (u.firstname LIKE '%".$string."%' OR u.lastname LIKE '%".$string."%' OR b.battle_name LIKE '%".$string."%')");*/
                $userQ = $this->db->query("SELECT distinct(u.id),u.* 
                FROM user AS u
                LEFT JOIN friend_list AS f ON f.user_id = u.id
                WHERE u.id != ". $this->session->userdata('logged_in')['id']." AND (u.firstname LIKE '%".$string."%' OR u.lastname LIKE '%".$string."%')");
				$users = $userQ->result_array();
        		
        		/*
				$battleQ = $this->db->query("SELECT concat(C.firstname , ' ' ,C.lastname ) as challenger,C.profile_picture as c_profile , user.profile_picture as f_profile ,
								FROM battle_request AS b
								LEFT JOIN user AS C ON C.id=battle_request.user_id
								LEFT JOIN user ON user.id=battle_request.friend_user_id
								WHERE u.id != ". $this->session->userdata('logged_in')['id']." AND (u.firstname LIKE '%".$string."%' OR u.lastname LIKE '%".$string."%')");*/
	    $this->db->select('concat(C.firstname , " " ,C.lastname ) as challenger ,'
		   . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
		    . 'concat(user.firstname , " ", user.lastname ) as friend , battle_request.* ' , FALSE);
	    $this->db->from('battle_request');
	    $this->db->join('user as C' , 'C.id=battle_request.user_id' , 'LEFT');
	    $this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
	    $this->db->like('battle_request.battle_name',$string);
	    $this->db->order_by('start_date' , 'desc');
            $battleQ = $this->db->get();
            $battle = $battleQ->result_array();
                
            $this->db->select('concat(C.firstname , " " ,C.lastname ) as challenger ,'
		    . ' C.profile_picture as c_profile ,tournament_request.* ' , FALSE);
	    $this->db->from('tournament_request');
	    $this->db->join('user as C' , 'C.id=tournament_request.user_id' , 'LEFT');
            $this->db->like('tournament_request.tournament_name',$string);
	    $this->db->order_by('start_date' , 'desc');
	    $resObj = $this->db->get();
            $tournament = $resObj->result_array();
                
            return array('users'=>$users,'battles'=>$battle, 'tournaments'=>$tournament);
    }
}


	