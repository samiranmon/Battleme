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
     * */
    public function set_script($_scriptName) {
        $result = $this->db->get_where('script', array('name' => $_scriptName))->row_array();
        if (empty($result)) {
            $this->db->insert('script', ['name' => $_scriptName, 'status' => 1, 'created_on' => date('Y-m-d H:i:s')]);
            return $this->db->insert_id();
        } else {
            return $result['id'];
        }
    }

    public function set_script_price($scriptId, $scriptPrice, $_date) {
        $result = $this->db->get_where('script_price', array('script_id' => $scriptId, 'date' => $_date))->row_array();
        if (empty($result)) {
            $this->db->insert('script_price', ['script_id' => $scriptId, 'price' => $scriptPrice, 'date' => $_date, 'created_on' => date('Y-m-d H:i:s')]);
            return $this->db->insert_id();
        }
    }

    public function set_script_volume($scriptId, $scriptVolume, $_date) {
        $result = $this->db->get_where('script_volume', array('script_id' => $scriptId, 'date' => $_date))->row_array();
        if (empty($result)) {
            $this->db->insert('script_volume', ['script_id' => $scriptId, 'volume' => $scriptVolume, 'date' => $_date, 'created_on' => date('Y-m-d H:i:s')]);
            return $this->db->insert_id();
        }
    }

    public function set_script_deliv_per($scriptId, $scriptDelivQuantity, $scriptDelivPer, $_date) {
        $result = $this->db->get_where('script_delivery', array('script_id' => $scriptId, 'date' => $_date))->row_array();
        if (empty($result)) {
            $this->db->insert('script_delivery', ['script_id' => $scriptId, 'delivery_qty' => $scriptDelivQuantity, 'delivery_percentage' => $scriptDelivPer, 'date' => $_date, 'created_on' => date('Y-m-d H:i:s')]);
            return $this->db->insert_id();
        }
    }

    public function check_nse_file($file_name = null) {
        $result = $this->db->get_where('nse_file', array('DATE(created_on)' => date('Y-m-d')))->row_array();
        if (empty($result)) {
            $this->db->insert('nse_file', ['name' => $file_name, 'created_on' => date('Y-m-d H:i:s')]);
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function is_present_nse_file() {
        $result = $this->db->get_where('nse_file', array('DATE(created_on)' => date('Y-m-d')))->row_array();
        if (!empty($result)) {

            $file_path = getcwd() . '/uploads/nse_stock/' . $result['name'];
            if (file_exists($file_path)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_current_nse_file() {
        $result = $this->db->get_where('nse_file', array('DATE(created_on)' => date('Y-m-d')))->row_array();
        if (!empty($result)) {
            return $result['name'];
        }
    }

    public function is_sheet_uploaded() {
        $result = $this->db->get_where('script_price', array('date' => date('Y-m-d')))->row_array();
        if (!empty($result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_three_days_old_data() {
        $this->db->select('id,date');
        $this->db->from('script_volume');
        $this->db->group_by('date');
        $this->db->order_by('date', 'asc');
        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() == 3) {
            $rs = $query->result_array();

            // delete last 3rd day data from script_volume table
            $this->db->where(['date'=>$rs[0]['date']]);
            $this->db->delete('script_volume');
            
            // delete last 3rd day data from script_price table
            $this->db->where(['date'=>$rs[0]['date']]);
            $this->db->delete('script_price');
            
            // delete last 3rd day data from script_delivery table
            $this->db->where(['date'=>$rs[0]['date']]);
            $this->db->delete('script_delivery');
        } else {
            return FALSE;
        }
    }

}