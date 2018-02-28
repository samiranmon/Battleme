<?php
 /**
  * Description of Wallet_model
  *
  */
 class Wallet_model Extends CI_Model {
     //put your code here
     public function __construct() {
	 parent::__construct();
     }
     
     
      public function getSiteSettingById($id=null) {
        $this->db->select('*');
        $this->db->from('sitesetting');
        $this->db->where('id', $id );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }
    
      public function getPaypalSettingById($id=null) {
        $this->db->select('*');
        $this->db->from('paypal_setting');
        $this->db->where('id', $id );
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }
     
    /**
     * add_request
     * this function save the payment transactions
     * @param array
     * @return int
     **/  
    public function insertTransaction($inputArr = array()) 
    {
	if(!empty($inputArr))
	{
            $query = $this->db->get_where('payments', array('txn_id' => $inputArr['txn_id'], 'user_id' => $inputArr['user_id']));
            if ($query->num_rows() < 1) {
                $this->db->insert('payments' , $inputArr) ;
                $insert_id =  $this->db->insert_id();
                return $insert_id;
            } 
	}
    }
    
    /**
     * update
     * this function update the payment transactions
     * @param array
     * @return int
     **/  
    public function updateTransaction($data = array(), $transactionId) 
    {
	$this->db->update('payments', $data, array('payment_id' => $transactionId));
    }
    
    /**
     * update
     * this function update the payment transactions
     * @param array
     * @return int
     **/  
    public function deductCoins($coins, $userId) 
    {
	//deduct coins
        
        $user  = $this->db->get_where('user', array('id' => $userId))->result_array();
        $existingCoins = $user[0]['coins'];
                
        $sql = "UPDATE user SET coins = '".($existingCoins-$coins)."'  WHERE id = '".$userId."'";
        $this->db->query($sql);
		     
    }
    
    public function getUserCoin($userId = NULL) {
         return $this->db->get_where('user', array('id' => $userId))->row_array();
    }
    
    public function setCashOutUserDetails($dataArray = [], $amount = 0, $user_id = NULL) {
        $this->db->insert('cashout_payments' , $dataArray) ;
        $sql = "UPDATE user SET coins = (coins - $amount) WHERE id = '".$user_id."'";
        $this->db->query($sql);
        
    }
    
 }
 