<?php

/**
 * Description of Battle
 * 
 * @author Chhanda
 */
class Battle extends CI_Controller {

    //put your code here
    public $sessionData;

    public function __construct() {
        parent::__construct();
        $this->load->model('Wallet_model', 'wallet');
        $this->load->model('battle_model', 'battles');
        $this->load->model('tournament_model', 'tournaments');
        $this->load->model('Friendsmodel', 'friends');
        $this->load->model('Usermodel', 'user');
        $this->load->model('Notificationmodel', 'notification');
        $this->load->model('Postmodel', 'post');
        $this->load->model('VoteModel', 'vote');
        $this->load->model('Song_library_model', 'library');
        $this->load->library('Common_lib');
        $this->sessionData = get_session_data();
    }

    /**
     * index function
     * this function is used to list battle request/battles
     * @return void
     * @param 
     * @author Chhanda
     * */
    /* public function index()
      {
      $user_id = $this->sessionData['id'] ;
      $battleData = $this->battles->get_battle_list($user_id) ;
      $arrData['userId'] = $user_id ;
      $arrData['battleList'] = $battleData ;
      $arrData['middle'] = 'battle_list';

      //echo '<pre>'; print_r($arrData['tournament_status']); die;

      $this->load->view('templates/template', $arrData);

      } */

    public function index() {

        $user_id = $this->sessionData['id'];
        $battleData = $this->battles->get_mybattle_list_categorise($user_id);
        
        
        
        $battleCat = $this->user->getBattleCategoryList();
        $battleCatArray = [];
        foreach ($battleCat as $value) {
            $battleCatArray[$value['id']] = $value['name'];
        }
        $battle_cat = $battleCatArray;
        
        //$battle_cat = [1 =>'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6 => 'Raggeton', 7=> 'Latino hip hop', 8 => 'Latino songs originals', 9 => 'Latino songs covers'];
        $battleDataArray = [];
        if(isset($battleData) && !empty($battleData)) {
            foreach ($battleData as $batlVal){
                if(array_key_exists($batlVal['battle_category'], $battle_cat)){
                    $battleDataArray[$batlVal['battle_category']][] = $batlVal;
                }
            }
        }
        //sort($battleDataArray);
        //echo '<pre>';        print_r($battleDataArray); die;
        $arrData['battleCat'] = $battleCat;
        $arrData['userId'] = $user_id;
        $arrData['battleList'] = $battleDataArray;
        //$arrData['battleList'] = $battleData;
        $arrData['battleType'] = '';
        $arrData['battleCategoryName'] = 'My Battles';
        $arrData['middle'] = 'battle_categories_list';
        $arrData['div_col_unit'] = 'col-md-12';
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
	$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }
    
    /**
     * index function
     * this function is used to list of all battle using there battle type and category
     * @return void
     * @param 
     * @author Samiran
     * */
    public function all($battle_type = '', $battle_cat = '') {
        
        $battleCat = $this->user->getBattleCategoryList();
        $battleCatArray = [];
        foreach ($battleCat as $value) {
            $battleCatArray[$value['id']] = $value['name'];
        }
        $battle_category = $battleCatArray;
        //$battle_category = [1 =>'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6 => 'Raggeton', 7=> 'Latino hip hop', 8 => 'Latino songs originals', 9 => 'Latino songs covers'];
        if (!($battle_type == 'regular-battle' || $battle_type == 'cash-battle')) {
            redirect('home');
        }

        /*if ($battle_cat == null) {
            redirect('home');
        }*/
        //if cash-battle or regular-battle

        $user_id = $this->sessionData['id'];
        $battleData = $this->battles->get_battle_list_categorise($battle_type, $battle_cat);
        
         $battleDataArray = [];
        if(isset($battleData) && !empty($battleData)) {
            foreach ($battleData as $batlVal){
                if(array_key_exists($batlVal['battle_category'], $battle_category)){
                    $battleDataArray[$batlVal['battle_category']][] = $batlVal;
                }
            }
        }
        $arrData['battleList'] = $battleDataArray;
        $arrData['battleCat'] = $battleCat;
        $arrData['userId'] = $user_id;
        $arrData['battleType'] = $battle_type;
        //$arrData['battleCategoryName'] = $battle_category[base64_decode($battle_cat)];
        $arrData['middle'] = 'battle_categories_list';
        $arrData['div_col_unit'] = 'col-md-12';
        
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
	$arrData['top_user'] = $this->user->get_top_user();
        
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);

        //echo '<pre>'; print_r($arrData); die;

        $this->load->view('templates/template', $arrData);
    }
    
    
    public function test_battle_list() {

        $user_id = $this->sessionData['id'];
        $battleData = $this->battles->get_mybattle_list_categorise($user_id);
        $arrData['userId'] = $user_id;
        $arrData['battleList'] = $battleData;
        $arrData['battleType'] = '';
        $arrData['battleCategoryName'] = 'My Battles';
        $arrData['middle'] = 'test_battle_list';
        $arrData['div_col_unit'] = 'col-md-12';
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
	$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }
    
    public function freestyle_library() {
        $user_id = $this->sessionData['id'];
        $battleData = $this->battles->get_myfreestyle_battle($user_id);
        $arrData['userId'] = $user_id;
        $arrData['battleList'] = $battleData;
        $arrData['battleType'] = '';
        $arrData['battleCategoryName'] = 'My Battles';
        $arrData['middle'] = 'freestyle_list';
        $arrData['div_col_unit'] = 'col-md-12';
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
	$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }

    /**
     * index function
     * this function is used to list all battle request/battles
     * @return void
     * @param 
     * @author Chhanda
     * */
    /* public function all()
      {
      $user_id = $this->sessionData['id'] ;
      $battleData = $this->battles->get_battle_list() ;
      $arrData['userId'] = $user_id ;
      $arrData['battleList'] = $battleData ;
      $arrData['middle'] = 'battle_list';
      echo '<pre>'; print_r($arrData); die;
      $this->load->view('templates/template', $arrData);

      } */

    /**
     * create function
     * this function is used create battle/challenge request
     * @return void
     * @param 
     * @author Chhanda
     * */
    public function create($friend_id = NULL) {
        
        //get friends list of logged in user
        $arrData = array();
        $selectedId = 0;
        $friendOptions = '';
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }

        $friend_list = $this->friends->get_challenge_frnds($sessionData['id']);
        //echo '<pre>';        print_r($friend_list);
        if (empty($friend_list)) {
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('message', 'Request can not be sent as friend user is not present');
            redirect('battle');
        }

        $friendOptions[''] = '--Select Friend Name--';
        foreach ($friend_list as $key => $value) {
            if ($value['id'] == $friend_id)
                $selectedId = $value['id'];
            $friendOptions[$value['id']] = ($value['firstname'] . " " . $value['lastname']);
        }
        
        $battleCat = $this->user->getBattleCategoryList();
            $battleCatArray = [];
            foreach ($battleCat as $value) {
                $battleCatArray[$value['id']] = $value['name'];
            }
            $categoryArray = $battleCatArray;

        $this->form_validation->set_rules('friend_user_id', 'Friend Name', 'trim|required');
        $this->form_validation->set_rules('battle_name', 'Battle Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('battle_category', 'Battle Category', 'trim|required|numeric');
        
        if ($this->input->post('battle_category') != 5) {
            $this->form_validation->set_rules('media_type', 'Media Type', 'trim|required');
            
            if($this->input->post('media_type') == 1) {
                $this->form_validation->set_rules('media_title', 'Media Title', 'trim|required');
                //echo '<pre>';
                    //print_r($_FILES['media']);die;
                if (empty($_FILES['media']['name'])) {
                    
                    $this->form_validation->set_rules('media', 'Media', 'required');
                }
            } else {
                
                $this->form_validation->set_rules('media_id', 'choose from library', 'trim|required');
                 if ($this->input->post('battle_category') == 4) {
                     // for custom query
                     //$this->form_validation->set_rules('media_id', 'choose from library', 'callback_check_video_file');
                     
                 }  
            }
        }
        
        if ($this->input->post('battle_category') == 5) {
            //$this->form_validation->set_rules('place', 'Place', 'trim|required');
            $this->form_validation->set_rules('freesty_library_id', 'Library id', 'trim|required');
            $this->form_validation->set_rules('date_time', 'Date & Time', 'trim|required');
        }
        
        if ($this->input->post('cash') == 2) {
            $this->form_validation->set_rules('entry', 'Entry', 'callback_greater_than_one');
        }

        if ($this->form_validation->run() == TRUE) {
            
            //$categoryArray =  [ 1 => 'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6=>'Raggeton', 7=>'Latino hip hop', 8=>'Latino songs originals', 9=>'Latino songs covers'];

            if ($this->input->post('battle_category') != 5) {
                
                if($this->input->post('media_type') == 1) {
                    /* for start of media uploade */
                    $mediaConfig = array(
                        'upload_path' => $this->config->item('library_media_path'),
                        //'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm|mp4|mp4|ogg|webm|avi|flv',
                        'allowed_types' => '*',
                        'encrypt_name'  => TRUE,
                        'max_size' => '1024159'
                    );

                    $uploadAck = $this->common_lib->upload_custom_media('media', $mediaConfig);
                    if (isset($uploadAck['file_name']) && isset($uploadAck['file_type'])) {
                        
                        $source = $this->config->item('library_media_path').$uploadAck['file_name'];
                        $file_type = explode('/', $uploadAck['file_type']);
                        if($file_type[0] == 'video') {
                            $conv_file_name = 'con_'.time().'.mp4';
                            $cont_file_path = $this->config->item('library_media_path').$conv_file_name;
                            shell_exec("/usr/local/bin/ffmpeg -i ".$source." -y -vcodec libx264 -crf 18 -pix_fmt yuv420p -qcomp 0.8 -preset medium -acodec aac -strict -2 -b:a 400k -x264-params ref=4 -profile:v baseline -level 3.1 -movflags +faststart ".$cont_file_path);
                            //shell_exec("/usr/local/bin/ffmpeg -i ".$source." -acodec libvorbis -vcodec libtheora -f ogg ".$cont_file_path." 2>&1");
                            //shell_exec("/usr/local/bin/ffmpeg -y -i ".$source." -ar 22050 -ab 512 -b 800k -f mp4 -s 514*362 -strict -2 -c:a aac ".$cont_file_path." 2>&1");
                            //shell_exec("/usr/local/bin/ffmpeg -i ".$source." -f mp4 -s 800x480 -strict -2 ".$cont_file_path." 2>&1");
                            if(file_exists($source)) { unlink($source); } 
                        } else if($file_type[0] == 'audio') {
                            $conv_file_name = 'con_'.time().'.mp3';
                            $cont_file_path = $this->config->item('library_media_path').$conv_file_name;
                            shell_exec("/usr/local/bin/ffmpeg -i ".$source." -f mp3 ".$cont_file_path." 2>&1");
                            
                            if(file_exists($source)) { unlink($source); } 
                        } else {
                            if(file_exists($source)) { unlink($source); } 
                            $this->session->set_flashdata('class', 'alert-danger');
                            $this->session->set_flashdata('message', 'File type is not allowed!');
                            redirect('battle/create/');
                        } 
                        
                        if(!file_exists($cont_file_path)) {
                            $this->session->set_flashdata('class', 'alert-danger');
                            $this->session->set_flashdata('message', 'File format is not allowed!');
                            redirect('battle/create/');
                        }
                        
                        //save file to users library first
                        $library_data = array(
                            'user_id' => $sessionData['id'],
                            'title' => $this->input->post('media_title'),
                            'media' => $conv_file_name,
                            'created_date' => date('Y-m-d H:i:s')
                        );
                        $library_id = $this->library->insert($library_data);
                    } else {
                        $this->session->set_flashdata('class', 'alert-danger');
                        $this->session->set_flashdata('message', $uploadAck['error']);
                        redirect('battle/create/');
                    }
                    /* end of media uploade */
                    
                } else {
                    $library_id =  $this->input->post('media_id');
                }
            }

            foreach ($this->input->post() as $key => $val)
                $$key = $val;

            $inputData['user_id'] = $sessionData['id'];
            $inputData['friend_user_id'] = $friend_user_id;
            $inputData['battle_name'] = $battle_name;
            $inputData['battle_category'] = $battle_category;
            $inputData['description'] = $description;
            $inputData['entry'] = (isset($entry) && $entry != '' && $sessionData['membership_id'] == 2) ? $entry : 0;
            $inputData['freesty_library_id'] = isset($freesty_library_id) ? $freesty_library_id : '';
            //$inputData['place'] = $place;
            $inputData['date_time'] = date('Y-m-d H:i:s', strtotime($date_time));
            //echo '<pre>'; print_r($inputData); die();

            $request_id = $this->battles->add_request($inputData);
            if ($request_id > 0) {
                
                /* Start of the inserting media section */
                if (isset($library_id) && $library_id > 0) {
                    //save media in battle 
                     if($this->input->post('media_type') == 1) { 
                         $copyStatus = copy($this->config->item('library_media_path') . $conv_file_name, $this->config->item('battle_media_path') . $conv_file_name);
                     }
                    
                    $form_data = array(
                        'battle_id' => $request_id,
                        'artist_id' => $sessionData['id'],
                        'fk_song_id' => $library_id,
                        'created_date' => date('Y-m-d H:i:s')
                    );
                    $this->battles->add_battle_media($form_data);
                }
                /* end of insert media */

                /*$postContent = 'User has sent you battle challenge';
                $data = array(
                    'content' => $postContent,
                    'subject_id' => $friend_user_id,
                    'object_id' => $friend_user_id,
                    'data_id' => $request_id,
                    'created_on' => date("Y-m-d H:i:s", time())
                );
                $this->post->addpost($data);*/
//		
                
                if ($this->input->post('battle_category') == 5) {
                    //send notification to friend user
                    $notification_msg = 'Has challenged you to a Freestyle Battle';
                    add_notification($friend_user_id, $sessionData['id'], $notification_msg, 'freestyle_request', $request_id);
                
                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('message', 'Freestyle Battle Challenge has been sent');
                    redirect('battle/freestyle_library');
                } else {
                    //send notification to friend user
                    if(isset($entry) && $entry != '' && $entry > 0) {
                         $notification_msg = 'Has challenged you to a '.$categoryArray[$battle_category].' Cash Battle of '.$entry.' Battle Bucks';
                    } else {
                        $notification_msg = 'Has challenged you to a '.$categoryArray[$battle_category].' battle';
                    }
                    add_notification($friend_user_id, $sessionData['id'], $notification_msg, 'battle_request', $request_id);
                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('message', 'Battle challenge has been sent');
                    redirect('battle');
                }
                
            }
        }
        $arrData['friendsOpt'] = $friendOptions;
        $arrData['selected'] = $selectedId;
        //echo '<pre>'; print_r($arrData['friendsOpt']);
        $arrData['categoryArray'] = $categoryArray;
        $arrData['middle'] = 'create_battle_request';
        $arrData['div_col_unit'] = 'col-md-12';
        
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
        $arrData['own_songs'] = $this->library->getUserSongs($this->session->userdata('logged_in')['id']);
        $arrData['freestyle_beat_lib'] = $this->battles->getFerrstyleList();
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }
    
    public function check_video_file($media_id) {
        
        $file = $this->library->getFileExtension($media_id);
        $videoArray = ['mp4', 'ogg', 'webm'];
        if(in_array($file['media'], $videoArray)) {
            return TRUE;
        } else {
             $this->form_validation->set_message('check_video_file', 'Please select only video file');
            return FALSE;
        }
    }

    public function greater_than_one($numeric) {
        if ($numeric <= 0) {
            $this->form_validation->set_message('greater_than_one', 'The {field} field can not be less than one Battle Buck');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function request($battle_id = NULL, $status = 0) {
        if (!is_null($battle_id)) {
            
            $battle_details = $this->battles->get_battle_details($battle_id);
            if (empty($battle_details))
                redirect('/');
            
            
            if($this->session->userdata('red_count') == '') {
                $this->session->set_userdata('red_count', 0);
            }
            //echo '<pre>';            print_r($battle_details);
            //echo '<pre>'; print_r($this->sessionData); die;
            if(isset($this->sessionData) && !empty($this->sessionData)) {
                
                $_mediaCheck = $this->battles->getBattleMedia(array('battle_id' => $battle_id, 'artist_id'=>$this->sessionData['id']));
                
                if(($this->sessionData['id'] == $battle_details[0]['friend_user_id'] OR  $this->sessionData['id'] == $battle_details[0]['user_id']) 
                        && $this->session->userdata('red_count') == 0 
                        && $_mediaCheck == FALSE 
                        && $battle_details[0]['battle_category'] == 5) {
                    
                    $this->session->set_userdata('red_count', 1);
                    redirect('battle/request/' . $battle_id.'?'. base64_encode($battle_id));
                }
            }
            
            
            //upload songs to battle
            if ($this->input->post('Submit') == 'Create') {

                $this->form_validation->set_rules('title', 'Title', 'trim|required');
                if($this->input->post('media_type') == 1) {
                    if (empty($_FILES['media']['name'])) {
                        $this->form_validation->set_rules('media', 'Song', 'trim|required');
                    }
                } else {
                    $this->form_validation->set_rules('media_id', 'choose from library', 'trim|required');
                    /* if ($battle_details[0]['battle_category'] == 4) { 
                        // for custom query
                        $this->form_validation->set_rules('media_id', 'choose from library', 'callback_check_video_file');
                    } */
                }

                $sess_data = get_session_data();
                $user_id = $sess_data['id'];
                $gender = $sess_data['gender']==1?' his':' her';
                if ($this->form_validation->run() == TRUE) {

                    if($this->input->post('media_type') == 1) {
                        
                        $mediaConfig = array(
                            'upload_path' => $this->config->item('library_media_path'),
                            //'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm|mp4|ogg|webm|avi|flv',
                            'allowed_types' => '*',
                            'encrypt_name'  => TRUE,
                            'max_size' => '1024159'
                        );
                        
                        $uploadAck = $this->common_lib->upload_custom_media('media', $mediaConfig);
                        if (isset($uploadAck['file_name']) && isset($uploadAck['file_type'])) {
                            
                            $source = $this->config->item('library_media_path').$uploadAck['file_name'];
                            $file_type = explode('/', $uploadAck['file_type']);
                            if($file_type[0] == 'video') {
                                $conv_file_name = 'con_'.time().'.mp4';
                                $cont_file_path = $this->config->item('library_media_path').$conv_file_name;
                                shell_exec("/usr/local/bin/ffmpeg -i ".$source." -y -vcodec libx264 -crf 18 -pix_fmt yuv420p -qcomp 0.8 -preset medium -acodec aac -strict -2 -b:a 400k -x264-params ref=4 -profile:v baseline -level 3.1 -movflags +faststart ".$cont_file_path);
                                //shell_exec("/usr/local/bin/ffmpeg -i ".$source." -acodec libvorbis -vcodec libtheora -f ogg ".$cont_file_path." 2>&1");
                                if(file_exists($source)) { unlink($source); }
                            } else if($file_type[0] == 'audio') {
                                $conv_file_name = 'con_'.time().'.mp3';
                                $cont_file_path = $this->config->item('library_media_path').$conv_file_name;
                                shell_exec("/usr/local/bin/ffmpeg -i ".$source." -f mp3 ".$cont_file_path." 2>&1");
                                if(file_exists($source)) { unlink($source); } 
                            } else {
                                if(file_exists($source)) { unlink($source); } 
                                $this->session->set_flashdata('class', 'alert-danger');
                                $this->session->set_flashdata('message', 'File type is not allowed!');
                                redirect('battle/request/' . $battle_id);
                            }   
                            
                            if(!file_exists($cont_file_path)) {
                                $this->session->set_flashdata('class', 'alert-danger');
                                $this->session->set_flashdata('message', 'File format is not allowed!');
                                redirect('battle/request/' . $battle_id);
                            }
                            
                            //save file to users library first
                            $library_data = array(
                                'user_id' => $user_id,
                                'title' => $this->input->post('title'),
                                'media' => $conv_file_name,
                                'created_date' => date('Y-m-d H:i:s')
                            );
                            $library_id = $this->library->insert($library_data);
                            if ($library_id > 0) {
                                //save media in battle 
                                $copyStatus = copy($this->config->item('library_media_path') . $conv_file_name, $this->config->item('battle_media_path') . $conv_file_name);
                                $form_data = array(
                                    'battle_id' => $battle_id,
                                    'artist_id' => $user_id,
                                    'fk_song_id' => $library_id,
                                    'created_date' => date('Y-m-d H:i:s')
                                );
                                $status = $this->battles->add_battle_media($form_data);
                                if ($status) {
                                    //$b_result_time = $this->battles->getSiteSettingById(11);
                                    /* for start of the battle */
                                    $battleData['status'] = 1;
                                    $battleData['start_date'] = date('Y-m-d H:i:s');
                                    $battleData['end_date'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s'))) . " +".$battle_details[0]['time_duration']." days"));
                                    $this->battles->update_request($battleData, array('battle_request_id' => $battle_id));
                                    
                                    $notification_msg = 'has uploaded'.$gender.' song to the battle';
                                    add_notification($this->input->post('challenger_user_id'), $user_id, $notification_msg, 'battle_request', $battle_id);
                                    /* end of the battle script */

                                    $this->session->set_flashdata('class', 'alert-success');
                                    $this->session->set_flashdata('success', 'Song has been added to battle');
                                    redirect('battle/request/' . $battle_id);
                                } else {
                                    $this->session->set_flashdata('class', 'alert-danger');
                                    $this->session->set_flashdata('success', 'Unable to upload song. Please try again');
                                    redirect('battle/request/' . $battle_id);
                                }
                            }
                        } else {
                            $this->session->set_flashdata('class', 'alert-danger');
                            $this->session->set_flashdata('message', $uploadAck['error']);
                            redirect('battle/request/' . $battle_id);
                        }
                    
                    } else if($this->input->post('media_type') == 2) {
                                //save media in battle 
                                $form_data = array(
                                    'battle_id' => $battle_id,
                                    'artist_id' => $user_id,
                                    'fk_song_id' => $this->input->post('media_id'),
                                    'created_date' => date('Y-m-d H:i:s')
                                );
                                $status = $this->battles->add_battle_media($form_data);
                                if ($status) {
                                    /* for start of the battle */
                                    $battleData['status'] = 1;
                                    $battleData['start_date'] = date('Y-m-d H:i:s');
                                    $battleData['end_date'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s'))) . " +".$battle_details[0]['time_duration']." days"));
                                    $this->battles->update_request($battleData, array('battle_request_id' => $battle_id));

                                    $notification_msg = 'has uploaded'.$gender.' song to the battle';
                                    add_notification($this->input->post('challenger_user_id'), $user_id, $notification_msg, 'battle_request', $battle_id);
                                    /* end of the battle script */

                                    $this->session->set_flashdata('class', 'alert-success');
                                    $this->session->set_flashdata('success', 'Song has been added to battle');
                                    redirect('battle/request/' . $battle_id);
                                } else {
                                    $this->session->set_flashdata('class', 'alert-danger');
                                    $this->session->set_flashdata('success', 'Unable to upload song. Please try again');
                                    redirect('battle/request/' . $battle_id);
                                }
                    } 
                    
                    
                }
            }

            $battle_media = $this->battles->get_battle_media(array('battle_id' => $battle_id));
             //echo '<pre>';            print_r($battle_media); 

            $vote_details_arr = $this->vote->get_voter_votes(array('battle_id' => $battle_id));
            //echo '<pre>'; print_r($vote_details_arr);

            if (!empty($vote_details_arr)) {
                $voteDetails = $vote_details_arr;
                $userWhrArr['battle_id'] = $battle_id;
                $userWhrArr['artist_id'] = $battle_details[0]['friend_user_id'];

                $battle_details[0]['friend_vote_cnt'] = $this->vote->count_vote($userWhrArr);
                $userWhrArr['artist_id'] = $battle_details[0]['user_id'];
                $battle_details[0]['user_vote_cnt'] = $this->vote->count_vote($userWhrArr);
            } else {
                $voteDetails = array();
                $battle_details[0]['friend_vote_cnt'] = 0;
                $battle_details[0]['user_vote_cnt'] = 0;
            }

            $postContent = '';
            if ($status > 0) {
                $date = date('Y-m-d');
                if ($status == 2) {
                    $updateData['end_date'] = $date;
                    $msg = ' has rejected your challenge to battle in '.$battle_details[0]['battle_name'];;
                    
                } else {
                    //deduct coins
                    $coinsToDeduct = $battle_details[0]['entry'];

                    if ($coinsToDeduct > 0 && ($battle_details[0]['c_coins'] < $coinsToDeduct || $battle_details[0]['f_coins'] < $coinsToDeduct)) {
                        $this->session->set_flashdata('success', 'Challenger or your coins balance less than battle charge');
                        redirect('battle/request/' . $battle_id);
                    }

                    $msg = ' has accepted your challenge to battle in '.$battle_details[0]['battle_name'];
                    $postContent = ' A battle has been started between ' . $battle_details[0]['challenger'] . ' and '
                            . $battle_details[0]['friend'];

                    if ($coinsToDeduct > 0) {

                        $this->load->model('wallet_model', 'wallet');

                        $this->wallet->deductCoins($coinsToDeduct, $battle_details[0]['friend_user_id']);
                        $this->wallet->deductCoins($coinsToDeduct, $battle_details[0]['user_id']);
                    }
                }
                $updateData['status'] = $status;
                $is_update = $this->battles->update_request($updateData, array('battle_request_id' => $battle_id));
                // send notification
                add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $msg, $type = 'battle_request', $battle_id);
                if ($is_update && $postContent != '') {
                    //post on wall/news feed
                    $data = array(
                        'content' => $postContent,
                        'subject_id' => $battle_details[0]['user_id'],
                        'object_id' => $battle_details[0]['user_id'],
                        'data_id' => $battle_id,
                        'data_type'  => 'common_wall',
                        'created_on' => date("Y-m-d H:i:s", time())
                    );
                    $this->post->addpost($data);
                    $data = array(
                        'content' => $postContent,
                        'subject_id' => $battle_details[0]['friend_user_id'],
                        'object_id' => $battle_details[0]['friend_user_id'],
                        'data_id' => $battle_id,
                        'data_type'  => 'common_wall',
                        'created_on' => date("Y-m-d H:i:s", time())
                    );
                    $this->post->addpost($data);
                }

                redirect('battle/request/' . $battle_id);
            }


            $arrData['battle_details'] = $battle_details[0];
            $arrData['battle_media'] = $battle_media;
            $arrData['vote_details'] = $voteDetails;

            $arrData['support_amount'] = $this->battles->get_support_amount($battle_id);
            $arrData['support_users'] = $this->battles->get_support_users($battle_id);
            
            $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
            $arrData['top_songs'] = $this->library->get_top_songs();
	    $arrData['top_user'] = $this->user->get_top_user();
            
            $arrData['own_songs'] = $this->library->getUserSongs($this->session->userdata('logged_in')['id']);
            //echo '<pre>'; print_r($arrData['own_songs']); die;
            
            
            $arrData['div_col_unit'] = 'col-md-12';
            if ($battle_details[0]['status'] == 3) {
               // $arrData['middle'] = 'closed_battle_page';
                //$this->load->view('templates/template', $arrData);
                
                $this->load->view('closed_battle_page', $arrData);
                
            } else {
                if($battle_details[0]['battle_category'] == 5) {
                     $arrData['fstyle_lib_song'] = $this->battles->getFerrstyleSingle($battle_id);
                     $this->load->view('freestyle_battle_page', $arrData);
                    // $this->load->view('freestyle_audio_chat', $arrData);
                } else {
                     $this->load->view('battle_page', $arrData);
                }
            }
            
        } else
            redirect('battle');
    }

    
    public function lease_freestyle($battle_id = null, $status = null) {
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
        $battle_id = (int)base64_decode($battle_id);
        if(!empty($battle_id) && is_int($battle_id) && $battle_id > 0) {
            $battle_details = $this->battles->get_battle_details($battle_id);
           
                $date = date('Y-m-d H:i:s');
                if ($status == 0) {
                    $updateData['end_date'] = $date;
                    $updateData['status'] = 2;
                    $msg = ' has rejected your battle beat request';
                } else {
                    $updateData['status'] = 4;
                    //deduct coins
                    $coinsToDeduct = $battle_details[0]['entry']+1;

                    if ($coinsToDeduct > 0 && ($battle_details[0]['c_coins'] < $coinsToDeduct || $battle_details[0]['f_coins'] < $coinsToDeduct)) {
                        $this->session->set_flashdata('success', 'Challenger or your coins balance less than battle charge');
                        redirect('wallet');
                    }

                    $msg = ' has accepted your Freestyle Battle Challenge';
                    $userDtl = $this->user->getSingleUser($battle_details[0]['user_id']);
                    $user_name = ucfirst($userDtl['firstname'].' '.$userDtl['lastname']);
                    
                    $fUserDtl = $this->user->getSingleUser($battle_details[0]['friend_user_id']);
                    $friend_name = ucfirst($fUserDtl['firstname'].' '.$fUserDtl['lastname']);
                            
                    $postContent = 'A freestyle battle between '.$user_name.' and '.$friend_name.' will take place on '.date('F d, g:i a',strtotime($battle_details[0]['date_time']));
                    
                    // 1 bb deducted from both account due to lease freestyle battle
                    $deduct_msg = '1 bb deducted from your wallet due to lease the freestyle battle';
                    add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $deduct_msg, $type = 'battle_request', $battle_id);
                    add_notification($battle_details[0]['friend_user_id'], $battle_details[0]['user_id'], $deduct_msg, $type = 'battle_request', $battle_id);

                    if ($coinsToDeduct > 0) {
                        $this->load->model('wallet_model', 'wallet');
                        $this->wallet->deductCoins($coinsToDeduct, $battle_details[0]['friend_user_id']);
                        $this->wallet->deductCoins($coinsToDeduct, $battle_details[0]['user_id']);
                    }
                }
                
                $is_update = $this->battles->update_request($updateData, array('battle_request_id' => $battle_id));
                // send notification
                add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $msg, $type = 'battle_request', $battle_id);
                if ($is_update && $postContent != '') {
                    //post on wall/news feed
                    $data = array(
                        'content' => $postContent,
                        'subject_id' => $battle_details[0]['user_id'],
                        'object_id' => $battle_details[0]['user_id'],
                        'data_id' => $battle_id,
                        'data_type'  => 'common_wall',
                        'created_on' => date("Y-m-d H:i:s", time()),
                        'updated_on' => date("Y-m-d H:i:s", time()),
                    );
                    $this->post->addpost($data);
                    $data = array(
                        'content' => $postContent,
                        'subject_id' => $battle_details[0]['friend_user_id'],
                        'object_id' => $battle_details[0]['friend_user_id'],
                        'data_id' => $battle_id,
                        'data_type'  => 'common_wall',
                        'created_on' => date("Y-m-d H:i:s", time()),
                        'updated_on' => date("Y-m-d H:i:s", time()),
                    );
                    $this->post->addpost($data);
                }

                if($status==1) {
                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('message', 'You have successfully accepted the battle bate.');
                } else {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('message', 'You have successfully rejected the battle bate.');
                }
                redirect('battle/freestyle_library');
            
        }
        
        //echo $battle_id; die;
        
    }



    public function start_notification($battle_id = null) {
        $battle_id = $this->input->post('battle_id');
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
        
        $battle_id = (int)base64_decode($battle_id);
        if(!empty($battle_id) && is_int($battle_id) && $battle_id > 0) {
            if($this->battles->is_notify($battle_id) == FALSE) {
                
                $result_array = $this->battles->get_timediff($battle_id);
                
                if($result_array != false) {
                    
                    if($result_array['date_diff'] >=0 && $result_array['date_diff'] < 1) {
                        if($result_array['time_diff'] <=5) {
                            
                            $battle_details = $this->battles->get_battle_details($battle_id);
                            $msg = 'battle will begin in 5 mins';
                            //add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $msg, $type = 'battle_request', $battle_id);
                            //add_notification($battle_details[0]['friend_user_id'], $battle_details[0]['user_id'], $msg, $type = 'battle_request', $battle_id);
                            add_notification($battle_details[0]['friend_user_id'], $battle_details[0]['user_id'], $msg, $type = 'battle_request', $battle_id);
                            add_notification($battle_details[0]['user_id'], $battle_details[0]['friend_user_id'], $msg, $type = 'battle_request', $battle_id);
                            
                            $this->battles->set_notify($battle_id);
                        }
                         
                    }
                    
                }
            } 
            
            
        }
    }
    
    
    public function auto_start($battle_id = null) {
        $battle_id = $this->input->post('battle_id');
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
            //$return_val = 0;
        $battle_id = (int)base64_decode($battle_id);
        if(!empty($battle_id) && is_int($battle_id) && $battle_id > 0) {
            
            $result_array = $this->battles->get_timediff($battle_id);
            
                if($result_array != false) {
                    
                    if($result_array['date_diff'] >=0 && $result_array['date_diff'] < 1 ) {
                        
                         $battle_details = $this->battles->get_battle_details($battle_id);
                        
                        if($result_array['time_diff'] <=1 && $result_array['time_diff'] >0 ) {
                            
                            // for post user wall
                            if($this->battles->is_posted($battle_id) == FALSE) {
                               
                                //$postContent = 'Freestyle battle will begin in 60 seconds. The artist are ' . $battle_details[0]['challenger'] . ' and '. $battle_details[0]['friend'];
                                $postContent = 'A Freestyle Battle will take place in 60 seconds click this post to view Battle';
                                
                                $data = array(
                                    'content' => $postContent,
                                    'subject_id' => $battle_details[0]['user_id'],
                                    'object_id' => $battle_details[0]['user_id'],
                                    'data_id' => $battle_id,
                                    'data_type'  => 'common_wall',
                                    'created_on' => date("Y-m-d H:i:s", time()),
                                    'updated_on' => date("Y-m-d H:i:s", time()),
                                );
                                $this->post->addpost($data);
                                $data = array(
                                    'content' => $postContent,
                                    'subject_id' => $battle_details[0]['friend_user_id'],
                                    'object_id' => $battle_details[0]['friend_user_id'],
                                    'data_id' => $battle_id,
                                    'data_type'  => 'common_wall',
                                    'created_on' => date("Y-m-d H:i:s", time()),
                                    'updated_on' => date("Y-m-d H:i:s", time()),
                                );
                                $this->post->addpost($data);

                                $this->battles->set_post($battle_id);
                            }
                            // for count down reply
                            echo 1; // Count down popup is run
                            die();
                         
                    } elseif ($result_array['time_diff'] <=0 && $result_array['time_diff'] > -1 && $battle_details[0]['status'] == 4) {
                        /* for start of the battle */
                        $battleData['status'] = 1;
                        $battleData['start_date'] = date('Y-m-d H:i:s');
                        $battleData['end_date'] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s'))) . " +7 days"));
                        $this->battles->update_request($battleData, array('battle_request_id' => $battle_id));
                    }
                    
                }
            } 
            
            echo 0; die();
        }
    }
    
    
    public function upload_live_voice() {
        
        if ($this->input->post('Submit') == 'Upload') {
            
            $sess_data = get_session_data();
            $user_id = $sess_data['id'];
            $return_status = [];
                
            $this->form_validation->set_rules('battle_id', 'Battle ID', 'trim|required');
            if (empty($_FILES['media']['name'])) {
                $this->form_validation->set_rules('media', 'Song', 'trim|required');
            }
                
            $battle_id = $this->input->post('battle_id');
            $sequence_number = $this->input->post('media_count');
                
            if ($this->form_validation->run() == TRUE && isset($user_id)) {
                
                $mediaConfig = array(
                        'upload_path' => $this->config->item('freestyle_composer'),
                        //'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm|mp4|ogg|webm|avi|flv',
                        'allowed_types' => '*',
                        'encrypt_name'  => TRUE,
                        'max_size' => '1024159'
                    );
                
                if($sequence_number == 1) {
                    $track_info = $this->battles->get_freestyle_media_track(['battle_id' =>$battle_id, 'user_id'=>$user_id,'sequence_number'=>1]);
                    if(!empty($track_info)) {
                        if(file_exists($this->config->item('freestyle_composer').$track_info['filename'])) { 
                            unlink($this->config->item('freestyle_composer').$track_info['filename']); 
                           // delete record
                            $this->battles->delete_freestyle_media_track(['id'=> $track_info['id']]);
                        }
                    }
                    /* for upload in freestyle composer directory and insert into track database */
                     $uploadAck = $this->common_lib->upload_custom_media('media', $mediaConfig);
                        if (isset($uploadAck['file_name']) && isset($uploadAck['file_type'])) {
                            $this->battles->set_freestyle_media_track(['battle_id' =>$battle_id, 'user_id'=>$user_id,'sequence_number'=>$sequence_number,'filename'=>$uploadAck['file_name'],'created_on'=>date('Y-m-d H:i:s')]);
                        }
                }
                
                if($sequence_number == 2) {
                    //1. file upload
                    $uploadAck = $this->common_lib->upload_custom_media('media', $mediaConfig);
                        if (isset($uploadAck['file_name']) && isset($uploadAck['file_type'])) {
                            
                            $track_info = $this->battles->get_freestyle_media_track(['battle_id' =>$battle_id, 'user_id'=>$user_id,'sequence_number'=>1]);
                            if(!empty($track_info)) {
                                
                                $first_media = $this->config->item('freestyle_composer').$track_info['filename'];
                                $second_media = $this->config->item('freestyle_composer').$uploadAck['file_name'];
                                
                                $filename = time().".mp3";
                                $finl_dest = $this->config->item('library_media_path').$filename;
                                shell_exec("/usr/local/bin/ffmpeg -i ".$first_media." -i ".$second_media." -filter_complex '[0:0][1:0]concat=n=2:v=0:a=1[out]' -map '[out]' ".$finl_dest." 2>&1");
                                
                                if(file_exists($finl_dest)) { 
                                    
                                    //save file to users library first
                                    $library_data = array(
                                        'user_id' => $user_id,
                                        'title' => $this->input->post('title'),
                                        'media' => $filename,
                                        'created_date' => date('Y-m-d H:i:s')
                                    );
                                    $library_id = $this->library->insert($library_data);
                                    if ($library_id > 0) {
                                        //save media in battle 
                                        $copyStatus = copy($this->config->item('library_media_path') . $filename, $this->config->item('battle_media_path') . $filename);
                                        $form_data = array(
                                            'battle_id' => $battle_id,
                                            'artist_id' => $user_id,
                                            'fk_song_id' => $library_id,
                                            'created_date' => date('Y-m-d H:i:s')
                                        );
                                        $status = $this->battles->add_battle_media($form_data);
                                        if ($status) {
                                            $this->session->set_flashdata('class', 'alert-success');
                                            $this->session->set_flashdata('success', 'Song has been added to battle');
                                            
                                            // delete data from freestyle composer and database
                                            if(file_exists($first_media)) { 
                                                unlink($first_media); 
                                            }
                                            if(file_exists($second_media)) { 
                                                unlink($second_media); 
                                            }
                                            $this->battles->delete_freestyle_media_track(['id'=> $track_info['id']]);
                                            
                                            
                                            $return_status = ['status'=>1, 'url'=>  base_url().'battle/request/' . $battle_id];
                                            echo json_encode($return_status); die();

                                        } 
                                    }
                                    
                                } else {
                                    //SHELL EXECUTION FAIL
                                    $return_status = ['status'=>0, 'msg'=>  'shell execution failed!'];
                                    echo json_encode($return_status); die();
                                }
                                
                            } else {
                                // ENTWORK ERROR
                                $return_status = ['status'=>0, 'msg'=>  'First sequence is not uploaded!'];
                                echo json_encode($return_status); die();
                            }
                            
                        }
                }

                
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', validation_errors());
                $return_status = ['status'=>0, 'msg'=>  'Form validation error!'];
                echo json_encode($return_status); die();
            }
        }
    }



    /* not yet used */

    public function upload_media($battle_id = NULL) {

        if ($this->input->post('Submit') == 'Create') {
            //$this->form_validation->set_rules('media', 'Song', 'trim|required');
            // if ($this->form_validation->run() == TRUE) {
            $mediaConfig = array(
                'upload_path' => $this->config->item('battle_media_path'),
                'allowed_types' => 'mp3|mp4|wav'
            );
            $filename = $this->common_lib->upload_media('media', $mediaConfig);
            $form_data = array(
                'battle_id' => $battle_id,
                'artist_id' => $user_id,
                'title' => $this->input->post('title'),
                'media' => $filename,
                'created_date' => date('Y-m-d H:i:s')
            );

//		}
//		else
//		{
//		    echo form_error('media');
//		}
        }
    }

    /**
     * index function
     * this function is used to list of all battle category for both cash & regular
     * @return void
     * @param 
     * @author Samiran
     * */
    public function category($battle_cat = '') {
        if ($battle_cat == null)
            redirect('home');
        //if cash-battle or regular-battle
        
        $battleCat = $this->user->getBattleCategoryList();
        $battleCatArray = [];
        foreach ($battleCat as $value) {
            $battleCatArray[$value['id']] = $value['name'];
        }
        $battle_category = $battleCatArray;
        
        
        //$battle_category = [ 1 => 'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle'];
        $user_id = $this->sessionData['id'];
        $battleData = $this->battles->get_battle_list();
        $arrData['userId'] = $user_id;
        $arrData['battleList'] = $battleData;
        $arrData['battle_category'] = $battle_category;
        $arrData['middle'] = 'battle_category';
        $arrData['div_col_unit'] = 'col-md-12';
        
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['top_songs'] = $this->library->get_top_songs();
	$arrData['top_user'] = $this->user->get_top_user();
        
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        //echo '<pre>'; print_r($arrData); die;
        $this->load->view('templates/template', $arrData);
    }
    
    public function find_membership() {
        $user_id = $this->input->post('user_id');
        $rs = $this->friends->get_membership($user_id);
        if(isset($rs['memberships_id'])) {
            echo $rs['memberships_id'];
        } else {
            echo 0;
        }
    }

}
