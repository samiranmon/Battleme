<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Profile extends CI_Controller {

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
        $this->load->model('Usermodel');
        $this->load->model('UserMemberships');
        $this->load->model('Postmodel');
        $this->load->model('Friendsmodel');
        $this->load->helper('randomstring_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Song_library_model', 'library');
        $this->load->library('Common_lib');
        $this->load->library('encrypt');
        $this->load->library('email');
    }

    /**
     * index function
     * loads the user profile page
     * @access public
     * @return void
     * @author 
     * */
    public function index() {

        $data['send_id'] = $user_id = $this->session->userdata('logged_in')['id'];
        $data['post_data'] = $this->Postmodel->getpost($user_id);
        $data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
        //echo '<pre>';        print_r($data['comments']); die;

        $data['userdata'] = $this->Usermodel->get_user_profile($user_id);
        $data['platinum_mics'] = $this->Usermodel->count_platinum_mics($user_id);
        $data['user_profile'] = $this->Usermodel->get_user_profile($user_id);
        $data['getfollowing'] = $this->Friendsmodel->get_following_friends($user_id);
        $data['getfollowers'] = $this->Friendsmodel->get_followers($user_id);
        $data['userfriend'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        /* Menbership list */
        $data['memberships'] = $this->UserMemberships->get_memberships();
        /* Get User Menbership */
        $where_user_memberships = array('user_id' => $user_id, 'status' => '1');
        $data['user_membership'] = $this->UserMemberships->get_user_membership($where_user_memberships);
        //echo '<pre>';        print_r($data['user_membership']); die;

        $data['validation_error_set'] = array();



        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['top_songs'] = $this->library->get_top_songs();
        $data['top_user'] = $this->Usermodel->get_top_user();
        $data['friend_id'] = $user_id;
        $data['pic_update'] = TRUE;
        


        $this->load->view('profile_edit', $data);
    }

    /**
     * update function
     * loads the update profile page
     * @access public
     * @return void
     * @author 
     * */
    public function update() {
        //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->session->userdata('logged_in');
        if (!isset($sessionData['id'])) {
            redirect('user');
        }

        $battleCat = $this->Usermodel->getBattleCategoryList();
        $battleCatArray = [];
        foreach ($battleCat as $value) {
            $battleCatArray[$value['id']] = $value['name'];
        }
        $arrData['battle_cat'] = $battleCatArray;
        
        $arrData['middle'] = 'profile_update';
        $arrData['div_col_unit'] = 'col-md-12';

        $arrData['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['user_profile'] = $arrData['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        $arrData['artist_category']     = $this->Usermodel->getArtistCategoryByUser();
        // $arrData['top_songs'] = $this->library->get_top_songs();
        //$arrData['top_user'] = $this->user->get_top_user();


        $validate_rule = array(
            array(
                'field' => 'fname',
                'label' => 'Firstname',
                'rules' => 'trim|required|min_length[2]|alpha'
            ),
            array(
                'field' => 'lname',
                'label' => 'Lastname',
                'rules' => 'trim|required|min_length[2]|alpha'
            ),
            array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'required'
            ),
            array(
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'aboutme',
                'label' => 'About me',
                'rules' => 'required'
            ),
            array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required'
            ),
            array(
                'field' => 'info',
                'label' => 'Info',
                'rules' => 'required'
            ),
            array(
                'field' => 'paypal_account_id',
                'label' => 'Account Id',
                'rules' => 'trim|valid_email'
            ),
            
            
        );
        $this->form_validation->set_rules($validate_rule);
        if ($this->form_validation->run() == true) {

            $filename = $arrData['user_profile'][0]->profile_picture;
            $cover_imagename = $arrData['user_profile'][0]->cover_picture;
            if ($_FILES['profilepicture']['name'] != '') {
                
                $filename = $this->upload_image('profilepicture');
                if(is_array($filename)) {
                    
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('profile_message', $filename['error']);
                    redirect('profile/update');
                }
                
                if ($arrData['user_profile'][0]->profile_picture != '') {
                    if(file_exists(getcwd() . '/uploads/profile_picture/' . $arrData['user_profile'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/' . $arrData['user_profile'][0]->profile_picture);
                    if(file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['user_profile'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['user_profile'][0]->profile_picture);
                    if(file_exists(getcwd() . '/uploads/profile_picture/medium_' . $arrData['user_profile'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/medium_' . $arrData['user_profile'][0]->profile_picture);
                    if(file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['user_profile'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['user_profile'][0]->profile_picture);
                }
                
            }
            if ($_FILES['cover_picture']['name'] != '') {
                
                $cover_imagename = $this->upload_cover_image('cover_picture');
                if(is_array($cover_imagename)) {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('profile_message', $cover_imagename['error']);
                    redirect('profile/update');
                }
                
                if ($arrData['user_profile'][0]->cover_picture != '') {
                    unlink(getcwd() . '/uploads/cover_picture/' . $arrData['user_profile'][0]->cover_picture);
                }
            }

            //print_r($filename);
            //die;
            /* for add remove artist registry table */
            $artist_registry = $this->input->post('artist_registry');
            if(isset($artist_registry) && !empty($artist_registry)) {
                $this->db->delete('artist_registry', array('user_id' => $sessionData['id'])); 
                foreach ($artist_registry as $key=>$v){
                    $this->db->insert('artist_registry', ['user_id'=>$sessionData['id'], 'battle_category'=>$artist_registry[$key], 'created_on'=> date('Y-m-d H:i:s')]); 
                }
            }
            /* end of add remove artist registry table */
            
            $data = array(
                'firstname' => ucfirst(strtolower($this->input->post('fname'))),
                'lastname' => ucfirst(strtolower($this->input->post('lname'))),
                'gender'   => $this->input->post('gender'),
                'profile_picture' => $filename,
                'cover_picture' => $cover_imagename,
                'city' => ucfirst(strtolower($this->input->post('city'))),
                'country' => ucfirst(strtolower($this->input->post('country'))),
                'aboutme' => $this->input->post('aboutme'),
                'info' => $this->input->post('info'),
                'paypal_account_id' => $this->input->post('paypal_account_id')
            );

            $status = $this->Usermodel->update_user_profile($sessionData['id'], $data);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('profile_message', "Profile has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('profile_message', "Unable to update. Please try again!");
            }

            redirect('profile/update');
        }

        $this->load->view('templates/template', $arrData);
    }

    /**
     * update function
     * loads the update profile page
     * @access public
     * @return void
     * @author 
     * */
    public function update_password() {
        //get friends list of logged in user
        $arrData = array();
        $sessionData = $this->session->userdata('logged_in');
        if (!isset($sessionData['id'])) {
            redirect('user');
        }
        $arrData['middle'] = 'update_password';
        $arrData['div_col_unit'] = 'col-md-12';

        $arrData['user_profile'] = $arrData['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
        if($arrData['user_profile'][0]->email != NULL && $arrData['user_profile'][0]->password != NULL ) {
            redirect('home'); }
        $arrData['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        
        if($arrData['user_profile'][0]->email == NULL)
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
                           
        if ($this->form_validation->run() == true) {
            $data = ['password' => md5($this->input->post('password'))];
            if($this->input->post('email') != NULL)
                $data['email'] = $this->input->post('email');

            $status = $this->Usermodel->update_user_profile($sessionData['id'], $data);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('post_message', "Password has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('post_message', "Unable to update. Please try again!");
            }

            redirect('home');
        }

        $this->load->view('templates/template', $arrData);
    }
    
    /**
     * edit_profile function
     * this function edits user profile
     * @access public
     * @param $id
     * @return void
     * @author 
     * */
    public function edit_profile($id) {
        // $data['user_profile'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);

        $data['send_id'] = $user_id = $this->session->userdata('logged_in')['id'];
        $data['post_data'] = $this->Postmodel->getpost($user_id);
        $data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
        $data['userdata'] = $this->Usermodel->get_user_profile($user_id);
        $data['user_profile'] = $this->Usermodel->get_user_profile($user_id);
        $data['getfollowing'] = $this->Friendsmodel->get_following_friends($user_id);
        $data['getfollowers'] = $this->Friendsmodel->get_followers($user_id);
        $data['userfriend'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);


        /* Menbership list */
        $data['memberships'] = $this->UserMemberships->get_memberships();
        /* Get User Menbership */
        $where_user_memberships = array('user_id' => $user_id, 'status' => '1');
        $data['user_membership'] = $this->UserMemberships->get_user_membership($where_user_memberships);

        $validate_rule = array(
            array(
                'field' => 'fname',
                'label' => 'Firstname',
                'rules' => 'trim|required|min_length[2]|alpha'
            ),
            array(
                'field' => 'lname',
                'label' => 'Lastname',
                'rules' => 'trim|required|min_length[2]|alpha'
            ),
            array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'required'
            ),
            array(
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'aboutme',
                'label' => 'About me',
                'rules' => 'required'
            ),
            array(
                'field' => 'info',
                'label' => 'Info',
                'rules' => 'required'
            ),
            array(
                'field' => 'paypal_account_id',
                'label' => 'Account Id',
                'rules' => 'trim|valid_email'
            ),
        );
        $this->form_validation->set_rules($validate_rule);
        if ($this->form_validation->run() == true) {

            $filename = $data['user_profile'][0]->profile_picture;
            $cover_imagename = $data['user_profile'][0]->cover_picture;
            if ($_FILES['profilepicture']['name'] != '') {
                if ($data['user_profile'][0]->profile_picture != '') {
                    unlink(getcwd() . '/uploads/profile_picture/' . $data['user_profile'][0]->profile_picture);
                    unlink(getcwd() . '/uploads/profile_picture/thumb_' . $data['user_profile'][0]->profile_picture);
                }
                $filename = $this->upload_image('profilepicture');
            }
            if ($_FILES['cover_picture']['name'] != '') {
                if ($data['user_profile'][0]->cover_picture != '') {
                    unlink(getcwd() . '/uploads/cover_picture/' . $data['user_profile'][0]->cover_picture);
                }
                $cover_imagename = $this->upload_cover_image('cover_picture');
            }

            //print_r($filename);
            //die;
            $data = array(
                'firstname' => ucfirst(strtolower($this->input->post('fname'))),
                'lastname' => ucfirst(strtolower($this->input->post('lname'))),
                'profile_picture' => $filename,
                'cover_picture' => $cover_imagename,
                'city' => ucfirst(strtolower($this->input->post('city'))),
                'country' => ucfirst(strtolower($this->input->post('country'))),
                'aboutme' => $this->input->post('aboutme'),
                'info' => $this->input->post('info'),
                'paypal_account_id' => $this->input->post('paypal_account_id')
            );

            $status = $this->Usermodel->update_user_profile($id, $data);
            if ($status) {
                $this->session->set_flashdata('class', 'alert-success');
                $this->session->set_flashdata('profile_message', "Profile has been updated successfully");
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('profile_message', "Unable to update. Please try again!");
            }
            $this->session->set_flashdata('activetab', 'editprofile');

            redirect('profile');
        } else {
//            echo '<pre>';
//            print_r(validation_errors());
//            die();
            if ($this->input->post('action') == 'Update') {
                //$this->session->set_flashdata('class', 'alert-success');
                //$this->session->set_flashdata('profile_message', "Profile has been updated successfully");
                $this->session->set_flashdata('activetab', 'editprofile');
            }

            $this->load->view('profile_edit', $data);
        }
    }

    /**
     * upload_image function
     * this function uploads the image
     * @access public
     * @param name of input type 
     * @return void
     * @author 
     * */
    function upload_image($name) {
        $target_dir = 'uploads/profile_picture/';
        $config['upload_path'] = $target_dir;
        $config['allowed_types'] = '*';
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
        $config['encrypt_name'] = TRUE;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 225;
        $config['height'] = 225;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        //if dir doesnot exist create it with 0755 permission
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        if (!$this->upload->do_upload($name)) {
            return array('error' => $this->upload->display_errors());
        } else {
            
            $mediaArray = $this->upload->data();
            $media_file = $mediaArray['file_name'];

             $file_type = explode('/', $mediaArray['file_type']);
            if($file_type[0] == 'image' && $mediaArray['is_image'] == 1) {
                // $data = array('upload_data' => $this->upload->data());
                // $thumbnail = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
                $this->resize_image($media_file);
                $this->resize_image_130x130($media_file);
                $this->big_resize_image($media_file);
                return $media_file;
            } else {
                if(file_exists(getcwd() . '/uploads/profile_picture/' . $media_file))
                    unlink(getcwd() . '/uploads/profile_picture/' . $media_file);
                 return array('error' => 'The filetype you are attempting to upload is not allowed.');
            }
            
        }
    }

    /**
     * upload_image function
     * this function uploads the image
     * @access public
     * @param name of input type 
     * @return void
     * @author 
     * */
    function upload_cover_image($name) {
        $target_dir = 'uploads/cover_picture/';
        $config['upload_path'] = $target_dir;
        $config['allowed_types'] = '*';
       // $config['max_size']             = 70000;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        //if dir doesnot exist create it with 0755 permission
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        if (!$this->upload->do_upload($name)) {
            return array('error' => $this->upload->display_errors());
        } else {
            
            $mediaArray = $this->upload->data();
            $media_file = $mediaArray['file_name'];

             $file_type = explode('/', $mediaArray['file_type']);
            if($file_type[0] == 'image' && $mediaArray['is_image'] == 1) {
                $this->cover_resize_image($media_file);
                return 'resize_'.$media_file;
            } else {
                if(file_exists(getcwd() . '/uploads/cover_picture/' . $media_file))
                    unlink(getcwd() . '/uploads/cover_picture/' . $media_file);
                 return array('error' => 'The filetype you are attempting to upload is not allowed.');
            }
        }
    }

    /**
     * resize_image function
     *  this function resizes the image to thumbnail
     * @param $image_name
     * @return void
     * @author 
     * */
    public function resize_image($image_name) {
        /* $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'thumb_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 80;
        $config['height'] = 80;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize(); */
        
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config=array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;
        
        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/profile_picture/' . $image_name);
                 if(isset($exif['Orientation'])) {
                      switch($exif['Orientation']) {
                           case 3:
                               $config['rotation_angle']='180';
                               break;
                           case 6:
                               $config['rotation_angle']='270';
                               break;
                           case 8:
                               $config['rotation_angle']='90';
                               break;
                        } 
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                 }
            } catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
            }
        }
        
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'thumb_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 80;
        $config['height'] = 80;
            
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    
    public function resize_image_130x130($image_name) {
        /* $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'uploads/profile_picture/130x130/'.$image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 130;
        $config['height'] = 130;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize(); */
        //-----------------
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config=array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;
        
        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/profile_picture/' . $image_name);
                 if(isset($exif['Orientation'])) {
                      switch($exif['Orientation']) {
                           case 3:
                               $config['rotation_angle']='180';
                               break;
                           case 6:
                               $config['rotation_angle']='270';
                               break;
                           case 8:
                               $config['rotation_angle']='90';
                               break;
                        } 
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                 }
            } catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
            }
        }
        
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'uploads/profile_picture/130x130/'.$image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 130;
        $config['height'] = 130;
            
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    
    
    public function big_resize_image($image_name) {
        /* $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'medium_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 565;
        $config['height'] = 441;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize(); */
        //----------
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config=array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;
        
        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/profile_picture/' . $image_name);
                 if(isset($exif['Orientation'])) {
                      switch($exif['Orientation']) {
                           case 3:
                               $config['rotation_angle']='180';
                               break;
                           case 6:
                               $config['rotation_angle']='270';
                               break;
                           case 8:
                               $config['rotation_angle']='90';
                               break;
                        } 
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                 }
            } catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
            }
        }
        
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'medium_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 565;
        $config['height'] = 441;
            
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
    
    public function cover_resize_image($image_name) {
       /* $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/cover_picture/' . $image_name;
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'resize_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 800;
        $config['height'] = 250;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()) {
            unlink(getcwd() . '/uploads/cover_picture/' .$image_name);
        } */
        // ---------------
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config=array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/cover_picture/' . $image_name;
        
        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/cover_picture/' . $image_name);
                 if(isset($exif['Orientation'])) {
                      switch($exif['Orientation']) {
                           case 3:
                               $config['rotation_angle']='180';
                               break;
                           case 6:
                               $config['rotation_angle']='270';
                               break;
                           case 8:
                               $config['rotation_angle']='90';
                               break;
                        } 
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                 }
            } catch(Exception $e) {
              //echo 'Message: ' .$e->getMessage();
            }
        }
        
        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'resize_' . $image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 800;
        $config['height'] = 250;
            
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()) {
            unlink(getcwd() . '/uploads/cover_picture/' .$image_name);
        }
    }
    
    

    /**
     * view_friend function
     * @param $frnd_id
     * @return void
     * @author 
     * */
    public function view($frnd_id) {
        $user_id = $this->session->userdata('logged_in')['id'];

        $data['send_id'] = $user_id;
        $data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
        $data['post_data'] = $this->Postmodel->getpost($frnd_id);


        $data['getfollowing'] = $this->Friendsmodel->get_following_friends($frnd_id);
        $data['getfollowers'] = $this->Friendsmodel->get_followers($frnd_id);

        $data['user_profile'] = $this->Usermodel->get_user_profile($frnd_id);
        if(!isset($data['user_profile']) || empty($data['user_profile'])) {
            redirect('profile');
        }
        //echo '<pre>';        print_r($data['user_profile']);

        $data['userdata'] = $this->Usermodel->get_user_profile($user_id);

        $data['frnd_details'] = $this->Friendsmodel->friend_details($user_id, $frnd_id);
        $data['user_follow_details'] = $this->Friendsmodel->follow_status($frnd_id);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);

        /* echo '<pre>'; 
          print_r($data['navigationbar_home']);
          die; */

        $data['userfriend'] = $this->Friendsmodel->get_all_frnds($frnd_id);
        $data['platinum_mics'] = $this->Usermodel->count_platinum_mics($frnd_id);
        $data['friend_id'] = $frnd_id;
        $data['pic_update'] = FALSE;
        $this->load->view('profile', $data);
    }

    /**
     * buy_media function
     * @param post
     * @return load page
     * @author Samiran
     * */
    public function buy_media() {
        $user_id = $this->session->userdata('logged_in')['id'];
        if (!isset($user_id)) {
            redirect('user');
        }

        $this->form_validation->set_rules('media_id', 'Media Id', 'trim|required|integer');
        $userdata = $this->Usermodel->get_user_profile($user_id);
        if ($userdata[0]->coins >= 1 && $this->form_validation->run() == TRUE) {

            $profile_id = $this->input->post('profile_id');
            $media_id = $this->input->post('media_id');


            // added bb to owner wallet 
            $this->db->where('id', $profile_id);
            $this->db->set('coins', 'coins+' . (1 * 0.75), FALSE);
            $this->db->update('user');

            // deduct bb to subsricber wallet 
            $this->db->where('id', $user_id);
            $this->db->set('coins', 'coins-1', FALSE);
            $this->db->update('user');

            // update database for buyer
            $dataArray = ['user_id' => $user_id, 'profile_id' => $profile_id, 'media_id' => $media_id, 'battle_bucks' => 1, 'payment_gross' => 1 * 1.1, 'currency_code' => 'USD', 'number_of_times_download' => 0, 'status' => 0];
            $this->db->insert('media_download', $dataArray);

            // for sending mail section
            $downloadLink = base_url() . 'download/media/' . base64_encode($this->encrypt->encode($user_id . '-' . $media_id));

            $msg = 'To download the media click ';
            $msg .= '<a href="' . $downloadLink . '">Here</a>';
            $this->email->from('noreply@battleme.hiphop', 'Your Battleme Team');
            $this->email->to($userdata[0]->email);
            $this->email->set_mailtype("html");

            $this->email->subject('Battleme.hiphop download link');
            $this->email->message($msg);
            $this->email->send();


            $this->session->set_userdata('class', 'alert-success');
            $this->session->set_userdata('buy_message', "Your payment has been received successfully. <br>Please check your mail. Download link is sent to your mail account");
            redirect('welcome');
        } else {
            $this->session->set_userdata('class', 'alert-danger');
            $this->session->set_userdata('buy_message', "Unable to buy. Please try again");
            redirect('welcome');
        }
    }

    /**
     * upgrade_membership
     *
     * This is used to upgrate memberships 
     *
     * @author	Nilam Bhapkar
     * @access	public
     * @param   
     * @return array
     */
    public function upgrade_membership($membership_id) {

        $user_id = $this->session->userdata('logged_in')['id'];

        $memberships = $this->UserMemberships->get_membership_details($membership_id);
        $coins = $memberships['membership_amount'];

        if ($coins > 0) {
            //Get user details
            $user = $this->Usermodel->get_user_by_id($user_id);

            if ($user[0]['coins'] < $coins) {

                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('membership_message', "Not enough Battle Buck in wallet, please add Battle Bucks in <a target='_blank' href='wallet'>wallet</a> first.");
                $this->session->set_flashdata('activetab', 'memberships');
                redirect('profile/');
            }
        }

        /* update user membership */

        $update_user_memberships = array('status' => '0');
        $this->UserMemberships->update_user_membership($update_user_memberships, $user_id);

        /* add user membership */
        $user_memberships_info['user_id'] = $user_id;
        $user_memberships_info['memberships_id'] = $membership_id;
        $user_memberships_info['status'] = '1';
        $status = $this->UserMemberships->add($user_memberships_info);
        if ($status) {
            if ($coins > 0) {
                //deduct coins
                $sql = "UPDATE user SET coins = '" . ($user[0]['coins'] - $coins) . "'  WHERE id = '" . $user_id . "'";
                $this->db->query($sql);
            }

            //Change value in session    
            $sess = $this->session->userdata('logged_in');
            $sess['membership_id'] = $membership_id;
            $sess['membership_name'] = $memberships['membership'];
            $this->session->set_userdata('logged_in', $sess);

            $this->session->set_flashdata('class', 'alert-success');
            $this->session->set_flashdata('membership_message', "Membership has been upgraded successfully");
        } else {
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('membership_message', "Unable to upgrade. Please try again");
        }
        $this->session->set_flashdata('activetab', 'memberships');
        redirect('profile/');
    }

    /**
     * upgrade_membership
     *
     * This is used to upgrate memberships 
     *
     * @author	Nilam Bhapkar
     * @access	public
     * @param   
     * @return array
     */
    public function membership_script() {

        $query = "SELECT U.id FROM `user` as U WHERE U.id NOT in (SElect user_id FROM user_memberships ) ";
        $query_rs = $this->db->query($query);
        $result = $query_rs->result_array();

        if (!empty($result)) {
            foreach ($result as $val) {

                $user_memberships_info['user_id'] = $val['id'];
                $user_memberships_info['memberships_id'] = '1';
                $user_memberships_info['status'] = '1';
                $this->UserMemberships->add($user_memberships_info);
            }
            echo "Users added to UserMemberships ";
        } else {
            echo "Users not found";
        }
        die;
    }

    public function add_song() {
        //if ($this->input->post('Submit') == 'Create') {


        $data['send_id'] = $user_id = $this->session->userdata('logged_in')['id'];
        $data['post_data'] = $this->Postmodel->getpost($user_id);
        $data['likes'] = $this->Postmodel->get_postlikes();
        $data['comments'] = $this->Postmodel->getcomments();
        $data['userdata'] = $this->Usermodel->get_user_profile($user_id);
        $data['user_profile'] = $this->Usermodel->get_user_profile($user_id);
        $data['getfollowing'] = $this->Friendsmodel->get_following_friends($user_id);
        $data['getfollowers'] = $this->Friendsmodel->get_followers($user_id);
        $data['userfriend'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $data['navigationbar_home'] = $this->load->view('navigationbar_home', $data, TRUE);


        /* Menbership list */
        $data['memberships'] = $this->UserMemberships->get_memberships();
        /* Get User Menbership */
        $where_user_memberships = array('user_id' => $user_id, 'status' => '1');
        $data['user_membership'] = $this->UserMemberships->get_user_membership($where_user_memberships);

        $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        //$data['top_songs'] = $this->library->get_top_songs();
        //$data['top_user'] = $this->Usermodel->get_top_user();
        $data['friend_id'] = $user_id;


        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $sess_data = get_session_data();
        $user_id = $sess_data['id'];
        if ($this->form_validation->run() == TRUE) {
            $mediaConfig = array(
                'upload_path' => $this->config->item('library_media_path'),
                'allowed_types' => '3gp|aa|aac|aax|act|aiff|amr|ape|au|awb|dct|dss|dvf|flac|gsm|iklax|ivs|m4a|m4b|m4p|mmf|mp3|mpc|msv|ogg|oga|mogg|opus|ra|rm|raw|sln|tta|vox|wav|wma|wv|webm|mp4'
            );
            $filename = $this->common_lib->upload_media('media', $mediaConfig);
            if (!is_array($filename)) {
                
                copy($this->config->item('library_media_path') . $filename, $this->config->item('battle_media_path') . $filename);
                
                //save file to users library first
                $library_data = array(
                    'user_id' => $user_id,
                    'title' => $this->input->post('title'),
                    'media' => $filename,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $library_id = $this->library->insert($library_data);
                if ($library_id > 0) {
                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('song_message', 'Song added to library');
                    $this->session->set_flashdata('activetab', 'library');
                    redirect('profile/#library');
                } else {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('song_message', 'Unable to add. Please try again');
                    $this->session->set_flashdata('activetab', 'library');
                    redirect('profile/#library');
                }
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('song_message', $filename['error']);
                $this->session->set_flashdata('activetab', 'library');
                redirect('profile/#library');
            }
        } else {
            if ($this->input->post('Submit') == 'Create') {
                //$this->session->set_flashdata('class', 'alert-success');
                //$this->session->set_flashdata('profile_message', "Profile has been updated successfully");
                $this->session->set_flashdata('activetab', 'library');
            }

            $this->load->view('profile_edit', $data);
        }
        //}
    }
    
    public function delete_library($libraryId=NULL) {
        $userId = $this->session->userdata('logged_in')['id'];
        $librartDtl = $this->library->getSongById(base64_decode($libraryId),$userId);
        
        if(!empty($librartDtl)) {
            
            $this->db->delete('song_library', array('song_id' => $librartDtl['song_id'])); 
            
            if(file_exists(getcwd() .'/'.$this->config->item('library_media_path'). $librartDtl['media']))
                unlink(getcwd() .'/'.$this->config->item('library_media_path').$librartDtl['media']);
            
            if(file_exists(getcwd() .'/'.$this->config->item('battle_media_path'). $librartDtl['media']))
                unlink(getcwd() .'/'.$this->config->item('battle_media_path').$librartDtl['media']);
            
            $this->session->set_flashdata('class', 'alert-success');
            $this->session->set_flashdata('song_message', 'Library has been deleted successfully!');
        } else {
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('song_message', 'Unable to delete. Please try again');
        }
        $this->session->set_flashdata('activetab', 'library');
        redirect('profile');
    }

    public function picture_upload() {
        if (is_array($_FILES)) {
            $arrData = array();
            $sessionData = $this->session->userdata('logged_in');
            if (!isset($sessionData['id'])) {
                redirect('user');
            }
            $arrData['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);

            $filename = $arrData['userdata'][0]->profile_picture;
            $cover_imagename = $arrData['userdata'][0]->cover_picture;
            if ($_FILES['profImage']['name'] != '') {
                
                $filename = $this->upload_image('profImage');
                if(is_array($filename)) {
                    die();
                }
                
                if ($arrData['userdata'][0]->profile_picture != '' && file_exists(getcwd() . '/uploads/profile_picture/' . $arrData['userdata'][0]->profile_picture)) {
                    unlink(getcwd() . '/uploads/profile_picture/' . $arrData['userdata'][0]->profile_picture);
                    if(file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['userdata'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['userdata'][0]->profile_picture);
                    if(file_exists(getcwd() . '/uploads/profile_picture/medium_' . $arrData['userdata'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/medium_' . $arrData['userdata'][0]->profile_picture);
                    if(file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['userdata'][0]->profile_picture))
                    unlink(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['userdata'][0]->profile_picture);
                }
                
            }
            /*if ($_FILES['cover_picture']['name'] != '') {
                if ($arrData['userdata'][0]->cover_picture != '') {
                    unlink(getcwd() . '/uploads/cover_picture/' . $arrData['userdata'][0]->cover_picture);
                }
                $cover_imagename = $this->upload_cover_image('cover_picture');
            }*/

            //print_r($filename);
            //die;
            $data = array(
                'profile_picture' => $filename,
                'cover_picture' => $cover_imagename,
            );

            $status = $this->Usermodel->update_user_profile($sessionData['id'], $data);
            if ($status) {
                echo base_url() . 'uploads/profile_picture/130x130/'.$filename;
            } else {
               
            }
            
        }
    }
    
    public function cover_upload() {
        if (is_array($_FILES)) {
            $arrData = array();
            $sessionData = $this->session->userdata('logged_in');
            if (!isset($sessionData['id'])) {
                redirect('user');
            }
            
            $arrData['userdata'] = $this->Usermodel->get_user_profile($this->session->userdata('logged_in')['id']);
            $cover_imagename = $arrData['userdata'][0]->cover_picture;
            
            if ($_FILES['coverImage']['name'] != '' ) {
                
                $cover_imagename = $this->upload_cover_image('coverImage');
                if(is_array($cover_imagename)) {
                    die();
                }
                
                if ($arrData['userdata'][0]->cover_picture != '' && file_exists(getcwd() . '/uploads/cover_picture/' . $arrData['userdata'][0]->cover_picture)) {
                    unlink(getcwd() . '/uploads/cover_picture/' . $arrData['userdata'][0]->cover_picture);
                }
                
            }
            $data = array(
                'cover_picture' => $cover_imagename,
            );

            $status = $this->Usermodel->update_user_profile($sessionData['id'], $data);
            if ($status) {
                echo base_url() . 'uploads/cover_picture/'.$cover_imagename;
            } else {
               
            }
            
        }
    }
    
    
    
    

}
