<?php

/**
 * Description of Wallet
 * 
 */
class Intraday_scanner extends CI_Controller {

    //put your code here
    public $sessionData;
    public $paypalMode;
    public $paypalSetting;

    public function __construct() {
        parent::__construct();

        $this->load->model('Usermodel', 'user');
        $this->load->model('Script', 'script');
        $this->load->library('Common_lib');
        $this->sessionData = get_session_data();
        $this->load->library('email');
    }

    /**
     * index function
     * @return void
     * @param 
     * */
    public function index() {
         
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://docs.google.com/spreadsheets/d/1J6YSSg6Dq0BKF30rRzTXSud4CdQ6uG5x1ZVJ1lY5i98/edit?chrome=false&rm=demo&format=csv#gid=2068381642"); 
        curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);

        $csv = curl_exec($ch); 
        curl_close($ch);
        var_dump($csv);
        
        
        

        if ($this->input->post('Submit')) {

            $csv = array_map('str_getcsv', file($_FILES['sheet']['tmp_name']));
            unset($csv[0]);
//            echo '<pre>';
//            print_r($csv); die;
            if (!empty($csv)) {
                foreach ($csv as $tVal) {
                    // Insert trad script
                    $scriptId = $this->script->set_script($tVal[0]);

                    # for close price 8
                    $scriptPrice = $tVal[8];
                    # for Date field 2
                    $_date = date("Y-m-d", strtotime($tVal[2]));
                    
                    # for volume 10
                     try {
                      $scriptVolume = (int)$tVal[10];
                    } catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage();
                      die();
                    }
                    # for delevery Quantity 13
                    try {
                      $scriptDelivQuantity = (int)$tVal[13];
                    } catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage();
                      die();
                    }
                    # for delevery percented 14
                     try {
                      $scriptDelivPer = (float)$tVal[14];
                    } catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage();
                      die();
                    }


                    // Insert price for script
                    $this->script->set_script_price($scriptId, $scriptPrice, $_date);
                    // Insert volume for script
                    $this->script->set_script_volume($scriptId, $scriptVolume, $_date);
                    // Insert price for script
                    $this->script->set_script_deliv_per($scriptId, $scriptDelivQuantity, $scriptDelivPer, $_date);
                }
            }
        } else {
            $data['middle'] = 'trad';
            $data['div_col_unit'] = 'col-md-12';
            $this->load->view('templates/template', $data);
        }
    }

    public function download_nse_file() {
        $file_name = 'stock_file_' . str_replace(' ', '_', date('Y-m-d h:i:s a')) . '.csv';
        $temp_file = getcwd() . '/uploads/nse_stock/' . $file_name; // return something like '/tmp/file_BQDfep'

        $fp = fopen($temp_file, 'w+') or die("Unable to open file!");
        chmod($temp_file, 0777);

        $ch = curl_init("https://www.nseindia.com/products/content/sec_bhavdata_full.csv");
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
        // close the file
        fclose($fp);

        // Check current excel sheet or not
        //        echo base_url('/uploads/nse_stock/stock_file_'.$file_name.'.csv');
        $csv_rows = array_map('str_getcsv', file($temp_file));
        if (isset($csv_rows) && !empty($csv_rows)) {
            unset($csv_rows[0]);
            $excel_date = date('Y-m-d', strtotime($csv_rows[1][2]));
            if ($excel_date == date('Y-m-d') && count($csv_rows) > 1800) {
                $status = $this->script->check_nse_file($file_name);
                if ($status) {
                    unlink($temp_file);
                }
                echo 'nse file uploaded';
            } else {
                if (file_exists($temp_file)) {
                    unlink($temp_file);
                }
                echo 'Current nse file not present';
            }
        }
    }

    // Inport csv file
    public function import_nse_file() {
        // check file is present for current date
        $status = $this->script->is_present_nse_file();
        if ($status) {
            // check sheet is uploaded or not
            $status = $this->script->is_sheet_uploaded();
            if ($status == FALSE) {

                // get current nse file
                $nse_file = $this->script->get_current_nse_file();
                $file_path = getcwd() . '/uploads/nse_stock/' . $nse_file;
                if (file_exists($file_path)) {

                    // delete previous file
                    $this->script->delete_three_days_old_data();
                    
                    // set csv file
                    $this->set_import($file_path);
                    echo 'sheet has been uploaded successfully';
                }
            } else {
                echo 'sheet is already uploaded';
            }
        } else {
            echo 'current nse file not present';
        }
    }

    public function set_import($_csv_file) {
        $csv = array_map('str_getcsv', file($_csv_file));
        unset($csv[0]);
//            echo '<pre>';
//            print_r($csv); die;
        if (!empty($csv)) {
            foreach ($csv as $tVal) {
                // Insert trad script
                $scriptId = $this->script->set_script($tVal[0]);

                # for close price 8
                $scriptPrice = (float)$tVal[8];
                # for Date field 2
                $_date = date("Y-m-d", strtotime($tVal[2]));
                # for volume 10
                //$scriptVolume = $tVal[10]==''?0:$tVal[10];
                
                try {
                  $scriptVolume = (int)$tVal[10];
                } catch(Exception $e) {
                  echo 'Message: ' .$e->getMessage();
                }
                
                # for delevery Quantity 13
                try {
                  $scriptDelivQuantity = (int)$tVal[13];
                } catch(Exception $e) {
                  echo 'Message: ' .$e->getMessage();
                }
                
                # for delevery percented 14
                try {
                  $scriptDelivPer = (float)$tVal[14];
                } catch(Exception $e) {
                  echo 'Message: ' .$e->getMessage();
                }
                


                // Insert price for script
                $this->script->set_script_price($scriptId, $scriptPrice, $_date);
                // Insert volume for script
                $this->script->set_script_volume($scriptId, $scriptVolume, $_date);
                // Insert price for script
                $this->script->set_script_deliv_per($scriptId, $scriptDelivQuantity, $scriptDelivPer, $_date);
            }
        }
    }
    
    // send mail 
    public function send_email_for_buy_sell() {
        $scripts = $this->script->get_volume_price_increase();
        $sell_scripts = $this->script->get_sell_script();
        $buy_scripts = $this->script->get_buy_script();
        
        if(isset($scripts) && !empty($scripts)) {
            //echo '<pre>';            print_r($scripts);
            
            $data['stocks'] = $scripts;
            if(isset($sell_scripts)) {
                $data['sell_stocks'] = $sell_scripts;
            }
            if(isset($buy_scripts)) {
                $data['buy_stocks'] = $buy_scripts;
            }
            echo $mail_content = $this->load->view('stock/volume_price_increase', $data, TRUE);
            
            // prepare email
            $this->email
                ->from('samiran@stockonline.in', 'Stock Online.')
                ->to('samiran.mmondal@gmail.com')
                ->subject('Stock prediction ('.date('Y/m/d').')')
                ->message($mail_content)
                ->set_mailtype('html');
            // send email
            $this->email->send();
        }
    }
    
    public function send_email() {
        // prepare email
            $this->email
                ->from('samiran@stockonline.in', 'Stock Online test.')
                ->to('samiran.mmondal@gmail.com')
                ->subject('Test cron job ('.date('Y/m/d h:i:s A').')')
                ->message('test')
                ->set_mailtype('html');
            // send email
            $this->email->send();
    }

}