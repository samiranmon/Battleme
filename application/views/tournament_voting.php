<?php
$this->load->view('battle_temp/header');
$this->config->load('config_facebook');
$user_id = $userdata[0]->id; 
 
//echo '<pre>';print_r($userdata);
  //$path = $this->config->item('battle_media_path') . $value['media'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style type="text/css">
.victory {
    height: 142px;
    margin-top: 15px;
    text-align: center;
}
</style>

 <?php if($this->session->flashdata('success')) { ?>
    <div id="session_msg" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
			
                <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button> 
                     <h4 class="modal-title">Acknowledge messages</h4>
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
    <input type="hidden" id="voter_id" name="voter_id" value="<?=$user_id?>">
    <input type="hidden" id="tournament_id" name="tournament_id" value="<?=$tournament_id?>">
    <input type="hidden" id="round" name="round" value="<?=$round?>">
</div>
	 
 

<?php if( ($user_id == $group_details[0]['id'] OR  $user_id == $group_details[1]['id']) ) { ?>
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
                <a target="_blank" href="<?=  base_url('profile/view/'.$group_details[0]['id'])?>">
                    <h2><?=$group_details[0]['name']?></h2></a>
            </div>
        </div>
        <div class="col-xs-2">
             
        </div>
        <div class="col-xs-5">
            <div class="user_name2">
                    <a target="_blank" href="<?=  base_url('profile/view/'.$group_details[1]['id'])?>">
                        <h2><?=$group_details[1]['name']?></h2>
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
                        if($group_details[0]['profile_picture'] == '') {
                            $c_img_path = base_url('public/images/clipOne.jpg');
                        } else {
                            if(file_exists(getcwd().'/uploads/profile_picture/medium_'.$group_details[0]['profile_picture'])) {
                                $c_img_path = base_url('uploads/profile_picture/'.'medium_'.$group_details[0]['profile_picture']);
                            } else {
                                $c_img_path = base_url('uploads/profile_picture/'.$group_details[0]['profile_picture']);
                            }
                        }
                    ?>
                    <img src="<?=$c_img_path?>" class="mySelectorOne" />
                 </div>
            </div>
            
            <div class="song_details">
                
                <div class="song_name">
                    <?php if($group_details[0]['media'] != '') { ?>
                    <div class="song_name_inner">
                        <h3><?=$group_details[0]['title']?></h3>&nbsp;

                        <?php if(0) { ?>
                            <a href="javascript:void(0)" data-target="#challenger_video_popup" data-toggle="modal"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <?php } else { //base_url($challenger_mediaPath)?>
                            <audio id="challengerAudio">
                              <source src="<?=base_url($this->config->item('battle_media_path').$group_details[0]['media'])?>">
                            </audio>
                            <a href="javascript:void(0)" class="playAudio"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <?php } ?>
                        
                        <?php //if( ($user_id != $battle_details['friend_user_id'] AND  $user_id != $battle_details['user_id']) ) { ?>
                        <div class="like">
                            <a href="javascript:void(0)" data-toggle="button" dataid="<?=$group_details[0]['song_id']?>" alt='<?php echo $user_id?>' class="songLike"> 
                                <h3 class="like_count_<?=$group_details[0]['song_id']?>"><?=$group_details[0]['like_count'];?></h3>&nbsp;
                                <img src="<?= base_url('public/images/battle-like.png') ?>" alt=""/>
                            </a> 
                        </div>
                        <?php //} ?>
                        
                    </div>
                    <?php } ?>
                </div>
                
                <div class="song_name">
                    <div class="song_name_inner2">
                        <!-- <h3>0</h3>-->
                        <div class="mike_section">
                            <ul>
                                <li class="yellow_mike"><?=$group_details[0]['win_cnt']?></li>
                                <li class="gray_mike">0</li>
                                <li class="lightgray_mike">0</li>
                                <li class="red_mike"><?=$group_details[0]['lose_cnt']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php if( ($user_id != $group_details[0]['id'] AND  $user_id != $group_details[1]['id']) ) { ?>
                <div class="vote_button">
                    <a href="javascript:void(0)" alt="<?=$group_details[0]['id']?>" class="voteBtn" data-target="#vote_challenger" data-toggle="modal">
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
                        if($group_details[1]['profile_picture'] == '') {
                            $f_img_path = base_url('public/images/clipTwo.jpg');
                        } else {
                            if(file_exists(getcwd().'/uploads/profile_picture/medium_'.$group_details[1]['profile_picture'])) {
                                $f_img_path = base_url('uploads/profile_picture/'.'medium_'.$group_details[1]['profile_picture']);
                            } else {
                                $f_img_path = base_url('uploads/profile_picture/'.$group_details[1]['profile_picture']);
                            }
                        }
                    ?>
                    <img src="<?=$f_img_path?>" class="mySelector" />
                </div>
            </div><!--.rightSVG-->   
            
            <div class="song_details2">
                <div class="song_name">
                    <?php if($group_details[1]['media'] != '') { ?>
                    <div class="song_name_inner">
                        <h3><?=$group_details[1]['title']?></h3>&nbsp;
                        <?php if(0) { ?>
                             <a href="javascript:void(0)" data-target="#friend_video_popup" data-toggle="modal"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <?php } else { ?>
                             <audio id="friendAudio">
                              <source src="<?=base_url($this->config->item('battle_media_path').$group_details[1]['media'])?>">
                            </audio>
                            <a href="javascript:void(0)" class="friendPlayAudio"><i class="fa fa-play" aria-hidden="true"></i></a>
                       <?php } ?>
                        
                        <div class="like">
                            <a href="javascript:void(0)" data-toggle="button" dataid="<?=$group_details[1]['song_id']?>" alt='<?=$user_id?>' class="songLike"> 
                                <h3 class="like_count_<?=$group_details[1]['song_id']?>"><?=$group_details[1]['like_count']?></h3>&nbsp;
                                <img src="<?= base_url('public/images/battle-like.png') ?>" alt=""/>
                            </a>
                        </div>
                        
                    </div>
                    <?php } ?>
                </div>
                <div class="song_name">
                    <div class="song_name_inner2">
                            <!--<h3>0</h3>-->
                        <div class="mike_section">
                            <ul>
                                <li class="yellow_mike"><?=$group_details[1]['win_cnt']?></li>
                                <li class="gray_mike">0</li>
                                <li class="lightgray_mike">0</li>
                                <li class="red_mike"><?=$group_details[1]['lose_cnt']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if( ($user_id != $group_details[0]['id'] AND  $user_id != $group_details[1]['id']) ) { ?>
                    <div class="vote_button2">
                        <a href="javascript:void(0)" class="voteBtn" alt="<?=$group_details[1]['id']?>" data-toggle="modal" data-target="#vote_1">
                            <img src="<?= base_url('public/images/button2.png') ?>" alt=""/>
                        </a>
                    </div>
                <?php } ?>
                
            </div>         
        </div>

        <div class="vas">
            <img src="<?= base_url('public/images/vs.png') ?>" alt=""/>
            <div class="victory"></div>
        </div>
        
    </div>    
</div>   

<div class="three_scroller">
    <div class="container">
        <div class="row">
            
            <div class="col-xs-4">
                <div class="red_scroll_box">
                    <h2 id="vote_cnt_<?=$group_details[0]['id']?>">Who Voted (<?=count($vote_list_first)?>)</h2>
                    
                    <ul class="red_ul" id="voter_list_<?=$group_details[0]['id']?>">
                        
                         <?php if(!empty($vote_list_first)) { 
                                foreach ($vote_list_first as $voter) {
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
                         <?php } } ?> 
                    </ul>
                </div>
            </div>
            
            <div class="col-xs-4"> </div>
            
            <div class="col-xs-4">
                <div class="red_scroll_box blue_box_scroll">
                    <h2 id="vote_cnt_<?=$group_details[1]['id']?>">Who Voted (<?=count($vote_list_second)?>)</h2>
                    <ul class="red_ul" id="voter_list_<?=$group_details[1]['id']?>">
                        <?php if(!empty($vote_list_second)) { 
                                foreach ($vote_list_second as $voter) {
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
                         <?php }} ?>
                        
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
             if(isset($user_id))
             {
                 if(!empty($vote_list_first)) {
                     foreach ($vote_list_first as $vote){
                         if($vote['social_media_type'] == 'tw' && $vote['voter_id']==$user_id) {
                              $disableTw = 'disabled="disabled"';
                         }
                         if($vote['social_media_type'] == 'fb' && $vote['voter_id']==$user_id) {
                              $disableFb = 'disabled="disabled"';
                         }
                     }
                 }
            ?>

            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Share this page on either of the site</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    
                    <?php if($disableTw== '') { ?> 
                    <a class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>" id="tw_share_btn_c">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <?php } if($disableFb == ''){ ?>
                    <a class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn_c">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 
                    <?php } ?>
                </p>
            </div>
            <?php  } else { ?>
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
            <?php  } ?>
        </div>
    </div>
</div>

<div id="vote_1" class="modal fade common-modal-popup vote-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
        <?php 
             $disableBtnFb = $disableBtnTw = '' ;
             if(isset($user_id))
             {
                 if(!empty($vote_list_second)) {
                     foreach ($vote_list_second as $vote){
                         if($vote['social_media_type'] == 'tw' && $vote['voter_id']==$user_id) {
                              $disableBtnTw = 'disabled="disabled"';
                         }
                         if($vote['social_media_type'] == 'fb' && $vote['voter_id']==$user_id) {
                              $disableBtnFb = 'disabled="disabled"';
                         }
                     }
                 }
        ?>

            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Share this page on either of the site</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    <?php if($disableBtnTw == '') { ?> 
                    <a class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Battle Page&url=<?=urlencode(current_url())?>" id="tw_share_btn">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <?php } if($disableBtnFb == '') { ?>
                    <a class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 
                    <?php } ?>
                </p>
            </div>
            <?php } else { ?>
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
            <?php } ?>
        </div>
    </div>
</div>
<!-- for voting popup section -->

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

<script src="http://code.jquery.com/jquery-latest.pack.js" type="text/javascript"></script>
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
                if(elemId !== 'tw_share_btn_promote') {
                        placeVote('tw');
                        $("#msg").removeClass();
                        $("#msg").addClass('alert');
                        $("#msg").addClass('alert-success');
                        $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> Thank you for your vote.");
                        $("#"+elemId).hide();
                        setTimeout(function () {
                        $("#msg").removeClass();
                        $("#msg").html('');
                                    }, 10000);
                        $(".close").trigger("click");
                }

         });
    });	
	
 /* FACEBOOK SCRIPT */
 
        var URL = window.location.href;
                
        window.fbAsyncInit = function() {
            //Initiallize the facebook using the facebook javascript sdk
            FB.init({
            appId:'<?=$this->config->item('appID')?>',
            cookie:true, // enable cookies to allow the server to access the session
            status:true, // check login status
            xfbml:true, // parse XFBML
            oauth: true, //enable Oauth
            version: 'v2.8'
            });
        };
        
        (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

        /* FACEBOOK SHARE CODE */
	 $('.fb_share_btn').click(function (e) {
	    e.preventDefault();
	    evnt = e ;
	    obj = $(this);
	    elemId = e.target.id;
            FB.ui({
                        method: 'feed',
                        //href: URL,
                        name:'Battle me',
                        link: URL,
                        caption: 'To vote your friend please visit ',
                        description: URL,
                        message: '',
		    }, function(response){
			if(elemId != 'fb_share_btn_promote' ) {
			if (response && !response.error_code) {
				//console.log("OK: "+JSON.stringify(response));
			    placeVote('fb');
			    $("#msg").removeClass();
			    $("#msg").addClass('alert');
			    $("#msg").addClass('alert-success');
			    $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> Thank you for your vote.");
			   // $("#vote").dialog('close');
			   setTimeout(function () {
				 $("#msg").removeClass();
				 $("#msg").html('');
			    
			    $('#'+elemId).hide();
			    }, 4000);
			    
			    $(".close").trigger("click");
			    
			} else {
			    //console.log("Not OK: "+JSON.stringify(response));
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
    var base_url = '<?=base_url()?>';
    var artists_id = $('#artists_id').val();
    var social_media = socialMedia ;
    var voter_id =  $('#voter_id').val();
    var tournament_id = $('#tournament_id').val();
    var round =$('#round').val();
     $.ajax({
        type: "POST",
        url: base_url + "ajax/tournament_place_vote",
        dataType: "json",
        data: {artist_id: artists_id, voter_id: voter_id, tournament_id: tournament_id, social_media_type: social_media, round:round},
        success: function (data) {
                //console.log('Result: '+data);
            $('#vote_cnt_'+artists_id).html("");
            $('#vote_cnt_'+artists_id).html('Who Voted ('+data[0]+')');

            $('#voter_list_'+artists_id).html(data[1]);
            $('.red_ul').mCustomScrollbar("update");

        },
        complete:function(){
            /* $.ajax({
                    type: "POST",
                    url: base_url + "ajax/place_post",
                    data:{battle_name:battle_name,subject_id: artists_id, object_id: voter_id, battle_id: battle_id, social_media_type: social_media},
                    success:function(res){
                    }
            }); */
        }
    });
}

$(document).ready(function(){
    $('.songLike').click(function () {
        var currObj = $(this);
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
});
</script>

<?php
$this->load->view('battle_temp/footer');