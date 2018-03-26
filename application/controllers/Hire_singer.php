<?php
/**
 * this class has functions that perform Chalange a Artist operation
 * @package Artist_registry
 * @subpackage controller
 * @author 
 * */
class Hire_singer extends CI_Controller {

    /**
     * __construct
     * 
     * this function calls the parent constructor.
     * @access public
     * @return void
     * @author 
     * */
    public function __construct() {
        parent::__construct();
        $data = $this->session->userdata('logged_in');
        if (empty($data)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        }
        $this->load->model('Friendsmodel', 'friends');
        //$this->load->model('Song_library_model' , 'library');
        $this->load->model('Usermodel', 'user');
        $this->load->model('Hire_model', 'hire');
        $this->load->library('Common_lib');
        $this->sessionData = get_session_data();
        $this->load->library('encrypt');
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function index() {
        
        $user_id = $this->sessionData['id'];
        $registerSinger = $this->hire->getRegisterSinger($user_id);
//        echo '<pre>';        print_r($registerSinger); die();
        
        $gender = [1 =>'male', 2 => 'female'];
        $registerSingerArray = [];
        if(isset($registerSinger) && !empty($registerSinger)) {
            foreach ($registerSinger as $regisVal){
                if(array_key_exists($regisVal['gender'], $gender)){
                    $registerSingerArray[$regisVal['gender']][] = $regisVal;
                }
            }
        }
        //sort($registerSingerArray);
        //echo '<pre>';        print_r($registerSingerArray); 
        
        $arrData['userId'] = $user_id;
        $arrData['singerList'] = $registerSingerArray;
        $arrData['middle'] = 'hire_singer';
        $arrData['div_col_unit'] = 'col-md-12';
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        
        //echo '<pre>';        print_r($arrData['userdata']);
        
        //$arrData['top_songs'] = $this->library->get_top_songs();
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }     
    
    /**
     * register function
     * this function is used register a singer
     * @return void
     * @param 
     * @author Sam
     * */
    public function register($friend_id = NULL) {
        //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
        //echo $this->config->item('library_media_path'); 
        $this->form_validation->set_rules('singer_gender', 'Singer Gender', 'trim|required');
        $this->form_validation->set_rules('singing_style[]', 'Singing Style', 'required');
        if (empty($_FILES['media']['name'])) {
            $this->form_validation->set_rules('media', 'Media', 'required');
        }

        if ($this->form_validation->run() == TRUE) {
            
            /* for start of media uploade */
            $mediaConfig = array(
                'upload_path' => $this->config->item('library_media_path'),
                'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm',
                'max_size' => '307200'
            );
            $filename = $this->common_lib->upload_media('media', $mediaConfig);
            if (!is_array($filename)) {
                
                //save file to users library first
                 foreach ($this->input->post() as $key => $val)
                $$key = $val;
                
                $inputData['user_id'] = $sessionData['id'];
                $inputData['gender'] = $singer_gender;
                $inputData['singing_style'] = isset($singing_style) ? implode(',', $singing_style) :'';
                $inputData['voice_clip'] = $filename;
                $inputData['created_on'] = date('Y-m-d H:i:s');
                //echo '<pre>'; print_r($inputData); die();

                $this->db->insert('register_singer' , $inputData);
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'You have successfully registered as a Singer');
                redirect('hire_singer/register');
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', $filename['error']);
                redirect('hire_singer/register/');
            }
            /* end of media uploade */
        }
        //echo '<pre>'; print_r($arrData['friendsOpt']);
        
        $arrData['middle'] = 'singer_register';
        $arrData['div_col_unit'] = 'col-md-12';
        
        $arrData['register_singer'] = $this->hire->get_register_singer($sessionData['id']);
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
        //$arrData['own_songs'] = $this->library->getUserSongs($this->session->userdata('logged_in')['id']);
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }
    
    public function release_payment() {
        //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
        
        $arrData['middle'] = 'hired_singer';
        $arrData['div_col_unit'] = 'col-md-12';
        
        //$arrData['register_singer'] = $this->hire->get_register_singer($sessionData['id']);
        $arrData['hired_singer'] = $this->hire->getHiredSinger($sessionData['id']);
        //echo '<pre>';        print_r($arrData['hired_singer']); die; 
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
        //$arrData['own_songs'] = $this->library->getUserSongs($this->session->userdata('logged_in')['id']);
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }
    
    public function rating_singer() {
         //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
          $hired_id = base64_decode($this->uri->segment(3)); 
          $hired_id = $this->encrypt->decode($hired_id); 
        if(!isset($hired_id)) {
            redirect('user');
        } 
        
         $arrData['hiredDtl'] = $this->hire->getHiredSingle($hired_id);
        //echo '<pre>';        print_r($arrData['hiredDtl']); die; 
        
        //echo $this->config->item('library_media_path'); 
        $this->form_validation->set_rules('rating_singer', 'Rating Singer', 'trim|required');
        $this->form_validation->set_rules('accept', 'Accept', 'required');
        $this->form_validation->set_rules('hired_user_id', 'Hired user id', 'required');
        if ($this->form_validation->run() == TRUE) {
                //save file to users library first
                 foreach ($this->input->post() as $key => $val)
                $$key = $val;
                
                $inputData['rating']            = $rating_singer;
                $inputData['user_id']           = $sessionData['id'];
                $inputData['hired_user_id']     = $arrData['hiredDtl']['hired_user_id'];
                $inputData['type']              = 1;
                $inputData['status']            = 1;
                // Rating table insert
                $this->db->insert('rating' , $inputData);
                
                // Status update for Hired user table
                 $this->db->where('id', $arrData['hiredDtl']['id']);
                $this->db->update('hired_user', ['status'=>1, 'updated_on'=>date('Y-m-d H:i:s')]);
                
                // Credited fund to Hired user 
                $sql = "UPDATE user SET coins = (coins + 150) WHERE id = '".$arrData['hiredDtl']['hired_user_id']."'";
                $this->db->query($sql);
                
                // Send notification to hired user
                $hiredUsrDtl = $this->user->getSingleUser($arrData['hiredDtl']['hired_user_id']);
                $msg = ucfirst($hiredUsrDtl['firstname']).' your wallet has been creadited 150 BB by '.$sessionData['name'];
                add_notification($arrData['hiredDtl']['hired_user_id'], $sessionData['id'], $msg);
                
                
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'You have successfully release the fund');
                redirect('hire_singer/release_payment');
               /* $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', $filename['error']);
                redirect('hire_singer/register/'); */
             
        }
        //echo '<pre>'; print_r($arrData['friendsOpt']);
        
        $arrData['middle'] = 'hired_singer';
        $arrData['div_col_unit'] = 'col-md-12';
        
        $arrData['action'] = 'update';
       
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        
        $this->load->view('templates/template', $arrData);
    }

    public function update() {
        //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
        
        $arrData['register_singer'] = $this->hire->get_register_singer($sessionData['id']);
        
        //echo $this->config->item('library_media_path'); 
        $this->form_validation->set_rules('singer_gender', 'Singer Gender', 'trim|required');
        $this->form_validation->set_rules('register_id', 'register_id', 'trim|required');
        $this->form_validation->set_rules('singing_style[]', 'Singing Style', 'required');
        
            //$this->form_validation->set_rules('media', 'Media', 'required');
        

        if ($this->form_validation->run() == TRUE) {
            
            if (!empty($_FILES['media']['name'])) {
                /* for start of media uploade */
                $mediaConfig = array(
                    'upload_path' => $this->config->item('library_media_path'),
                    'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm',
                    'max_size' => '307200'
                );
                $filename = $this->common_lib->upload_media('media', $mediaConfig);
            } else {
                $filename = $arrData['register_singer']['voice_clip'];
            }
            
            
            if (!is_array($filename)) {
                
                //save file to users library first
                 foreach ($this->input->post() as $key => $val)
                $$key = $val;

                $inputData['user_id'] = $sessionData['id'];
                $inputData['gender'] = $singer_gender;
                $inputData['singing_style'] = isset($singing_style) ? implode(',', $singing_style) :'';
                $inputData['voice_clip'] = $filename;
                //echo '<pre>'; print_r($inputData); die();

                $this->db->where('id', $register_id);
                $this->db->update('register_singer', $inputData); 
                
                // delete old file
                if($arrData['register_singer']['voice_clip'] != '' && file_exists(getcwd().'/uploads/library/'.$arrData['register_singer']['voice_clip'])) {
                     unlink(getcwd().'/uploads/library/'.$arrData['register_singer']['voice_clip']);
                 }

                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'You have successfully updated');
                redirect('hire_singer/register');
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', $filename['error']);
                redirect('hire_singer/register/');
            }
            /* end of media uploade */
        }
        //echo '<pre>'; print_r($arrData['friendsOpt']);
        
        $arrData['middle'] = 'singer_register';
        $arrData['action'] = 'update';
        $arrData['div_col_unit'] = 'col-md-12';
        
        
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
        //$arrData['own_songs'] = $this->library->getUserSongs($this->session->userdata('logged_in')['id']);
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
    }
    
    
    
    public function doHired() {
        
        $arrData = array();
        $sessionData = $this->sessionData;
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
         $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
         //echo '<pre>';         print_r($arrData['userdata']); die;
        
        $this->form_validation->set_rules('hired_user', 'Hired user', 'trim|required');
        $this->form_validation->set_rules('current_balance', 'Current Balance', 'required');
        $this->form_validation->set_rules('terms', 'terms', 'required');

        if ($this->form_validation->run() == TRUE) {

                if((int)$arrData['userdata'][0]->coins < 175) {
                     $this->session->set_flashdata('class', 'alert-success');
                     $this->session->set_flashdata('message', 'Server error');
                     redirect('hire_singer');
                }
                
                //Balance deduction
                 $sql = "UPDATE user SET coins = (coins - 175) WHERE id = '".$sessionData['id']."'";
                 $this->db->query($sql);
                 
                 // Insert hire user
                foreach ($this->input->post() as $key => $val)
                $$key = $val;
                
                $inputData['user_id'] = $sessionData['id'];
                $inputData['hired_user_id'] = $hired_user;
                $inputData['status'] = 0;
                $inputData['created_on'] = date('Y-m-d H:i:s');
                $this->db->insert('hired_user' , $inputData) ;
            
                // Send notification to hired user
                $hiredUsrDtl = $this->user->getSingleUser($hired_user);
                $msg = ucfirst($hiredUsrDtl['firstname']).' you have been hired by '.$arrData['userdata'][0]->firstname.' '.$arrData['userdata'][0]->lastname." here is user's contact information ".$arrData['userdata'][0]->email;
                add_notification($hired_user, $sessionData['id'], $msg);
            
            
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('message', 'You have successfully Hired a Singer');
                redirect('hire_singer');
            
        } else {
            
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('message', validation_errors());
            redirect('hire_singer');
        }
        
    }

   
}