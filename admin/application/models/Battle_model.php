<?php
 /**
  * Description of Battle_model
  *
  * @author Chhanda 
  */
 class Battle_model Extends CI_Model {
     //put your code here
     public function __construct() {
	 parent::__construct();
     }
     
    /**
     * add_request
     * this function save the battle request
     * @author Chhanda
     * @param array
     * @return int
     **/  
    public function add_request($inputArr = array()) 
    {
	if(!empty($inputArr))
	{
	    $this->db->insert('battle_request' , $inputArr) ;
	    return $this->db->insert_id(); 
	}
    }
    /**
     * add_battle_media
     * this function saves the battle media
     * @author Chhanda
     * @param array
     * @return int
     **/  
    public function add_battle_media($inputArr = array()) 
    {
	if(!empty($inputArr))
	{
	    $this->db->insert('battle_media' , $inputArr) ;
	    return $this->db->insert_id(); 
	}
    }
    
    
    /**
     * get_battle_details
     * this function returns the battle details
     * @author Chhanda
     * @param int battle request id
     * @return array
     **/  
    public function get_battle_details($request_id = NULL)
    {
	if(!is_null($request_id) && $request_id > 0 )
	{
	    $this->db->select('concat(C.firstname , " " ,C.lastname ) as challenger ,'
		    . ' C.profile_picture as c_profile , C.coins as c_coins , user.profile_picture as f_profile , user.coins as f_coins ,'
		    . ' C.win_cnt as c_win , C.lose_cnt as c_loss , user.win_cnt , user.lose_cnt ,'
		    . 'concat(user.firstname , " ", user.lastname ) as friend , battle_request.* ' , FALSE);
	    $this->db->from('battle_request');
	    $this->db->join('user as C' , 'C.id=battle_request.user_id' , 'LEFT');
	    $this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
	    
	   
	    
	    $this->db->where('battle_request_id' ,$request_id ) ;
	    $result = $this->db->get();
//	    echo $this->db->last_query();
	    return $result->result_array();
	}
	else
	    return array();
    }
    
     /**
     * update_request
     * this function update_request 
     * @author Chhanda
     * @param update field array , where condition array
     * @return array
     **/  
    public function update_request($inputData = array() , $whereArr = array())
    {
	if(!empty($whereArr))
	    $this->db->where($whereArr) ;
	if(!empty($inputData))
	    $status = $this->db->update('battle_request' , $inputData);
	
	return $status ;
    }
    
    /**
     * get_battle_list
     * this returns the battles of user
     * @author Chhanda
     * @param int user id
     * @return  array
     **/  
    public function get_battle_list($user_id = NULL)
    {
	$result = array();
	if(!is_null($user_id))
	{   
	    $this->db->where('battle_request.user_id = '.$user_id);
	    $this->db->or_where('battle_request.friend_user_id = '.$user_id);
	}
	    $this->db->select('concat(C.firstname , " " ,C.lastname ) as challenger ,'
		    . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
		    . 'concat(user.firstname , " ", user.lastname ) as friend , battle_request.* ' , FALSE);
	    $this->db->from('battle_request');
	    $this->db->join('user as C' , 'C.id=battle_request.user_id' , 'LEFT');
	    $this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
	    $this->db->order_by('start_date' , 'desc');
	    $resObj = $this->db->get();
	    if($resObj->num_rows() > 0 )
	    {
		$result = $resObj->result_array();
	    }
	    return $result ;
    }
    
    /**
     * get_battle_media
     * this function returns songs uploaded by artists in battle
     * @author Chhanda
     * @param array of where conditions
     * @return  array
     **/  
    public function  get_battle_media($whereArr = array())
    {
	if(!empty($whereArr))
	    $this->db->where($whereArr);
	$this->db->select('song_library.title , song_library.media ,'
                . ' battle_media.media_id , battle_media.artist_id, battle_media.fk_song_id,'
                . ' (select count(id) from `likes` where post_id = battle_media.fk_song_id and post_type="song") as like_count');
	 $this->db->join('song_library' , 'song_library.song_id=battle_media.fk_song_id' , 'LEFT');
	$result = $this->db->get('battle_media');
	return($result->result_array());
    }
    
    /**
     * get_running_battle
     * this function returns the running battle 
     * @author Chhanda
     * @param array of where conditions
     * @return  array
    **/  
    public function get_running_battle()
    {
	$resultArr = array();
	$date = date('Y-m-d H:i:s');
	$sql = " SELECT battle_request.entry, battle_request_id as bId , user_id as CId , friend_user_id FId , end_date, "
		. " ( SELECT count(vote_id) FROM battle_votes where battle_id = bId and `artist_id` = CId ) as challengerCnt ,"
		. " ( SELECT count(vote_id) FROM battle_votes where battle_id = bId and `artist_id` = FId ) as friendCnt "
		. " FROM `battle_request` LEFT JOIN battle_votes ON battle_request.battle_request_id = battle_votes.battle_id "
		. " WHERE end_date <= '{$date}' "
		. " AND status = 1 "
		. " GROUP BY bId " ;
		     
	
	$resultObj = $this->db->query($sql);
	if( $resultObj->num_rows() > 0 )
	{
	    $resultArr =  $resultObj->result_array();
	}
	return $resultArr;
	
    }
    
    public function sendNotiToVoter($battleId,$winnerId) {
        $sql = "select bv.voter_id, bv.artist_id from battle_votes bv where bv.battle_id =$battleId";
        $resultObj = $this->db->query($sql);
	if($resultObj->num_rows() > 0) {
            
	    $resultArr =  $resultObj->result_array();
            if(!empty($resultArr)) {
                foreach ($resultArr as $val) {
                    if($val['artist_id']==$winnerId) {
                        //send notification to voter
                        $notification_msg = 'Would you like to be notified that the artist you voted for won';
                        add_notification($val['voter_id'], $val['artist_id'], $notification_msg);
                    } else {
                        $notification_msg = 'Would you like to be notified that the artist you voted for lost';
                        add_notification($val['voter_id'], $val['artist_id'], $notification_msg);
                    }
                }
            }
	}
    }

    
    public function batchUpdate($updateArr = array() , $field = NULL  , $table = NULL)
    {
	if(!empty($updateArr) && ! is_null($field) &&  ! is_null($table) )
	{
	    return $this->db->update_batch($table , $updateArr , $field);
	    echo $this->db->last_query();
	}
    }
    
    
    public function update_user_count($field = NULL , $user_id = NULL)
    {
	if( ! is_null($field) && ! is_null($user_id))
	{
	    echo $sql = "UPDATE user SET {$field} = {$field} + 1  WHERE id = '".$user_id."'";
	    return $this->db->query($sql);
	}
    }
    
    
     public function get_support_amount($battle_id = NULL)
    {
	$result = array();
	if(!is_null($battle_id))
	{   
            $this->db->select_sum('battle_bucks', 'amount');
	    $this->db->where('artist_payments.battle_id = '.$battle_id); 	 
	    $this->db->where('artist_payments.payment_status = "Completed"');
	    $this->db->where('artist_payments.is_credited_user = 0');
	    $this->db->from('artist_payments');
	    
	    $resObj = $this->db->get();
	     
		$result = $resObj->row_array();
                if(!empty($result['amount'])) {
                    return $result['amount'];
                } else {
                    return 0;
                }
        } else {
            return 0;
        }
    }
    
    public function get_support_users($whereArr = NULL) {
        $resultArr = array();
	 if(!empty($whereArr))
	 {
	     $this->db->select('concat(user.firstname , " " ,user.lastname ) as supporter_name, artist_payments.battle_bucks, user.profile_picture, user.id as supporter_id');
             $this->db->from('artist_payments');
             $this->db->join('user' , 'user.id = artist_payments.user_id' , 'LEFT');
             $this->db->where('artist_payments.payment_status = "Completed"');
             $this->db->where('artist_payments.battle_id ='.$whereArr);
             $this->db->order_by('artist_payments.id' , 'desc');
	     
	     $result = $this->db->get();
	     if($result->num_rows() > 0 )
	     {
		 $resultArr = $result->result_array();
	     }
	 }
	 return $resultArr ;
    }
    
    
    /**
     * get_battle_list_categorise
     * this returns the battles of user
     * @author Samiran
     * @param int user id
     * @return  array
     **/  
    public function get_battle_list_categorise($battle_type = NULL, $battle_cat = NULL)
    {
	$result = array();
	if($battle_type == 'regular-battle')
	{   
	    $this->db->where('battle_request.entry = 0');
	    //$this->db->or_where('battle_request.friend_user_id = '.$user_id);
	} else {
            $this->db->where('battle_request.entry > 0');
        }
        
        if($battle_cat != null) {
            $this->db->where('battle_request.battle_category = '.  base64_decode($battle_cat));
        }
            
            $this->db->where('(battle_request.status = 1 OR battle_request.status = 3)');
            //$this->db->where('(DATE_ADD(battle_request.end_date, INTERVAL 90 DAY)  >= now())');
            
            
            
	    $this->db->select('(select concat(sl.media,",", sl.title, ",", bm.fk_song_id) from song_library sl inner join battle_media bm on sl.song_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = C.id) as challenger_media, '
                    . '(select concat(sl.media, ",", sl.title, ",", bm.fk_song_id) from song_library sl inner join battle_media bm on sl.song_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = user.id) as friend_media, '
                    . '(select count(bv.vote_id) from battle_votes bv where bv.battle_id = battle_request.battle_request_id and bv.artist_id = C.id) as challenger_vote, '
                    . '(select count(bv.vote_id) from battle_votes bv where bv.battle_id = battle_request.battle_request_id and bv.artist_id = user.id) as friend_vote, '
                    . '(select count(l.id) from likes l inner join battle_media bm on l.post_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = C.id) as challenger_like, '
                    . '(select count(l.id) from likes l inner join battle_media bm on l.post_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = user.id) as friend_like, '
                    . ' concat(C.firstname , " " ,C.lastname ) as challenger ,'
		    . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
		    . 'concat(user.firstname , " ", user.lastname ) as friend , battle_request.* ' , FALSE);
	    $this->db->from('battle_request');
	    $this->db->join('user as C' , 'C.id=battle_request.user_id' , 'LEFT');
	    $this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
	    $this->db->order_by('battle_request.battle_request_id' , 'desc');
	    $resObj = $this->db->get();
            
            //echo $this->db->last_query();
            
	    if($resObj->num_rows() > 0 )
	    {
		$result = $resObj->result_array();
	    }
	    return $result ;
    }
    
    
    public function get_mybattle_list_categorise($user_id) {
        
        $result = array();
        if(!is_null($user_id))
	{   
            $this->db->where('battle_request.battle_category != 5');
	    //$this->db->where('battle_request.user_id = '.$user_id);
	    //$this->db->or_where('battle_request.friend_user_id = '.$user_id);
            $this->db->where("(`battle_request`.`user_id` = ".$user_id." OR `battle_request`.`friend_user_id` = $user_id)"); 
	}
        
        $this->db->select('(select concat(sl.media,",", sl.title, ",", bm.fk_song_id) from song_library sl inner join battle_media bm on sl.song_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = C.id) as challenger_media, '
                . '(select concat(sl.media, ",", sl.title, ",", bm.fk_song_id) from song_library sl inner join battle_media bm on sl.song_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = user.id) as friend_media, '
                . '(select count(bv.vote_id) from battle_votes bv where bv.battle_id = battle_request.battle_request_id and bv.artist_id = C.id) as challenger_vote, '
                . '(select count(bv.vote_id) from battle_votes bv where bv.battle_id = battle_request.battle_request_id and bv.artist_id = user.id) as friend_vote, '
                . '(select count(l.id) from likes l inner join battle_media bm on l.post_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = C.id) as challenger_like, '
                . '(select count(l.id) from likes l inner join battle_media bm on l.post_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = user.id) as friend_like, '
                . ' concat(C.firstname , " " ,C.lastname ) as challenger ,'
                . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
                . 'concat(user.firstname , " ", user.lastname ) as friend , battle_request.* ' , FALSE);
        $this->db->from('battle_request');
        $this->db->join('user as C' , 'C.id=battle_request.user_id' , 'LEFT');
        $this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
        $this->db->order_by('battle_request.battle_request_id' , 'desc');
        //$this->db->order_by('battle_request.battle_category' , 'asc');
        $resObj = $this->db->get();

        //echo $this->db->last_query();

        if($resObj->num_rows() > 0 )
        {
            $result = $resObj->result_array();
        }
        return $result ;
    }
    
    public function get_myfreestyle_battle($user_id) {
        
        $result = array();
        if(!is_null($user_id))
	{   
            $this->db->where('battle_request.battle_category = 5');
            $this->db->where("(`battle_request`.`user_id` = ".$user_id." OR `battle_request`.`friend_user_id` = $user_id)"); 
	}
        
        $this->db->select('(select concat(sl.media,",", sl.title, ",", bm.fk_song_id) from song_library sl inner join battle_media bm on sl.song_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = C.id) as challenger_media, '
                . '(select concat(sl.media, ",", sl.title, ",", bm.fk_song_id) from song_library sl inner join battle_media bm on sl.song_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = user.id) as friend_media, '
                . '(select count(bv.vote_id) from battle_votes bv where bv.battle_id = battle_request.battle_request_id and bv.artist_id = C.id) as challenger_vote, '
                . '(select count(bv.vote_id) from battle_votes bv where bv.battle_id = battle_request.battle_request_id and bv.artist_id = user.id) as friend_vote, '
                . '(select count(l.id) from likes l inner join battle_media bm on l.post_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = C.id) as challenger_like, '
                . '(select count(l.id) from likes l inner join battle_media bm on l.post_id = bm.fk_song_id where bm.battle_id = battle_request.battle_request_id and bm.artist_id = user.id) as friend_like, '
                . ' concat(C.firstname , " " ,C.lastname ) as challenger ,'
                . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
                . 'concat(user.firstname , " ", user.lastname ) as friend , battle_request.* ' , FALSE);
        $this->db->from('battle_request');
        $this->db->join('user as C' , 'C.id=battle_request.user_id' , 'LEFT');
        $this->db->join('user' , 'user.id=battle_request.friend_user_id' , 'LEFT');
        $this->db->order_by('battle_request.battle_request_id' , 'desc');
        $resObj = $this->db->get();

        //echo $this->db->last_query();

        if($resObj->num_rows() > 0 )
        {
            $result = $resObj->result_array();
        }
        return $result ;
    }
    
    
    public function is_notify($battle_id = '') {
        $result = array();
        $this->db->where('track_notification.battle_id ='.$battle_id);
        $this->db->where('track_notification.tracking_type ="artist_noty"');
        $this->db->select('id' , FALSE);
        $this->db->from('track_notification');
        $resObj = $this->db->get();
        //echo $this->db->last_query();
        if($resObj->num_rows() > 0 )
        {
            return TRUE;
            //$result = $resObj->row_array();
        }
        return FALSE;
    }
    
     public function is_posted($battle_id = '') {
        $result = array();
        $this->db->where('track_notification.battle_id ='.$battle_id);
        $this->db->where('track_notification.tracking_type ="artist_post"');
        $this->db->select('id' , FALSE);
        $this->db->from('track_notification');
        $resObj = $this->db->get();
        //echo $this->db->last_query();
        if($resObj->num_rows() > 0 )
        {
            return TRUE;
            //$result = $resObj->row_array();
        }
        return FALSE;
    }
    
    public function get_timediff($battle_id='') {
        $result = array();
        $this->db->select('DATEDIFF(date_time, NOW()) as date_diff, TIMESTAMPDIFF(MINUTE, NOW(), date_time) as time_diff');
        $this->db->from('battle_request');
        $this->db->where('battle_request.battle_request_id ='.$battle_id);
        $resObj = $this->db->get();
        //echo $this->db->last_query();
        if($resObj->num_rows() > 0 )
        {
            return $result = $resObj->row_array();
        }
        return FALSE;
    }
    
    public function set_notify($battle_id='') {
        $data = array(
           'battle_id' => $battle_id,
           'status' => 1,
           'tracking_type' => 'artist_noty'
        );

        $this->db->insert('track_notification', $data); 
    }
    
    public function set_post($battle_id='') {
        $data = array(
           'battle_id' => $battle_id,
           'status' => 1,
           'tracking_type' => 'artist_post'
        );

        $this->db->insert('track_notification', $data); 
    }
    
    
 }
 