<?php

/**
 * Notificationmodel class
 * @package battleme
 * @subpackage model
 * @author 
 * */
class Postmodel extends CI_Model {

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
        $this->load->model('Song_library_model','library');
        $this->load->model('Usermodel','user');
    }

    /**
    * addpost function
    * @param $data
    * @return void
    * @author 
    **/
    public function addpost($data)
    {
        $this->db->insert('post', $data); 
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function getpost($id)
    {
        $sql  = "SELECT user.id as userid,user.*, post.id as postid,post.created_on as post_timestamp, post . * "
        ." FROM post "
        ."JOIN user ON post.object_id = user.id"
//        ." LEFT JOIN comments ON comments.post_id = post.id"        
        ." WHERE (post.subject_id = ".$id.")"
        ."ORDER BY post.updated_on DESC";
        return $this->db->query($sql)->result_array();
    }
    
//    public function getcomments($postid) {
//        return $this->db->get('comments', array('post_id' => $postid))->result_array();        
//    }
    
    public function getcomments() {
        
        $sql = "SELECT user.id AS userid,comments.created_on as comment_timestamp, comments.id AS comment_id, comments . * , user . * FROM comments JOIN user ON user.id = comments.user_id";
        return $this->db->query($sql)->result_array();       
    }
    
    
    public function addcomment($data)
    {
        $this->db->insert('comments', $data); 
    }
    
    public function addlike($data,$postid,$userid ){
        
        $query = $this->db->get_where('likes', array('user_id' => $userid, 'post_id' => $postid))->result_array();
        if (empty($query)) {
            $this->db->insert('likes', $data);
            $sql = "SELECT COUNT( user_id ) AS likes FROM  likes WHERE post_id = ".$postid." GROUP BY post_id ";
            return $this->db->query($sql)->result_array();
        } else {
            $this->db->delete('likes', array('user_id' => $userid, 'post_id' => $postid));
            return 'dont_send_notification';
        }
        
    }
    
    public function get_postlikes(){
        $sql = "SELECT *, COUNT( user_id ) AS likes FROM  likes GROUP BY post_id ";
        return $this->db->query($sql)->result_array();
    }
    
    public function add_like($insertData = array())
    {
	$status = 0 ;
	if(!empty($insertData))
	{
	    $this->db->where($insertData);
	    $resObj = $this->db->get('likes');
	    if($resObj->num_rows() > 0 )
	    {
		$status = $this->db->delete('likes', $insertData);
	    }
	    else
	    {
		$insertData['created_on'] = date('Y-m-d H:i:s');
		$status =  $this->db->insert('likes', $insertData);
                
                $userArray = get_session_data();
                $mediaArray = $this->library->getMediaDetails($insertData['post_id']);
                $friendId = $mediaArray['user_id'];
                $userId = $userArray['id'];
                $userDtl = $this->user->getSingleUser($userId);
                $msg = ucfirst($userDtl['firstname']).' liked your song <strong>'.$mediaArray['title'].'</strong>';
                add_notification($friendId, $userId, $msg, $type = 'song');
	    }
	}  
	return $status  ;
	
    }
    
    public function get_like_count($inputArr = array())
    {
	if(!empty($inputArr))
	{
	    $this->db->where($inputArr);
	    $res = $this->db->get('likes');
	    return($res->num_rows()) ;
	    
	}
	else
	    return  0 ;
    }
    
	/**
     * getAllPost
     *
     * @return void
     * @author Trushali
     **/
    public function getAllPost($id)
    {
		$sql = "SELECT post.id as postid,post.*,post.created_on as post_timestamp,user.* FROM post LEFT JOIN user ON post.object_id=user.id where object_id IN (select user_id from friend_list where resource_id='".$id."' AND user_approved='1') OR post.object_id='".$id."' ORDER BY post.created_on DESC"; 
        return $this->db->query($sql)->result_array();
    }
    
    
    
     /**
     * getCommonWallPost function
     *
     * @return array
     * @author Samiran
     **/
    public function getCommonWallPost($id)
    {
        $sql  = "SELECT user.id as userid,user.*, post.id as postid,post.created_on as post_timestamp, post . * "
        ." FROM post "
        ."JOIN user ON post.object_id = user.id"
        ." INNER JOIN `friend_list` fl on (post.object_id = fl.user_id or post.object_id = fl.resource_id) "                
        ." WHERE fl.resource_id = ".$id." and fl.active = 1 AND fl.resourse_approved =1 AND fl.user_approved = 1 AND post.data_type='common_wall' "
        ." GROUP BY post.id ORDER BY post.updated_on DESC";
        return  $this->db->query($sql)->result_array();
        // echo $this->db->last_query(); die();
    }
    
    
    /**
     * getRccordCountCommonWall function
     *
     * @return int
     * @author Samiran
     **/
    public function getRccordCountCommonWall($id)
    {
        $sql  = "SELECT post.id as postid"
        ." FROM post "
        ."JOIN user ON post.object_id = user.id"
        ." INNER JOIN `friend_list` fl on (post.object_id = fl.user_id or post.object_id = fl.resource_id) "                
        ." WHERE fl.resource_id = ".$id." and fl.active = 1 AND fl.resourse_approved =1 AND fl.user_approved = 1 AND post.data_type='common_wall' "
        ." GROUP BY post.id ";
       $query = $this->db->query($sql);
       return $rowcount = $query->num_rows();
        // echo $this->db->last_query(); die();
    }
    
    public function getSinglePost($where = []) {
        return $this->db->get_where('post', $where)->row_array();
    }
    public function getSingleComment($where = []) {
        return $this->db->get_where('comments', $where)->row_array();
    }
    
    
}