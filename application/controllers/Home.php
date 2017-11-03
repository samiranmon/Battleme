<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Home extends CI_Controller {

    /**
     * __construct
     * 
     * this function calls the parent constructor.
     * @access public
     * @return void
     * @author 
     * */
     public $sessionData ;
    public function __construct() {
        parent::__construct();
        $data = $this->session->userdata('logged_in');
        if (empty($data)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        }
        $this->load->model('Friendsmodel');
        $this->load->model('Usermodel');
        $this->load->model('Song_library_model' , 'songs');
        $this->load->helper('randomstring_helper');
	$this->load->model('Postmodel');
	$this->sessionData = get_session_data();
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function index() {
        $this->load->helper('form');
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        //echo '<pre>';        print_r($data['userdata']); die;
        
        if($this->input->post('post_message')) {
            $this->form_validation->set_rules('post', 'Post your message', 'trim|required');
            if(isset($_POST['see_post'])) {
                $this->form_validation->set_rules('see_post', 'Who see your post', 'trim|required');
            }
            if ($this->form_validation->run() == FALSE) { 
            } else {
                $media_file = '';
                $media_error = 0;
                $media_type = 0;
                
                if(!empty($_FILES['media_post']['name'])) {
                    $config['upload_path'] = $this->config->item('post_media_path');
                    
                    $config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|ogg|webm|mp3';
                    if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])){
                        $config['allowed_types'] = 'flv|FLV|mkv|MKV|jpeg|gif|jpg|png|mp4|ogg|ogv|avi|mp3';
                    }
                    $config['max_size']	= '1024480';
                    $config['max_width']  = 0;
                    $config['max_height']  = 0;
                    $config['remove_spaces']=TRUE;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('media_post'))
                    {
                        $media_error = 1;
                        $data['post_media_error'] = $this->upload->display_errors();
                        //echo '<pre>'; print_r($this->upload->data());
                        $this->session->set_flashdata('class' , 'alert-danger');
                        $this->session->set_flashdata('post_message' , $data['post_media_error']);
                        redirect('home');
                    }
                    else
                    { 
                        $mediaArray = $this->upload->data();
                        $media_file = $mediaArray['file_name'];
                        $ext = pathinfo($media_file, PATHINFO_EXTENSION);
                        
                         $media_type = 3; // for voice
                         
                        if($mediaArray['is_image'] != 1 && in_array($ext, ['flv','FLV','mkv','MKV','mp4','ogg','ogv','avi'])) {
                            $media_type = 2; // for video
                            if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])){
                                $conv_file_name = 'con_'.time().'.mp4';
                                $cont_file_path = $this->config->item('post_media_path').$conv_file_name;
                                shell_exec("ffmpeg -i ".$this->config->item('post_media_path').$media_file." -f mp4 -s 500x400 -strict -2  ".$cont_file_path." 2>&1");
                                // for deleting the source file
                                if(file_exists($this->config->item('post_media_path').$media_file)) {
                                    unlink($this->config->item('post_media_path').$media_file);
                                }
                                $media_file = $conv_file_name;
                            }
                        }
                        
                        if(isset($mediaArray['is_image']) && $mediaArray['is_image'] == 1) {
                            $media_type = 1;
                            // for resize the media image
                            $this->resize_image($media_file);
                            $this->medium_resize_image($media_file);
                            
                            if(file_exists($this->config->item('post_media_path').$media_file)) {
                                unlink($this->config->item('post_media_path').$media_file);
                            }
                        }
                        
                    }
                }
                // Insert post data in to post table & set session messeges 
                if($media_error == 0) {
                    $post_content = $this->input->post('post');
                    $post_content = str_replace('https://', '', $post_content); 
                    $search     = ['/www.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi', '/m.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi', '/www.m.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi'];
                    $replace    = "<iframe width='455' height='315' src='https://youtube.com/embed/$1' frameborder='0' allowfullscreen></iframe>";
                    $post_content = preg_replace($search,$replace,$post_content); 
                    
                    $post_data = array(
                        'content' => $post_content,
                        'subject_id' => $this->session->userdata('logged_in')['id'],
                        'object_id' => $this->session->userdata('logged_in')['id'],
                        'media' => $media_file,
                        'media_type' => $media_type,
                        'see_post'   => $this->input->post('see_post'),
                        'data_type'  => 'common_wall',
                        'created_on' => date("Y-m-d H:i:s", time()),
                        'updated_on' => date("Y-m-d H:i:s", time())
                    );
                    $this->Postmodel->addpost($post_data);
                    //$msg = "posted on your wall";
                    //add_notification($userid, $myid, $msg);
                    //$this->session->set_flashdata('class' , 'alert-danger');
                    $this->session->set_flashdata('class' , 'alert-success');
		    $this->session->set_flashdata('post_message' , 'Your message has been posted successfully');
                    redirect('home');
                }
                
            }
        }
        
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        //$data['right_sidebar'] = $this->load->view('right_sidebar', $data, TRUE);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        //$data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);
	$data['top_songs'] = $this->songs->get_top_songs();
	$data['top_user'] = $this->Usermodel->get_top_user();
        $data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
        //echo '<pre>'; print_r($data['comments']); die;
        
        // for wall section
        /*$total_row = $this->Postmodel->getRccordCountCommonWall($this->session->userdata('logged_in')['id']); 
        $this->load->library('pagination');
        $config['base_url'] = base_url('home/index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = 10;
        $config['cur_tag_open'] = '&nbsp;<span class="custom_link"><a class="current">';
        $config['cur_tag_close'] = '</a></span>';
        $config['num_tag_open'] = '<span class="custom_link">';
        $config['num_tag_close'] = '</span>';
        $config['next_tag_open'] = '<span class="custom_link">';
        $config['next_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span class="custom_link">';
        $config['last_tag_close'] = '</span>';
        $config['first_tag_open'] = '<span class="custom_link">';
        $config['first_tag_close'] = '</span>';
        $config['prev_tag_open'] = '<span class="custom_link">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="current_link">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = ($this->uri->segment(3));
        } else{ $page = 1; } 
        $data['post_data'] = $this->Postmodel->getCommonWallPost($this->session->userdata('logged_in')['id'], $page, $config['per_page']);
         * 
         */
        $data['post_data'] = $this->Postmodel->getCommonWallPost($this->session->userdata('logged_in')['id']);
        //echo '<pre>'; print_r($data['post_data']); die();
        // end of wall section
	
        $this->load->view('home', $data);
    }
    
    /* public function index() {
        
        $ffmpeg = trim(shell_exec('ffmpeg -version'));
        if (empty($ffmpeg)) {
            echo 'ffmpeg not available';
        } 
        //shell_exec($ffmpeg . ' -i ...');
        
        $this->load->helper('form');
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        //echo '<pre>';        print_r($data['userdata']); die;
        
        if($this->input->post('post_message')) {
            $this->form_validation->set_rules('post', 'Post your message', 'trim|required');
            if(isset($_POST['see_post'])) {
                $this->form_validation->set_rules('see_post', 'Who see your post', 'trim|required');
            }
            if ($this->form_validation->run() == FALSE) { 
            } else {
                $media_file = '';
                $media_error = 0;
                $media_type = 0;
                
                if(!empty($_FILES['media_post']['name'])) {
                    $config['upload_path'] = $this->config->item('post_media_path');
                    
                    $config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|ogg|webm|mp3';
                    if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])){
                        $config['allowed_types'] = 'flv|FLV|mkv|MKV|jpeg|gif|jpg|png|mp4|ogg|ogv|avi|mp3';
                    }
                    
                    $config['max_size']	= '300480';
                    $config['max_width']  = '1024';
                    $config['max_height']  = '1250';
                    $config['remove_spaces']=TRUE;
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('media_post'))
                    {
                        $media_error = 1;
                        $data['post_media_error'] = $this->upload->display_errors();
                        //echo '<pre>'; print_r($this->upload->data());
                    }
                    else
                    { 
                        $mediaArray = $this->upload->data();
                        $media_file = $mediaArray['file_name'];
                        $ext = pathinfo($media_file, PATHINFO_EXTENSION);
                        
                         $media_type = 3; // for voice
                         
                        if($mediaArray['is_image'] != 1 && in_array($ext, ['flv','FLV','mkv','MKV','mp4','ogg','ogv','avi'])) {
                            $media_type = 2; // for video
                            if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])){
                                $conv_file_name = 'con_'.time().'.mp4';
                                $cont_file_path = $this->config->item('post_media_path').$conv_file_name;
                                shell_exec("ffmpeg -i ".$this->config->item('post_media_path').$media_file." -f mp4 -s 500x400 -strict -2  ".$cont_file_path." 2>&1");
                                // for deleting the source file
                                if(file_exists($this->config->item('post_media_path').$media_file)) {
                                    unlink($this->config->item('post_media_path').$media_file);
                                }
                                $media_file = $conv_file_name;
                            }
                        }
                        
                        if(isset($mediaArray['is_image']) && $mediaArray['is_image'] == 1) {
                            $media_type = 1;
                            // for resize the media image
                            $this->resize_image($media_file);
                        }
                        
                    }
                }
                // Insert post data in to post table & set session messeges 
                if($media_error == 0) {
                    $post_content = $this->input->post('post');
                    $post_content = str_replace('https://', '', $post_content); 
                    $search     = ['/www.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi', '/m.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi', '/www.m.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi'];
                    $replace    = "<iframe width='455' height='315' src='https://youtube.com/embed/$1' frameborder='0' allowfullscreen></iframe>";
                    $post_content = preg_replace($search,$replace,$post_content); 
                    
                    $post_data = array(
                        'content' => $post_content,
                        'subject_id' => $this->session->userdata('logged_in')['id'],
                        'object_id' => $this->session->userdata('logged_in')['id'],
                        'media' => $media_file,
                        'media_type' => $media_type,
                        'see_post'   => $this->input->post('see_post'),
                        'data_type'  => 'common_wall',
                        'created_on' => date("Y-m-d H:i:s", time()),
                        'updated_on' => date("Y-m-d H:i:s", time())
                    );
                    $this->Postmodel->addpost($post_data);
                    //$msg = "posted on your wall";
                    //add_notification($userid, $myid, $msg);
                    //$this->session->set_flashdata('class' , 'alert-danger');
                    $this->session->set_flashdata('class' , 'alert-success');
		    $this->session->set_flashdata('post_message' , 'Your message has been posted successfully');
                    redirect('home');
                }
                
            }
        }
        
        
        
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['right_sidebar'] = $this->load->view('right_sidebar', $data, TRUE);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);
	$data['top_songs'] = $this->songs->get_top_songs();
	$data['top_user'] = $this->Usermodel->get_top_user();
        
        // for wall section
        $data['post_data'] = $this->Postmodel->getCommonWallPost($this->session->userdata('logged_in')['id']);
        $data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
        //echo '<pre>'; print_r($data['comments']); die;
	
        $this->load->view('home', $data);
    } */
    
    

    /**
     * search function
     * this function searches for user and passes the data to view
     * @return void
     * @author 
     * */
    public function search() {
        $this->load->helper('form');
        $data['search_html'] = '';
        $this->load->model('Searchmodel');
		$user_id = $this->sessionData['id'] ;
		$data['userId'] = $user_id;
        $data['search_result'] = $this->Searchmodel->search_home($this->input->post('home_search'));
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['top_songs'] = $this->songs->get_top_songs();
	$data['top_user'] = $this->Usermodel->get_top_user();
        $this->load->view('search_result', $data);
    }
    
    /**
     * 
     * @return type
     */
    public function notify(){
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        //echo '<pre>';            print_r($data['get_notification']); die;
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        
        $noty_count_html = '';
        if(isset($data['new_notifn_count'][0]['new_notification']) && $data['new_notifn_count'][0]['new_notification'] != 0) { 
            $noty_count_html = '<div class="infotxt badge">'.$data['new_notifn_count'][0]['new_notification'].'</div>';
        }
        
        $notification_html = [$this->load->view('ajax_notification', $data, TRUE), $noty_count_html];
        echo json_encode($notification_html);
    }
    
    /**
     * 
     * @param array $data
     * @return type
     */
    public function search_friend($data){ 
        $userid = $this->session->userdata('logged_in')['id'];
        $friend['friend_data'] = $this->Friendsmodel->search_friend($userid,$data);
        $friend_search = $this->load->view('home_search_rightsidebar',$friend,TRUE);
        echo $friend_search;
        return $friend_search;
    }
	
	/**
	 * 
	 */
    public function post(){
    	$data['send_id'] = $user_id = $this->session->userdata('logged_in')['id'];
        $data['post_data'] = $this->Postmodel->getAllPost($user_id);
		$data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
		$data['userdata'] = $this->Usermodel->get_user_profile($user_id);
		$data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
		$data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);
		 $data['user_profile'] = $this->Usermodel->get_user_profile($user_id);
    	$this->load->view('display_post', $data);
    }
    
    
    public function addcomment($postid, $userid) {
        $myid = $this->session->userdata('logged_in')['id'];
        $validate_rule = array(
            array(
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($validate_rule);
        if ($this->form_validation->run() == False) {
            redirect('home');
        } else {
            $comment = $this->input->post('comment');
            $data = array(
                'post_id' => $postid,
                'user_id' => $myid,
                'comment' => $comment,
                'created_on' => date("Y-m-d H:i:s", time())
            );
            $this->Postmodel->addcomment($data);
            // for update post table\
            $this->db->where('id', $postid);
            $this->db->update('post', ["updated_on" => date("Y-m-d H:i:s", time())]); 
            
            $msg = "commented on your post";
            add_notification($userid, $myid, $msg, 'post_comment', $postid);
            // for session messages 
             $this->session->set_flashdata('class' , 'alert-success');
	     $this->session->set_flashdata('post_message' , 'You comment posted successfully');
            redirect('home');
             
        }
    }
    
    // for share a post
    public function sharepost($post_id=NULL, $friend_user_id= NULL) {
        $myid = $this->session->userdata('logged_in')['id'];
        
        $post_data = $this->Postmodel->getSinglePost(['id'=>$post_id]);
        
        $modify_post = ['content'=>$post_data['content'],'subject_id'=>$myid, 'object_id'=>$myid, 'shared_user_id'=>$friend_user_id,
                'data_id'=>$post_data['data_id'], 'media'=>$post_data['media'], 'media_type'=>$post_data['media_type'], 'see_post'=>$post_data['see_post'],
            'data_type'=>'common_wall', 'status'=>$post_data['status'], 'created_on'=>date('Y-m-d H:i:s'), 'updated_on'=>date('Y-m-d H:i:s')];
        
        $this->Postmodel->addpost($modify_post);
        
        $this->session->set_flashdata('class' , 'alert-success');
        $this->session->set_flashdata('post_message' , 'You has been shared successfully');
        redirect('home');
    }

        /**
     * resize_image function
     *  this function resizes the image to thumbnail
     * @param $image_name
     * @return void
     * @author 
     * */
    
    public function resize_image($image_name) { 
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->config->item('post_media_path'). $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'thumb_' . $image_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 531;
        $config['height'] = 248;
            
        $this->image_lib->clear();
        $this->image_rotation($config['source_image']);
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    
    public function medium_resize_image($image_name) {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->config->item('post_media_path'). $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'medium_' . $image_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 700;
        $config['height'] = 500;    

        $this->image_lib->clear();
        $this->image_rotation($config['source_image']);
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    
    function image_rotation($params = NULL)
    {        
        //if (!is_array($params) || empty($params)) return FALSE;

        $file_path = $params;
        //echo $params.'hi';
        
        $exif = @file_get_contents($file_path);
        
        //echo 'hi to '.$file_path.'<pre>';        print_r($exif); die;

        if (empty($exif['Orientation'])) return FALSE;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $file_path;

        $orientations = array();

        switch ($exif['Orientation']) {
            case 1: // no need to perform any changes
                break;

            case 2: // horizontal flip
                $orientations[] = 'hor';
                break;

            case 3: // 180 rotate left
                $orientations[] = '180';
                break;

            case 4: // vertical flip
                $orientations[] = 'ver';
                break;

            case 5: // vertical flip + 90 rotate right
                $orientations[] = 'ver';
                $orientations[] = '270';
                break;

            case 6: // 90 rotate right
                $orientations[] = '270';
                break;

            case 7: // horizontal flip + 90 rotate right
                $orientations[] = 'hor';
                $orientations[] = '270';
                break;

            case 8: // 90 rotate left
                $orientations[] = '90';
                break;

            default:
                break;
        }

        foreach ($orientations as $orientation) {
            $config['rotation_angle'] = $orientation;
            $this->image_lib->initialize($config);
            $this->image_lib->rotate();
        }
    }
    
    
    
    public function delete_post() {
        $postId = $this->uri->segment(3);
        if(isset($postId)) {
            $rsult_ack = $this->Postmodel->getSinglePost(['id' => $postId, 'subject_id' => $this->session->userdata('logged_in')['id']]);
            //echo '<pre>';            print_r($rsult_ack); die;
            if(!empty($rsult_ack)) {
                
                $this->db->delete('post', ['id'=>$rsult_ack['id']]); 
                $this->db->delete('comments', ['post_id'=>$rsult_ack['id']]); 
                $this->db->delete('likes', ['post_id'=>$rsult_ack['id']]); 
                // deleting the posted file
                if($rsult_ack['media_type'] > 0) {
                    if(file_exists($this->config->item('post_media_path').$rsult_ack['media'])) {
                        unlink($this->config->item('post_media_path').$rsult_ack['media']);
                    }
                    if(file_exists($this->config->item('post_media_path').'thumb_'.$rsult_ack['media'])) {
                        unlink($this->config->item('post_media_path').'thumb_'.$rsult_ack['media']);
                    }
                    if(file_exists($this->config->item('post_media_path').'medium_'.$rsult_ack['media'])) {
                        unlink($this->config->item('post_media_path').'medium_'.$rsult_ack['media']);
                    }
                }
                $this->session->set_flashdata('class' , 'alert-success');
                $this->session->set_flashdata('post_message' , 'Your post has been deleted successfully');
                redirect('home');
            }

            $this->session->set_flashdata('class' , 'alert-danger');
            $this->session->set_flashdata('post_message' , 'Please try again');
            redirect('home');
        }
        
        $this->session->set_flashdata('class' , 'alert-danger');
        $this->session->set_flashdata('post_message' , 'Please try again');
        redirect('home');
    }
    
    public function delete_comment() {
        $commentId = $this->input->post('comment_id');
        if(isset($commentId)) {
            $rsult_ack = $this->Postmodel->getSingleComment(['id' => $commentId, 'user_id' => $this->session->userdata('logged_in')['id']]);
            //echo '<pre>';            print_r($rsult_ack); die;
            if(!empty($rsult_ack)) {
                $this->db->delete('comments', ['id'=>$rsult_ack['id']]); 
                echo 1;
                die();
            }

            $this->session->set_flashdata('class' , 'alert-danger');
            $this->session->set_flashdata('post_message' , 'Please try again');
            redirect('home');
        }
        
        $this->session->set_flashdata('class' , 'alert-danger');
        $this->session->set_flashdata('post_message' , 'Please try again');
        redirect('home');
    }


}