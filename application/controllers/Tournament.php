<?php

/**
 * Description of Tournament
 * 
 */
class Tournament extends CI_Controller {

    //put your code here
    public $sessionData;

    public function __construct() {
        parent::__construct();
        $s = $this->session->userdata('logged_in');
        if (empty($s)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        }

        $this->load->model('tournament_model', 'tournaments');
        $this->load->model('Friendsmodel', 'friends');
        $this->load->model('Usermodel', 'user');
        $this->load->model('Notificationmodel', 'notification');
        $this->load->model('Postmodel', 'post');
        $this->load->model('VoteModel', 'vote');
        $this->load->model('Song_library_model', 'library');
        $this->load->library('Common_lib');
        $this->sessionData = get_session_data();
    }

    /**
     * index function
     * @return void
     * @param 
     * */
    public function index() {
        $user_id = $this->sessionData['id'];
        $tournamentData = $this->tournaments->get_tournament_list($user_id);
        $arrData['userId'] = $user_id;
        $arrData['tournamentList'] = $tournamentData;
        $arrData['middle'] = 'tournament_list';
        $arrData['div_col_unit'] = 'col-md-12';

        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['tournament_status'] = $this->tournaments->get_user_tournament_status($user_id);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
        $arrData['top_user'] = $this->user->get_top_user();

        $this->load->view('templates/template', $arrData);
    }

    /**
     * get all tournaments
     * @return void
     * @param 
     * */
    public function all() {
        $user_id = $this->sessionData['id'];
        $tournamentData = $this->tournaments->get_tournament_list();
        $arrData['userId'] = $user_id;
        $arrData['tournamentList'] = $tournamentData;
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['tournament_status'] = $this->tournaments->get_user_tournament_status($user_id);
        $arrData['tournament_status'] = $this->tournaments->getCurrentTournament();
        //print_r($arrData['tournament_status']);
        $arrData['top_songs'] = $this->library->get_top_songs();
        $arrData['top_user'] = $this->user->get_top_user();

        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);

        $arrData['middle'] = 'tournament_list';
        $arrData['div_col_unit'] = 'col-md-12';
        /* echo '<pre>';
          print_r($arrData['tournament_status']);
          die(); */

        $this->load->view('templates/template', $arrData);
    }

    /**
     * cron function for tournaments
     *
     */
//     public function check_tournaments()
//     {
//         //Get all running tournaments
//          $tournaments = $this->tournaments->get_running_tournaments();
//          
//          foreach($tournaments as $tournament){
//        
//              $round = NULL;
//              $diff  = strtotime(date('Y-m-d H.i.s'))- strtotime($tournament['start_date']);
//              $days  = floor($diff/(60*60*24)); 
//        
//                  if($days==6) {$round = 2; }
//              elseif($days==12){$round = 3; }
//              elseif($days==18){$round = 4; }
//              elseif($days==24){$round = 5; }
//              elseif($days==30){$round = 6; }
//              elseif($days==36){$round = 7; }
//              
//              if(isset($round)){
//                 
//                  //Get previous round winners
//                  $winners = $this->tournaments->get_round_winners($round-1, $tournament['tournament_request_id']);
//                  
//                   if($round == 6){
//                       $groups[] = $winners[0] . "," . $winners[1]. "," . $winners[2];
//                   }elseif($round == 7){
//                       $groups[] = $winners[0];
//                       
//                       //Close tournament
//                       $this->tournaments->close_tournament($winners[0], $tournament['tournament_request_id']);
//                       
//                   }else{
//                    
//                        // Shuffle the members
//                        shuffle($winners);
//
//                        // Pair the adjacent members
//                        for ( $index = 0; $index < count($winners); $index +=2) {
//                            $groups[] = $winners[$index ] . "," . $winners[$index+1];
//                        }
//                    
//                   }
//                   
//                    foreach($groups as $group){
//                    $this->db->insert('tournament_groups' , ['tournament_request_id' => $tournament['tournament_request_id'], 
//                                                             'tournament_group'      => $group,
//                                                             'round'                 => $round]);
//                    }
//                    
//              }
//          }
//          
//         
//          echo 'Completed'; 
//     }

    /**
     * create function
     * this function is used create tournament request
     * @return void
     * @param 
     * */
    public function create() {
        //get friends list of logged in user
        $arrData = array();
        $selectedId = 0;
        $friendOptions = '';
        $sessionData = $this->sessionData;

        //Restrict if user alresdy in a tournament
        $user_tournament_status = $this->tournaments->get_user_tournament_status($sessionData['id']);

        if (count($user_tournament_status) > 0 || $sessionData['user_type'] != 'artist' || $sessionData['membership_id'] != 2) {
            redirect('home');
        }

        if ($this->input->post('Submit')) {
            foreach ($this->input->post() as $key => $val) {
                $$key = $val;
            }

            $inputData['user_id'] = $sessionData['id'];
            //   $inputData['friend_user_id']  = $friend_user_id ;
            $inputData['tournament_name'] = $tournament_name;
            $inputData['description'] = $description;
            //$inputData['entry'] = $entry;
            //$inputData['prize'] = $prize;
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('tournament_name', 'Tournament Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                
                $request_id = $this->tournaments->add_request($inputData);
                $user = $this->user->get_user_by_id($sessionData['id']);

                //Add post
                $postContent = $user[0]['firstname'] . ' ' . $user[0]['lastname'] . ' has started a tournament';
                $data = array('content' => $postContent,
                    'subject_id' => $sessionData['id'],
                    'object_id' => $sessionData['id'],
                    'data_id' => $request_id,
                    'data_type' => 'tournament',
                    'created_on' => date("Y-m-d H:i:s", time())
                );
                $this->post->addpost($data);

                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'New Tournament created');

                redirect('tournament/all');
            }
            
        }

        // $arrData['friendsOpt'] = $friendOptions ;
        $arrData['middle'] = 'create_tournament_request';
        $arrData['div_col_unit'] = 'col-md-12';
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
        $arrData['top_user'] = $this->user->get_top_user();

        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);

        $this->load->view('templates/template', $arrData);
    }

    public function request($tournament_request_id = NULL, $status = 0) {
        $sessionData = $this->sessionData;

        if (!is_null($tournament_request_id)) {
            //Get tournament details
            $tournament_details = $this->tournaments->get_tournament_details($tournament_request_id);
            //echo '<pre>'; print_r($tournament_details); die;
            //Get tournament groups if tournament started
            if (isset($tournament_details[0]['start_date'])) {
                $arrData['tournament_groups'] = $this->tournaments->get_tournament_groups($tournament_request_id, $tournament_details[0]['start_date']);
                //echo '<pre>'; print_r($arrData['tournament_groups']); die;
            }

            //Get all members ids
            foreach ($tournament_details as $tournament_detail) {
                $arrData['friend_user_ids'][] = $tournament_detail['friend_user_id'];
            }

            //Get tournament media
            //$tournament_media = $this->tournaments->get_tournament_media(array('tournament_request_id' => $tournament_request_id));
            //echo '<pre>'; print_r($tournament_media); die; 
            //Get tournament votes
            $round = '';

            if (isset($tournament_details[0]['start_date'])) {
                $diff = strtotime(date('Y-m-d H.i.s')) - strtotime($tournament_details[0]['start_date']);
                $days = floor($diff / (60 * 60 * 24));

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

            /* $vote_details_arr = $this->vote->get_tournament_votes(array('tournament_request_id' => $tournament_request_id, 'round' => $round));
            $arrData['voters'] = [];

            if (!empty($vote_details_arr)) {
                foreach ($vote_details_arr as $vote) {
                    $arrData['artists'][] = $vote['artist_id'];
                    $arrData['voters'][] = $vote['voter_id'];
                }

                $arrData['vote_count'] = array_count_values($arrData['artists']);
                $voteDetails = $vote_details_arr;
            } else {
                $voteDetails = array();
                $tournament_details[0]['friend_vote_cnt'] = 0;
                $tournament_details[0]['user_vote_cnt'] = 0;
            } */

            //Set values
            $arrData['tournament_details'] = $tournament_details;
            //$arrData['tournament_media'] = $tournament_media;
            //$arrData['vote_details'] = $voteDetails;
            $arrData['round'] = $round;

            $arrData['middle'] = 'tournament_page';
            $arrData['div_col_unit'] = 'col-md-12';
            $arrData['own_songs'] = $this->library->getUserSongs($sessionData['id']);
            //echo '<pre>';            print_r($arrData['own_songs']); 
            
            //$arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
            //$arrData['top_songs'] = $this->library->get_top_songs();
            //$arrData['top_user'] = $this->user->get_top_user();

            //$arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
            //$arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
            //$arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);

            $this->load->view('templates/tournament_template', $arrData);
        } else
            redirect('battle');
    }

    public function entry_tournament($tournament_id = NULL) {
        //echo $tournament_id; die;
        //Add media
        $sess_data = get_session_data();
        $user_id = $sess_data['id'];
        if(isset($sess_data['membership_id']) && ($sess_data['membership_id'] == 1 || $sess_data['membership_id'] == 3 )) {
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('message', 'Want to participate in tournaments? Upgrade to Premium membership so you can Put Your Money Where Your Mouth is and let the cash flow in!');
            redirect('tournament/request/' . $tournament_id);
        }
        if($_POST) {
            $tournament_id = $this->input->post('tournament_id');
        }
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('media_type', 'Media Type', 'trim|required');
        
        if($this->input->post('media_type') == 1) {
             if (empty($_FILES['media']['name'])) {
                $this->form_validation->set_rules('media', 'Media', 'required');
            }
        } else {
            $this->form_validation->set_rules('media_id', 'choose from library', 'trim|required');
        }
        $this->form_validation->set_rules('tournament_id', 'Tournament Id', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            
            if($this->input->post('media_type') == 1) {
                $mediaConfig = array(
                    'upload_path' => $this->config->item('library_media_path'),
                    'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm',
                    'max_size' => '307200');
            }
            
            //Get user details
            $user = $this->user->get_user_by_id($user_id);
            //Get tournament details
            //$tournament_details = $this->tournaments->get_tournament_details($tournament_id);

            if ($user[0]['coins'] < tournamentEntry) {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', 'Not enough coins available. Please buy coins');
                redirect('tournament/request/' . $tournament_id);
            }

            if($this->input->post('media_type') == 1) {
                $filename = $this->common_lib->upload_media('media', $mediaConfig);
                if (!is_array($filename)) {
                    //save file to users library first
                    $library_data = array(
                        'user_id' => $user_id,
                        'title' => $this->input->post('title'),
                        'media' => $filename,
                        'created_date' => date('Y-m-d H:i:s'));

                    $library_id = $this->library->insert($library_data);

                    } else {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('message', $filename['error']);
                    redirect('tournament/request/' . $tournament_id);
                }
            } else {
                $library_id =  $this->input->post('media_id');
            }

                if (isset($library_id) && $library_id > 0) {
                    //save media in battle 
                    if($this->input->post('media_type') == 1) {
                        $copyStatus = copy($this->config->item('library_media_path') . $filename, $this->config->item('battle_media_path') . $filename);
                    }
                    $form_data = array(
                        'tournament_request_id' => $tournament_id,
                        'artist_id' => $user_id,
                        'fk_song_id' => $library_id,
                        'created_date' => date('Y-m-d H:i:s'));

                    $status = $this->tournaments->add_tournament_media($form_data);

                    if ($status) {
                        $this->session->set_flashdata('class', 'alert-success');
                        $this->session->set_flashdata('message', 'Song has been added to tournament');
                    } else {
                        $this->session->set_flashdata('class', 'alert-danger');
                        $this->session->set_flashdata('message', 'Unable to upload song. Please try again');
                        redirect('tournament/request/' . $tournament_id);
                    }
                }


            // Add members
            foreach ($this->input->post() as $key => $val)
                $$key = $val;

            $inputData['tournament_request_id'] = $tournament_id;
            $inputData['friend_user_id'][] = $user_id;
            $result = $this->tournaments->add_tournament_members($inputData, tournamentEntry);

            //Add post
            $postContent = $user[0]['firstname'] . ' ' . $user[0]['lastname'] . ' has enterted a tournament';
            $data = array('content' => $postContent,
                'subject_id' => $user_id,
                'object_id' => $user_id,
                'data_id' => $tournament_id,
                'data_type' => 'tournament',
                'created_on' => date("Y-m-d H:i:s", time())
            );
            $this->post->addpost($data);

            if ($result) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'You have entered the tournament successfully');
                redirect('tournament/request/' . $tournament_id);
            }
        } 

        
        // for view page
        $tournament_details = $this->tournaments->get_tournament_details($tournament_id);
        //Get tournament groups if tournament started
        if (isset($tournament_details[0]['start_date'])) {
            $arrData['tournament_groups'] = $this->tournaments->get_tournament_groups($tournament_id, $tournament_details[0]['start_date']);
        }
        //Get all members ids
        foreach ($tournament_details as $tournament_detail) {
            $arrData['friend_user_ids'][] = $tournament_detail['friend_user_id'];
        }
 
        $round = '';
        if (isset($tournament_details[0]['start_date'])) {
            $diff = strtotime(date('Y-m-d H.i.s')) - strtotime($tournament_details[0]['start_date']);
            $days = floor($diff / (60 * 60 * 24));

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

        //Set values
        $arrData['tournament_details'] = $tournament_details;
        $arrData['round'] = $round;

        $arrData['middle'] = 'tournament_page';
        $arrData['div_col_unit'] = 'col-md-12';
        $arrData['own_songs'] = $this->library->getUserSongs($user_id);
        $this->load->view('templates/tournament_template', $arrData);
        
    }
    
    public function voting() {
        if(is_null($this->uri->segment(3)) || is_null($this->uri->segment(4)) || is_null($this->uri->segment(5))){
            redirect('home');
        }
      $tournament_id = $this->uri->segment(3);
      $round = $this->uri->segment(4);
      $round_array = ['1st'=>1,'2nd'=>2,'3rd'=>3,'4th'=>4,'5th'=>5,'6th'=>6,'7th'=>7];
      if(in_array($round, $round_array)) {
          $round = $round_array[$round]; 
      } else { redirect('home'); }
      $group_id = base64_decode($this->uri->segment(5));
       $group_id = explode('/', $group_id);
       sort($group_id);
      //echo '<pre>';      print_r($group_id); die;
      if(isset($group_id[0]) && isset($group_id[1]) ){
            $first_user = $group_id[0];
            $second_user = $group_id[1];
      } else { redirect('home'); }
      
      // Start to tournament voting page
            $arrData['tournament_id'] = $tournament_id;
            $arrData['round'] = $round;
            $arrData['group_details'] = $this->tournaments->get_group_details($tournament_id,$first_user,$second_user);
            //echo '<pre>';            print_r($arrData['group_details']); die;
            $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
            //echo '<pre>'; print_r($arrData); die();
            
            $vote_param1 = ['tournament_request_id'=>$tournament_id, 'round'=>$round, 'artist_id'=>$first_user];
            $vote_param2 = ['tournament_request_id'=>$tournament_id, 'round'=>$round, 'artist_id'=>$second_user];
            $arrData['vote_list_first'] = $this->tournaments->get_voter_votes($vote_param1);
            $arrData['vote_list_second'] = $this->tournaments->get_voter_votes($vote_param2);
            //echo '<pre>'; print_r($arrData); die();
            
            $this->load->view('tournament_voting', $arrData);
    }

}
