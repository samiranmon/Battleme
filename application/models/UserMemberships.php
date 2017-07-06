<?php

/**
 * UserMemberships class
 * 
 * @package battle
 * @subpackage model
 * @author 
 * */
class UserMemberships extends CI_Model {

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
     * add
     * saves to user memberships 
     * @author	Nilam Bhapkar
     * @access	public
     * @param array $arrData 
     * @return	array
     */
    function add($arrData) {
        if ($this->db->insert('user_memberships', $arrData)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * get_memberships
     *
     * This is used to get memberships list
     *
     * @author	Nilam Bhapkar
     * @access	public
     * @param   
     * @return array
     */
    function get_memberships() {
        $this->db->from('memberships');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * get_record
     *
     * This is used to get post details
     *
     * @author	Nilam Bhapkar
     * @access	public
     * @param   array-$whereClause
     * @return void
     */
    function get_user_membership($whereClause = '') {
        $query = $this->db->get_where('user_memberships', $whereClause);
        return $query->row_array();
    }

    /**
     * update_user_membership
     * Update  user membership
     * @author	Nilam Bhapkar
     * @access	public
     * @param array $arrData,Integer $id
     * @return	boolean
     */
    function update_user_membership($arrData, $user_id) {
        $this->db->where('user_id', $user_id);
        if ($this->db->update('user_memberships', $arrData)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * get_membership_user
     * returns the membership and its details
     * @author	Chhanda Rane
     * @access	public
     * @param array $arrData
     * @return	array
     */
    function get_membership_user($whereArr = array())
    {
	$result_array = array();
	$this->db->select('memberships.* , memberships.id as membership_id , user_memberships.*');
	$this->db->from('user_memberships');
	$this->db->join('memberships' , 'user_memberships.memberships_id = memberships.id' , 'LEFT');
        $this->db->where('user_memberships.status', 1) ;
	if(!empty($whereArr))
	    $this->db->where($whereArr) ;
	$res = $this->db->get();
	if($res->num_rows() > 0 )
	    $result_array =  $res->result_array();
	  return  $result_array ; 
	
    }
    
     /**
     * get_membership_details
     * Get membership details
     * @access	public
     * @param array $arrData,Integer $id
     * @return	boolean
     */
    function get_membership_details($membership_id) {
        
        $query = $this->db->get_where('memberships', array('id' => $membership_id));
        return $query->row_array();
    }

}