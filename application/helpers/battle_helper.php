<?php

 /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
 if(!function_exists('get_session_data'))
 {
     function get_session_data()
     {
	 $CI = get_instance();
	 $data = $CI->session->userdata('logged_in') ;
	 if(!empty($data))
	     return $data ;
	  
     }
 }

 
 if(!function_exists('get_template_data'))
 {
     function get_template_data()
     {
	 $CI = get_instance();
	 $sessionData = get_session_data();
	 $CI->load->model('Usermodel');
	 $CI->load->model('Friendsmodel');
	 if(!empty($sessionData))
	 {
	      $data['userdata'] = $CI->Usermodel->get_user_profile($sessionData['id']);
	      $data['rightsidebar'] = $CI->Friendsmodel->get_all_frnds($sessionData['id']);
	      $data['right_sidebar'] = $CI->load->view('right_sidebar', $data, TRUE);
	      $data['get_notification'] = get_notification($sessionData['id']);
		$data['new_notifn_count'] = get_new_notification($sessionData['id']);
		$data['navigationbar_home'] = $CI->load->view('navigationbar_home', $data, TRUE);
	      
	 }
	 else
	 {
	     $data['userdata'] = array();
	     $data['rightsidebar'] = array();
	     $data['get_notification'] = array();
	     $data['new_notifn_count'] = array();
	     $data['navigationbar_home'] = '';
	 }
	 
	
        
        
	return $data ;
     }
 }
 
 
 
 if(!function_exists('get_user_songs'))
 {
     function get_user_songs($user_id = NULL)
     {
	 if( !is_null($user_id) )
	 {
	     $CI = get_instance();
	     $CI->load->model('Song_library_model' , 'library');
	     $song_list = $CI->library->get_list(array('sl.user_id' => $user_id)) ;
	     return $song_list;
	     
	 }
     }
 }
 
 
 if(!function_exists('getSiteSettingById'))
 {
    function getSiteSettingById($id=null) {
        $CI = get_instance();
        $CI->db->select('*');
        $CI->db->from('sitesetting');
        $CI->db->where('id', $id );
        $query = $CI->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }
 }
 
 if(!function_exists('getCmsPageById'))
 {
    function getCmsPageById($id=null) {
        $CI = get_instance();
        $CI->db->select('*');
        $CI->db->from('content_management');
        $CI->db->where('id', $id );
        $query = $CI->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }
 }