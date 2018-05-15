<?php 
 /**
  * Description of Wallet
  * 
  */
 class Trad extends CI_Controller {
     //put your code here
     public $sessionData;
     public $paypalMode;
     public $paypalSetting;
     public function __construct() {
	 parent::__construct();
         
	 $this->load->model('Usermodel' , 'user');
         $this->load->model('Script' , 'script');
	 $this->load->library('Common_lib');
	 $this->sessionData = get_session_data();
     }
     
     /**
     * index function
     * @return void
     * @param 
     * */
     public function index()
     {
        
        if($this->input->post('Submit')) {
            
            $csv = array_map('str_getcsv', file($_FILES['sheet']['tmp_name']));
            unset($csv[0]);
//            echo '<pre>';
//            print_r($csv); die;
            if(!empty($csv)) {
                foreach ($csv as $tVal) {
                    // Insert trad script
                     $scriptId = $this->script->set_script($tVal[0]); 
                     
                     # for close price 8
                     $scriptPrice = $tVal[8];
                     # for Date field 2
                     $_date = date("Y-m-d", strtotime($tVal[2])); 
                     # for volume 10
                     $scriptVolume = $tVal[10];
                     # for delevery Quantity 13
                     $scriptDelivQuantity = $tVal[13];
                     # for delevery percented 14
                     $scriptDelivPer = $tVal[14];
                     
                     
                    // Insert price for script
                    $this->script->set_script_price($scriptId, $scriptPrice, $_date);
                    // Insert volume for script
                    $this->script->set_script_volume($scriptId, $scriptVolume, $_date);
                    // Insert price for script
                    $this->script->set_script_deliv_per($scriptId, $scriptDelivQuantity, $scriptDelivPer, $_date);
                     
                }
            }
           
         }else{
             $data['middle'] = 'trad';
             $data['div_col_unit'] = 'col-md-12';
             $this->load->view('templates/template', $data);
         }
         	 
     }
        
 }