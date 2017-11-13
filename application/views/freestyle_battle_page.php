<?php
$this->load->view('battle_temp/header');

$sess_data = get_session_data();
$user_id = $sess_data['id'];
if (isset($user_id)) {
    $user = $this->wallet->getUserCoin($user_id);
    $user_coins = $user['coins'];
}
//echo '<pre>';print_r($user);
$voterVotes = array();
$challenger_mediaPath = $challenger_title = $friend_media_path = $friend_title = '';

//echo "<pre>";
//print_r($battle_media);
$challenger_song_id = '';
$friend_song_id = '';
$challenger_like_count = 0;
$friend_like_count = 0;

if (!empty($battle_media))
//echo "<pre>"; print_r($battle_media);
    foreach ($battle_media as $key => $value) {
        $path = $this->config->item('battle_media_path') . $value['media'];
        $title = $value['title'];
        if ($battle_details['user_id'] == $value['artist_id']) {
            $challenger_mediaPath = $path;
            $challenger_title = $title;
            $challenger_song_id = $value['fk_song_id'];
            $challenger_like_count = $value['like_count'];
        }
        if ($battle_details['friend_user_id'] == $value['artist_id']) {
            $friend_media_path = $path;
            $friend_title = $title;
            $friend_song_id = $value['fk_song_id'];
            $friend_like_count = $value['like_count'];
        }
    }
//echo "<pre>";
//print_r($battle_details);

if ($user_id > 0) {
    foreach ($vote_details as $key => $value) {
        if ($value['voter_id'] == $user_id) {
            $voterVotes[$value['artist_id']]['social_media'][$value['social_media_type']] = 1;
        }
    }
}
//end of upload for media data
//print_r($voterVotes);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php 
     if($battle_details['status'] == 0 )
	  $text = ' challenged ' ;
     else
	 $text = ' started ' ;
     //$battle_details['challenger'] .' has '.$text.' battle with '. $battle_details['friend']
     //$battle_details['battle_name']
     //$battle_details['description']
?>
	 
<?php if( $user_id == $battle_details['friend_user_id'] && $battle_details['status'] == 0 && $battle_details['battle_category'] != 5 ) { ?>
<!-- start challenge accept or decline popup --> 
<div id="challenge_accept_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
			
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button> 
                     <h4 class="modal-title"><?='Would you accept '.ucfirst($battle_details['challenger']).' challenge !'?></h4>
                </div>
                
                <div class="modal-body">
                    <div class="alert-info">
                        <?php if($battle_details['entry']>0) { ?>
                            <small style="margin-left: 58px;">
                                <?php echo 'Charge of '.$battle_details['entry'].' battle bucks will be charged after accepting challenge' ?>
                            </small>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="pull-right">
                        <a href="<?php echo base_url().'battle/request/'.$battle_details['battle_request_id'].'/4'?>" class="btn btn-success">Accept</a>
                        <a href="<?php echo base_url().'battle/request/'.$battle_details['battle_request_id'].'/2'?>" class="btn btn-small btn-danger">Reject</a>
                    </div>
                </div>
		 
            </div>
        </div>
    </div>
<!-- end challenge accept or decline popup --> 
<?php } ?>

 <?php if($this->session->flashdata('success')) { ?>
    <div id="session_msg" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
			
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button> 
                     <h4 class="modal-title">Acknowledgement Message</h4>
                </div>
                
                <div class="modal-body">
                    <div class="alert-info">
                        <small style="margin-left: 58px; color: green;">
                            <?=$this->session->flashdata('success')?>
                        </small>
                    </div>
                    <br>
                </div>
		 
            </div>
        </div>
    </div>            
<?php } ?>

<?php if($battle_details['status'] == 4 && $battle_details['battle_category'] == 5) { ?>
<div id="freestyle_beat_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
			
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button> 
                     <h4 class="modal-title">Started freestyle battle</h4>
                </div>
                
                <div class="modal-body">
                    <div class="alert-info">
                        <small style="margin-left: 58px; color: green;">
                            Freestyle battle will start on <?=date('F d, \a\t g:i a',strtotime($battle_details['date_time']))?> 
                        </small>
                    </div>
                    <br>
                </div>
		 
            </div>
        </div>
    </div>

<!-- For count down popup is start -->
<div id="count_down_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                 <h4 class="modal-title">Count down is started</h4>
            </div>

            <div class="modal-body">
                <div class="alert-info">
                    <h3>Started in <span class="countdown">60</span> seconds</h3>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>

<?php } ?>
    
<div style="display: none;">
    <input type="hidden" id="artists_id" name="artists_id">
    <input type="hidden" id="voter_id" name="voter_id" value="<?php echo $sess_data['id']?>">
    <input type="hidden" id="battle_id" name="battle_id" value="<?php echo $battle_details['battle_request_id']?>">
    <input type="hidden" id="battle_name" name="battle_name" value="<?php echo $battle_details['battle_name'];?>" />
</div>
	 

<?php  
 if($user_id == $battle_details['friend_user_id'] && $friend_media_path != '')
    $media_count = 1 ; 
  else if($user_id == $battle_details['user_id'] && $challenger_mediaPath != '')
        $media_count = 1;
  else
      $media_count = 0;
  
if(($user_id == $battle_details['friend_user_id'] OR  $user_id == $battle_details['user_id']) && $media_count == 0) { ?>
        <!-- start challenge file upload popup --> 
        <?php $this->load->view('freestyle_live_voice'); ?>
        <!-- end challenge file upload popup --> 
<?php } ?>

<?php if( ($user_id == $battle_details['friend_user_id'] OR  $user_id == $battle_details['user_id']) ) { ?>
    <div class="centered" style="text-align: center; display: none;">
	    <div class="doc-buttons">
		<a href="#" class="btn btn-md btn-success promoteBtn" data-toggle="modal" data-target="#promote_div">Promote</a>
		<br>
	    </div>
    </div>
<?php } ?>



<div class="container">
    <div class="logo">
        <a href="<?= base_url() ?>"><img src="<?= base_url('public/images/battle-logo.png') ?>" alt=""/></a>
    </div>

    <div class="row">
        <div class="col-xs-5">
            <div class="user_name">
                <a target="_blank" href="<?=  base_url('profile/view/'.$battle_details['user_id'])?>">
                    <h2><?=$battle_details['challenger']?></h2></a>
            </div>
        </div>
        <div class="col-xs-2">
            <?php if(isset($user_id) && $battle_details['entry']>0) { ?>
                <div class="support">
                    <a data-toggle="modal" data-target="#support_your_artist_popup" href="javascript:void(0)">
                        <h2>Support <span>Your artist</span></h2>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="col-xs-5">
            <div class="user_name2">
                    <a target="_blank" href="<?=  base_url('profile/view/'.$battle_details['friend_user_id'])?>">
                        <h2><?=$battle_details['friend']?></h2>
                    </a>
            </div>
        </div>
    </div>
</div>

<div class="container middle_set">
    <div class="row">
        
        
        <div class="col-xs-6">

            <div class="leftSVG">
                 <div class="mainboxred">
                     <?php 
                        if($battle_details['c_profile'] == '') {
                            $c_img_path = base_url('public/images/clipOne.jpg');
                        } else {
                            if(file_exists(getcwd().'/uploads/profile_picture/medium_'.$battle_details['c_profile'])) {
                                $c_img_path = base_url('uploads/profile_picture/'.'medium_'.$battle_details['c_profile']);
                            } else {
                                $c_img_path = base_url('uploads/profile_picture/'.$battle_details['c_profile']);
                            }
                        }
                    ?>
                    <img src="<?=$c_img_path?>" class="mySelectorOne" />
                 </div>
            </div>
            
            <div class="song_details">
                
                <div class="song_name">
                    <?php if($challenger_mediaPath != '') { ?>
                    <div class="song_name_inner">
                        <h3><?=$challenger_title?></h3>&nbsp;

                        <?php if($battle_details['battle_category'] == 4) { ?>
                            <a href="javascript:void(0)" data-target="#challenger_video_popup" data-toggle="modal"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <?php } else { //base_url($challenger_mediaPath)?>
                            <audio id="challengerAudio">
                              <source src="<?=base_url($challenger_mediaPath)?>">
                            </audio>
                            <a href="javascript:void(0)" class="playAudio"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <?php } ?>
                        
                        <?php //if( ($user_id != $battle_details['friend_user_id'] AND  $user_id != $battle_details['user_id']) ) { ?>
                        <div class="like">
                            <a href="javascript:void(0)" data-toggle="button" dataid="<?php echo $challenger_song_id?>" alt='<?php echo $user_id?>' class="songLike"> 
                                <h3 class="like_count_<?php echo $challenger_song_id;?>"><?php echo $challenger_like_count;?></h3>&nbsp;
                                <img src="<?= base_url('public/images/battle-like.png') ?>" alt=""/>
                            </a> 
                        </div>
                        <?php //} ?>
                        
                    </div>
                    <?php } ?>
                </div>
                
                <div class="song_name">
                    <div class="song_name_inner2">
                        <?php if($battle_details['entry']>0) { ?>
                        <h3><?=$battle_details['entry']?></h3>
                        <?php } ?>
                        <div class="mike_section">
                            <ul>
                                <li class="yellow_mike"><?=$battle_details['c_win']?></li>
                                <li class="gray_mike">0</li>
                                <li class="lightgray_mike">0</li>
                                <li class="red_mike"><?=$battle_details['c_loss']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php if( ($user_id != $battle_details['friend_user_id'] AND  $user_id != $battle_details['user_id']) ) { ?>
                <div class="vote_button">
                    <a href="javascript:void(0)" alt="<?php echo $battle_details['user_id']?>" class="voteBtn" data-target="#vote_challenger" data-toggle="modal">
                        <img src="<?= base_url('public/images/button1.png') ?>" alt=""/>
                    </a>
                </div>
                <?php } ?>
            </div>
            <!--.leftSVG-->
        </div>
        
        <div class="col-xs-6">
            <div class="rightSVG">
                <div class="mainbox">
                    <?php 
                        if($battle_details['f_profile'] == '') {
                            $f_img_path = base_url('public/images/clipTwo.jpg');
                        } else {
                            if(file_exists(getcwd().'/uploads/profile_picture/medium_'.$battle_details['f_profile'])) {
                                $f_img_path = base_url('uploads/profile_picture/'.'medium_'.$battle_details['f_profile']);
                            } else {
                                $f_img_path = base_url('uploads/profile_picture/'.$battle_details['f_profile']);
                            }
                        }
                    ?>
                    <img src="<?=$f_img_path?>" class="mySelector" />
                </div>
            </div><!--.rightSVG-->   
            
            <div class="song_details2">
                <div class="song_name">
                    <?php if($friend_media_path != '') { ?>
                    <div class="song_name_inner">
                        <h3><?=$friend_title?></h3>&nbsp;
                        <?php if($battle_details['battle_category'] == 4) { ?>
                             <a href="javascript:void(0)" data-target="#friend_video_popup" data-toggle="modal"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <?php } else { ?>
                             <audio id="friendAudio">
                              <source src="<?=base_url($friend_media_path)?>">
                            </audio>
                            <a href="javascript:void(0)" class="friendPlayAudio"><i class="fa fa-play" aria-hidden="true"></i></a>
                       <?php } ?>
                        
                        <div class="like">
                            <a href="javascript:void(0)" data-toggle="button" dataid="<?php echo $friend_song_id?>" alt='<?php echo $user_id?>' class="songLike"> 
                                <h3 class="like_count_<?php echo $friend_song_id;?>"><?php echo $friend_like_count;?></h3>&nbsp;
                                <img src="<?= base_url('public/images/battle-like.png') ?>" alt=""/>
                            </a>
                        </div>
                        
                    </div>
                    <?php } ?>
                </div>
                <div class="song_name">
                    <div class="song_name_inner2">
                        <?php if($battle_details['entry']>0) { ?>
                            <h3><?=$battle_details['entry']?></h3>
                        <?php } ?>
                        <div class="mike_section">
                            <ul>
                                <li class="yellow_mike"><?=$battle_details['win_cnt']?></li>
                                <li class="gray_mike">0</li>
                                <li class="lightgray_mike">0</li>
                                <li class="red_mike"><?=$battle_details['lose_cnt']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if( ($user_id != $battle_details['friend_user_id'] AND  $user_id != $battle_details['user_id']) ) { ?>
                    <div class="vote_button2">
                        <a href="javascript:void(0)" class="voteBtn" alt="<?php echo $battle_details['friend_user_id']?>" data-toggle="modal" data-target="#vote_1">
                            <img src="<?= base_url('public/images/button2.png') ?>" alt=""/>
                        </a>
                    </div>
                <?php } ?>
                
            </div>         
        </div>

        <div class="vas">
            <img src="<?= base_url('public/images/vs.png') ?>" alt=""/>
            <div class="victory">
                 <?php if(isset($user_id) && $battle_details['entry']>0) { ?>
                    <img src="<?= base_url('public/images/victor.png') ?>" alt=""/>
                    <h3><?=round($battle_details['entry']*2 + $support_amount)?> <img src="<?= base_url('public/images/b.png') ?>" alt=""/></h3>
                 <?php } ?>
            </div>
        </div>
    </div>    
</div>   

<div class="three_scroller">
    <div class="container">
        <div class="row">
            
            <div class="col-xs-4">
                <div class="red_scroll_box">
                    <h2 id="vote_cnt_<?php echo $battle_details['user_id'] ?>">Who Voted (<?php echo $battle_details['user_vote_cnt'] ?>)</h2>
                    
                    <ul class="red_ul" id="voter_list_<?php echo $battle_details['user_id'] ?>">
                        
                         <?php if(!empty($vote_details)) { 
                                foreach ($vote_details as $voter) {
                                    if($voter['artist_id'] == $battle_details['user_id'] ){
                             ?>
                            <li> 
                                <div class="singer_name">
                                    <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank">
                                        <?php if($voter['profile_picture'] != '') { ?>
                                            <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/thumb_'.$voter['profile_picture'])?>">
                                        <?php } else { ?>
                                            <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>" style="width: 50px">
                                        <?php } ?>
                                    </a>
                                </div>
                                
                                <div class="song_title">
                                    <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank"> 
                                        <?=$voter['voter_name']?>
                                    </a>
                                </div>
                            </li> 
                         <?php }} } ?> 
                    </ul>
                </div>
            </div>
            
            <div class="col-xs-4">
              <?php if(isset($user_id) && $battle_details['entry']>0) {
                  if(!empty($support_users)) {
                  ?>  
                <div class="red_scroll_box yellow_box_scroll">
                    <h2>Who Donated</h2>
                    <ul class="red_ul">
                        <?php foreach ($support_users as $sval) { ?>
                                <li> 
                                    <div class="singer_name">
                                        <a class="thumb-sm m-r" href="<?=  base_url('profile/view/'.$sval['supporter_id'])?>" target="_blank" >
                                            <?php if($sval['profile_picture'] != '') { ?>
                                            <img alt="<?=$sval['supporter_name']?>" src="<?php echo base_url('uploads/profile_picture/'.'thumb_'.$sval['profile_picture'])?>">
                                            <?php } else { ?>
                                            <img alt="<?=$sval['supporter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>" style="width: 50px">
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="song_title">
                                        <a href="<?=  base_url('profile/view/'.$sval['supporter_id'])?>" target="_blank"  class="clear"> 
                                            <?=$sval['supporter_name'] .' - '.(int)$sval['battle_bucks'].'B'?>
                                        </a>
                                    </div>
                                </li> 
                        <?php } ?> 
                    </ul>
                </div>
              <?php } }?>  
            </div>
            
            <div class="col-xs-4">
                <div class="red_scroll_box blue_box_scroll">
                    <h2 id="vote_cnt_<?php echo $battle_details['friend_user_id'] ?>">Who Voted (<?php echo $battle_details['friend_vote_cnt'] ?>)</h2>
                    <ul class="red_ul" id="voter_list_<?php echo $battle_details['friend_user_id'] ?>">
                        <?php if(!empty($vote_details)) { 
                                foreach ($vote_details as $voter) {
                                    if($voter['artist_id'] == $battle_details['friend_user_id'] ){
                             ?>
                            <li> 
                                <div class="singer_name">
                                    <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank">
                                        <?php if($voter['profile_picture'] != '') { ?>
                                            <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/thumb_'.$voter['profile_picture'])?>">
                                        <?php } else { ?>
                                            <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>" style="width: 50px">
                                        <?php } ?>
                                    </a>
                                </div>
                                
                                <div class="song_title">
                                    <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank"> 
                                        <?=$voter['voter_name']?>
                                    </a>
                                </div>
                            </li> 
                         <?php }} } ?>
                        
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

</div> 

<!-- for promote section -->
<div id="promote_div" class="modal fade common-modal-popup promote-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Promote for your Battle</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    <a  class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>" id="tw_share_btn_promote">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <a  class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn_promote">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 

                </p>
            </div>

        </div>
    </div>
</div>
<!-- end of the promote section -->

<!-- for voting popup section -->
<div id="vote_challenger" class="modal fade common-modal-popup vote-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <?php 
             $disableFb = $disableTw = '' ;
             if( !empty($sess_data))
             {
                 if(array_key_exists($battle_details['user_id'] , $voterVotes))
                 {
                     $socialMediaArr = $voterVotes[$battle_details['user_id']]['social_media'] ;
                     if(array_key_exists('fb' , $socialMediaArr))
                             $disableFb = 'disabled="disabled"';
                     if(array_key_exists('tw' , $socialMediaArr))
                              $disableTw = 'disabled="disabled"';
                 }

                 ?>

            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Share this page on either of the site</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    <a  <?php echo $disableTw ?> class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>" id="tw_share_btn_c">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <a  <?php echo $disableFb ?> class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn_c">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 
<!--			<a class="btn btn-sm btn-danger" href="#">
                        <i class="fa fa-fw fa-instagram"></i> Instagram</a>-->
                </p>
            </div>
            <?php  } else {
                    ?>
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                Vote for Artists
            </div> 
            <div class="modal-body">
                <p>
                    Please <a href="<?php echo base_url()?>" class="text-info">Login</a> OR 
                    <a href="<?php echo base_url('user/registration')?>" class="text-info">Sign Up</a> to place Vote.
                </p>
            </div>
                        <?php 
                }
             ?>
        </div>
    </div>
</div>

<div id="vote_1" class="modal fade common-modal-popup vote-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
        <?php 
             $disableBtnFb = $disableBtnTw = '' ;
             if( !empty($sess_data))
             {
                 if(array_key_exists($battle_details['friend_user_id'] , $voterVotes))
                 {
                     $socialMediaArr = $voterVotes[$battle_details['friend_user_id']]['social_media'] ;
                     if(array_key_exists('fb' , $socialMediaArr))
                             $disableBtnFb = 'disabled="disabled"';
                     if(array_key_exists('tw' , $socialMediaArr))
                              $disableBtnTw = 'disabled="disabled"';
                 }

                 ?>

            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Share this page on either of the site</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    <a class="btn btn-sm btn-info" <?php echo $disableBtnTw ?> href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>" id="tw_share_btn">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <a <?php echo $disableBtnFb ?> class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 
<!--			<a class="btn btn-sm btn-danger" href="#">
                        <i class="fa fa-fw fa-instagram"></i> Instagram</a>-->
                </p>
            </div>
            <?php  } else {
                    ?>
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                Vote for Artists
            </div> 
            <div class="modal-body">
                <p>
                    Please <a href="<?php echo base_url()?>" class="text-info">Login</a> OR 
                    <a href="<?php echo base_url('user/registration')?>" class="text-info">Sign Up</a> to place Vote.
                </p>
            </div>
                        <?php 
                }
             ?>
        </div>
    </div>
</div>
<!-- for voting popup section -->

<!-- ==== Support your artist action ==== -->
<form action="<?=base_url().'wallet/support_artist'?>" method="post" id="support_form" style="display: none" >
    <input type="text" value="10" name="amount" id="support_amount">
    <input type="text" value="<?=$battle_details['battle_request_id']?>" name="battle_id">
</form>

<!-- == Support your artist pop-up == -->
<?php if(isset($user_id)) { ?>
<div id="support_your_artist_popup" class="modal fade common-modal-popup vote-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
			
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <h4 class="modal-title">Support your artist</h4>
                </div>
                <form action="<?=base_url().'wallet/support_artist_from_wallet'?>" method="post" id="support_your_artist" >
                    <div class="modal-body">
                        <div class="alert-info">Your Balance: <strong id="user_bb"><?=$user_coins?></strong> Battle bucks</div>
                        <br>
                        <div>
                            <p>How much <strong>Battle bucks</strong> you would like to donate to this battle</p>
                            <input type="number" min="1" name="amount" id="wallet_amount" required="" >
                            <input type="text" value="<?=$battle_details['battle_request_id']?>" name="battle_id" hidden="">
                            <input type="submit" value="Donate" class="btn btn-sm btn-info">
                        </div>

                    </div>
                </form>
		 
            </div>
        </div>
    </div>
<?php } ?>
<!-- == end of the Support your artist pop-up == -->

<!-- challenger video popup -->
<?php if($challenger_mediaPath != '') { ?> 
<div id="challenger_video_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Artist video</h4>
            </div>
            
            <div class="modal-body">
                 <video width="400" controls="controls">
                    <source type="video/mp4" src="<?=base_url($challenger_mediaPath)?>"></source>
                 </video>
            </div>

        </div>
    </div>
</div>
<?php } ?>
<!-- challenger video popup -->

<!-- friend video popup -->
<?php if($friend_media_path != '') { ?> 
<div id="friend_video_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Artist video</h4>
            </div>
            
            <div class="modal-body">
                 <video width="400" controls="controls">
                    <source type="video/mp4" src="<?=base_url($friend_media_path)?>"></source>
                 </video>
            </div>

        </div>
    </div>
</div>
<?php } ?>
<!-- friend video popup -->

<script type="text/javascript">
    $(document).ready(function(){
          var playing = false;
          $('.playAudio').click(function() {
              if (playing == false) {
                  playing = true;
                  document.getElementById('challengerAudio').play();
                  $(this).html('<i class="fa fa-pause" aria-hidden="true"></i>');
              } else {
                playing = false;
                document.getElementById('challengerAudio').pause();
                $(this).html('<i class="fa fa-play" aria-hidden="true"></i>');
              }
          });
          
          // for friend audio
          var friend_playing = false;
          $('.friendPlayAudio').click(function() {
              if (friend_playing == false) {
                  friend_playing = true;
                  document.getElementById('friendAudio').play();
                  $(this).html('<i class="fa fa-pause" aria-hidden="true"></i>');
              } else {
                friend_playing = false;
                document.getElementById('friendAudio').pause();
                $(this).html('<i class="fa fa-play" aria-hidden="true"></i>');
              }
          });
        
    });
    
    
    <?php if( $user_id == $battle_details['friend_user_id'] && $battle_details['status'] == 0 ) { ?>
        $(window).load(function(){
            $('#challenge_accept_popup').modal('show');
        });
    <?php } ?>
        
    <?php if($this->session->flashdata('success')) { ?>
        $(window).load(function(){
            $('#session_msg').modal('show');
        });
    <?php } ?>
        
        
    <?php if($battle_details['status'] == 4 && $battle_details['battle_category'] == 5) { ?>
        $(window).load(function(){
        $('#freestyle_beat_popup').modal('show');
    });
    <?php } ?>

        
    <?php  if($battle_details['status'] == 1 && ($user_id == $battle_details['friend_user_id'] OR  $user_id == $battle_details['user_id']) && $media_count == 0) { ?>
     $(window).load(function(){
         $('#file_upload_popup').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        //$('#file_upload_popup').modal('show');
    });
    <?php } ?>
        
</script>

<!--    <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>-->
<!--<script src="http://code.jquery.com/jquery-latest.pack.js" type="text/javascript"></script>-->
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
<!--<script src="<?php //echo base_url('public/js/jquery.twitterbutton.1.1.js')?>" type="text/javascript"></script>-->
<script>
window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));

</script>

<script type="text/javascript">
$(document).ready(function(){
	
	$(".voteBtn").click(function (event) {
	    var obj = $(this);
	    var artist_id;
            event.preventDefault();
             artist_id = $(this).attr('alt');
	     $('#artists_id').val(artist_id);
	    
	});
	
	twttr.ready(function (twttr) {
	//get  twitter event
	twttr.events.bind('tweet' , function(event) {
	elemId = event.target.id;
	if(elemId !== 'tw_share_btn_promote')
	{
		placeVote('tw');
		$("#msg").removeClass();
	        $("#msg").addClass('alert');
		$("#msg").addClass('alert-success');
		$("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> Thank you for your vote.");
		$("#"+elemId).attr('disabled' , 'disabled');
		setTimeout(function () {
		$("#msg").removeClass();
		$("#msg").html('');
			    }, 10000);
		$(".close").trigger("click");
	}
		
     });
	});	
		
	var URL = window.location.href ;
	
	/* FACEBOOK SHARE CODE */
	 $('.fb_share_btn').click(function (e) {
	    e.preventDefault();
	    evnt = e ;
	    obj = $(this);
	    elemId = e.target.id;
            FB.ui({
                        method: 'share',
                        href: URL
		    }, function(response){
			if(elemId != 'fb_share_btn_promote' ) {
			if (response && !response.error_code) {
			    
				console.log("OK: "+JSON.stringify(response));
			   placeVote('fb');
			    $("#msg").removeClass();
			    $("#msg").addClass('alert');
			    $("#msg").addClass('alert-success');
			    $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> Thank you for your vote.");
			   // $("#vote").dialog('close');
			   setTimeout(function () {
				 $("#msg").removeClass();
				 $("#msg").html('');
			    
			    $('#'+elemId).attr('disabled' , 'disabled');
			    }, 4000);
			    
			    $(".close").trigger("click");
			    
			} else {
			    console.log("Not OK: "+JSON.stringify(response));
			    $("#msg").removeClass();
			    $("#msg").addClass('alert');
			    $("#msg").addClass('alert-info');
			    $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button>Your vote can not be placed untill you share this battle");
			    $(".close").trigger("click");
			}
                        }
			else
			{
			    $(".close").trigger("click");
			}
			
                    });
        });
	
    }) ;
    
  
    
    function placeVote(socialMedia)
    {
		var artists_id = $('#artists_id').val();
		var social_media = socialMedia ;
		var voter_id =  $('#voter_id').val();
		var battle_id = $('#battle_id').val();
		var battle_name =$('#battle_name').val();
		 $.ajax({
                type: "POST",
                url: base_url + "ajax/place_vote",
                dataType: "json",
                data: {artist_id: artists_id, voter_id: voter_id, battle_id: battle_id, social_media_type: social_media},
                success: function (data) {
                	//console.log('Result: '+data);
                    $('#vote_cnt_'+artists_id).html("");
                    $('#vote_cnt_'+artists_id).html('Who Voted ('+data[0]+')');
                    
                    $('#voter_list_'+artists_id).html(data[1]);
                    $('.red_ul').mCustomScrollbar("update");
		    
                },
                complete:function(){
                	$.ajax({
                		type: "POST",
                		url: base_url + "ajax/place_post",
                		data:{battle_name:battle_name,subject_id: artists_id, object_id: voter_id, battle_id: battle_id, social_media_type: social_media},
                		success:function(res){
                			//console.log("post"+res);
                		}
                	});
                }
            });
    }



$(document).ready(function(){
    $('#support_your_artist').on('submit', function(){
        
        var wallet_amount = $('#wallet_amount').val();
        var user_bb = parseInt($('#user_bb').html());
        if(wallet_amount > 0) {
            if(user_bb >= wallet_amount) {
                return true;
            } else {
                $('#support_amount').val(wallet_amount*1.1);
                $('#support_form').submit();
            }
        }
        return false;
    });
    
    $('.songLike').click(function () {
            currObj = $(this);
            var data_id = $(this).attr('dataid');
            var like_type = 'song';
            var user_id = $(this).attr('alt');
            if (user_id == '') {
                return false;
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>ajax/like/",
                data: {data_id: data_id, like_type: like_type, user_id: user_id},
                success: function (data) {
                    $('.like_count_' + data_id).html(data);
                    currObj.addClass('active');
                }
            });
        });
        
// freestyle artist send notification 
sendNotification();
setInterval(sendNotification, 15000);
function sendNotification() {
    $.ajax({
        type: "POST",
        url: "<?=base_url() ?>battle/start_notification/",
        data: {battle_id: '<?=base64_encode($battle_details['battle_request_id'])?>'},
        success: function (data) {

        }
    });
}

// Auto start freestyle battle
autoStartFreestyle();
setInterval(autoStartFreestyle, 10000);
function autoStartFreestyle() {
    $.ajax({
        type: "POST",
        url: "<?=base_url() ?>battle/auto_start/",
        data: {battle_id: '<?=base64_encode($battle_details['battle_request_id'])?>'},
        success: function (data) {
            if(data == 1) {
                $('#freestyle_beat_popup').modal('hide');
                $('#count_down_popup').modal('show');
            }
                
        }
    });
}

// count down script
$('#count_down_popup').on('shown.bs.modal', function () { 
   var doUpdate = function() {
    $('.countdown').each(function() {
      var count = parseInt($(this).html());
      if (count !== 0) {
        $(this).html(count - 1);
      } else {
          $('#count_down_popup').modal('hide');
          //$('#file_upload_popup').modal('show');
          
          $('#file_upload_popup').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
      }
      
      
    });
  };

  // Schedule the update to happen once every second
  setInterval(doUpdate, 1000);
});

 





});
</script>

<?php
$this->load->view('battle_temp/footer');