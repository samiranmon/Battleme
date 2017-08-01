<?php

/**
 * Usermodel class
 * this class has function that perform insert update delete of admin user details
 * @package battle
 * @subpackage model
 * @author 
 * */
class Adminusermodel extends CI_Model {

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
     * @param $email
     * @param $password
     * @return login result
     * @author 
     * */
    public function login($email, $password) {
        $this->db->select('admin_user.*');
        $this->db->from('admin_user');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * adduser function
     * @param $data
     * @return void
     * @author 
     * */
    public function adduser($data) {
        $result = $this->db->get_where('user', array('fb_id' => $data['fb_id']))->result_array();

        if (empty($result)) {
            $this->db->insert('user', $data);
            return $this->db->get_where('user', array('id' => $this->db->insert_id()))->result_array();
        } else {
            return $result;
        }
    }

    /**
     * checkuser function
     * @param $data
     * @return void
     * @author 
     * */
    public function checkuser($data) {
        $result = $this->check_user_data($data['email']);
        if (empty($result)) {
            $this->db->insert('admin_user', $data);
        } else {
            return "user already exist";
        }
    }

    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     * */
    public function check_user_data($email) {
        return $this->db->get_where('admin_user', array('email' => $email))->result();
    }

    /**
     * update_user_data function
     * @param $data
     * @param $id
     * @return void
     * @author 
     * */
    public function update_user_data($data, $id) {
        $this->db->update('admin_user', $data, array('id' => $id));
    }

    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     * */
    public function get_user_data($id, $key) {
        return $this->db->get_where('admin_user', array('id' => $id, 'secret_key' => $key))->result();
    }

    public function get_user_by_id($id = NULL) {
        if ($id == NULL) {
            $sessionData = $this->sessionData = get_session_data();
            $id = $sessionData['id'];
        }

        return $this->db->get_where('admin_user', array('id' => $id))->result_array();
    }

    /**
     * get_user_profile function
     *
     * @return void
     * @author 
     * */
    public function get_user_profile($id = NULL) {
        if (!is_null($id)) {
            $sql = "SELECT *,(SELECT COUNT(user_id)  FROM user_follow WHERE user_id = " . $id
                    . ") AS following,(SELECT COUNT(following_frnd_id)  FROM user_follow WHERE following_frnd_id = "
                    . $id . ") AS follower FROM user where id = " . $id;
            return $this->db->query($sql)->result();
        }

        // return $this->db->get_where('user', array('id' => $id))->result();
    }

    /**
     * update_user_profile function
     *
     * @return void
     * @author 
     * */
    public function update_user_profile($id, $data) {
        $user_id = $this->session->userdata('logged_in')['id'];

        if (!isset($user_id) || $user_id == '') {
            return FALSE;
        }

        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        return true;

        /* if($this->db->affected_rows() > 0){  
          return true;
          }else{
          return false;
          } */
    }

    public function delete_user_details($id) {
        $deluser = $this->db->delete('user', array('id' => $id));
        if ($deluser) {
            return true;
        } else {
            return false;
        }
    }

    public function get_top_user() {
        $sql = "select * from user WHERE user_type = 'artist' ORDER BY win_cnt desc limit 100 ";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->result_array();
        }
        return array();
    }

    public function updateadminprofile($data, $id) {

        $this->db->where('id', $id);
        $this->db->update('admin_user', $data);
        return true;
    }

    public function get_admindetails($id) {
        $this->db->select('*');
        $this->db->from('admin_user');

        $this->db->where('id', $id);


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
    }

    public function get_count_user_battle() {
        $this->db->select('count(user_memberships.user_id) as count')
                ->from('user')
                ->join('user_memberships', 'user.id=user_memberships.user_id');
        $query = $this->db->get();

        $row = $query->row_array('count');

        $this->db->select('count(*) as count');
        $this->db->from('battle_request');
        $query1 = $this->db->get();
        $row1 = $query1->row_array('count');

        $sql = "SELECT  count(*) as count, TIMESTAMPDIFF(minute, start_date,CURDATE()) as tim from battle_request where status=1 having tim<=10080";
        $res = $this->db->query($sql);
        $activebattle = $res->result_array('count');

        $this->db->select('count(*) as count');
        $this->db->from('tournament_request');
        $query2 = $this->db->get();
        $row2 = $query2->row_array('count');
        //SELECT  count(user_memberships.user_id ) as count,user_memberships.memberships_id as membership FROM `user_memberships` INNER JOIN user ON user_memberships.user_id=user.id  GROUP BY user_memberships.memberships_id
        $this->db->select('count(user_memberships.user_id ) as count,user_memberships.memberships_id as membership')
                ->from('user_memberships')
                ->join('user', 'user_memberships.user_id=user.id')
                ->group_by('user_memberships.memberships_id');
        $query3 = $this->db->get();
        $row3 = $query3->result_array();
        //print_r($row3);
        $get_count = array(
            'user' => $row['count'],
            'battle' => $row1['count'],
            'tournament' => $row2['count'],
            'allmember_count' => $row3,
            'activebattle' => $activebattle
        );
        //print_r($get_count);die;
        return $get_count;
    }

    public function get_user_details($id) {
        $this->db->select('*');
        $this->db->from('user');

        $this->db->where('id', $id);


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
    }

    public function get_member_details($id) {
        $this->db->select('*');
        $this->db->from('memberships');

        $this->db->where('id', $id);


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
    }

    public function get_sitesetting_details($id) {
        $this->db->select('*');
        $this->db->from('sitesetting');

        $this->db->where('id', $id);


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
    }

    public function save_facebook_data($data) {


        if ($this->db->insert('fbdata', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_contactus_details() {
        $this->db->select('*');
        $this->db->from('contact_us');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_contactus_email($id) {
        $this->db->select('*');
        $this->db->from('contact_us');

        $this->db->where('id', $id);


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
    }

    public function update_contactus_email($id) {
        $data = array('status' => 1);
        $this->db->update('contact_us', $data, array('id' => $id));
    }

    public function get_songlike_details() {
//           $this->db->select('*');
//        $this->db->from('contact_us');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT likes.id,likes.post_id,count(likes.post_id) as likes,likes.user_id,song_library.song_id,song_library.user_id,song_library.media,song_library.title FROM song_library INNER JOIN likes ON song_library.song_id=likes.post_id and likes.post_type='song' GROUP BY song_library.song_id");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function paypalsetting() {
        $this->db->select('paypal_setting.*');
        $this->db->from('paypal_setting');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_battle_details() {
        //$this->db->select('*');
        //$this->db->from('battle_request');
        //$query = $this->db->get();
        $query = $this->db->query("SELECT br.*,(SELECT firstname from user u where u.id=br.user_id) as username,(SELECT firstname from user u where u.id=br.friend_user_id) as userfname,(SELECT firstname from user u where u.id=br.winner) as winner,(SELECT count(lk.id) from likes lk where lk.battle_id=br.battle_request_id AND lk.user_id=br.user_id) as userlike,(SELECT count(lk.id) from likes lk where lk.battle_id=br.battle_request_id AND lk.user_id=br.friend_user_id) as frinedlike,(SELECT count(lk.id) from likes lk where lk.battle_id=br.battle_request_id) as battlelike,(SELECT count(bv.vote_id) from battle_votes bv where bv.battle_id=br.battle_request_id) as battlevote "
                . " ,(SELECT count(bv.vote_id) from battle_votes bv where bv.battle_id=br.battle_request_id AND bv.artist_id=br.user_id) as uservote,(SELECT count(bv.vote_id) from battle_votes bv where bv.battle_id=br.battle_request_id AND bv.artist_id=br.friend_user_id) as friendvote,(SELECT SUM(battle_bucks)  from artist_payments ap where ap.battle_id=br.battle_request_id) as donate FROM battle_request br ORDER BY br.battle_request_id ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_battle_songs($id) {

        $query = $this->db->query("SELECT u.id,u.firstname,br.battle_request_id,br.user_id,br.friend_user_id,bm.*,sl.*,sl.user_id as songuser FROM battle_request br "
                . "INNER JOIN battle_media bm ON bm.battle_id=br.battle_request_id "
                . " INNER JOIN song_library sl ON bm.fk_song_id=sl.song_id"
                . " INNER JOIN user u ON sl.user_id=u.id  WHERE br.battle_request_id=" . $id);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_donate_details() {
//           $this->db->select('*');
//        $this->db->from('contact_us');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT user.firstname,battle_request.battle_name,artist_payments.payment_gross,artist_payments.created_on FROM artist_payments INNER JOIN user  ON artist_payments.user_id=user.id INNER JOIN battle_request ON artist_payments.battle_id=battle_request.battle_request_id WHERE artist_payments.payment_status='Completed'");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_vote_details() {
//           $this->db->select('*');
//        $this->db->from('contact_us');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT bv.*,(SELECT firstname from user u where u.id=bv.voter_id) as votername,(SELECT firstname from user u where u.id=bv.artist_id) as artistname,(SELECT battle_name from battle_request br where br.battle_request_id=bv.battle_id) as battlename FROM battle_votes as bv");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_media_details() {
//           $this->db->select('*');
//        $this->db->from('contact_us');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT CONCAT(u.firstname,' ',u.lastname) as uname,sl.*,"
                . "(SELECT count(bm.media_id) FROM battle_media as bm WHERE bm.fk_song_id=sl.song_id) as battledonwload ,"
                . "(SELECT count(tm.media_id) FROM tournament_media as tm WHERE tm.fk_song_id=sl.song_id) as tournamentdonwload ,("
                . "SELECT SUM(md.battle_bucks) FROM media_download as md WHERE md.media_id=sl.song_id) as songbattlebuck "
                . "FROM song_library as sl INNER JOIN user u ON sl.user_id=u.id INNER JOIN media_download md ON md.media_id=sl.song_id");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_media_download_details() {
//           $this->db->select('*');
//        $this->db->from('contact_us');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT u.id,sl.*,md.*,(SELECT firstname FROM user u WHERE md.user_id=u.id) as downloader,(SELECT firstname FROM user u WHERE md.profile_id=u.id) as mediaowner,(SELECT count(md.id) FROM media_download md WHERE md.media_id=sl.song_id) as download FROM media_download md INNER JOIN user u ON md.user_id=u.id INNER JOIN song_library sl ON md.media_id=sl.song_id");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_tournament_details() {
//           $this->db->select('*');
//        $this->db->from('contact_us');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT tr.*,u.firstname FROM tournament_request tr INNER JOIN user u ON tr.user_id=u.id");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getUserSecurityQuestion($uId = null) {

        $this->db->select('sa.id, sa.answer, sq.question');
        $this->db->from('security_answer sa');
        $this->db->join('security_question sq', 'sa.question_id=sq.id');
        $this->db->where('sa.user_id', $uId);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}
