<?php
 /**
  * Description of Tournament_model
  *
  */
 class Tournament_model Extends CI_Model {
     //put your code here
     public function __construct() {
	 parent::__construct();
     }
     
    /**
     * add_request
     * this function save the tournament request
     * @param array
     * @return int
     **/  
    public function add_request($inputArr = array()) 
    {
	if(!empty($inputArr))
	{
	      /*  $friend_user_ids = $inputArr['friend_user_id'];
                
                unset($inputArr['friend_user_id']);
                
                $count = count($friend_user_ids);
                
                if($count > 95){
                    $inputArr['start_date'] = date('Y-m-d H.i.s');
                    
                    $end_date = strtotime('+30 days', strtotime(date('Y-m-d H.i.s')) );
                    $inputArr['end_date'] = date('Y-m-d',$end_date);
                }*/
                
                $this->db->insert('tournament_request' , $inputArr) ;
                $insert_id =  $this->db->insert_id();
                
                /*foreach($friend_user_ids as $friend_user_id){
                    $this->db->insert('tournament_members' , ['tournament_request_id' => $insert_id, 
                                                              'friend_user_id'        => $friend_user_id]) ;
                }*/
                
                return $insert_id;
	}
    }
    
    /**
     * add_tournament_members
     * this function add tournament members
     **/  
    public function add_tournament_members($inputArr = array(), $entry = NULL) 
    {
	if(!empty($inputArr) && $entry != NULL)
	{
	        $friend_user_ids = $inputArr['friend_user_id'];
                
                foreach($friend_user_ids as $friend_user_id){
                    
               /* $user  = $this->db->get_where('user', array('id' => $friend_user_id))->result_array();
                $coins = $user[0]['coins']; */
               
                //deduct coins
                $sql = "UPDATE user SET coins = coins - $entry WHERE id = '".$friend_user_id."'";
                $this->db->query($sql);
                
                $this->db->insert('tournament_members' , ['tournament_request_id' => $inputArr['tournament_request_id'], 
                                                              'friend_user_id'       => $friend_user_id]);
                }
                
                // Get existing members count 
                $q = $this->db->query('SELECT count(*) as count from tournament_members where tournament_request_id ='.$inputArr['tournament_request_id'])->row();
                 $count = ($q->count); 
                
                if($count == 32){
                      
                    $end_date = strtotime('+25 days', strtotime(date('Y-m-d H:i:s')) );
                    $end_date = date('Y-m-d H:i:s',$end_date);
                    $this->db->where('tournament_request_id', $inputArr['tournament_request_id']);
                    $this->db->update('tournament_request' , ['start_date' => date('Y-m-d H:i:s'), 'end_date' => $end_date]);
                    
                    $this->db->select('friend_user_id');
                    $this->db->from('tournament_members');
                    $this->db->where('tournament_request_id' ,$inputArr['tournament_request_id'] ) ;
                    
                    $result = $this->db->get()->result_array();
                    foreach($result as $r)
                        { $members[] = $r['friend_user_id'];  }
            
                    // Shuffle the members
                    shuffle($members);

                    // Pair the adjacent members
                    for ( $index = 0; $index < $count; $index +=2) {
                        $groups[] = $members[$index ] . "," . $members[$index+1];
                    }

                    foreach($groups as $group){
                    $this->db->insert('tournament_groups' , ['tournament_request_id' => $inputArr['tournament_request_id'], 
                                                             'tournament_group'      => $group,
                                                             'round'                 => 1]);
                    }
                
                }
                
                return true;
	}
    }
    
        
    /**
     * get_tournament_list
     * @param int user id
     * @return  array
     **/  
    public function get_tournament_list($user_id = NULL)
    {
	$result = array();
        
        if(!is_null($user_id))
	{   
	    $this->db->where('tournament_request.user_id = '.$user_id);
	    $this->db->or_where('tournament_members.friend_user_id = '.$user_id);
	}
	    $this->db->select('concat(C.firstname , " " ,C.lastname ) as challenger ,'
		    . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
		    . 'concat(user.firstname , " ", user.lastname ) as friend , tournament_request.* ' , FALSE);
	    $this->db->from('tournament_request');
            $this->db->join('tournament_members' , 'tournament_request.tournament_request_id=tournament_members.tournament_request_id' , 'LEFT');
	    $this->db->join('user as C' , 'C.id=tournament_request.user_id' , 'LEFT');
	    $this->db->join('user' , 'user.id=tournament_members.friend_user_id' , 'LEFT');
	    $this->db->order_by('tournament_request.tournament_request_id' , 'desc');
	    $resObj = $this->db->get();
	    if($resObj->num_rows() > 0 )
	    {
		$result = $resObj->result_array();
	    }
            
	    return $result ;
            
    }
    
    /**
     * get_tournament_details
     * this function returns the tournament details
     * @param int tournament request id
     * @return array
     **/  
    public function get_tournament_details($request_id = NULL)
    {
	if(!is_null($request_id) && $request_id > 0 )
	{
	    $this->db->select('concat(C.firstname , " " ,C.lastname ) as challenger ,'
		    . ' C.profile_picture as c_profile , user.profile_picture as f_profile ,'
		    . ' C.win_cnt as c_win , C.lose_cnt as c_loss , user.win_cnt , user.lose_cnt, user.id as friend_user_id ,'
		    . 'concat(user.firstname , " ", user.lastname ) as friend , tournament_request.*, sl.media, sl.title ' , FALSE);
	    $this->db->from('tournament_request');
            $this->db->join('tournament_members' , 'tournament_request.tournament_request_id=tournament_members.tournament_request_id' , 'LEFT');
	    $this->db->join('user as C' , 'C.id=tournament_request.user_id' , 'LEFT');
	    $this->db->join('user' , 'user.id=tournament_members.friend_user_id' , 'LEFT');
	    $this->db->join('tournament_media tm' , 'tournament_members.friend_user_id=tm.artist_id' , 'LEFT');
	    $this->db->join('song_library sl' , 'tm.fk_song_id=sl.song_id' , 'LEFT');
            
	    $this->db->where('tournament_request.tournament_request_id' ,$request_id );
            $this->db->group_by("tournament_members.friend_user_id"); 
	    $result = $this->db->get();
            //echo $this->db->last_query(); die;
            
         //   echo '<pre>'; print_r($result->result_array()); die;
//	    echo $this->db->last_query();
	    return $result->result_array();
	}
	else
	    return array();
    }
    
    /**
     * get_tournament_groups
     * this function returns the tournament groups
     * @param int tournament request id
     * @return array
     **/  
    public function get_tournament_groups($tournament_request_id, $start_date=NULL, $round = NULL)
    { 
        if(isset($start_date)){
            $diff  = strtotime(date('Y-m-d H.i.s'))- strtotime($start_date);
            $days  = floor($diff/(60*60*24)); 
 
             if ($days < 6) {
                    $round = 1;
                } elseif ($days < 11) {
                    $round = 2;
                } elseif ($days < 16) {
                    $round = 3;
                } elseif ($days < 19) {
                    $round = 4;
                } elseif ($days < 24) {
                    $round = 5;
                } elseif ($days < 29) {
                    $round = 6;
                } elseif ($days >= 34) {
                    $round = 7;
                }
        }  
        
       
        $this->db->select('tournament_group, round');
	$this->db->from('tournament_groups');
	$this->db->where('tournament_groups.tournament_request_id' ,$tournament_request_id );
       // $this->db->where('tournament_groups.round' ,$round );
	$result = $this->db->get()->result_array();
       //echo '<pre>'; print_r($result); die; 
        
        $round_array = [1=>'1st',2=>'2nd',3=>'3rd',4=>'4th',5=>'5th',6=>'6th',7=>'7th'];
        
        if(!empty($result)){ 
            foreach($result as $g){
                
                if($g['round']==6) {
                    if(array_key_exists($g['round'], $round_array)) {
                          $groups[$round_array[$g['round']]][]= $this->media_detal_by_user($g['tournament_group'],$tournament_request_id);
                      }
                } else {
                    $group_array = explode(',', $g['tournament_group']); 
                    $first_user = $group_array[0];
                    $second_user = $group_array[1];

                     if(array_key_exists($g['round'], $round_array)) {
                          $groups[$round_array[$g['round']]][]= $this->media_detal_by_user($first_user,$tournament_request_id);
                          $groups[$round_array[$g['round']]][]= $this->media_detal_by_user($second_user,$tournament_request_id);
                      }
                }
               
            } 
        }
        //echo '<pre>'; print_r($groups); die; 
        return $groups;
        
    }
    
    public function media_detal_by_user($user='',$tournament_request_id='') {
        $sql = "select u.id user_id, u.profile_picture as f_profile, concat(u.firstname ,' ', u.lastname ) as friend, sl.media, sl.title"
                . " from (select user.* from user where user.id in($user)) as u"
                . " inner join tournament_media tm on u.id = tm.artist_id"
                . " inner join song_library sl on tm.fk_song_id=sl.song_id where tm.tournament_request_id=$tournament_request_id";
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    

    public function get_tournament_groups_array($tournament_request_id,$round = NULL)
    { 
        $this->db->select('tournament_group');
	$this->db->from('tournament_groups');
	$this->db->where('tournament_groups.tournament_request_id' ,$tournament_request_id );
        $this->db->where('tournament_groups.round' ,$round );
	$result = $this->db->get()->result_array();
       //echo '<pre>'; print_r($result); die; 
        if($round==7){
             $groups[][] = $result[0]['tournament_group'];
        }else{ 
            foreach($result as $g){
                $groups[]= explode(',', $g['tournament_group']);
            } 
        }
        //echo '<pre>'; print_r($groups); die; 
        return $groups;
        
    }

        /**
     * get_round_winners
     **/  
    public function get_round_winners($round, $tournament_request_id)
    {
	$this->db->select('artist_id');
	$this->db->from('tournament_votes');
        $this->db->where('round', $round);
        $this->db->where('tournament_request_id', $tournament_request_id);
        $votes = $this->db->get()->result_array();
        $artists = [];
        foreach($votes as $vote){
            $artists[] = $vote['artist_id'];
        }
        //echo '<pre>';        print_r($artists); 
        $vote_count = array_count_values($artists); 
        $groups = $this->get_tournament_groups_array($tournament_request_id,$round);
        //echo '<pre>';        print_r($groups); die;
         
        foreach($groups as $group){
            
            $vote1 = isset($vote_count[$group[0]]) ? $vote_count[$group[0]] : 0 ;
            $vote2 = isset($vote_count[$group[1]]) ? $vote_count[$group[1]] : 0 ;
            //echo '<pre>'; print_r($vote_count); die;
            if($round==6){
                $vote3     = isset($vote_count[$group[2]]) ? $vote_count[$group[2]] : 0 ;
                
                $arr       = [$group[0]=>$vote1, $group[1]=>$vote2, $group[2]=>$vote3];
                $max       = max(array_values($arr));
                $keys      = array_keys($arr, $max);
                $value     = array_rand($keys); 
                $winners[] = $keys[$value];
                
            }else{
                
                if($vote1 > $vote2 ){ $winners[] = $group[0]; }
                elseif($vote2 > $vote1){ $winners[] = $group[1]; }
                elseif(($vote2 == $vote1)){ $winners[] = $group[array_rand($group)]; }
            }
    
        }
	return $winners;
    }
    
    /**
     * requestVoteNoti
     **/ 
    public function requestVoteNoti($tournamentId, $round, $winnerId) {
        
        $this->db->select('tournament_votes.voter_id');
	$this->db->from('tournament_votes');
        $this->db->where('tournament_request_id', $tournamentId); 
        $this->db->where('artist_id', $winnerId); 
        $this->db->where('round', $round-1); 
        $result = $this->db->get()->result_array();
        
        if(!empty($result)) {
            foreach ($result as $val) {
                //send notification to voter
                $round_array = ['1'=>'1st','2'=>'2nd','3'=>'3rd','4'=>'4th','5'=>'5th','6'=>'6th','7'=>'7th'];
                  if(array_key_exists($round,$round_array)) {
                      $round_str = $round_array[$round]; 
                  }
                  
                $uIds = $this->getGroupIds($round, $tournamentId, $winnerId);
                $notification_msg = base_url().'tournament/voting/'.$tournamentId.'/'.$round_str.'/'.$uIds;
                //$notification_msg = 'Would you like to be notified that the artist you voted for won';
                add_notification($val['voter_id'], $winnerId, $notification_msg,'tournament_vote_request');
            }
        }
        
    }
    
    public function getGroupIds($round, $tournamentId, $winnerId) {
        $this->db->select('tournament_group');
	$this->db->from('tournament_groups');
        $this->db->where('round', $round);
        $this->db->where('tournament_request_id', $tournamentId);
        $this->db->where("FIND_IN_SET($winnerId, tournament_group)>0");
        $result = $this->db->get()->row_array();
        if(!empty($result)) {
            return base64_encode(str_replace(',', '/', $result['tournament_group']));
        }
    }

        /**
     * get_running_tournaments
     **/  
    public function get_running_tournaments()
    {
	//Get existing members count with adding 1 for including owner into count
        $this->db->select('*');
	$this->db->from('tournament_request');
         $q = $this->db->where('start_date IS NOT NULL AND end_date IS NOT NULL AND start_date <=CURDATE() AND end_date >=CURDATE()');
        return $this->db->get()->result_array();
	    
    }
    
    /**
     * get_members_count
     * this function returns the tournament members count
     * @param int tournament request id
     **/  
    public function get_members_count($request_id = NULL)
    {
	if(!is_null($request_id) && $request_id > 0 )
	{
	    // Get existing members count with adding 1 for including owner into count
                $q = $this->db->query('SELECT count(*) as count from tournament_members where tournament_request_id ='.$request_id)->row();
                $count =  ($q->count) + 1; 
	    
                return $count;
	}
    }
    
    /**
     * get_tournament_media
     * this function returns songs uploaded by artists in tournament
     * @param array of where conditions
     * @return  array
     **/  
    public function  get_tournament_media($whereArr = array())
    {
	if(!empty($whereArr))
	    $this->db->where($whereArr);
	$this->db->select('song_library.title , song_library.media , tournament_media.media_id , tournament_media.artist_id');
	 $this->db->join('song_library' , 'song_library.song_id=tournament_media.fk_song_id' , 'LEFT');
	$result = $this->db->get('tournament_media');
	return($result->result_array());
    }
    
    /**
     * update_request
     * this function update_request 
     * @param update field array , where condition array
     * @return array
     **/  
    public function update_request($inputData = array() , $whereArr = array())
    {
	if(!empty($whereArr))
	    $this->db->where($whereArr) ;
	if(!empty($inputData))
	    $status = $this->db->update('tournament_members' , $inputData);
	
	return $status ;
    }
    
    /**
     * add_tournament_media
     * this function saves the battle media
     * @author Chhanda
     * @param array
     * @return int
     **/  
    public function add_tournament_media($inputArr = array()) 
    {
	if(!empty($inputArr))
	{
	    $this->db->insert('tournament_media' , $inputArr) ;
	    return $this->db->insert_id(); 
	}
    }
    
     /**
     * get_user_tournament_status
     **/  
    public function get_user_tournament_status($user_id) 
    {
	     $this->db->select('tournament_request.tournament_request_id', FALSE);
             $this->db->from('tournament_request');
             $this->db->join('tournament_members' , 'tournament_request.tournament_request_id=tournament_members.tournament_request_id' , 'LEFT');
             $this->db->where('tournament_request.end_date IS NULL' );
             $this->db->where('(tournament_request.user_id='.$user_id. ' OR tournament_members.friend_user_id='.$user_id.')' );
              
            return $q = $this->db->get()->result_array();
             
    }
    
     /**
     * Currnet Tournament
     **/  
    public function getCurrentTournament() 
    {
        $sql = "SELECT count(tournament_members.friend_user_id) count_user"
                . " FROM (select * from `tournament_request` order by `tournament_request`.tournament_request_id DESC limit 0,1 ) as tournament_request"
                . " LEFT JOIN `tournament_members` ON `tournament_request`.`tournament_request_id`=`tournament_members`.`tournament_request_id`";
        $result = $this->db->query($sql);
        return $result->row_array();
    }
    
    
    
    /**
     * close_tournament
     **/ 
    
    public function close_tournament($winner, $tournament_request_id)
     {
        //Get tournament finalists
        $groups = $this->tournaments->get_tournament_groups($tournament_request_id,NULL, 6);
        
        foreach($groups as $group){   $members=$group;     }
      
        if(($key = array_search($winner, $members)) !== false) {
                unset($members[$key]);
        }
        $members = array_values($members);
        
        $this->db->select('artist_id');
	$this->db->from('tournament_votes');
        $this->db->where('round', 6);
        $this->db->where('tournament_request_id', $tournament_request_id);
        $votes = $this->db->get()->result_array();
        $artists = [];
        foreach($votes as $vote){
            $artists[] = $vote['artist_id'];
        }
       
        $vote_count = array_count_values($artists);
 
        $vote1 = isset($vote_count[$members[0]]) ? $vote_count[$members[0]] : 0 ;
        $vote2 = isset($vote_count[$members[1]]) ? $vote_count[$members[1]] : 0 ;
        
        $finalists = ['first' => $winner];
        
        if($vote1 > $vote2 ){ $finalists['second'] = $members[0]; $finalists['third'] = $members[1]; }
        elseif($vote2 > $vote1){ $finalists['second'] = $members[1]; $finalists['third'] = $members[0]; }
        elseif(($vote2 == $vote1)){ $finalists['second'] = $members[array_rand($members)] ;
           foreach($members as $member){if($finalists['second'] != $member){ $finalists['third'] = $member;  }}}
           
        //Add cups to finalists
        //foreach($finalists as $cup=>$finalist){
            $this->user->add_cup('platinum', $winner);
       // }   
           
        //Get tournament details
        $tournament_details = $this->get_tournament_details($tournament_request_id);

        //Get all members ids
        foreach($tournament_details as $tournament_detail){
            $friend_user_ids[] = $tournament_detail['friend_user_id'] ;
        }

        //Remove winner
        if (($key = array_search($winner, $friend_user_ids)) !== false) {
             unset($friend_user_ids[$key]);
        }

        //Update lose count
        foreach($friend_user_ids as $user_id){

            $user  = $this->db->get_where('user', array('id' => $user_id))->result_array();
            $count = $user[0]['lose_cnt'];

            $sql = "UPDATE user SET lose_cnt = '".($count+1)."'  WHERE id = '".$user_id."'";
            $this->db->query($sql);
        }

        //Update winner count
        $user  = $this->db->get_where('user', array('id' => $winner))->result_array();
        $count = $user[0]['win_cnt'];

        $sql = "UPDATE user SET win_cnt = '".($count+1)."'  WHERE id = '".$winner."'";
        $this->db->query($sql);
        
        //Add prize coins to winners
        $exist_coins  = $user[0]['coins'];
        $sql = "UPDATE user SET coins = '".(($user[0]['coins'])+(tournamentFirstPrize))."'  WHERE id = '".$winner."'";
        $this->db->query($sql);
        
        $this->db->select('coins');
        $this->db->from('user');
        $this->db->where('id',$finalists['second']);
        $exist_coins2 = $this->db->get()->row()->coins;
         
        $sql = "UPDATE user SET coins = '".(($exist_coins2)+(tournamentSecondPrize))."'  WHERE id = '".$finalists['second']."'";
        $this->db->query($sql);
        
        $this->db->select('coins');
        $this->db->from('user');
        $this->db->where('id',$finalists['third']);
        $exist_coins3 = $this->db->get()->row()->coins;
        
        $sql = "UPDATE user SET coins = '".(($exist_coins3)+(tournamentThirdPrize))."'  WHERE id = '".$finalists['third']."'";
        $this->db->query($sql);
        
        //Update tournament
        $sql = "UPDATE tournament_request SET finalists = '".base64_encode(serialize($finalists))."'  WHERE tournament_request_id = '".$tournament_request_id."'";
        $this->db->query($sql);
        
        //Add post
        $postContent = $user[0]['firstname'].' '.$user[0]['lastname'].' has won a tournament';
             
        $data = array('content'    => $postContent ,
			   'subject_id' => $user[0]['id'],
			   'object_id'  => $user[0]['id'],
			   'data_id'    => $tournament_request_id,
                           'data_type'  => 'tournament',
			   'created_on' => date("Y-m-d H:i:s", time())
	       	);
	$this->post->addpost($data);

        return true;
	 
     }
     
     public function get_group_details($tournament_id='',$first_user='',$second_user='') {
         
          $sql = "select u.id, u.firstname, u.lastname, concat(u.firstname ,' ',u.lastname ) name, u.profile_picture, "
                    . "u.coins, u.win_cnt, u.lose_cnt, "
                    . "sl.song_id, sl.media, sl.title, "
                    . "(select count(id) from `likes` where post_id = sl.song_id and post_type='song') as like_count"
                    . " from tournament_members tm "
                    . "inner join user u on tm.friend_user_id = u.id "
                    . "inner join tournament_media t_media on u.id = t_media.artist_id "
                    . "inner join song_library sl on t_media.fk_song_id = sl.song_id "
                    . " where tm.tournament_request_id=$tournament_id and tm.friend_user_id in($first_user,$second_user)"
                    . " and t_media.tournament_request_id=$tournament_id order by tm.friend_user_id asc";
	    
	  $result = $this->db->query($sql);
	  return $result->result_array();
     }
     
     public function get_voter_votes($whereArr = [])
     {
	 $resultArr = array();
	 if(!empty($whereArr))
	 {
	     $this->db->select('social_media_type , artist_id , vote_id , voter_id, concat(user.firstname , " " ,user.lastname ) as voter_name, user.profile_picture');
             $this->db->from('tournament_votes tv');
             $this->db->join('user' , 'user.id = tv.voter_id' , 'LEFT');
	     $this->db->where($whereArr);
	     //$this->db->group_by('voter_id');
	     $this->db->order_by('tv.vote_id' , 'desc');
	     
	     $result = $this->db->get();
	     if($result->num_rows() > 0 )
	     {
		 $resultArr = $result->result_array();
	     }
	 }
	 return $resultArr ;
     }
    
 }
 