<?php

/**
 * this class has function to send emails to user
 * @package battle
 * @subpackage model
 * @author 
 * */
class Sendmailmodel extends CI_Model {

    /**
     * __construct
     * 
     * this function loads the database
     * @access public
     * @return void
     * @author 
     * */
    public function __construct() {
        $this->load->database();
    }

    /**
     * sendmail
     * 
     * this function sends mail to user.
     * @access public
     * @param $emailis
     * @param $subject
     * @param $body
     * @return boolean
     * @author 
     * */
    public function sendmail($emailid, $subject, $body) {
        $this->load->library('Classphpmailer');
        $this->load->library('Classsmtp');
        $mail = new Classphpmailer();
//        $mail->isSMTP();
//        $mail->Host = 'smtp.wwindia.com';
//        $mail->SMTPAuth = true;
//        $mail->Username = 'tushar.patil@wwindia.com';
//        $mail->Password = 'Tush@1992';
//        $mail->Port = 25;
        $mail->From = 'info@battleme.com';
        $mail->FromName = 'Battleme Info';
        $mail->addAddress($emailid);

        $mail->addReplyTo($emailid);

        $mail->WordWrap = 50;
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;

        if (!$mail->send()) {
            return $mail->ErrorInfo;
        }
        return true;
    }

}
