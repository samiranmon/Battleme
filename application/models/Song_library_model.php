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
	 
	 $this->db->select("sl.`song_id` as sId , sl.`user_id`, sl.`media`, sl.`title`, sl.`created_date`, 
		 (select count(*) FROM likes where post_id = sId AND post_type='song') as likeCount, br.battle_category, bm.fk_song_id as battle_media, tm.fk_song_id as tournament_media");
         
         $this->db->from('song_library sl');
	 $this->db->join('battle_media bm' , 'sl.song_id = bm.fk_song_id' , 'LEFT');
	 $this->db->join('tournament_media tm' , 'sl.song_id = tm.fk_song_id' , 'LEFT');
	 $this->db->join('battle_request br' , 'bm.battle_id = br.battle_request_id' , 'LEFT');
         
	 $this->db->order_by('sl.created_date' , 'desc');
          $this->db->group_by('sl.song_id'); 
	 $resObj = $this->db->get() ;
	 //echo $this->db->last_query(); 
	 
	 if($resObj->num_rows() > 0 )
	 {
	     $result = $resObj->result_array();
	 }
	 return $result ;
     }
     
     public function get_top_songs()
     {
	 $result = array();
	 $this->db->select("`song_id` as sId ,song_library.file_type, song_library.`user_id`, `media`, `title`, `created_date` , user.firstname , user.lastname 
		 , (select count(*) FROM likes where post_id = sId AND post_type='song') as likeCount");
	 $this->db->from('song_library') ;
	 $this->db->join('user' , 'user.id = song_library.user_id' , 'LEFT');
         $this->db->join('(select * from user_memberships where user_memberships.status=1) um' , 'um.user_id = user.id', 'LEFT');
         $this->db->where(['um.memberships_id' => 2]);
         $this->db->having("likeCount > 0");
	 $this->db->order_by('likeCount' , 'desc');
	 $resObj = $this->db->get();
	 if($resObj->num_rows() > 0) {
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
     
     public function getFileExtension($media_id = NULL) {
         $result = array();
	 $this->db->where(['song_id' => $media_id]);
	 $this->db->select("SUBSTRING_INDEX(media,'.',-1) AS `media`");
	 $resObj = $this->db->get('song_library') ;
	 
	 if($resObj->num_rows() > 0 )
	 {
	     $result = $resObj->row_array();
	 }
	 return $result ;
     }
     
     public function getSongById($songId =NULL, $userId = NULL)
     {
         $result = array();
	 $this->db->where(['song_id' => $songId, 'user_id'=>$userId]);
	 $this->db->select("*");
	 $resObj = $this->db->get('song_library') ;
	 
	 if($resObj->num_rows() > 0 )
	 { $result = $resObj->row_array(); }
	 return $result ;
     }
     
     
     
 }
 