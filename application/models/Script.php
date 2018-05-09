<?php

/**
 * Usermodel class
 * this class has function that perform insert update delete of admin user details
 * @package battle
 * @subpackage model
 * @author 
 * */
class Script extends CI_Model {

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
    * @param $email
    * @param $password
    * @return login result
    * @author 
    **/
    
  public function set_script($_scriptName) {
      $result = $this->db->get_where('script', array('name' => $_scriptName))->row_array();
        if(empty($result)){
            $this->db->insert('script', ['name'=>$_scriptName,'status'=>1, 'created_on'=> date('Y-m-d H:i:s')]);
            return $this->db->insert_id();
        }else{
            return $result['id'];
        }
  }
  
  public function set_script_price($scriptId, $scriptPrice, $_date) {
   $result = $this->db->get_where('script_price', array('script_id' => $scriptId, 'date'=>$_date))->row_array();
    if(empty($result)){
        $this->db->insert('script_price', ['script_id'=>$scriptId,'price'=>$scriptPrice, 'date'=>$_date, 'created_on'=> date('Y-m-d H:i:s')]);
        return $this->db->insert_id();
    }
  }
  
  public function set_script_volume($scriptId, $scriptVolume, $_date) {
   $result = $this->db->get_where('script_volume', array('script_id' => $scriptId, 'date'=>$_date))->row_array();
    if(empty($result)){
        $this->db->insert('script_volume', ['script_id'=>$scriptId,'volume'=>$scriptVolume, 'date'=>$_date, 'created_on'=> date('Y-m-d H:i:s')]);
        return $this->db->insert_id();
    }
  }
  
  public function set_script_deliv_per($scriptId, $scriptDelivPer, $_date) {
   $result = $this->db->get_where('script_delivery', array('script_id' => $scriptId, 'date'=>$_date))->row_array();
    if(empty($result)){
        $this->db->insert('script_delivery', ['script_id'=>$scriptId,'delivery_percentage'=>$scriptDelivPer, 'date'=>$_date, 'created_on'=> date('Y-m-d H:i:s')]);
        return $this->db->insert_id();
    }
  }


 

    /**
     * adduser function
     * @param $data
     * @return void
     * @author 
     **/
    public function adduser($data){
        $result = $this->db->get_where('user', array('fb_id' => $data['fb_id']))->result_array();

        if(empty($result)){
            $this->db->insert('user', $data);
            return $this->db->get_where('user', array('id' => $this->db->insert_id()))->result_array();
        }else{
            return $result;
        }

    }
    
    public function fb_api_adduser($data=[]) {
        $this->db->where('fb_id', $data['fb_id']);
        if($data['email'] != NULL)
        $this->db->or_where('email', $data['email']);
        $query = $this->db->get('user');
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            $this->db->insert('user', $data);
            return $this->db->get_where('user', array('id' => $this->db->insert_id()))->row_array();
        }
    }

        /**
     * checkuser function
     * @param $data
     * @return void
     * @author 
     **/
    public function checkuser($data){
        $result = $this->check_user_data($data['email']); 
        if(empty($result)){
            $this->db->insert('user', $data); 
           return $this->db->insert_id();
        }else{
            return "user already exist";
        }

    }
    
    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     **/
    public function check_user_data($email)
    {
       return $this->db->get_where('user', array('email' => $email))->result();
    }

    /**
     * update_user_data function
     * @param $data
     * @param $id
     * @return void
     * @author 
     **/
    public function update_user_data($data,$id){
        $this->db->update('user', $data, array('id' => $id));
    }

    /**
     * check_user_data function
     *
     * @return email address if matches the given criteria or false
     * @author 
     **/
    public function get_user_data($id,$key)
    {
       return $this->db->get_where('user', array('id' => $id, 'secret_key' => $key))->result();
    }
    
   
    public function get_user_by_id($id=NULL)
    {
        if($id == NULL){
             $sessionData = $this->sessionData = get_session_data();
             $id = $sessionData['id'];
        }
        
       return $this->db->get_where('user', array('id' => $id))->result_array();
    }
    
    public function getSingleUser($id = NULL) {
        return $this->db->get_where('user', array('id' => $id))->row_array();
    }

    /**
     * get_user_profile function
     *
     * @return void
     * @author 
     **/
    public function get_user_profile($id = NULL)
    {
	if(!is_null($id))	
	{
            //$this->db->join('(select * from user_memberships group by `user_id` desc) um' , 'u.id=um.user_id');
	    $sql= "SELECT u.*, um.memberships_id, (SELECT COUNT(user_id)  FROM user_follow WHERE user_id = ".$id
                        .") AS following,(SELECT COUNT(following_frnd_id)  FROM user_follow WHERE following_frnd_id = "
                        .$id.") AS follower FROM user as u "
                        . "inner join (select memberships_id, user_id from user_memberships where status = 1 group by `id` desc) um on u.id=um.user_id "
                        . "where u.id = ".$id;
		return $this->db->query($sql)->result();
	}
	
        // return $this->db->get_where('user', array('id' => $id))->result();
    }

    /**
     * update_user_profile function
     *
     * @return void
     * @author 
     **/
    public function update_user_profile($id,$data)
    {
        $user_id = $this->session->userdata('logged_in')['id'];
        
        if(!isset($user_id) || $user_id=='') {
            return FALSE;
        }
        
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        return true; 
        
        /* if($this->db->affected_rows() > 0){  
          return true; 
        }else{  
          return false; 
        } */
    }
    
    
    public function get_top_user()
    {
	//$sql = "select * from user WHERE user_type = 'artist' ORDER BY win_cnt desc limit 100 " ;
	$sql = "select user.* from user inner join user_memberships um on user.id = um.user_id  WHERE user.win_cnt >0 and um.memberships_id = 2 and um.status = 1 group by user.id ORDER BY user.win_cnt desc limit 100" ;
        
	$res = $this->db->query($sql);
	if($res->num_rows() > 0 )
	{
	    return $res->result_array();
	}
	return array();
    }
    
    /**
     * add_cup function
     * 
     **/
    public function add_cup($cup,$user_id)
    {
       $user  = $this->db->get_where('user', array('id' => $user_id))->result_array();
       $existing_cups  = $user[0]['cups'];

       if($existing_cups == NULL){
           $existing_cups = ['gold'=> 0, 'platinum'=> 0, 'diamond'=>0];
       }else{
           $existing_cups = unserialize(base64_decode($existing_cups));
       }
       $existing_cups[$cup] = $existing_cups[$cup]+1;
       
       $sql = "UPDATE user SET cups = '".base64_encode(serialize($existing_cups))."'  WHERE id = '".$user_id."'";
       $this->db->query($sql);
    }
    
    /**
     * addPremiumUser Set Express Checkout function
     * @param $data
     * @return void
     * @author 
     **/
    
    public function addPremiumUser($data){
        
        $result = $this->check_user_data($data['email']); 
        if(!empty($result)){
            $this->session->set_flashdata('success', 'user already exist');
            redirect('user/registration'); 
        }

        $SECFields = array(
            'token' => '', // A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
            'maxamt' => 50.00, // The expected maximum total amount the order will be, including S&H and sales tax.
            'returnurl' => base_url('user/premiumsuccess'), // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
            'cancelurl' => base_url('user/premiumcancel'), // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
            'callback' => base_url().'user/premiumipn', // URL to which the callback request from PayPal is sent.  Must start with https:// for production.
            'callbacktimeout' => 4, // An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
            'callbackversion' => '', // The version of the Instant Update API you're using.  The default is the current version.							
            'reqconfirmshipping' => '', // The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
            'noshipping' => '', // The value 1 indiciates that on the PayPal pages, no shipping address fields should be displayed.  Maybe 1 or 0.
            'allownote' => '', // The value 1 indiciates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
            'addroverride' => '', // The value 1 indiciates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
            'localecode' => '', // Locale of pages displayed by PayPal during checkout.  Should be a 2 character country code.  You can retrive the country code by passing the country name into the class' GetCountryCode() function.
            'pagestyle' => '', // Sets the Custom Payment Page Style for payment pages associated with this button/link.  
            'hdrimg' => '', // URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
            'hdrbordercolor' => '', // Sets the border color around the header of the payment page.  The border is a 2-pixel permiter around the header space.  Default is black.  
            'hdrbackcolor' => '', // Sets the background color for the header of the payment page.  Default is white.  
            'payflowcolor' => '', // Sets the background color for the payment page.  Default is white.
            'skipdetails' => '', // This is a custom field not included in the PayPal documentation.  It's used to specify whether you want to skip the GetExpressCheckoutDetails part of checkout or not.  See PayPal docs for more info.
            'email' => '', // Email address of the buyer as entered during checkout.  PayPal uses this value to pre-fill the PayPal sign-in page.  127 char max.
            'solutiontype' => '', // Type of checkout flow.  Must be Sole (express checkout for auctions) or Mark (normal express checkout)
            'landingpage' => '', // Type of PayPal page to display.  Can be Billing or Login.  If billing it shows a full credit card form.  If Login it just shows the login screen.
            'channeltype' => '', // Type of channel.  Must be Merchant (non-auction seller) or eBayItem (eBay auction)
            'giropaysuccessurl' => '', // The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
            'giropaycancelurl' => '', // The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
            'banktxnpendingurl' => '', // The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
            'brandname' => '', // A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
            'customerservicenumber' => '', // Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
            'giftmessageenable' => '', // Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
            'giftreceiptenable' => '', // Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
            'giftwrapenable' => '', // Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
            'giftwrapname' => '', // Label for the gift wrap option such as "Box with ribbon".  25 char max.
            'giftwrapamount' => '', // Amount charged for gift-wrap service.
            'buyeremailoptionenable' => '', // Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
            'surveyquestion' => '', // Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
            'surveyenable' => '', // Enable survey functionality. Allowable values are 0 and 1
            'totaltype' => '', // Enables display of "estimated total" instead of "total" in the cart review area.  Values are:  Total, EstimatedTotal
            'notetobuyer' => '', // Displays a note to buyers in the cart review area below the total amount.  Use the note to tell buyers about items in the cart, such as your return policy or that the total excludes shipping and handling.  127 char max.							
            'buyerid' => '', // The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
            'buyerusername' => '', // The user name of the user at the marketplaces site.
            'buyerregistrationdate' => '', // Date when the user registered with the marketplace.
            'allowpushfunding' => ''     // Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.			
        );

        // Basic array of survey choices.  Nothing but the values should go in here.  
        $SurveyChoices = array('Choice 1', 'Choice2', 'Choice3', 'etc');

        // You can now utlize parallel payments (split payments) within Express Checkout.
        // Here we'll gather all the payment data for each payment included in this checkout 
        // and pass them into a $Payments array.  
        // Keep in mind that each payment will ahve its own set of OrderItems
        // so don't get confused along the way.
        if(isset($data['battle_category']) && !empty($data['battle_category'])) {
            $custom_data = $data['firstname'].'|'.$data['lastname'].'|'.$data['email'].'|'.$data['password'].'|'.$data['encrypt_password'].'|'.implode('|', $data['battle_category']);
        } else {
            $custom_data = $data['firstname'].'|'.$data['lastname'].'|'.$data['email'].'|'.$data['password'].'|'.$data['encrypt_password'];
        }
        
        $Payments = array();
        $Payment = array(
            'amt' => 0.01, // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
            'currencycode' => 'USD', // A three-character currency code.  Default is USD.
            'itemamt' => '', // Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
            'shippingamt' => 0.01, // Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
            'shipdiscamt' => 0.00, // Shipping discount for this order, specified as a negative number.
            'insuranceoptionoffered' => '', // If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
            'handlingamt' => '', // Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
            'taxamt' => 0.00, // Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
            'desc' => 'Battle Me is a Hip Hop recording studio and Rap community that fits into your pocket. Over 300,000 rappers already use it.', // Description of items on the order.  127 char max.
            'custom' => $custom_data, // Free-form field for your own use.  256 char max.
            'invnum' => '', // Your own invoice or tracking number.  127 char max.
            'notifyurl' => '', // URL for receiving Instant Payment Notifications
            'shiptoname' => '', // Required if shipping is included.  Person's name associated with this address.  32 char max.
            'shiptostreet' => '', // Required if shipping is included.  First street address.  100 char max.
            'shiptostreet2' => '', // Second street address.  100 char max.
            'shiptocity' => '', // Required if shipping is included.  Name of city.  40 char max.
            'shiptostate' => '', // Required if shipping is included.  Name of state or province.  40 char max.
            'shiptozip' => '', // Required if shipping is included.  Postal code of shipping address.  20 char max.
            'shiptocountrycode' => '', // Required if shipping is included.  Country code of shipping address.  2 char max.
            'shiptophonenum' => '', // Phone number for shipping address.  20 char max.
            'notetext' => '', // Note to the merchant.  255 char max.  
            'allowedpaymentmethod' => '', // The payment method type.  Specify the value InstantPaymentOnly.
            'allowpushfunding' => '', // Whether the merchant can accept push funding:  0 - Merchant can accept push funding.  1 - Merchant cannot accept push funding.  This will override the setting in the merchant's PayPal account.
            'paymentaction' => '', // How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order. 
            'paymentrequestid' => '', // A unique identifier of the specific payment request, which is required for parallel payments. 
            'sellerid' => '', // The unique non-changing identifier for the seller at the marketplace site.  This ID is not displayed.
            'sellerusername' => '', // The current name of the seller or business at the marketplace site.  This name may be shown to the buyer.
            'sellerpaypalaccountid' => ''   // A unique identifier for the merchant.  For parallel payments, this field is required and must contain the Payer ID or the email address of the merchant.
        );

        // For order items you populate a nested array with multiple $Item arrays.  
        // Normally you'll be looping through cart items to populate the $Item array
        // Then push it into the $OrderItems array at the end of each loop for an entire 
        // collection of all items in $OrderItems.

        $PaymentOrderItems = array();
        $Item = array(
            'name' => 'Battle membership', // Item name. 127 char max.
            'desc' => '', // Item description. 127 char max.
            'amt' => '', // Cost of item.
            'number' => '', // Item number.  127 char max.
            'qty' => '', // Item qty on order.  Any positive integer.
            'taxamt' => '', // Item sales tax
            'itemurl' => '', // URL for the item.
            'itemweightvalue' => '', // The weight value of the item.
            'itemweightunit' => '', // The weight unit of the item.
            'itemheightvalue' => '', // The height value of the item.
            'itemheightunit' => '', // The height unit of the item.
            'itemwidthvalue' => '', // The width value of the item.
            'itemwidthunit' => '', // The width unit of the item.
            'itemlengthvalue' => '', // The length value of the item.
            'itemlengthunit' => '', // The length unit of the item.
            'itemurl' => '', // URL for the item.
            'itemcategory' => '', // Must be one of the following values:  Digital, Physical
            'ebayitemnumber' => '', // Auction item number.  
            'ebayitemauctiontxnid' => '', // Auction transaction ID number.  
            'ebayitemorderid' => '', // Auction order ID number.
            'ebayitemcartid' => ''      // The unique identifier provided by eBay for this order from the buyer. These parameters must be ordered sequentially beginning with 0 (for example L_EBAYITEMCARTID0, L_EBAYITEMCARTID1). Character length: 255 single-byte characters
        );
        array_push($PaymentOrderItems, $Item);

        // Now we've got our OrderItems for this individual payment, 
        // so we'll load them into the $Payment array
        $Payment['order_items'] = $PaymentOrderItems;

        // Now we add the current $Payment array into the $Payments array collection
        array_push($Payments, $Payment);

        $BuyerDetails = array(
            'buyerid' => '', // The unique identifier provided by eBay for this buyer.  The value may or may not be the same as the username.  In the case of eBay, it is different.  Char max 255.
            'buyerusername' => '', // The username of the marketplace site.
            'buyerregistrationdate' => '' // The registration of the buyer with the marketplace.
        );

        // For shipping options we create an array of all shipping choices similar to how order items works.
        $ShippingOptions = array();
        $Option = array(
            'l_shippingoptionisdefault' => TRUE, // Shipping option.  Required if specifying the Callback URL.  true or false.  Must be only 1 default!
            'l_shippingoptionname' => 'Battle shipping', // Shipping option name.  Required if specifying the Callback URL.  50 character max.
            'l_shippingoptionlabel' => 'Battle shipping label', // Shipping option label.  Required if specifying the Callback URL.  50 character max.
            'l_shippingoptionamount' => 0.01,      // Shipping option amount.  Required if specifying the Callback URL.  
        );
        array_push($ShippingOptions, $Option);

        // For billing agreements we create an array similar to working with 
        // payments, order items, and shipping options.	
        $BillingAgreements = array();
        $Item = array(
            'l_billingtype' => 'RecurringPayments', // Required.  Type of billing agreement.  For recurring payments it must be RecurringPayments.  You can specify up to ten billing agreements.  For reference transactions, this field must be either:  MerchantInitiatedBilling, or MerchantInitiatedBillingSingleSource
            'l_billingagreementdescription' => 'BattlemeMembership', // Required for recurring payments.  Description of goods or services associated with the billing agreement.  
            'l_paymenttype' => '', // Specifies the type of PayPal payment you require for the billing agreement.  Any or IntantOnly
            'l_billingagreementcustom' => ''     // Custom annotation field for your own use.  256 char max.
        );
        array_push($BillingAgreements, $Item);

        $PayPalRequestData = array(
            'SECFields' => $SECFields,
            'SurveyChoices' => $SurveyChoices,
            'Payments' => $Payments,
            'BuyerDetails' => $BuyerDetails,
            'ShippingOptions' => $ShippingOptions,
            'BillingAgreements' => $BillingAgreements
        );

        $PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('Errors' => $PayPalResult['ERRORS']);
//            echo '<pre>';
//            print_r($errors); die;
            $this->session->set_flashdata('class', 'alert-danger');
            $this->session->set_flashdata('message', $PayPalResult['ERRORS']);
            redirect(base_url('user/premiumcancel'));
        } else {
            
            if(isset($PayPalResult['REDIRECTURL'])) {
                redirect($PayPalResult['REDIRECTURL']);
            }
            // Successful call.  Load view or whatever you need to do here.	
        }
       
    }
    
    
    /*public function addPremiumUser($data){
        
        $result = $this->check_user_data($data['email']); 
        if(!empty($result)){
            $this->session->set_flashdata('success', 'user already exist');
            redirect('user/registration'); 
        }
        
        //Set variables for paypal form
        $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //test PayPal api url
        $paypalID = 'inder.bajaj-seller@wwindia.com'; //business email
        $returnURL = base_url().'user/premiumsuccess'; //payment success url
        $cancelURL = base_url().'user/premiumcancel'; //payment cancel url
        $notifyURL = base_url().'user/premiumipn'; //ipn url

        //get particular product data
        $logo = base_url().'assets/images/codexworld-logo.png';

        $this->paypal_lib->add_field('business', $paypalID);
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', 'premium');
        $this->paypal_lib->add_field('item_number',  1);
        $this->paypal_lib->add_field('amount',  40);        
        $this->paypal_lib->add_field('custom', serialize($data));        
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
        
        exit;
    } */
    /**
     * getArtistByCategory function
     * @param $userId
     * @return Array
     * @author Samiran
     **/
    public function getArtistByCategory($userId=''){
        $user_id = $this->session->userdata('logged_in')['id'];
        $this->db->select('concat(u.firstname , " " ,u.lastname ) as user_name,'
		    . 'u.id user_id, u.email, u.profile_picture, u.info, u.win_cnt, u.lose_cnt, '
		    . 'ar.battle_category, um.memberships_id', FALSE);
	    $this->db->from('user u');
	    $this->db->join('artist_registry ar' , 'u.id=ar.user_id');
	    $this->db->join('(select * from user_memberships group by `user_id` desc) um' , 'u.id=um.user_id');
            $this->db->where('u.id !='.$user_id);
            $this->db->where('um.memberships_id !=3');
	    $result = $this->db->get();
	    //echo $this->db->last_query();
	    return $result->result_array();
    }
    
    
    public function getArtistCategoryByUser($userId=''){
         $user_id = $this->session->userdata('logged_in')['id'];
        $this->db->select('ar.battle_category', FALSE);
	    $this->db->from('user u');
	    $this->db->join('artist_registry ar' , 'u.id=ar.user_id');
            $this->db->where('u.id='.$user_id);
	    $result = $this->db->get();
	    //echo $this->db->last_query();
	    return $result->result_array();
    }
    
    // For invitation to friend
    public function inviteFriend($data){
        $result = $this->db->get_where('invitation', array('refer_user' => $data['refer_user'], 'friend_email' => $data['friend_email']))->row_array();
        if(empty($result)){
            $this->db->insert('invitation', $data);
            return $this->db->insert_id();
        }else{
            return TRUE;
        }
    }
    
    /**
     * getRecurringProfileInfo function
     * @param $userId
     * @return Array
     * @author Samiran
     **/
    public function getRecurringProfileInfo($userId=''){
        
        $this->db->select('rp.*', FALSE);
	    $this->db->from('recurring_payments rp');
	   // $this->db->join('artist_registry ar' , 'u.id=ar.user_id');
	   //$this->db->join('(select * from user_memberships group by `user_id` desc) um' , 'u.id=um.user_id');
            $this->db->where('rp.user_id',$userId);
	    $result = $this->db->get();
	    //echo $this->db->last_query();
	    return $result->row_array();
    }
    
    public function getCmsPage($id = NULL) {
        return $this->db->get_where('content_management', array('id' => $id))->row_array();
    }
    
    function getBattleCategoryList() {
        $this->db->select('id,name,media', FALSE);
        $this->db->from('battle_category');
        $this->db->where('status', 1);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        if($query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    
    public function getSecurityQuestion() {
        $this->db->select('id, question, created_at', FALSE);
        $this->db->from('security_question');
        $this->db->where('status', 1);
        //$this->db->order_by("id", "asc");
        $this->db->order_by('rand()');
        $this->db->limit(2);
        $query = $this->db->get();
        if($query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    
    public function count_platinum_mics($userId = NULL) {
        $this->db->select('count(`tournament_group_id`) as tlatinum_count', FALSE);
        $this->db->where('tournament_group', $userId);
        $this->db->where('round', 6);
        $query = $this->db->get('tournament_groups');
        if($query->num_rows() > 0 ) {
            return $query->row_array();
        } else {
            return NULL;
        }
    }
    
}