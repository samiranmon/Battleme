<?php

/**
 * Notificationmodel class
 * @package battleme
 * @subpackage model
 * @author 
 * */
class Notificationmodel extends CI_Model {

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
     * add_notification function
     * this function adds the notification data in database
     * @return void
     * @author 
     **/
    public function add_notification($data)
    {
        $this->db->insert('notifications',$data);
    }

    /**
     * get_notification function
     * this function retrieves the notification details of user from database
     * @return notifications array
     * @author 
     **/
    public function get_notification($id = NULL)
    {
//        $sql  = "SELECT user.id as userid,user.*, notifications . * "
//        ." FROM notifications "
//        ."JOIN user ON notifications.object_id = user.id"
//        ." WHERE (notifications.subject_id = ".$id.") AND (notifications.status = 0)";
	if(!is_null($id) && $id > 0 )
	{
	       $sql = "SELECT user.id AS userid, user. * , notifications. * FROM notifications "
            ."JOIN user ON notifications.object_id = user.id "
            ." WHERE (notifications.subject_id =  ".$id.") ORDER BY notifications.created_on DESC LIMIT 0 , 5";
	    return $this->db->query($sql)->result_array();
	}
	
     
    }
    
    /**
     * get_notification function
     * this function retrieves the notification details of user from database
     * @return notifications array
     * @author 
     **/
    public function get_all_notification($id = NULL )
    {
       if(!is_null($id) && $id > 0 )
	{
	$sql  = "SELECT user.id as userid,user.*, notifications . * "
        ." FROM notifications "
        ."LEFT JOIN user ON notifications.object_id = user.id"
        ." WHERE notifications.subject_id = ".$id." order by notifications.created_on desc";
        return $this->db->query($sql)->result_array();
	}
    }
    
    public function mark_as_read($myid,$date) {
        
//        $this->db->where('ID', '557');
//        $this->db->where('OWNER_ID', '22');
//        $this->db->update('MY_TABLE', $My_New_Data_Array);
        $sql  =" UPDATE notifications SET status = 1 "
               ."WHERE (subject_id = ".$myid.") AND (created_on <= '".$date."')";
        $this->db->query($sql);
        $this->db->last_query();
        
    }
     
    public function check_new_notification($id = NULL ){
	if(!is_null($id) && $id > 0 )
	{
        $sql = "SELECT count(subject_id) as new_notification "
            ." FROM notifications "
            ." WHERE (notifications.subject_id = ".$id.") AND (notifications.status = 0)";
        return $this->db->query($sql)->result_array();
	}
    }

    

}
