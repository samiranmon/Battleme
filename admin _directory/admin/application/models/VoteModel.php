<?php

 /**
  * Description of VoteModel
  *
  * @author Chhanda Rane
  */
 class VoteModel extends CI_Model {
     public function __construct() {
	 parent::__construct();
	  $this->load->database();
     }
     
     /**
     * place_vote
     * this function save the vote
     * @author Chhanda
     * @param array
     * @return boolean
     **/  
     public function place_vote($inputArr = array())
     {
	 if(!empty($inputArr))
	 {
	     $resultObj = $this->db->insert('battle_votes' , $inputArr) ;
	    return $resultObj; 
	 }
	 else
	     return false;
     }
     
      /**
     * place_tournament_vote
     * this function save the tournament vote
     * @author Chhanda
     * @param array
     * @return boolean
     **/  
     public function place_tournament_vote($inputArr = array())
     {
	 if(!empty($inputArr))
	 {
	     $resultObj = $this->db->insert('tournament_votes' , $inputArr) ;
	    return $resultObj; 
	 }
	 else
	     return false;
     }
     
     /**
     * count_vote
     * this function returns the vote count 
     * @author Chhanda
     * @param array
     * @return boolean
     **/ 
     public function count_vote($whereArr = array())
     {
	 $cnt = 0 ;
	 if(!empty($whereArr))
	 {
	    $this->db->where($whereArr);
	    $resObj = $this->db->get('battle_votes') ;
	    $cnt = $resObj->num_rows();
	 }
	 return $cnt ;
     }
     
     /**
     * count_tournament_votes
     * this function returns the vote count 
     * @param array
     * @return boolean
     **/ 
     public function count_tournament_votes($whereArr = array())
     {
	 $cnt = 0 ;
	 if(!empty($whereArr))
	 {
	   // $this->db->where(['tournament_votes.tournament_request_id' => 2]);
           // $this->db->where(['tournament_votes.artist_id' => 11]);
            $this->db->where($whereArr);
	    $resObj = $this->db->get('tournament_votes') ;
	    $cnt = $resObj->num_rows();
	 }
	 return $cnt ;
     }
     
     /**
     * get_voter_votes
     * this function returns for which atist voter has voted and by which social media type 
     * @author Chhanda
     * @param array
     * @return boolean
     **/ 
     public function get_voter_votes($whereArr = array())
     {
	 $resultArr = array();
	 if(!empty($whereArr))
	 {
	     $this->db->select('social_media_type , artist_id , vote_id , voter_id, concat(user.firstname , " " ,user.lastname ) as voter_name, user.profile_picture');
             $this->db->from('battle_votes');
             $this->db->join('user' , 'user.id = battle_votes.voter_id' , 'LEFT');
	     $this->db->where($whereArr);
	     //$this->db->group_by('voter_id');
	     $this->db->order_by('vote_id' , 'desc');
	     
	     $result = $this->db->get();
	     if($result->num_rows() > 0 )
	     {
		 $resultArr = $result->result_array();
	     }
	 }
	 return $resultArr ;
     }
     
     /**
     * get_tournament_votes
     * @param array
     * @return boolean
     **/ 
     public function get_tournament_votes($whereArr = array())
     {
	 $resultArr = array();
	 if(!empty($whereArr))
	 {
	     $this->db->select('social_media_type , artist_id , vote_id , voter_id');
	     $this->db->where($whereArr);
	    // $this->db->group_by('voter_id');
	     $this->db->order_by('artist_id' , 'desc');
	     
	     $result = $this->db->get('tournament_votes');
	     if($result->num_rows() > 0 )
	     {
		 $resultArr = $result->result_array();
	     }
	 }
	 return $resultArr ;
     }
     
     /**
     * get_voter_list
     * @param array
     * @return array
     **/ 
     public function get_voter_list($battle_id='',$artist_id='')
     {
	 $resultArr = array();
	  
	     $this->db->select('concat(user.firstname , " " ,user.lastname ) as voter_name, user.profile_picture, user.id voter_id');
             $this->db->from('battle_votes');
             $this->db->join('user' , 'user.id = battle_votes.voter_id' , 'left');
	     $this->db->where('battle_votes.artist_id='.$artist_id);
	     $this->db->where('battle_votes.battle_id='.$battle_id);
	     $this->db->order_by('battle_votes.vote_id' , 'desc');
	     $result = $this->db->get();
             
	     if($result->num_rows() > 0 )
	     {
		 $resultArr = $result->result_array();
	     }
	 return $resultArr ;
     }
     
     public function get_tournament_voter_list($tournament_id,$round,$artist_id)
     {
	 $resultArr = array();
	  
	     $this->db->select('concat(user.firstname , " " ,user.lastname ) as voter_name, user.profile_picture, user.id voter_id');
             $this->db->from('tournament_votes');
             $this->db->join('user' , 'user.id = tournament_votes.voter_id' , 'left');
	     $this->db->where('tournament_votes.artist_id='.$artist_id);
	     $this->db->where('tournament_votes.tournament_request_id='.$tournament_id);
	     $this->db->where('tournament_votes.round='.$round);
	     $this->db->order_by('tournament_votes.vote_id' , 'desc');
	     $result = $this->db->get();
             
	     if($result->num_rows() > 0 )
	     {
		 $resultArr = $result->result_array();
	     }
	 return $resultArr ;
     }
     
 }
 