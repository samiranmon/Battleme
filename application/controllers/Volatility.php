<?php

/**
 * Description of Wallet
 * 
 */
class Volatility extends CI_Controller {

    //put your code here
    public $sessionData;
    public $paypalMode;
    public $paypalSetting;

    public function __construct() {
        parent::__construct();

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
        
        if ($this->input->post('Submit')) {
            // Update nifty 100 stock
            $csv = array_map('str_getcsv', file($_FILES['sheet']['tmp_name']));
            unset($csv[0]);
//            echo '<pre>';
//            print_r($csv); die;
            if (!empty($csv)) {
                foreach ($csv as $tVal) {
                    // Update nifty100 script
                    $scriptId = $this->script->set_nifty100($tVal[2]);

                }
            }
        } else {
            $data['middle'] = 'trad';
            $data['div_col_unit'] = 'col-md-12';
            $this->load->view('templates/template', $data);
        }
    }

    public function download() {
        $file_name = 'volatility_file_' . str_replace(' ', '_', date('Y-m-d h:i:s a')) . '.csv';
        $temp_file = getcwd() . '/uploads/volatility_csv/' . $file_name; // return something like '/tmp/file_BQDfep'

        $fp = fopen($temp_file, 'w+') or die("Unable to open file!");
        chmod($temp_file, 0777);

        $ch = curl_init("https://www.nseindia.com/archives/nsccl/volt/CMVOLT_".date("dmY").".CSV");
//        $ch = curl_init("https://www.nseindia.com/archives/nsccl/volt/CMVOLT_29052018.CSV");
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
            $excel_date = date('Y-m-d', strtotime($csv_rows[1][0]));
            if ($excel_date == date('Y-m-d') && count($csv_rows) > 1600) {
                $status = $this->script->check_volatility_file($file_name, count($csv_rows));
                if ($status) {
                    unlink($temp_file);
                }
                echo 'Volatility file uploaded';
            } else {
                if (file_exists($temp_file)) {
                    unlink($temp_file);
                }
                echo 'Current nse file not present';
            }
        }
    }

    // Inport csv file
    public function import_volatility() {
        // check file is present for current date
        $status = $this->script->is_present_volatility_file();
        if ($status) {
            // check sheet is uploaded or not
            $status = $this->script->is_volatility_sheet_uploaded();
            if ($status == FALSE) {

                // get current nse file
                $vola_file = $this->script->get_current_volatility_file();
                $file_path = getcwd() . '/uploads/volatility_csv/' . $vola_file;
                if (file_exists($file_path)) {

                    // delete previous day data from volatility table
//                    $this->script->delete_three_days_old_data();
                    
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
                $scriptId = $this->script->get_script($tVal[1]);
                if($scriptId) {
                   
                    # for sheet date 0
                    $_date = date("Y-m-d", strtotime($tVal[0]));
                    
                    # for previous volatility 5
                    try {
                      $preVolatility = (float)$tVal[5];
                    } catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage(); die();
                    }

                    # for current volatility 6
                    try {
                      $currVolatility = (float)$tVal[6];
                    } catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage(); die();
                    }

                    # for annualised volatility 7
                    try {
                      $annuVolatility = (float)$tVal[7];
                    } catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage(); die();
                    }

                    // Insert data in to volatility
                    $this->script->set_volatility($scriptId, $_date, $preVolatility, $currVolatility, $annuVolatility);
                }
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