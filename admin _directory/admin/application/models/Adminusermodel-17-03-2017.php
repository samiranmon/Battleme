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
    **/
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
     **/
    public function adduser($data){
        $result = $this->db->get_where('user', array('fb_id' => $data['fb_id']))->result_array();

        if(empty($result)){
            $this->db->insert('user', $data);
            return $this->db->get_where('user', array('id' => $this->db->insert_id()))->result_array();
        }else{
            return $result;
        }

    }
    
    /**
     * checkuser function
     * @param $data
     * @return void
     * @author 
     **/
    public function checkuser($data){
        $result = $this->check_user_data($data['email']); 
        if(empty($result)){
            $this->db->insert('admin_user', $data);   
        }else{
            return "user already exist";
        }

    }
    
    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     **/
    public function check_user_data($email)
    {
       return $this->db->get_where('admin_user', array('email' => $email))->result();
    }

    /**
     * update_user_data function
     * @param $data
     * @param $id
     * @return void
     * @author 
     **/
    public function update_user_data($data,$id){
        $this->db->update('admin_user', $data, array('id' => $id));
    }

    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     **/
    public function get_user_data($id,$key)
    {
       return $this->db->get_where('admin_user', array('id' => $id, 'secret_key' => $key))->result();
    }
    
   
    public function get_user_by_id($id=NULL)
    {
        if($id == NULL){
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
     **/
    public function get_user_profile($id = NULL)
    {
	if(!is_null($id))	
	{
	    $sql= "SELECT *,(SELECT COUNT(user_id)  FROM user_follow WHERE user_id = ".$id
                        .") AS following,(SELECT COUNT(following_frnd_id)  FROM user_follow WHERE following_frnd_id = "
                        .$id.") AS follower FROM user where id = ".$id;
		return $this->db->query($sql)->result();
	}
	
        // return $this->db->get_where('user', array('id' => $id))->result();
    }

    /**
     * update_user_profile function
     *
     * @return void
     * @author 
     **/
    public function update_user_profile($id,$data)
    {
        $user_id = $this->session->userdata('logged_in')['id'];
        
        if(!isset($user_id) || $user_id=='') {
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
         $deluser=$this->db->delete('user', array('id' => $id));
         if($deluser){
             return true;
         }else{
             return false;
         }
    }
    
    
    public function get_top_user()
    {
	$sql = "select * from user WHERE user_type = 'artist' ORDER BY win_cnt desc limit 100 " ;
	$res = $this->db->query($sql);
	if($res->num_rows() > 0 )
	{
	    return $res->result_array();
	}
	return array();
    }
    public function updateadminprofile($data,$id) {
        
        $this->db->where('id', $id);
        $this->db->update('admin_user', $data);
         return true;
    }
    public function get_admindetails($id) {
    $this->db->select('*');
    $this->db->from('admin_user');

    $this->db->where('id', $id );


    $query = $this->db->get();

    if ( $query->num_rows() > 0 )
    {
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
    
    $sql = "SELECT  count(*) as count, TIMESTAMPDIFF(minute, start_date,CURDATE()) as tim from battle_request where status=1 having tim<=10080" ;
    $res = $this->db->query($sql);
    $activebattle=$res->result_array('count');
    
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
    $get_count=array(
        'user'=>$row['count'],
        'battle'=>$row1['count'],
        'tournament'=>$row2['count'],
        'allmember_count'=>$row3,
        'activebattle'=>$activebattle
    );
    //print_r($get_count);die;
    return $get_count;
    }
    
     public function get_user_details($id) {
    $this->db->select('*');
    $this->db->from('user');

    $this->db->where('id', $id );


    $query = $this->db->get();

    if ( $query->num_rows() > 0 )
    {
        $row = $query->row_array();
        return $row;
    }
    }

}