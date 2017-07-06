<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>


<div class="midsection">
    <h4 class="font-thin m-l-md m-t">
        <?php 
            if($battleType == '') echo 'My Battles';
            else
            echo $battleType == 'cash-battle' ? 'Cash Battles' : 'Regular Battles'; 
        ?>
    </h4>
     
    <div class="clearfix"></div>
    <?php
// echo "<pre>";
// print_r($battleList);
    if ($this->session->flashdata('message')) {
        ?>
        <div class="alert <?php echo $this->session->flashdata('class') ?>">
            <button class="close" data-dismiss="alert">x</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
<?php } ?>
    <br><br>
    <div class="error" style="clear: both;    text-align: center;">                   
        <?php echo $this->session->flashdata('reg_error_message'); ?>
    </div>
    
    
    <div class="list-group alt" style="max-height: 450px; overflow-y:scroll;" > 
        <?php
        if (!empty($battleList)) {
            //echo '<pre>'; print_r($battleList); die;
            foreach ($battleList as $key => $value) {
                
                $chlngr_prof_pic = $value['c_profile'] == ''? 'default.png' : $value['c_profile'];
                $chlngr_prof_pic = base_url('uploads/profile_picture/'.$chlngr_prof_pic);
                
                $friend_prof_pic = $value['f_profile'] == ''? 'default.png' : $value['f_profile'];
                $friend_prof_pic = base_url('uploads/profile_picture/'.$friend_prof_pic);
                
                $challenger_media_array = explode(',', $value['challenger_media']);
                $challenger_media_path = $this->config->item('battle_media_path').$challenger_media_array[0];
                $challenger_media_title = isset($challenger_media_array[1]) ? $challenger_media_array[1]:'';
                $challenger_media_id = isset($challenger_media_array[2]) ? trim($challenger_media_array[2]):'';
                
                
                $friend_media_array = explode(',', $value['friend_media']);
                $friend_media_path = $this->config->item('battle_media_path').$friend_media_array[0];
                $friend_media_title = isset($friend_media_array[1]) ? $friend_media_array[1]:'';
                $friend_media_id = isset($friend_media_array[2]) ? trim($friend_media_array[2]):'';

                $link = base_url() . "battle/request/" . $value['battle_request_id'];
                ?>
        
            <ul class="bloc_div">
                <li class="list-group-item" style="width: 48%; float: left;" > 
                    <div class="media">
                        <div class="media-body"> 
                            
                                <div class="pro_pic">
                                    <img src="<?=$chlngr_prof_pic?>" alt="<?=$value['challenger']?>" class="image-full">
                                </div> 
                            <div class="pro_txt"><h5><?=$challenger_media_title.' ('.ucwords($value['challenger']).')'?></h5></div>
        
                            <div>
                                <a href="javascript:void(0)">Votes: <?=$value['challenger_vote']?></a>
                                <a href="javascript:void(0)">Likes: <span class="like_count_<?=$challenger_media_id?>"><?=$value['challenger_like']?></span></a>
                            </div> 
                            <?php if($challenger_media_array[0] != '') { ?>
                                <div class="toggle">
                                    <img src="<?=  base_url('public/images/like.png')?>" alt="">
                                    <a data-toggle="button" dataid="<?=$challenger_media_id?>" alt='<?=$userId?>' class="btn btn-default songLike active"> 
                                         <span class="text-active"> 
                                             <i class="fa fa-thumbs-o-up text"></i> 
                                             <span class="like_count_<?=$challenger_media_id?>"><?=$value['challenger_like']?></span>
                                         </span> 
                                    </a> 
                                </div>
                            <?php } ?>
                            
                            <br>
                            
                            <div>
                                <?php if($value['winner'] > 0 ) {
                                        if($value['user_id'] == $value['winner']) {
                                    ?>
                                        <a href="javascript:void(0)" style="color: green;">Winner</a>
                                <?php } else { ?> 
                                        <a href="javascript:void(0)" style="color: red;">Loser</a>
                                    <?php } } ?>
                            </div> 
                            
                            <?php if($challenger_media_array[0] != '' && $value['battle_category'] != 4) {
                                    $this->view('responsive_player', ['path' => base_url($challenger_media_path), 'id' => 'challenger_'.$value['battle_request_id']]);
                                }
                            ?>
                            
                            <?php if($challenger_media_array[0] != '' && $value['battle_category'] == 4) { ?>
                                <video width="350" controls="controls">
                                    <source type="video/mp4" src="<?=base_url($challenger_media_path)?>"></source>
                                </video>
                            <?php } ?>
                        </div> 
                        
                        <div><a href="<?php echo $link ?>"><button>Visit Battle Page</button></a></div>
                    </div>
                </li> 
                
                <li class="list-group-item" style="width: 48%; float: left;">
                    <div class="media">
                        <div class="media-body"> 
                            
                            <div class="pro_pic">
                                <img src="<?=$friend_prof_pic?>" alt="<?=$value['friend']?>" class="image-full">
                            </div> 
                             <div class="pro_txt"><h5><?=$friend_media_title.' ('.ucwords($value['friend']).')'?></h5></div>
                            <div>
                                <a href="javascript:void(0)">Votes: <?=$value['friend_vote']?></a>
                                 <a href="javascript:void(0)">Likes: <span class="like_count_<?=$friend_media_id?>"><?=$value['friend_like']?></span></a>
                            </div> 
                            
                            <?php if($friend_media_array[0] != '') { ?>
                                <div class="toggle">
                                    <img src="<?=base_url('public/images/like.png')?>" alt="">
                                    <a data-toggle="button" dataid="<?=$friend_media_id?>" alt='<?=$userId?>' class="btn btn-default songLike active"> 
                                         <span class="text-active"> 
                                             <i class="fa fa-thumbs-o-up text"></i> 
                                             <span class="like_count_<?=$friend_media_id?>"><?=$value['friend_like']?></span>
                                         </span> 
                                    </a> 
                                </div>
                            <?php } ?>
                            <br>
                            
                             <div>
                                <?php if($value['winner'] > 0 ) {
                                        if($value['friend_user_id'] == $value['winner']) {
                                    ?>
                                        <a href="javascript:void(0)" style="color: green;">Winner</a>
                                <?php } else { ?> 
                                        <a href="javascript:void(0)" style="color: red;">Loser</a>
                                    <?php } } ?>
                            </div> 
                            
                            <?php 
                                if($friend_media_array[0] != '' && $value['battle_category'] != 4) {
                                    $this->view('responsive_player', ['path' => base_url($friend_media_path), 'id' => 'friend_'.$value['battle_request_id']]);
                                }
                            ?>
                            
                            <?php if($friend_media_array[0] != '' && $value['battle_category'] == 4) { ?>
                                <video width="400" controls="controls">
                                    <source type="video/mp4" src="<?=base_url($friend_media_path)?>"></source>
                                </video>
                            <?php } ?>
                            
                        </div> 
                        
                        <div>
                            <?php
                            
                                if($value['status'] == 0) {
                                    echo 'Request pending';
                                } else if($value['status'] == 4) {
                                    echo 'Accepted';
                                } else if($value['status'] == 2) {
                                    echo 'Rejected';
                                } else if(strtotime($value['end_date']) >= strtotime(date('Y-m-d H:i:s')) ) {
                                    //echo ' 4 days 36 mins till battle ends';
                                    $date_a = new DateTime($value['end_date']);
                                    $date_b = new DateTime(date('Y-m-d H:i:s'));
                                    $interval = date_diff($date_a,$date_b);
                                    echo $interval->format('%d').' days '.$interval->format('%h').' hour '.$interval->format('%i').' mins till battle ends';
                                } else {
                                    echo 'Closed';
                                }
                            ?>
                           
                        </div>

                    </div>
                </li>
            </ul>
        
        
        
        <?php
    }
} else {
    ?>
            <div class="list-group-item"> 
                <p align="center">
                    <small class="text-muted">
                        Battle records not found
                    </small>
                </p>
            </div>
        <?php } ?>

  
    </div> 
</div>