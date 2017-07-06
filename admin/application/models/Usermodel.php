<?php

/**
 * Usermodel class
 * this class has function that perform insert update delete of admin user details
 * @package battle
 * @subpackage model
 * @author 
 * */
class Usermodel extends CI_Model {

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
    
    /**
     * addPremiumUser function
     * @param $data
     * @return void
     * @author 
     **/
    public function addPremiumUser($data){
        
        $result = $this->check_user_data($data['email']); 
        if(!empty($result)){
            $this->session->set_flashdata('success', 'user already exist');
            redirect('user/registration'); 
        }
        
        //Set variables for paypal form
        $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
        $paypalID = 'inder.bajaj-seller@wwindia.com'; //business email
        $returnURL = base_url().'user/premiumsuccess'; //payment success url
        $cancelURL = base_url().'user/premiumcancel'; //payment cancel url
        $notifyURL = base_url().'user/premiumipn'; //ipn url

        //get particular product data
        $logo = base_url().'assets/images/codexworld-logo.png';

        $this->paypal_lib->add_field('business', $paypalID);
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', 'premium');
        $this->paypal_lib->add_field('item_number',  1);
        $this->paypal_lib->add_field('amount',  40);        
        $this->paypal_lib->add_field('custom', serialize($data));        
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
        
        exit;
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
    public function contentmanagement() {
           $this->db->select('content_management.*');
        $this->db->from('content_management');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function admin_add_contentmanagement($savedata) {
           $this->db->insert('content_management', $savedata);
        $query = $this->db->insert_id();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function get_contentmanagement_details($id) {
    $this->db->select('*');
    $this->db->from('content_management');

    $this->db->where('id', $id );


    $query = $this->db->get();

    if ( $query->num_rows() > 0 )
    {
        $row = $query->row_array();
        return $row;
    }
    }
    public function admin_edit_contentmanagement($id,$data)
    {
                
        $this->db->where('id', $id);
        $this->db->update('content_management', $data);
        return true; 
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    public function email_templatemanagement() {
           $this->db->select('email_template.*');
        $this->db->from('email_template');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function admin_email_templatemanagement($savedata) {
           $this->db->insert('email_template', $savedata);
        $query = $this->db->insert_id();
        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function get_emailtempmanagement_details($id) {
    $this->db->select('*');
    $this->db->from('email_template');
    $this->db->where('id', $id );
    $query = $this->db->get();
    if ( $query->num_rows() > 0 )
    {
        $row = $query->row_array();
        return $row;
    }
    }
    public function admin_edit_emailtempmanagement($id,$data)
    {
                
        $this->db->where('id', $id);
        $this->db->update('email_template', $data);
        return true; 
        
    }
     public function get_paymentdetails() {
//           $this->db->select('payments.*');
//        $this->db->from('payments');
//        $query = $this->db->get();
        $query = $this->db->query("SELECT payments.user_id,payments.txn_id,payments.payment_gross,payments.payment_status,payments.payer_email,user.id,user.firstname,user.lastname,user.coins FROM payments INNER JOIN user ON payments.user_id=user.id ");        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
}