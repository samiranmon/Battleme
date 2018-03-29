<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Profile extends CI_Controller {

    public $paypalMode;
    public $paypalSetting;

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
        $this->load->model('wallet_model', 'wallet');
        $this->load->library('Common_lib');
        $this->load->library('encrypt');
        $this->load->library('email');

        $this->config->load('paypal');

        $paypal_mode = $this->wallet->getSiteSettingById(2);
        if (isset($paypal_mode['status']) && $paypal_mode['status'] == 0) {
            $this->paypalMode = TRUE;
            $this->paypalSetting = $this->wallet->getPaypalSettingById(2);
        } else {
            $this->paypalMode = FALSE;
            $this->paypalSetting = $this->wallet->getPaypalSettingById(3);
        }

        $config = array(
            'Sandbox' => $this->paypalMode, // Sandbox / testing mode option.
            'APIUsername' => $this->paypalSetting['api_username'], // PayPal API username of the API caller
            'APIPassword' => $this->paypalSetting['api_password'], // PayPal API password of the API caller
            'APISignature' => $this->paypalSetting['api_signature'], // PayPal API signature of the API caller
            'APISubject' => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion'), // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
            'DeviceID' => $this->config->item('DeviceID'),
            'ApplicationID' => $this->paypalSetting['application_id'],
            'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
        );

        $this->load->library('paypal/Paypal_pro', $config, 'paypal_pro');
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
        $arrData['artist_category'] = $this->Usermodel->getArtistCategoryByUser();
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
                if (is_array($filename)) {

                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('profile_message', $filename['error']);
                    redirect('profile/update');
                }

                if ($arrData['user_profile'][0]->profile_picture != '') {
                    if (file_exists(getcwd() . '/uploads/profile_picture/' . $arrData['user_profile'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/' . $arrData['user_profile'][0]->profile_picture);
                    if (file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['user_profile'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['user_profile'][0]->profile_picture);
                    if (file_exists(getcwd() . '/uploads/profile_picture/medium_' . $arrData['user_profile'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/medium_' . $arrData['user_profile'][0]->profile_picture);
                    if (file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['user_profile'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['user_profile'][0]->profile_picture);
                }
            }
            if ($_FILES['cover_picture']['name'] != '') {

                $cover_imagename = $this->upload_cover_image('cover_picture');
                if (is_array($cover_imagename)) {
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
            if (isset($artist_registry) && !empty($artist_registry)) {
                $this->db->delete('artist_registry', array('user_id' => $sessionData['id']));
                foreach ($artist_registry as $key => $v) {
                    $this->db->insert('artist_registry', ['user_id' => $sessionData['id'], 'battle_category' => $artist_registry[$key], 'created_on' => date('Y-m-d H:i:s')]);
                }
            }
            /* end of add remove artist registry table */

            $data = array(
                'firstname' => ucfirst(strtolower($this->input->post('fname'))),
                'lastname' => ucfirst(strtolower($this->input->post('lname'))),
                'gender' => $this->input->post('gender'),
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
        if ($arrData['user_profile'][0]->email != NULL && $arrData['user_profile'][0]->password != NULL) {
            redirect('home');
        }
        $arrData['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);

        if ($arrData['user_profile'][0]->email == NULL)
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == true) {
            $data = ['password' => md5($this->input->post('password'))];
            if ($this->input->post('email') != NULL)
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
            if ($file_type[0] == 'image' && $mediaArray['is_image'] == 1) {
                // $data = array('upload_data' => $this->upload->data());
                // $thumbnail = $data['upload_data']['raw_name'].'_thumb'.$data['upload_data']['file_ext'];
                $this->resize_image($media_file);
                $this->resize_image_130x130($media_file);
                $this->big_resize_image($media_file);
                return $media_file;
            } else {
                if (file_exists(getcwd() . '/uploads/profile_picture/' . $media_file))
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
            if ($file_type[0] == 'image' && $mediaArray['is_image'] == 1) {
                $this->cover_resize_image($media_file);
                return 'resize_' . $media_file;
            } else {
                if (file_exists(getcwd() . '/uploads/cover_picture/' . $media_file))
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
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;

        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/profile_picture/' . $image_name);
                if (isset($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $config['rotation_angle'] = '180';
                            break;
                        case 6:
                            $config['rotation_angle'] = '270';
                            break;
                        case 8:
                            $config['rotation_angle'] = '90';
                            break;
                    }
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                }
            } catch (Exception $e) {
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
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;

        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/profile_picture/' . $image_name);
                if (isset($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $config['rotation_angle'] = '180';
                            break;
                        case 6:
                            $config['rotation_angle'] = '270';
                            break;
                        case 8:
                            $config['rotation_angle'] = '90';
                            break;
                    }
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                }
            } catch (Exception $e) {
                //echo 'Message: ' .$e->getMessage();
            }
        }

        $config['create_thumb'] = FALSE;
        $config['new_image'] = 'uploads/profile_picture/130x130/' . $image_name;
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
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/profile_picture/' . $image_name;

        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/profile_picture/' . $image_name);
                if (isset($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $config['rotation_angle'] = '180';
                            break;
                        case 6:
                            $config['rotation_angle'] = '270';
                            break;
                        case 8:
                            $config['rotation_angle'] = '90';
                            break;
                    }
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                }
            } catch (Exception $e) {
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
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/cover_picture/' . $image_name;

        if (function_exists('exif_read_data')) {
            try {
                $exif = @exif_read_data('uploads/cover_picture/' . $image_name);
                if (isset($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $config['rotation_angle'] = '180';
                            break;
                        case 6:
                            $config['rotation_angle'] = '270';
                            break;
                        case 8:
                            $config['rotation_angle'] = '90';
                            break;
                    }
                    $this->image_lib->initialize($config);
                    $this->image_lib->rotate();
                }
            } catch (Exception $e) {
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
        if ($this->image_lib->resize()) {
            unlink(getcwd() . '/uploads/cover_picture/' . $image_name);
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
        if (!isset($data['user_profile']) || empty($data['user_profile'])) {
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
        if(empty($memberships)) {
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('membership_message', "Invalid user membership. Unable to upgrade. Please try again");
            $this->session->set_flashdata('activetab', 'memberships');
            redirect('profile/');
        }

        if($membership_id == 2) {
            $this->UserMemberships->updatePremiumUser($coins);
        }

        /* update user membership */
        $update_user_memberships = array('status' => '0');
        $this->UserMemberships->update_user_membership($update_user_memberships, $user_id);
        
        /* update user type */
        $this->UserMemberships->update_user_type($membership_id, $user_id);

        /* add user membership */
        $user_memberships_info['user_id'] = $user_id;
        $user_memberships_info['memberships_id'] = $membership_id;
        $user_memberships_info['status'] = '1';
        $status = $this->UserMemberships->add($user_memberships_info);
        if ($status) {
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
            
            $mediaConfig['upload_path'] = $this->config->item('library_media_path');
            $mediaConfig['allowed_types'] = '*';
            $mediaConfig['max_size']	= '1024480';
            $mediaConfig['remove_spaces']=TRUE;
            $mediaConfig['encrypt_name'] = TRUE;
            
            $mediaData = $this->common_lib->upload_custom_media('media', $mediaConfig);
            if (array_key_exists("error",$mediaData)) {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('song_message', $mediaData['error']);
                $this->session->set_flashdata('activetab', 'library');
                redirect('profile/#library');
            } else {
                $filename = $mediaData['file_name'];
                $file_type = explode('/', $mediaData['file_type']);
//                echo '<pre>';                print_r($file_type); die;
                if($file_type[0] == 'video') {
                    $media_type = 2; // for video
                    $conv_file_name = 'con_'.time().'.mp4';
                    $cont_file_path = $this->config->item('library_media_path').$conv_file_name;
                    shell_exec("/usr/local/bin/ffmpeg -i ".$this->config->item('library_media_path').$filename." -y -vcodec libx264 -crf 18 -pix_fmt yuv420p -qcomp 0.8 -preset medium -acodec aac -strict -2 -b:a 400k -x264-params ref=4 -profile:v baseline -level 3.1 -movflags +faststart ".$cont_file_path);
                    if(file_exists($this->config->item('library_media_path').$filename)) { unlink($this->config->item('library_media_path').$filename); } 
                    $filename = $conv_file_name;

                } else if($file_type[0] == 'audio') {
                    $media_type = 1; // for voice
                    $conv_file_name = 'con_'.time().'.mp3';
                    $cont_file_path = $this->config->item('library_media_path').$conv_file_name;
                    shell_exec("/usr/local/bin/ffmpeg -i ".$this->config->item('library_media_path').$filename." -f mp3 ".$cont_file_path." 2>&1");
                    if(file_exists($this->config->item('library_media_path').$filename)) { unlink($this->config->item('library_media_path').$filename); } 
                    $filename = $conv_file_name;

                } else {
                    if(file_exists($this->config->item('library_media_path').$filename)) {
                        unlink($this->config->item('library_media_path').$filename); } 
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('song_message', 'Unable to add. Please try again');
                    $this->session->set_flashdata('activetab', 'library');
                    redirect('profile/#library');
                }
                if(!file_exists($this->config->item('library_media_path').$filename)) {
                    $this->session->set_flashdata('class', 'alert-danger');
                    $this->session->set_flashdata('song_message', 'Unable to add. Please try again');
                    $this->session->set_flashdata('activetab', 'library');
                    redirect('profile/#library');
                }
                copy($this->config->item('library_media_path').$filename, $this->config->item('battle_media_path').$filename);

                //save file to users library first
                $library_data = array(
                    'user_id' => $user_id,
                    'title' => $this->input->post('title'),
                    'media' => $filename,
                    'file_type' => $media_type,
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
            }
        } else {
            if ($this->input->post('Submit') == 'Create') {
                //$this->session->set_flashdata('class', 'alert-success');
                //$this->session->set_flashdata('profile_message', "Profile has been updated successfully");
                $this->session->set_flashdata('activetab', 'library');
            }

            $this->load->view('profile_edit', $data);
        }
    }

    public function delete_library($libraryId = NULL) {
        $userId = $this->session->userdata('logged_in')['id'];
        $librartDtl = $this->library->getSongById(base64_decode($libraryId), $userId);

        if (!empty($librartDtl)) {

            $this->db->delete('song_library', array('song_id' => $librartDtl['song_id']));

            if (file_exists(getcwd() . '/' . $this->config->item('library_media_path') . $librartDtl['media']))
                unlink(getcwd() . '/' . $this->config->item('library_media_path') . $librartDtl['media']);

            if (file_exists(getcwd() . '/' . $this->config->item('battle_media_path') . $librartDtl['media']))
                unlink(getcwd() . '/' . $this->config->item('battle_media_path') . $librartDtl['media']);

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
                if (is_array($filename)) {
                    die();
                }

                if ($arrData['userdata'][0]->profile_picture != '' && file_exists(getcwd() . '/uploads/profile_picture/' . $arrData['userdata'][0]->profile_picture)) {
                    unlink(getcwd() . '/uploads/profile_picture/' . $arrData['userdata'][0]->profile_picture);
                    if (file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['userdata'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/thumb_' . $arrData['userdata'][0]->profile_picture);
                    if (file_exists(getcwd() . '/uploads/profile_picture/medium_' . $arrData['userdata'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/medium_' . $arrData['userdata'][0]->profile_picture);
                    if (file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['userdata'][0]->profile_picture))
                        unlink(getcwd() . '/uploads/profile_picture/130x130/' . $arrData['userdata'][0]->profile_picture);
                }
            }
            /* if ($_FILES['cover_picture']['name'] != '') {
              if ($arrData['userdata'][0]->cover_picture != '') {
              unlink(getcwd() . '/uploads/cover_picture/' . $arrData['userdata'][0]->cover_picture);
              }
              $cover_imagename = $this->upload_cover_image('cover_picture');
              } */

            //print_r($filename);
            //die;
            $data = array(
                'profile_picture' => $filename,
                'cover_picture' => $cover_imagename,
            );

            $status = $this->Usermodel->update_user_profile($sessionData['id'], $data);
            if ($status) {
                echo base_url() . 'uploads/profile_picture/130x130/' . $filename;
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

            if ($_FILES['coverImage']['name'] != '') {

                $cover_imagename = $this->upload_cover_image('coverImage');
                if (is_array($cover_imagename)) {
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
                echo base_url() . 'uploads/cover_picture/' . $cover_imagename;
            } else {
                
            }
        }
    }

    public function premiumsuccess() {
        $userId = $this->session->userdata('logged_in')['id'];
        //get the transaction data
        $token = $this->input->get('token');

        //Get express checkout details
        $PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($token);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            //$errors = array('Errors'=>$PayPalResult['ERRORS']);
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('message', $PayPalResult['ERRORS']);
            redirect(base_url('user/premiumcancel'));
        } else {
            // Success block
            //[CUSTOM] => one-samiran.brainium@gmail.com|1|2|3|8|9
            //echo '<pre>'; print_r($PayPalResult); die;

            if (isset($PayPalResult['BILLINGAGREEMENTACCEPTEDSTATUS']) && $PayPalResult['BILLINGAGREEMENTACCEPTEDSTATUS'] == 1 && $PayPalResult['PAYERSTATUS'] == 'verified') {
                $buyerData = ['TOKEN' => $PayPalResult['TOKEN'], 'PAYERID' => $PayPalResult['PAYERID'], 'EMAIL' => $PayPalResult['EMAIL'], 'NAME' => $PayPalResult['FIRSTNAME'] . ' ' . $PayPalResult['LASTNAME'], 'BUSINESS' => isset($PayPalResult['BUSINESS']) ? $PayPalResult['BUSINESS'] : ''];

                $profileDetails = $this->Create_recurring_payments_profile($buyerData);
//                echo '<pre>'; print_r($profileDetails); die;
                
                if (!empty($profileDetails) && isset($profileDetails['PROFILEID'])) {
                    /* [PROFILESTATUS] => ActiveProfile */

                    /* update user membership */
                    $this->UserMemberships->update_user_membership(['status' => 0], $userId);
                    
                    // Insert membership table
                    $memberships_info['user_id'] = $userId;
                    $memberships_info['memberships_id'] = 2;
                    $memberships_info['status'] = 1;
                    $this->UserMemberships->add($memberships_info);
                    
                    /* update user type */
                    $this->UserMemberships->update_user_type(2, $userId);

                    // Insert payment details into 
                    $recurring_data = ['user_id' => $userId, 'profile_id' => $profileDetails['PROFILEID'],
                        'token' => $profileDetails['REQUESTDATA']['TOKEN'], 'payer_id' => $profileDetails['REQUESTDATA']['PAYERID'],
                        'payer_name' => $profileDetails['REQUESTDATA']['SUBSCRIBERNAME'], 'payer_email' => $profileDetails['REQUESTDATA']['EMAIL'],
                        'business' => isset($profileDetails['REQUESTDATA']['BUSINESS']) ? $profileDetails['REQUESTDATA']['BUSINESS'] : '', 'payer_status' => $profileDetails['REQUESTDATA']['PAYERSTATUS'],
                        'amount' => $profileDetails['REQUESTDATA']['AMT'], 'currency_code' => $profileDetails['REQUESTDATA']['CURRENCYCODE'],
                        'profile_start_date' => $profileDetails['REQUESTDATA']['PROFILESTARTDATE'], 'profile_status' => 1, 'created_on' => date('Y-m-d H:i:s')];
                    $this->db->insert('recurring_payments', $recurring_data);
                    
                    //Change value in session    
                    $sess = $this->session->userdata('logged_in');
                    $sess['membership_id'] = 2;
                    $sess['membership_name'] = 'Premium membership';
                    $this->session->set_userdata('logged_in', $sess);

                    $this->session->set_flashdata('class', 'alert-success');
                    $this->session->set_flashdata('membership_message', "Membership has been upgraded successfully");
                    
                    $this->session->set_flashdata('activetab', 'memberships');
                    redirect('profile/');
                    
                    /* $data['payment_amt'] = $PayPalResult['AMT'];
                    $data['currency_code'] = $PayPalResult['CURRENCYCODE'];
                    $data['status'] = "Active";
                    //pass the transaction data to view
                    $data['middle'] = 'payment_success';
                    $this->session->set_flashdata('success', 'Please login to continue');
                    $this->load->view('templates/template', $data); */
                }
            } else {
                $this->session->set_flashdata('class', 'alert-danger');
                $this->session->set_flashdata('message', 'Payment Unverified');
                redirect(base_url('user/premiumcancel'));
            }
        }
    }

    public function Create_recurring_payments_profile($buyerData = []) {
        /* echo gmdate('Y-m-d H:i:s'); 
          echo date("Y-d-mTG:i:sz",  strtotime(date('Y-m-d H:i:s')));
          gmdate('Y-m-d H:i:s', strtotime("+30 days"))
          die; */

        $CRPPFields = array(
            'token' => $buyerData['TOKEN'], // Token returned from PayPal SetExpressCheckout.  Can also use token returned from SetCustomerBillingAgreement.
        );

        $ProfileDetails = array(
            'subscribername' => $buyerData['NAME'], // Full name of the person receiving the product or service paid for by the recurring payment.  32 char max.
            'profilestartdate' => gmdate('Y-m-d H:i:s', strtotime("+30 days")), // Required.  The date when the billing for this profiile begins.  Must be a valid date in UTC/GMT format.
            'profilereference' => ''         // The merchant's own unique invoice number or reference ID.  127 char max.
        );

        $ScheduleDetails = array(
            'desc' => 'BattlemeMembership', // Required.  Description of the recurring payment.  This field must match the corresponding billing agreement description included in SetExpressCheckout.
            'maxfailedpayments' => '', // The number of scheduled payment periods that can fail before the profile is automatically suspended.  
            'autobilloutamt' => ''     // This field indiciates whether you would like PayPal to automatically bill the outstanding balance amount in the next billing cycle.  Values can be: NoAutoBill or AddToNextBilling
        );

        $BillingPeriod = array(
            'trialbillingperiod' => '',
            'trialbillingfrequency' => '',
            'trialtotalbillingcycles' => '',
            'trialamt' => '',
            'billingperiod' => 'Month', // Required.  Unit for billing during this subscription period.  One of the following: Day, Week, SemiMonth, Month, Year
            'billingfrequency' => 1, // Required.  Number of billing periods that make up one billing cycle.  The combination of billing freq. and billing period must be less than or equal to one year. 
            'totalbillingcycles' => 0, // the number of billing cycles for the payment period (regular or trial).  For trial period it must be greater than 0.  For regular payments 0 means indefinite...until canceled.  
            'amt' => 10, // Required.  Billing amount for each billing cycle during the payment period.  This does not include shipping and tax. 
            'currencycode' => 'USD', // Required.  Three-letter currency code.
            'shippingamt' => '', // Shipping amount for each billing cycle during the payment period.
            'taxamt' => ''      // Tax amount for each billing cycle during the payment period.
        );

        $ActivationDetails = array(
            'initamt' => '', // Initial non-recurring payment amount due immediatly upon profile creation.  Use an initial amount for enrolment or set-up fees.
            'failedinitamtaction' => '', // By default, PayPal will suspend the pending profile in the event that the initial payment fails.  You can override this.  Values are: ContinueOnFailure or CancelOnFailure
        );

        $CCDetails = array(
            'creditcardtype' => '', // Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
            'acct' => '', // Required.  Credit card number.  No spaces or punctuation.  
            'expdate' => '', // Required.  Credit card expiration date.  Format is MMYYYY
            'cvv2' => '', // Requirements determined by your PayPal account settings.  Security digits for credit card.
            'startdate' => '', // Month and year that Maestro or Solo card was issued.  MMYYYY
            'issuenumber' => ''       // Issue number of Maestro or Solo card.  Two numeric digits max.
        );

        $PayerInfo = array(
            'email' => $buyerData['EMAIL'], // Email address of payer.
            'payerid' => $buyerData['PAYERID'], // Unique PayPal customer ID for payer.
            'payerstatus' => 'verified', // Status of payer.  Values are verified or unverified
            'business' => $buyerData['BUSINESS']                    // Payer's business name.
        );

        $PayerName = array(
            'salutation' => '', // Payer's salutation.  20 char max.
            'firstname' => '', // Payer's first name.  25 char max.
            'middlename' => '', // Payer's middle name.  25 char max.
            'lastname' => '', // Payer's last name.  25 char max.
            'suffix' => ''        // Payer's suffix.  12 char max.
        );

        $BillingAddress = array(
            'street' => '', // Required.  First street address.
            'street2' => '', // Second street address.
            'city' => '', // Required.  Name of City.
            'state' => '', // Required. Name of State or Province.
            'countrycode' => '', // Required.  Country code.
            'zip' => '', // Required.  Postal code of payer.
            'phonenum' => ''      // Phone Number of payer.  20 char max.
        );

        $ShippingAddress = array(
            'shiptoname' => '', // Required if shipping is included.  Person's name associated with this address.  32 char max.
            'shiptostreet' => '', // Required if shipping is included.  First street address.  100 char max.
            'shiptostreet2' => '', // Second street address.  100 char max.
            'shiptocity' => '', // Required if shipping is included.  Name of city.  40 char max.
            'shiptostate' => '', // Required if shipping is included.  Name of state or province.  40 char max.
            'shiptozip' => '', // Required if shipping is included.  Postal code of shipping address.  20 char max.
            'shiptocountry' => '', // Required if shipping is included.  Country code of shipping address.  2 char max.
            'shiptophonenum' => ''           // Phone number for shipping address.  20 char max.
        );

        $PayPalRequestData = array(
            'CRPPFields' => $CRPPFields,
            'ProfileDetails' => $ProfileDetails,
            'ScheduleDetails' => $ScheduleDetails,
            'BillingPeriod' => $BillingPeriod,
            'ActivationDetails' => $ActivationDetails,
            'CCDetails' => $CCDetails,
            'PayerInfo' => $PayerInfo,
            'PayerName' => $PayerName,
            'BillingAddress' => $BillingAddress,
            'ShippingAddress' => $ShippingAddress
        );

        $PayPalResult = $this->paypal_pro->CreateRecurringPaymentsProfile($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            //$errors = array('Errors'=>$PayPalResult['ERRORS']);
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('message', $PayPalResult['ERRORS']);
            redirect(base_url('user/premiumcancel'));
        } else {
            return $PayPalResult;
            // Successful call.  Load view or whatever you need to do here.	
        }
    }

    public function premiumipn() {

        $paypalInfo = $this->input->post();
        $this->email->from('noreply@mydevfactory.com', 'Your Battleme Team');
        $this->email->to('samiran.brainium@gmail.com');
        $this->email->set_mailtype("html");
        $this->email->subject('Test instant payment notification');
        $this->email->message(json_encode($paypalInfo));
        $this->email->send();

        die();

        //get the transaction data
        $postData = $this->input->post();
        if (!empty($postData) && isset($postData['TOKEN'])) {

            //Get express checkout details
            $PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($postData['TOKEN']);

            if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
                $errors = array('Errors' => $PayPalResult['ERRORS']);
            } else {
                echo '<pre>';
                print_r($PayPalResult);
                // Successful call.  Load view or whatever you need to do here.	
            }
        }





        // Update invitation table 
        //$this->db->update('invitation', ['friend_user'=>$user_info[0]->id], array('friend_email' =>  $this->input->post('email')));
        // End of update invitation table

        /* $battle_category = $this->input->post('battle_category');
          if(!empty($battle_category)) {
          foreach ($battle_category as $k=>$catVal){
          if($battle_category[$k] > 0)
          $this->db->insert('artist_registry', ['user_id'=>$user_info[0]->id, 'battle_category'=>$battle_category[$k],'created_on'=>date('Y-m-d H:i:s')]);
          }
          } */

        //paypal return transaction details array
        $paypalInfo = $this->input->post();

        $data['product_id'] = $paypalInfo["item_number"];
        $data['txn_id'] = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["payment_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;
        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

        //check whether the payment is verified
        if (eregi("VERIFIED", $result)) {
            //insert the transaction data into the database
            $this->load->model('wallet_model', 'wallet');
            $transactionId = $this->wallet->insertTransaction($data);

            $user = unserialize($paypalInfo['custom']);

            /* add user_memberships */

            $result = $this->Usermodel->checkuser($user);

            $user_info = $this->Usermodel->check_user_data($user['email']);
            $user_memberships_info['user_id'] = $user_info[0]->id;
            $user_memberships_info['memberships_id'] = 2;
            $user_memberships_info['status'] = '1';
            $this->UserMemberships->add($user_memberships_info);

            $this->wallet->updateTransaction(['user_id' => $user_info[0]->id], $transactionId);

            $this->load->model('Sendmailmodel');
            $subject = "registration for battleme was successful";
            $body = "Hello <b>" . $user['firstname'] . "</b><br><br>";
            $body .= "You successfully created account for battleme.<br>";
            //  $body .= "your pasword for same is: <b>" . $this->input->post('password1') . "</b><br><br>";
            $body .= "Thank you";
            $this->Sendmailmodel->sendmail($user['email'], $subject, $body);
        }
    }

}
