<?php
/**
 * this class has functions that perform Chalange a Artist operation
 * @package Artist_registry
 * @subpackage controller
 * @author 
 * */
class Artist_registry extends CI_Controller {

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
        if (empty($data)) {
            $currenturl = current_url();
            $this->session->set_userdata('currenturl', $currenturl);
            redirect('user');
        }
        $this->load->model('Friendsmodel', 'friends');
        $this->load->model('Song_library_model' , 'library');
        $this->load->model('Usermodel', 'user');
        $this->load->model('battle_model', 'battles');
        $this->sessionData = get_session_data();
    }

    /**
     * index function
     * loads the user home page
     * @return void
     * @author
     * */
    public function index() {
        
        $user_id = $this->sessionData['id'];
        $artistData = $this->user->getArtistByCategory($user_id);
        //echo '<pre>';        print_r($artistData);
        
        $battleCat = $this->user->getBattleCategoryList();
        $battleCatArray = [];
        foreach ($battleCat as $value) {
            $battleCatArray[$value['id']] = $value['name'];
        }
        $battle_cat = $battleCatArray;
        
        //$battle_cat = [1 =>'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6 => 'Raggeton', 7=> 'Latino hip hop', 8 => 'Latino songs originals', 9 => 'Latino songs covers'];
        $artistDataArray = [];
        if(isset($artistData) && !empty($artistData)) {
            foreach ($artistData as $artistVal){
                if(array_key_exists($artistVal['battle_category'], $battle_cat)){
                    $artistDataArray[$artistVal['battle_category']][] = $artistVal;
                }
            }
        }
        //sort($artistDataArray);
        //echo '<pre>';        print_r($artistDataArray); die;
        
        $arrData['userId'] = $user_id;
        $arrData['battleCat'] = $battleCat;
        $arrData['artistList'] = $artistDataArray;
        //$arrData['battleList'] = $battleData;
        $arrData['battleType'] = '';
        //$arrData['battleCategoryName'] = 'My Battles';
        $arrData['middle'] = 'artist_registry';
        $arrData['div_col_unit'] = 'col-md-12';
        //echo '<pre>'; print_r($arrData); die;
        $arrData['rightsidebar'] = $this->friends->get_all_frnds($this->session->userdata('logged_in')['id']);
        $arrData['get_notification'] = get_notification($this->session->userdata('logged_in')['id']);
        $arrData['new_notifn_count'] = get_new_notification($this->session->userdata('logged_in')['id']);
        $arrData['userdata'] = $this->user->get_user_profile($this->session->userdata('logged_in')['id']);
        //$arrData['top_songs'] = $this->library->get_top_songs();
	//$arrData['top_user'] = $this->user->get_top_user();
        
        $this->load->view('templates/template', $arrData);
        
    }       

   
}