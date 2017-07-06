<?php
 /**
  * Description of Hire_model
  *
  * @author Chhanda 
  */
 class Hire_model Extends CI_Model {
     //put your code here
     public function __construct() {
	 parent::__construct();
     }
    
    /**
     * get_register_singer
     * this function returns the battle details
     * @author Chhanda
     * @param int battle request id
     * @return array
     **/  
    public function get_register_singer($userId = NULL)
    {
	if(!is_null($userId) )
	{
	    $this->db->select('rs.*, u.profile_picture, concat(u.firstname , " " ,u.lastname ) as user_name, u.id user_id,'
                    . ' (select sum(r.rating)/count(r.id) from rating r where r.hired_user_id=rs.user_id) as user_rating' , FALSE);
	    $this->db->from('user u');
	    $this->db->join('register_singer rs' , 'u.id=rs.user_id');
	    //$this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
	    
	    $this->db->where('rs.user_id' ,$userId) ;
	    $result = $this->db->get();
//	    echo $this->db->last_query();
	    return $result->row_array();
	}
	else
	    return array();
    }
    
    
    public function getRegisterSinger($userId = NULL) {
        $this->db->select('rs.*, u.profile_picture, concat(u.firstname , " " ,u.lastname ) as user_name, u.id user_id, hu.status,'
                . ' (select count(hired_user.id) from hired_user where hired_user.hired_user_id=hu.hired_user_id) as count_hired,'
                . ' (select sum(r.rating)/count(r.id) from rating r where r.hired_user_id=rs.user_id) as user_rating' , FALSE);
        $this->db->from('user u');
        $this->db->join('register_singer rs' , 'u.id=rs.user_id');
        $this->db->join('(select * from hired_user order by hired_user.status asc limit 0,1) hu' , 'hu.hired_user_id=rs.user_id' , 'LEFT');

        $this->db->where('rs.user_id !=' ,$userId);
        //$this->db->order_by("hu.status", "asc");
        $this->db->group_by('rs.user_id');
        
        $result = $this->db->get();
//	    echo $this->db->last_query();
        return $result->result_array();
    }
    
     public function getHiredSinger($userId = NULL) {
        $this->db->select('rs.*, u.profile_picture, concat(u.firstname , " " ,u.lastname ) as user_name, u.id user_id, hu.status, hu.id hired_id,'
                . ' (select count(hu1.hired_user_id) from hired_user hu1) as count_hired,'
                . ' (select sum(r.rating)/count(r.id) from rating r where r.hired_user_id=hu.hired_user_id ) as user_rating' , FALSE);
        $this->db->from('user u');
        $this->db->join('hired_user hu' , 'hu.hired_user_id=u.id');
        $this->db->join('register_singer rs' , 'hu.hired_user_id=rs.user_id');
        $this->db->where('hu.user_id',$userId) ;
        $result = $this->db->get();
        //$rowcount = $result->num_rows();
        //echo $rowcount;
	    //echo $this->db->last_query();
        return $result->result_array();
    }
    
    public function getHiredSingle($hiredId = NULL) {
         $this->db->select('hu.*' , FALSE);
	    $this->db->from('hired_user hu');
	    //$this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
	    $this->db->where('hu.id' ,$hiredId) ;
	    $result = $this->db->get();
	//    echo $this->db->last_query();
	    return $result->row_array();
    }
     
 }
 