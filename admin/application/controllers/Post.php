<?php

/**
 * this class has functions that perform login operation
 * @package battle
 * @subpackage controller
 * @author 
 * */
class Post extends CI_Controller {

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
//        if (empty($data)) {
//            $currenturl = current_url();
//            $this->session->set_userdata('currenturl', $currenturl);
//            redirect('user');
//        }
        $this->load->model('Postmodel');
        $this->load->library('form_validation');
        // $this->load->model('Usermodel');
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function index() {
        
    }

    /**
     * addpost function
     *
     * @return void
     * @author 
     * */
    public function addpost($userid) {
        $myid = $this->session->userdata('logged_in')['id'];
        $validate_rule = array(
            array(
                'field' => 'post',
                'label' => 'Post',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($validate_rule);
        if ($this->form_validation->run() == False) {
            if ($myid === $userid) {
                redirect('profile');
            } else {
                redirect('profile/view/' . $userid);
            }
        } else {

            $data = array(
                'content' => $this->input->post('post'),
                'subject_id' => $userid,
                'object_id' => $myid,
                'created_on' => date("Y-m-d H:i:s", time()),
                'updated_on' => date("Y-m-d H:i:s", time())
            );
            $this->Postmodel->addpost($data);
            $msg = "posted to my wall";
            add_notification($userid, $myid, $msg,'someone_wrote');
            if ($myid === $userid) {
                redirect('profile');
            } else {
                redirect('profile/view/' . $userid);
            }
        }
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
            if ($myid === $userid) {
                redirect('profile');
            } else {
                redirect('profile/view/' . $userid);
            }
        } else {

            $comment = $this->input->post('comment');
            $data = array(
                'post_id' => $postid,
                'user_id' => $myid,
                'comment' => $comment,
                'created_on' => date("Y-m-d H:i:s", time()),
            );
            $this->Postmodel->addcomment($data);
            if ($myid === $userid) {
                 $msg = "recommended on your comment";
                add_notification($userid, $myid, $msg,'someone_wrote');
                redirect('profile');
            } else {
                 $msg = "commented on your wall";
                add_notification($userid, $myid, $msg,'someone_wrote');
                redirect('profile/view/' . $userid);
            }
        }
    }

	function addPostComment($postid, $userid){
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
            if ($myid === $userid) {
                redirect('profile');
            } else {
                redirect('profile/view/' . $userid);
            }
        } else {

            $comment = $this->input->post('comment');
            $data = array(
                'post_id' => $postid,
                'user_id' => $myid,
                'comment' => $comment,
                'created_on' => date("Y-m-d H:i:s", time())
            );
            $this->Postmodel->addcomment($data);
            $msg = "commented on your post";
            add_notification($userid, $myid, $msg);
            if ($myid === $userid) {
                redirect('profile');
            } else {
                redirect('home/post');
            }
        }
	}

    public function addlike($postid, $userid, $frndid)
    {
        $data = array(
            'post_id' => $postid,
            'user_id' => $userid,
            'created_on' => date("Y-m-d H:i:s", time())
        );
        $message = $this->Postmodel->addlike($data, $postid, $userid);
        
        if ($message != 'dont_send_notification') {
            $myid = $this->session->userdata('logged_in')['id'];
            $msg = "liked your post";
            add_notification($frndid,$myid, $msg);
        }
	else
	    print $message;
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
                }
                $this->session->set_flashdata('class' , 'alert-success');
                $this->session->set_flashdata('post_message' , 'Your post has been deleted successfully');
                redirect('profile');
            }

            $this->session->set_flashdata('class' , 'alert-danger');
            $this->session->set_flashdata('post_message' , 'Please try again');
            redirect('profile');
        }
        
        $this->session->set_flashdata('class' , 'alert-danger');
        $this->session->set_flashdata('post_message' , 'Please try again');
        redirect('profile');
    }
}
