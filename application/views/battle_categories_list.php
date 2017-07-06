<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>
<style type="text/css">
.like-place {
    float: left;
    width: 50%;
}
</style>
<div class="midsection">
    <h4 class="battle-list-heading">
        <?php
        if ($battleType == '')
            echo 'BATTLE LIST';
        else
            echo $battleType == 'cash-battle' ? 'CASH BATTLES' : 'REGULAR BATTLES'; 
        ?>
    </h4>
    
     <?php if ($this->session->flashdata('message')) { ?>
        <div class="alert <?php echo $this->session->flashdata('class') ?>">
            <button class="close" data-dismiss="alert">x</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('reg_error_message')) { ?>
        <div class="error" style="clear: both;    text-align: center;">                   
            <?php echo $this->session->flashdata('reg_error_message'); ?>
        </div>
    <?php } ?>

    <div class="battle-list-block">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs responsive-tabs" role="tablist">
            <?php 
                if(!empty($battleCat)) {
                foreach ($battleCat as $value) {
            ?>
                <li role="presentation" <?php if ($value['id'] ==1) { echo 'class="active"'; } ?>> 
                    <a href="#0<?=$value['id']?>" aria-controls="0<?=$value['id']?>" role="tab" data-toggle="tab">
                        <img src="<?=base_url('uploads/battle_category/'.$value['media']); ?>" alt="<?=$value['name']?>">
                    </a> 
                </li>
            <?php }} ?>    
        </ul>
        <!-- Tab panes -->
        
        <div class="tab-content">
            
            <?php
             if (!empty($battleList)) { 
             //echo '<pre>'; print_r($battleList); die;
             foreach ($battleList as $key => $battleListArray) {
            ?>
                <div role="tabpanel" class="tab-pane <?=$key==1?'active':''?>" id="0<?=$key?>">
                    <div class="examples">
                        <div id="tab0<?=$key?>" class="eg tab-block">
                            <?php
                             foreach ($battleListArray as $key1 => $value) {
                
                                 if(file_exists(getcwd().'/uploads/profile_picture/130x130/'.$value['c_profile']) && $value['c_profile'] != '') {
                                     $chlngr_prof_pic = $value['c_profile'];
                                 } else {
                                     $chlngr_prof_pic = 'default.png';
                                 }
                                $chlngr_prof_pic = base_url('uploads/profile_picture/130x130/'.$chlngr_prof_pic);

                                
                                if(file_exists(getcwd().'/uploads/profile_picture/130x130/'.$value['f_profile']) && $value['f_profile'] != '') {
                                    $friend_prof_pic = $value['f_profile'];
                                } else {
                                    $friend_prof_pic = 'default.png';
                                }
                                $friend_prof_pic = base_url('uploads/profile_picture/130x130/'.$friend_prof_pic);

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
                                    <div class="user-battle">
                                        <div class="user-battle-left">
                                            <div class="userbattle-img">
                                                <img src="<?=$chlngr_prof_pic?>" alt="<?=$value['challenger']?>">
                                            </div>
                                            <div class="userbattle-text">
                                                <a href="<?=base_url('profile/view/'.$value['user_id'])?>"><h2><?=ucwords($value['challenger'])?></h2></a>
                                                <p><?=$challenger_media_title?></p>
                                                
                                                <?php if($challenger_media_array[0] != '') { ?>
                                                    <div class="like-place">
                                                        <div class="like-btn">
                                                            <a href="javascript:void(0)" class="songLike" battleid="<?=$value['battle_request_id']?>" dataid="<?=$challenger_media_id?>" alt='<?=$userId?>'>
                                                                <img src="<?= base_url() ?>public/images/like-green.png" alt="like">
                                                            </a>
                                                        </div>
                                                        <div class="like-point like_count_<?=$challenger_media_id?>"><?=$value['challenger_like']?></div>
                                                    </div>
                                                <?php } ?>
                                                <div>
                                                    <?php if($value['winner'] > 0 ) { if($value['user_id'] == $value['winner']) { ?>
                                                            <a href="javascript:void(0)" style="color: green;">Winner</a>
                                                    <?php } else { ?> 
                                                        <a href="javascript:void(0)" style="color: red;">Loser</a>
                                                    <?php } } ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="user-battle-right">
                                            <div class="userbattle-img">
                                                <img src="<?=$friend_prof_pic?>" alt="<?=$value['friend']?>">
                                            </div>
                                            <div class="userbattle-text">
                                                <a href="<?=base_url('profile/view/'.$value['friend_user_id'])?>"><h2><?=ucwords($value['friend'])?></h2></a>
                                                <p><?=$friend_media_title?></p>
                                                
                                                <?php if($friend_media_array[0] != '') { ?>
                                                    <div class="like-place">
                                                        <div class="like-btn">
                                                            <a href="javascript:void(0)" battleid="<?=$value['battle_request_id']?>" dataid="<?=$friend_media_id?>" alt='<?=$userId?>' class="songLike">
                                                                <img src="<?= base_url() ?>public/images/like.jpg" alt="like">
                                                            </a>
                                                        </div>
                                                        <div class="like-point like_count_<?=$friend_media_id?>"><?=$value['friend_like']?></div>
                                                    </div>
                                                <?php } ?>
                                                
                                                <div>
                                                    <?php if($value['winner'] > 0 ) {
                                                            if($value['friend_user_id'] == $value['winner']) {
                                                        ?>
                                                            <a href="javascript:void(0)" style="color: green;">Winner</a>
                                                    <?php } else { ?> 
                                                            <a href="javascript:void(0)" style="color: red;">Loser</a>
                                                        <?php } } ?>
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
                                        </div>

                                        <div class="go-to-battel"> <a href="<?=$link?>"> Go to Battle </a></div>
                                    </div>

                             <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } }?>
            
            
        </div>
    </div>

    <div class="clearfix"></div>



</div>