<?php
$this->load->view('battle_temp/header');
$this->config->load('config_facebook');

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
//print_r($voterVotes);
//upload media form data

 
//print_r($voterVotes);


$song_array = [];
if (isset($own_songs) && !empty($own_songs)) {
    foreach ($own_songs as $songKey => $songValue) {
            $song_id = $songValue['sId'];
            $media = $this->config->item('library_media_path') . $songValue['media'];
            //$artist = $songValue['user_id'];
            $artistName = ucfirst($songValue['firstname']);
            $title = substr($songValue['title'], 0,12).'...';
            //$likeCount = $songValue['likeCount'];

            if (file_exists('/home2/pranay/public_html/samiran/battleme/' . $media)) {
                $song_array[] = [base_url() . $media, $title, $song_id];
            } else if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/battleme/' . $media)) {
                $song_array[] = [base_url() . $media, $title, $song_id];
            }
    }
}

 $songs_str = json_encode($song_array); 

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

<div style="display: none;">
    <input type="hidden" id="artists_id" name="artists_id">
    <input type="hidden" id="voter_id" name="voter_id" value="<?php echo $sess_data['id']?>">
    <input type="hidden" id="battle_id" name="battle_id" value="<?php echo $battle_details['battle_request_id']?>">
    <input type="hidden" id="battle_name" name="battle_name" value="<?php echo $battle_details['battle_name'];?>" />
</div>


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
            <br><br>
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
                
                    <?php if($battle_details['user_id']==$battle_details['winner']) { ?>
                        <div class="winner_stamp_1">WINNER</div>
                    <?php } else { ?> 
                         <div class="looser_stamp">LOOSER</div>
                    <?php } ?>
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
                            <a href="javascript:void(0)" data-toggle="button" battleid="<?=$battle_details['battle_request_id']?>" dataid="<?php echo $challenger_song_id?>" alt='<?php echo $user_id?>' class="songLike"> 
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
                
                <?php if($battle_details['friend_user_id']==$battle_details['winner']) { ?>
                        <div class="winner_stamp">WINNER</div>
                    <?php } else { ?> 
                         <div class="looser_stamp_1">LOOSER</div>
                    <?php } ?>
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
                            <a href="javascript:void(0)" data-toggle="button" battleid="<?=$battle_details['battle_request_id']?>" dataid="<?php echo $friend_song_id?>" alt='<?php echo $user_id?>' class="songLike"> 
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
                    
                    <ul class="red_ul" id="voter_list_<?=$battle_details['user_id'] ?>">
                        
                         <?php if(!empty($vote_details)) { 
                                foreach ($vote_details as $voter) {
                                    if($voter['artist_id'] == $battle_details['user_id'] ){
                             ?>
                            <li> 
                                <div class="singer_name">
                                    <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank">
                                        <?php if($voter['profile_picture'] != '' && file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $voter['profile_picture'])) { ?>
                                            <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/thumb_'.$voter['profile_picture'])?>" style="width: 50px">
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
                                            <?php if($sval['profile_picture'] != '' && file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $sval['profile_picture'])) { ?>
                                            <img alt="<?=$sval['supporter_name']?>" src="<?php echo base_url('uploads/profile_picture/thumb_'.$sval['profile_picture'])?>" style="width: 50px">
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
                    <ul class="red_ul" id="voter_list_<?=$battle_details['friend_user_id'] ?>">
                        <?php if(!empty($vote_details)) { 
                                foreach ($vote_details as $voter) {
                                    if($voter['artist_id'] == $battle_details['friend_user_id'] ){
                             ?>
                            <li> 
                                <div class="singer_name">
                                    <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank">
                                            <?php if($voter['profile_picture'] != '' && file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $voter['profile_picture'])) { ?>
                                            <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/thumb_'.$voter['profile_picture'])?>" style="width: 50px">
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
    
        
    <?php if($this->session->flashdata('success')) { ?>
        $(window).load(function(){
            $('#session_msg').modal('show');
        });
    <?php } ?>
</script>
 
<script type="text/javascript">

$(document).ready(function(){
    
    $('.songLike').click(function () {
            currObj = $(this);
            var data_id = $(this).attr('dataid');
            var like_type = 'song';
            var battle_id = $(this).attr('battleid');
            var user_id = $(this).attr('alt');
            if (user_id == '') {
                return false;
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>ajax/like/",
                data: {data_id: data_id, like_type: like_type, user_id: user_id, battle_id: battle_id},
                success: function (data) {
                    $('.like_count_' + data_id).html(data);
                    currObj.addClass('active');
                }
            });
        });
        
        
        // For pick song from Lirrary
         $('input[name="media_type"]').click(function () {
            if ($('input[name=media_type]:checked').val() == 1) {
                $('#file_area').show();
                $('#library_area').hide();
            } else {
                $('#library_area').show();
                $('#file_area').hide();
            }
        });
        if ($('input[name=media_type]:checked').val() == 1) {
                $('#file_area').show();
                $('#library_area').hide();
            }
        if ($('input[name=media_type]:checked').val() == 2) {
                $('#library_area').show();
                $('#file_area').hide();
            }
            
        var soundArr = <?=$songs_str?>;
        var sLan = soundArr.length; 

        for (i = 0; i < sLan; i++) {
            var songCount = i + 1;
            $(".soundWidget ul").append("<li><span><input type='radio' name='media_id' id='demia_data_"+soundArr[i][2]+"' value='" + soundArr[i][2] + "' ></span><div class=audioleft><a href=javascript:void(0)>" + soundArr[i][1] + "</a></div><div class=audioright><audio><source src='" + soundArr[i][0] + "'  type=audio/mpeg></audio><button onclick='return false' class=Soundplay></button><button onclick='return false' class=Soundpause></button></div></li>");
        }
        var aud = new Audio();
        var pp;
        $(".soundWidget ul li").each(function () {

            $(this).find(".Soundplay").click(function () {
                pp = $(this).prev().find("source").attr("src");
                aud.src = pp;
                aud.pause();
                aud.play();
            });
            $(this).find(".Soundpause").click(function () {
                aud.src = pp;
                aud.pause();
            });
        });
    
        <?php if(set_value('media_id') != '') { ?>
            $("#demia_data_"+<?=set_value('media_id')?>).prop("checked", true);
        <?php } ?>
        
});
</script>

<?php
$this->load->view('battle_temp/footer');