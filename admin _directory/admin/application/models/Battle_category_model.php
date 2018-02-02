<?php

/**
 * Battle_category_model class
 * this class has function that perform insert update delete of admin user details
 * @package battle
 * @subpackage model
 * @author 
 * */
class Battle_category_model extends CI_Model {

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
        $this->db->select('user.*');
        $this->db->from('user');
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
            $this->db->insert('user', $data);   
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
       return $this->db->get_where('user', array('email' => $email))->result();
    }

    /**
     * update_user_data function
     * @param $data
     * @param $id
     * @return void
     * @author 
     **/
    public function update_user_data($data,$id){
        $this->db->update('user', $data, array('id' => $id));
    }

    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     **/
    public function get_user_data($id,$key)
    {
       return $this->db->get_where('user', array('id' => $id, 'secret_key' => $key))->result();
    }
    
   
    public function get_user_by_id($id=NULL)
    {
        if($id == NULL){
             $sessionData = $this->sessionData = get_session_data();
             $id = $sessionData['id'];
        }
        
       return $this->db->get_where('user', array('id' => $id))->result_array();
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
    
    /**
     * add_cup function
     * 
     **/
    public function add_cup($cup,$user_id)
    {
       $user  = $this->db->get_where('user', array('id' => $user_id))->result_array();
       $existing_cups  = $user[0]['cups'];

       if($existing_cups == NULL){
           $existing_cups = ['gold'=> 0, 'platinum'=> 0, 'diamond'=>0];
       }else{
           $existing_cups = unserialize(base64_decode($existing_cups));
       }
       $existing_cups[$cup] = $existing_cups[$cup]+1;
       
       $sql = "UPDATE user SET cups = '".base64_encode(serialize($existing_cups))."'  WHERE id = '".$user_id."'";
       $this->db->query($sql);
    }
    
    
    public function getBattleCategoryList() {
        //$this->db->select('user.*');
        $this->db->from('battle_category');
        //$this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

        public function get_all_user() {
           $this->db->select('user.*');
        $this->db->from('user');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function get_membership() {
           $this->db->select('memberships.*');
        $this->db->from('memberships');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function admin_update_user_profile($id,$data)
    {
                
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        return true; 
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    public function admin_update_membership($id,$data)
    {
                
        $this->db->where('id', $id);
        $this->db->update('memberships', $data);
        return true; 
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
     public function sitesetting() {
           $this->db->select('sitesetting.*');
        $this->db->from('sitesetting');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function admin_update_sitesetting($id,$data)
    {
                
        $this->db->where('id', $id);
        $this->db->update('sitesetting', $data);
        return true; 
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    public function get_user_membership($id)
    {
        $query = $this->db->query("SELECT memberships.membership,user_memberships.memberships_id FROM user_memberships INNER JOIN memberships ON user_memberships.memberships_id=memberships.id where user_memberships.status=1 and user_memberships.user_id='".$id."'");        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    
    
    public function delete($id) {
         $deluser=$this->db->delete('battle_category', array('id' => $id));
         if($deluser){
             return true;
         }else{
             return false;
         }
    }
    
    
     public function getSingleCategory($id) {
        $this->db->select('*');
        $this->db->from('battle_category');
        $this->db->where('id', $id );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }
    
     public function update($id,$data)
    {
                
        $this->db->where('id', $id);
        $this->db->update('battle_category', $data);
        return true; 
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    
     public function addCategory($data)
    {
                
        $this->db->insert('battle_category', $data);
        return $this->db->insert_id();
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    
}