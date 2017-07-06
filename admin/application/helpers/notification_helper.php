<?php

/**
*add_notification function
* @return voi
* @author tushar.patil
**/

if ( ! function_exists('add_notification'))
{
function add_notification($sub_id = 0 , $obj_id = 0,$msg  = '', $type = NULL , $data_id = NULL) {
	$CI = get_instance();
	// Get a reference to the controller object
	// You may need to load the model if it hasn't been pre-loaded
	$CI->load->model('Usermodel');
	$CI->load->model('Notificationmodel');

	// Call a function of the model
	$sub_profile = $CI->Usermodel->get_user_profile($sub_id);
	$obj_profile = $CI->Usermodel->get_user_profile($obj_id);
	
	$add_notification_data = array(
		'subject_id' => $sub_profile[0]->id, 
		'subject_type' => $sub_profile[0]->user_type,
		'object_id' => $obj_profile[0]->id,
		'object_type' => $obj_profile[0]->user_type,
		'message' => $msg,
		'status' => 0,
		'notification_type' => $type,
		'data_id' => $data_id,
		'created_on' => date("Y-m-d H:i:s",time())
		);
	$CI->Notificationmodel->add_notification($add_notification_data);
}
}
/**
* get_notification 
* this function is use to get the notifications of the user
**/
if ( ! function_exists('get_notification'))
{
	function get_notification($id){
		$CI = get_instance();
		$CI->load->model('Notificationmodel');
		// $CI->Notificationmodel->get_notification($id));
		return $CI->Notificationmodel->get_notification($id);
	    }
}



/**
* get_new_notification 
* this function is use to get the new notifications of the user
**/
if ( ! function_exists('get_new_notification'))
{
	function get_new_notification($id){
		$CI = get_instance();
		$CI->load->model('Notificationmodel');
		// $CI->Notificationmodel->get_notification($id));
		return $CI->Notificationmodel->check_new_notification($id);


	}
}