<?php

/**
 * Description of Tournament
 * 
 */
class Cron extends CI_Controller {

    //put your code here
    public $sessionData;

    public function __construct() {
        parent::__construct();

        $this->load->model('battle_model', 'battles');
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
     * cron function for tournaments
     *
     */
    public function check_tournaments() {
        //Get all running tournaments
        $tournaments = $this->tournaments->get_running_tournaments();
        //echo '<pre>';        print_r($tournaments); die;
        
        foreach ($tournaments as $tournament) {

            $round = NULL;
            $diff = strtotime(date('Y-m-d H.i.s')) - strtotime($tournament['start_date']);
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
            
            //$round = 2;
            
            //Check to ensure no duplicate values in tournament groups
            if (isset($round)) {
                $query = "SELECT tournament_group_id from tournament_groups where tournament_request_id=" . $tournament['tournament_request_id'] . " AND round = " . $round . " LIMIT 1";
                $query_rs = $this->db->query($query);
                $result = $query_rs->result_array();
            }
            
            if (isset($round) && count($result) < 1) {

                //Get previous round winners
                $winners = $this->tournaments->get_round_winners($round - 1, $tournament['tournament_request_id']);
                //echo '<pre>';                print_r($winners); die;

                if ($round == 6) {
                    //$groups[] = $winners[0] . "," . $winners[1] . "," . $winners[2];
                     $groups[] = $winners[0];

                    //Close tournament
                    //$this->tournaments->close_tournament($winners[0], $tournament['tournament_request_id']);
                } elseif ($round == 7) {
                    $groups[] = $winners[0];

                    //Close tournament
                    $this->tournaments->close_tournament($winners[0], $tournament['tournament_request_id']);
                } else {
                    // Shuffle the members
                        //shuffle($winners);
                    // Pair the adjacent members
                    for ($index = 0; $index < count($winners); $index +=2) {
                        $groups[] = $winners[$index] . "," . $winners[$index + 1];
                    }
                }
                //echo '<pre>'; print_r($groups); die;
                foreach ($groups as $group) {
                    $this->db->insert('tournament_groups', ['tournament_request_id' => $tournament['tournament_request_id'],
                        'tournament_group' => $group,
                        'round' => $round]);
                }
                
                // Send notification to next round vote
                foreach ($winners as $winKey=>$val){
                    $this->tournaments->requestVoteNoti($tournament['tournament_request_id'], $round, $winners[$winKey]);
                }
            }
        }


        echo 'Completed';
        $this->db->insert('cron', ['cron' => 'check_tournaments']);
    }

    public function check_battles() {
        $battle_list = $this->battles->get_running_battle();
        $updateBattle = array();
        
        if (!empty($battle_list)) {
            foreach ($battle_list as $key => $value) {
                if ($value['end_date'] <= date("Y-m-d H:i:s")) {

                    if ($value['challengerCnt'] > $value['friendCnt']) {
                        $winnerId = $value['CId'];
                        $looserId = $value['FId'];
                    } else if ($value['friendCnt'] > $value['challengerCnt']) {
                        $winnerId = $value['FId'];
                        $looserId = $value['CId'];
                    } else {

                        $contestants = [$value['FId'], $value['CId']];
                        $winner = array_rand($contestants);

                        $winnerId = $contestants[$winner];

                        foreach ($contestants as $con) {
                            if ($con != $winnerId) {
                                $looserId = $con;
                            }
                        }
                    }


                    $whrArr = array('battle_request_id' => $value['bId']);
                    $updateArr = array(
                        'winner' => $winnerId,
                        'status' => 3
                    );
                    
                    // For send notification to the user
                    $this->battles->sendNotiToVoter($value['bId'],$winnerId,$looserId);
                    
                    // For Update user cash battle 
                    if(!is_null($value['entry']) && $value['entry'] > 0) {
                        
                         $winner_amount = $value['entry'] * 2;
                        $winner_amount += $this->battles->get_support_amount($value['bId']);
                        
                        $this->db->where('id',$winnerId);
                        $this->db->set('coins', 'coins+'.$winner_amount, FALSE);
                        $this->db->update('user');
                        
                        // update artist payments
                        $this->db->where('battle_id',$value['bId']);
                        $this->db->update('artist_payments', ['is_credited_user'=>1]);
                    }
                    
                    //Add cup
                    $this->user->add_cup('gold', $winnerId);

                    $this->battles->update_user_count('win_cnt', $winnerId);
                    $this->battles->update_user_count('lose_cnt', $looserId);
                    $this->battles->update_request($updateArr, $whrArr);
                    $this->db->last_query();
                }
            }
        }
        $this->db->insert('cron', ['cron' => 'check_battles']);
        echo "Completed";
    }
    
    
    public function test() {
        echo 'Hello';
        /* $this->load->library('email');

        $this->email->from('noreply@battleme.hiphop', 'Your Battleme Team');
        $this->email->to('samiran.brainium@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send(); */
    }


    /* public function index() {
        $this->battles->sendNotiToVoter($battleId=41,$winnerId=283);
    } */

}
