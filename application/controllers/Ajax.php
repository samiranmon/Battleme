<?php
 /**
  * Description of Ajax
  *
  * @author Chhanda Rane
  */
 class Ajax extends CI_Controller {
     //put your code here
     public function __construct() {
	 parent::__construct();
	 $this->load->model('VoteModel' , 'vote');
	 $this->load->model('Postmodel' , 'post');
	 $this->load->model('Usermodel');
         $this->load->model('Friendsmodel');
     }
     
     
     public function place_vote()
     {
	 foreach($this->input->post() as $key => $value )
	     $$key = $value ;
	 
	 $inputData['voter_id'] = $voter_id ;
	 $inputData['battle_id'] = $battle_id ;
	 $inputData['artist_id'] = $artist_id ;
	 $inputData['social_media_type'] = $social_media_type ;
	 
	 $result = $this->vote->place_vote($inputData);
	 
	 $cntWhereArr['battle_id'] = $battle_id ;
	 $cntWhereArr['artist_id'] = $artist_id ;
	 $voteCount = $this->vote->count_vote($cntWhereArr);
         
         
         // get voter list
         $data = [];
         $data['voterList'] = $this->vote->get_voter_list($battle_id,$artist_id);
         $voterList = $this->load->view('ajax_voter_list',$data, TRUE);
         echo json_encode([$voteCount,$voterList]);
         die();
     }
     
     public function place_tournament_vote()
     {
	 foreach($this->input->post() as $key => $value )
	     $$key = $value ;
	 
	 $inputData['voter_id']              = $voter_id ;
	 $inputData['tournament_request_id'] = $tournament_request_id ;
	 $inputData['artist_id']             = $artist_id ;
	 $inputData['social_media_type']     = $social_media_type ;
         $inputData['round']                 = $round ;
	 
	 $result = $this->vote->place_tournament_vote($inputData);
	 
	 $cntWhereArr['tournament_request_id'] = $tournament_request_id ;
	 $cntWhereArr['artist_id']             = $artist_id ;
         $cntWhereArr['round']                 = $round ;
	 $voteCount = $this->vote->count_tournament_votes($cntWhereArr);
	 echo $voteCount ;
     }
     
     
      public function like()
    {
	$postArr = $this->input->post();
	foreach($postArr as $key => $value)
	    $$key = $value ;
	
	$inputArr['post_id'] = $data_id;
	$inputArr['post_type'] = $like_type;
	$inputArr['user_id'] = $user_id;
        if(isset($battle_id)) {
            $inputArr['battle_id'] = $battle_id;
        }
	$result = $this->post->add_like($inputArr);
	
	if($result)
	{
             if(isset($battle_id)) {
                 $likeCount = $this->post->get_like_count(array('post_id' => $data_id , 'post_type' => 'song', 'battle_id' => $battle_id));
             } else {
                 $likeCount = $this->post->get_like_count(array('post_id' => $data_id , 'post_type' => 'song'));
             }
	    //echo $this->db->last_query();
	    echo $likeCount ;
	}
	else
	    echo 0 ;
	
	
    }
	
    /**
     * To add a post after up vote from fb or twitter
     */
    public function place_post(){
            $postArr = $this->input->post();
            foreach($postArr as $key => $value)
            $$key = $value ;
            $msg = 'voted for you in '.$battle_name;
            add_notification($subject_id, $object_id, $msg, $type = 'vote', $battle_id);
            return true;

            /* $userdata = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
            //battle_name:battle_name,artist_id: artists_id, voter_id: voter_id, battle_id: battle_id, social_media_type: social_media
            $inputArr['content'] = $userdata[0]->firstname.' '.$userdata[0]->lastname." Up voted to ".$battle_name; 
            $inputArr['subject_id'] = $subject_id;
            $inputArr['object_id'] = $object_id;
            $inputArr['data_id'] = '';
            $inputArr['status'] = '1';
            $inputArr['created_on'] = date('Y:m:d h:i:s');
            $result = $this->post->addpost($inputArr);
            if($result){
                    echo true;
            }else{
                    echo false;
            } */

            exit;
    }
        
        
    public function tournament_place_vote()
     {
         foreach($this->input->post() as $key => $value )
             $$key = $value ; 
          
         $inputData['artist_id'] = $artist_id;
         $inputData['round'] = $round;
         $inputData['social_media_type'] = $social_media_type;
         $inputData['voter_id'] = $voter_id ;
         $inputData['tournament_request_id'] = $tournament_id ;
         
         $this->db->insert('tournament_votes', $inputData); 


         // get voter list
         $data = [];
         $data['voterList'] = $this->vote->get_tournament_voter_list($tournament_id,$round,$artist_id);
         $voterList = $this->load->view('ajax_voter_list',$data, TRUE);
         echo json_encode([count($data['voterList']),$voterList]);
         die();
     }
     
    public function get_active_user() {
        $userId = $this->session->userdata('logged_in')['id'];
        if(isset($userId) && is_numeric($userId)) {
            // Start for update section
            $this->db->where('id', $userId);
            $this->db->set('updated_on', 'NOW()', FALSE);
            $this->db->update('user'); 
            
            // get connected user list
            $data['rightsidebar'] = $this->Friendsmodel->get_connected_frnds($this->session->userdata('logged_in')['id']);
            $userList = $this->load->view('connect_user_list',$data, TRUE);
            echo json_encode([$userList]);
            die();
            
        }

    }
 }
 