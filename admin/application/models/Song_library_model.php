<?php

 /*
  * To change this license header, choose License Headers in Project Properties.
  * To change this template file, choose Tools | Templates
  * and open the template in the editor.
  */

 /**
  * Description of Song_library_model
  *
  * @author Chhanda
  */
 class Song_library_model extends CI_Model {
     //put your code here
     public function __construct() {
	 parent::__construct();
     }
     
     public function insert($inputArr = array())
     {
	 if(!empty($inputArr))
	{
	    $this->db->insert('song_library' , $inputArr) ;
	    return $this->db->insert_id(); 
	}
     }
     
     public function get_list($whereArr = array())
     {
	 $result = array();
	 if(!empty($whereArr))
	     $this->db->where($whereArr);
	 
	 
	 $this->db->select("`song_id` as sId , `user_id`, `media`, `title`, `created_date` , 
		 (select count(*) FROM likes where post_id = sId AND post_type='song') as likeCount");
	 $this->db->order_by('created_date' , 'desc');
	 $resObj = $this->db->get('song_library') ;
//	 echo $this->db->last_query();
	 
	 if($resObj->num_rows() > 0 )
	 {
	     $result = $resObj->result_array();
	 }
	 return $result ;
     }
     
     public function get_top_songs()
     {
	 $result = array();
	 $this->db->select("`song_id` as sId , `user_id`, `media`, `title`, `created_date` , user.firstname , user.lastname 
		 , (select count(*) FROM likes where post_id = sId AND post_type='song') as likeCount");
	 $this->db->from('song_library') ;
	 $this->db->join('user' , 'user.id = song_library.user_id' , 'LEFT');
	 $this->db->order_by('likeCount' , 'desc');
	 $resObj = $this->db->get() ;
	 if($resObj->num_rows() > 0 )
	 {
	     $result = $resObj->result_array();
	 }
	 return $result ;
     }
     
     public function getUserSongs($userId = '')
     {
	 $result = array();
         $this->db->where(['song_library.user_id' => $userId]);
         $this->db->where(['song_library.media RECEXP ".mp3"']);
	 $this->db->select("`song_id` as sId , `user_id`, `media`, `title`, `created_date` , user.firstname , user.lastname 
		 , (select count(*) FROM likes where post_id = sId AND post_type='song') as likeCount");
	 $this->db->from('song_library') ;
	 $this->db->join('user' , 'user.id = song_library.user_id' , 'LEFT');
	 $this->db->order_by('likeCount' , 'desc');
	 $resObj = $this->db->get() ;
	 if($resObj->num_rows() > 0 )
	 {
	     $result = $resObj->result_array();
	 }
	 return $result ;
     }
     
     public function getMediaDetails($song_id='') {
         $result = array();
	 $this->db->where(['song_id' => $song_id]);
	 $this->db->select("`media`, `title`, `user_id`");
	 $resObj = $this->db->get('song_library') ;
	 
	 if($resObj->num_rows() > 0 )
	 {
	     $result = $resObj->row_array();
	 }
	 return $result ;
     }
     
 }
 