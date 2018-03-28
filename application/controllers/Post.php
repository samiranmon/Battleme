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
            
            $media_file = '';
            $media_error = 0;
            $media_type = 0;
            
            if(!empty($_FILES['media_post']['name'])) {
                $config['upload_path'] = $this->config->item('post_media_path');
                $config['allowed_types'] = '*';
                $config['max_size']	= '1024480';
                $config['max_width']  = 0;
                $config['max_height']  = 0;
                $config['remove_spaces']=TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);

                if (! $this->upload->do_upload('media_post')) {
                    $media_error = 1;
                    $data['post_media_error'] = $this->upload->display_errors();
                    //echo '<pre>'; print_r($this->upload->data());
                    $this->session->set_flashdata('class' , 'alert-danger');
                    $this->session->set_flashdata('post_message' , $data['post_media_error']);
                    if ($myid === $userid) {
                        redirect('profile');
                    } else {
                        redirect('profile/view/' . $userid);
                    }
                } else { 
                    $mediaArray = $this->upload->data();
                    $media_file = $mediaArray['file_name'];

                     $file_type = explode('/', $mediaArray['file_type']);
                    if($file_type[0] == 'video') {
                        $media_type = 2; // for video

                        $conv_file_name = 'con_'.time().'.mp4';
                        $cont_file_path = $this->config->item('post_media_path').$conv_file_name;
                        shell_exec("/usr/local/bin/ffmpeg -i ".$this->config->item('post_media_path').$media_file." -y -vcodec libx264 -crf 18 -pix_fmt yuv420p -qcomp 0.8 -preset medium -acodec aac -strict -2 -b:a 400k -x264-params ref=4 -profile:v baseline -level 3.1 -movflags +faststart ".$cont_file_path);
                        if(file_exists($this->config->item('post_media_path').$media_file)) { unlink($this->config->item('post_media_path').$media_file); } 
                        $media_file = $conv_file_name;

                    } else if($file_type[0] == 'audio') {
                        $media_type = 3; // for voice
                        $conv_file_name = 'con_'.time().'.mp3';
                        $cont_file_path = $this->config->item('post_media_path').$conv_file_name;
                        shell_exec("/usr/local/bin/ffmpeg -i ".$this->config->item('post_media_path').$media_file." -f mp3 ".$cont_file_path." 2>&1");
                        if(file_exists($this->config->item('post_media_path').$media_file)) { unlink($this->config->item('post_media_path').$media_file); } 
                        $media_file = $conv_file_name;

                    } else if($file_type[0] == 'image' && $mediaArray['is_image'] == 1) {
                        $media_type = 1;
                        // for resize the media image
                        $this->resize_image($media_file);
                        $this->medium_resize_image($media_file);

                        if(file_exists($this->config->item('post_media_path').$media_file)) {
                            unlink($this->config->item('post_media_path').$media_file);
                        }
                    } else {
                        if(file_exists($this->config->item('post_media_path').$media_file)) {
                            unlink($this->config->item('post_media_path').$media_file); } 
                        
                        $this->session->set_flashdata('class' , 'alert-danger');
                        $this->session->set_flashdata('post_message' , 'File type is not allowed!');
                        if ($myid === $userid) {
                            redirect('profile');
                        } else { redirect('profile/view/' . $userid); }
                    } 

                    if(!file_exists($this->config->item('post_media_path').$media_file)) {
                        $this->session->set_flashdata('class', 'alert-danger');
                        $this->session->set_flashdata('post_message', 'Failed try again!');
                        if ($myid === $userid) {
                            redirect('profile');
                        } else { redirect('profile/view/' . $userid); }
                    }
                }
            }
            
            if($media_error == 0) {
                $post_content = $this->input->post('post');
                $post_content = str_replace('https://', '', $post_content); 
                $search     = ['/www.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi', '/m.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi', '/www.m.youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi'];
                $replace    = "<iframe width='455' height='315' src='https://youtube.com/embed/$1' frameborder='0' allowfullscreen></iframe>";
                $post_content = preg_replace($search,$replace,$post_content); 

                $data = array(
                    'content' => $post_content,
                    'subject_id' => $userid,
                    'object_id' => $myid,
                    'media' => $media_file,
                    'media_type' => $media_type,
                    'created_on' => date("Y-m-d H:i:s", time()),
                    'updated_on' => date("Y-m-d H:i:s", time())
                );
                $this->Postmodel->addpost($data);
                $msg = "posted to my wall";
                add_notification($userid, $myid, $msg,'someone_wrote');
                if ($myid === $userid) {
                    $this->session->set_flashdata('class' , 'alert-success');
                    $this->session->set_flashdata('post_message' , 'Your message has been posted successfully');
                    redirect('profile');
                } else {
                    $this->session->set_flashdata('class' , 'alert-success');
                    $this->session->set_flashdata('post_message' , 'Your message has been posted successfully');
                    redirect('profile/view/' . $userid);
                }
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
            $post_type = 'post_like';
            add_notification($frndid,$myid, $msg, $post_type, $postid);
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
                    if(file_exists($this->config->item('post_media_path').'thumb_'.$rsult_ack['media'])) {
                        unlink($this->config->item('post_media_path').'thumb_'.$rsult_ack['media']);
                    }
                    if(file_exists($this->config->item('post_media_path').'medium_'.$rsult_ack['media'])) {
                        unlink($this->config->item('post_media_path').'medium_'.$rsult_ack['media']);
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
        //$exif = @exif_read_data($file_path);
        $exif = @file_get_contents($file_path);
        
        //echo $file_path.'<pre>';        print_r($exif); die;

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
    
    
}
