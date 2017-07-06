<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * Common Library Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Common Methods
 * @author	Chhanda Rane
 */
class Common_lib {

    /**
     * getCaptcha
     *
     * getCaptcha
     *
     * @access	public
     * @param	none
     * @return	array
     */
    function getCaptcha() {
        $CI_OBJ = & get_instance();
        $CI_OBJ->load->library('captcha');
        $CI_OBJ->load->library('form_validation');
        $CI_OBJ->form_validation->set_rules('captext', 'Captcha', 'trim|required|callback__check_captcha');
        $captcha = $CI_OBJ->captcha->generateCaptcha();
        //$data['capimage']= $captcha['image'] ;

        $newdata = array(
            'captchaWord' => $captcha['word'],
            'captchaTime' => $captcha['time'],
        );

        $CI_OBJ->session->set_userdata($newdata);
        return $captcha['image'];
    }

   
       // callback function to check the captcha
    function _check_captcha($input) {
        $CI_OBJ = & get_instance();
        if ($CI_OBJ->session->userdata('captchaWord') != $input) {
            // set the validation error
            $CI_OBJ->form_validation->set_message('_check_captcha', 'The captcha entered is incorrect.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    

    public function upload_image($fieldName = "", $configArr = array(), $thumbnailArr = array(), $resize = "0") {
        $CI_OBJ = & get_instance();
        $CI_OBJ->load->library('image_lib');
        $CI_OBJ->image_lib->clear();
        $CI_OBJ->load->library('upload');
        //set right permission to folder
        // set_write_permission($configArr['upload_path']);
        $CI_OBJ->upload->initialize($configArr);

        if ($CI_OBJ->upload->do_upload($fieldName)) {
            $image_data = $CI_OBJ->upload->data();

            if ($configArr['isThumb'] || ($resize)) {
               // set_write_permission($thumbnailArr['thumbFilePath']);
                if ($thumbnailArr['width'] == "")
                    $thumbnailArr['width'] = 150;

                if ($thumbnailArr['height'] == "")
                    $thumbnailArr['height'] = 150;

                if (!isset($thumbnailArr['maintain_ratio']) OR $thumbnailArr['maintain_ratio'] == "")
                    $thumbnailArr['maintain_ratio'] = true;

                $thumbConfigArr = array(
                    'source_image' => $image_data['full_path'],
                    'new_image' => $thumbnailArr['thumbFilePath'],
                    'maintain_ratio' => $thumbnailArr['maintain_ratio'],
                    'width' => $thumbnailArr['width'],
                    'height' => $thumbnailArr['height']
                );
                //set_write_permission($thumbConfigArr['new_image']);
                $CI_OBJ->image_lib->initialize($thumbConfigArr);
		 set_write_permission($thumbnailArr['thumbFilePath']);

                if ($CI_OBJ->image_lib->resize())
                    $error = array('error' => $CI_OBJ->image_lib->display_errors());

               
            }

            return $image_data["file_name"];
        }
        else {

            $error = array('error' => $CI_OBJ->upload->display_errors());
            return $error;
        }
    }
    
    public function upload_media($fieldName = "", $configArr = array())
    {
	$CI_OBJ = & get_instance();
	$CI_OBJ->load->library('upload');
	$CI_OBJ->upload->initialize($configArr);
	ini_set('upload_max_filesize', '30M');
	//ini_set('post_max_size','30M');
	ini_set('max_execution_time','200');
	 if(!$CI_OBJ->upload->do_upload($fieldName)) {
	     $CI_OBJ->upload->display_errors('<div>', '</div>');
	   $error = array('error' => $CI_OBJ->upload->display_errors());
            return $error;
	} 
	else
	{
	     $file_data = $CI_OBJ->upload->data();
	     return $file_data["file_name"];
	}
    }

}
