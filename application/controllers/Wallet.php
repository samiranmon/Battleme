<?php 
 /**
  * Description of Wallet
  * 
  */
 class Wallet extends CI_Controller {
     //put your code here
     public $sessionData ;
     public function __construct() {
	 parent::__construct();
         
	 $this->load->model('Usermodel' , 'user');
         $this->load->model('Song_library_model', 'library');
	 $this->load->model('Notificationmodel' , 'notification');
         $this->load->model('wallet_model' , 'wallet');
         $this->load->model('Friendsmodel');
	 $this->load->library('Common_lib');
	 $this->sessionData = get_session_data();
         
         $this->load->library('Paypal_lib');
         $this->load->library('email');
     }
     
     /**
     * index function
     * @return void
     * @param 
     * */
     public function index()
     {
         //Check login
         $s = $this->session->userdata('logged_in');
            if(empty($s)) { $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');}        
         
        if($this->input->post('Submit'))
	 {
            foreach($this->input->post() as $key => $val){
             $$key = $val; }
            
            /*if(!is_int($amount) || $amount < 1){die($amount);
                redirect('wallet');
            }*/
            
	    $sessionData   = $this->sessionData;
             
            //Set variables for paypal form
            $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
            $paypalID = 'inder.bajaj-seller@wwindia.com'; //business email
            $returnURL = base_url().'wallet/success'; //payment success url
            $cancelURL = base_url().'wallet/cancel'; //payment cancel url
            $notifyURL = base_url().'wallet/ipn'; //ipn url

            //get particular product data
            $userID = $sessionData['id']; //current user id
            $logo = base_url().'assets/images/codexworld-logo.png';

            $this->paypal_lib->add_field('business', $paypalID);
            $this->paypal_lib->add_field('return', $returnURL);
            $this->paypal_lib->add_field('cancel_return', $cancelURL);
            $this->paypal_lib->add_field('notify_url', $notifyURL);
            $this->paypal_lib->add_field('item_name', 'coins');
            $this->paypal_lib->add_field('custom', $userID);
            $this->paypal_lib->add_field('item_number',  1);
            $this->paypal_lib->add_field('amount',  $amount);        
            $this->paypal_lib->image($logo);

            $this->paypal_lib->paypal_auto_form();
         }else{
             $user           = $this->user->get_user_by_id();
             $data['user']   = $user[0];
             $data['middle'] = 'wallet';
             $data['div_col_unit'] = 'col-md-12';
             $data['rightsidebar'] = $this->Friendsmodel->get_all_frnds($this->session->userdata('logged_in')['id']);
             $data['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
             $data['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
             $data['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
             $data['top_songs'] = $this->library->get_top_songs();
             $data['top_user'] = $this->user->get_top_user();
             
             $this->load->view('templates/template', $data);
         }
         	 
     }
    
    function success(){
        //get the transaction data
        $paypalInfo = $this->input->get();
        
        $data['item_number'] = $paypalInfo['item_number']; 
        $data['txn_id'] = $paypalInfo["tx"];
        $data['payment_amt'] = $paypalInfo["amt"];
        $data['currency_code'] = $paypalInfo["cc"];
        $data['status'] = $paypalInfo["st"];
        
        //pass the transaction data to view
        $data['middle'] = 'payment_success';
        $this->load->view('templates/template', $data);
     }
     
     function cancel(){
        
        $data['middle'] = 'payment_cancel';
        $this->load->view('templates/template', $data);
        
     }
     
     function ipn(){
        //paypal return transaction details array
        $paypalInfo    = $this->input->post();

        $data['user_id'] = $paypalInfo['custom'];
        $data['product_id']    = $paypalInfo["item_number"];
        $data['txn_id']    = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["payment_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status']    = $paypalInfo["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
        
        //check whether the payment is verified
        if(eregi("VERIFIED",$result)){
            //insert the transaction data into the database
            $this->load->model('wallet_model' , 'wallet');
            $this->wallet->insertTransaction($data);
           
            //add coins
            $user  = $this->db->get_where('user', array('id' => $data['user_id']))->result_array();
            $coins = $user[0]['coins'];
            //$new_coins = ($data['payment_gross']) * coinsCurrencyRatio;
            $new_coins = round(($data['payment_gross'] * 0.91),2);
            $sql = "UPDATE user SET coins = '".($coins+$new_coins)."'  WHERE id = '".$data['user_id']."'";
            $this->db->query($sql);
        }
    }
    
    
    
    
    // For support your artist section
    
    public function support_artist()
     {
         //Check login
         $s = $this->session->userdata('logged_in');
            if(empty($s)) { $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');}        
         
        if($this->input->post('amount'))
	 {
            foreach($this->input->post() as $key => $val){
             $$key = $val; }
            
            /*if(!is_int($amount) || $amount < 1){die($amount);
                redirect('wallet');
            }*/
            
	    $sessionData   = $this->sessionData;
             
            //Set variables for paypal form
            $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
            $paypalID = 'inder.bajaj-seller@wwindia.com'; //business email
            $returnURL = base_url().'wallet/aupport_success'; //payment success url
            $cancelURL = base_url().'wallet/cancel'; //payment cancel url
            $notifyURL = base_url().'wallet/aupport_ipn'; //ipn url

            //get particular product data
            $userID = $sessionData['id']; //current user id
            $logo = base_url().'assets/images/codexworld-logo.png';

            $this->paypal_lib->add_field('business', $paypalID);
            $this->paypal_lib->add_field('return', $returnURL);
            $this->paypal_lib->add_field('cancel_return', $cancelURL);
            $this->paypal_lib->add_field('notify_url', $notifyURL);
            $this->paypal_lib->add_field('item_name', 'coins');
            $this->paypal_lib->add_field('custom', $userID);
            $this->paypal_lib->add_field('item_number',  $battle_id);
            $this->paypal_lib->add_field('amount',  $amount);        
            $this->paypal_lib->image($logo);

            $this->paypal_lib->paypal_auto_form();
         }else{
             redirect('battle');
         }
         	 
     }
     
     
     public function aupport_ipn() {
          //paypal return transaction details array
        $paypalInfo    = $this->input->post();

        $data['user_id'] = $paypalInfo['custom'];
        //$data['product_id']    = $paypalInfo["item_number"];
        $data['battle_id']    = $paypalInfo["item_number"];
        $data['txn_id']    = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["payment_gross"];
        $data['battle_bucks'] = round($paypalInfo["payment_gross"]*0.9, 2);
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status']    = $paypalInfo["payment_status"];
        $data['is_credited_user']    = 0;

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
        
        //check whether the payment is verified
        if(eregi("VERIFIED",$result)){
            
            //insert the transaction data into the database
             $this->db->insert('artist_payments' , $data) ;
            $insert_id =  $this->db->insert_id();
            
        }
     }
     
     
     public function aupport_success() {
         //get the transaction data
        $paypalInfo = $this->input->get();
        
        $data['battle_id'] = $paypalInfo['item_number']; 
        $data['txn_id'] = $paypalInfo["tx"];
        $data['payment_amt'] = $paypalInfo["amt"];
        $data['currency_code'] = $paypalInfo["cc"];
        $data['status'] = $paypalInfo["st"];
        
         $this->session->set_flashdata('class' , 'alert-success');
	 $this->session->set_flashdata('success' , 'You have successfully donated!');
        
         redirect('battle/request/'.$data['battle_id']);
     }
     
     
     
     public function support_artist_from_wallet() {
         
        $battle_id    = $this->input->post('battle_id');
        $amount       = $this->input->post('amount');
        $sessionData   = $this->sessionData;
        
        
        $data['user_id'] = $sessionData['id'];
        $data['battle_id']    = $battle_id;
        $data['txn_id']    = '';
        $data['payment_gross'] = round($amount*1.1, 2);
        $data['battle_bucks'] = $amount;
        $data['currency_code'] = 'USD';
        $data['payer_email'] = '';
        $data['payment_status']    = 'Completed';
        $data['is_credited_user']    = 0;
        $this->db->insert('artist_payments' , $data) ;
        
           
            //deduct coins
            $user  = $this->db->get_where('user', array('id' => $sessionData['id']))->result_array();
            $coins = $user[0]['coins'];
            
            $sql = "UPDATE user SET coins = '".($coins-$amount)."'  WHERE id = '".$sessionData['id']."'";
            $this->db->query($sql);
            
            $this->session->set_flashdata('class' , 'alert-success');
	    $this->session->set_flashdata('success' , 'You have successfully donated!');
        
            redirect('battle/request/'.$battle_id);
    }
    
    /* Cash Out the Fund */
    
    function cash_out_user_ipn(){
        //paypal return transaction details array
        $paypalInfo    = $this->input->post();
        
        /* $this->email->from('mydevfactory.com', 'System Mail'); 
        $this->email->to('samiran.brainium@gmail.com');
        $this->email->subject('Cash out Payment Info'); 
        $this->email->message(json_encode($paypalInfo)); 
        $this->email->send(); */
    }
     
     
 }
 