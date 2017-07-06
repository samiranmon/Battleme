<style>
    .btn { padding: 1px 9px;}
    
</style>
<?php
$sess_data = get_session_data();
$user_id = $sess_data['id'];
if(isset($user_id)) {
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

if(!empty($battle_media))
    //echo "<pre>"; print_r($battle_media);
foreach($battle_media as $key => $value)
{
    $path = $this->config->item('battle_media_path').$value['media'];
    $title =  $value['title'];
    if($battle_details['user_id'] == $value['artist_id'])
    { 
       $challenger_mediaPath = $path ;
       $challenger_title =  $title  ;
       $challenger_song_id = $value['fk_song_id'];
       $challenger_like_count = $value['like_count'];
    }
    if($battle_details['friend_user_id'] == $value['artist_id'])
    {
	$friend_media_path = $path;
	$friend_title =  $title  ;
        $friend_song_id = $value['fk_song_id'];
        $friend_like_count = $value['like_count'];
    }
	 
}
//echo "<pre>";
//print_r($battle_details);

if($user_id > 0 )
    {
	foreach($vote_details as $key => $value )
	{
	    if($value['voter_id'] == $user_id)
	    {
		$voterVotes[$value['artist_id']]['social_media'][$value['social_media_type']] =  1 ;
	    }

	}
}
//print_r($voterVotes);
//upload media form data

 $title_data = array(
     'name' => 'title',
     'id' => 'title',
     'class' => 'form-control',
     'maxlength' => '125',
     'placeholder' => 'Media Title',
     'value' => set_value('title'),
     'data-required' => 'true'
 );
 $media_data = array(
     'name' => 'media',
     'id' => 'media',
     'class' => '',
     'maxlength' => '225',
     'data-required' => 'true'
 );
 $data_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Create',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Upload'
);

 $form_attr = array('name' => 'battle_media', 'id' => 'battle_media' , 'class' => '' , 'data-validate' => 'parsley');
//end of upload for media data
//print_r($voterVotes);

 /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 ?>
<div class="midsection" >

<div class="col-lg-12 panel">
    <section class="panel panel-default scrollable"> 
		
    <?php 
     if($battle_details['status'] == 0 )
	  $text = ' challenged ' ;
     else
	 $text = ' started ' ;
     
     ?>
	<header class="panel-heading"> 
		    <span class="h4"><?php echo $battle_details['challenger'] .' has '.$text.' battle with '. $battle_details['friend']?></span> 
	<?php if( $user_id == $battle_details['friend_user_id'] && $battle_details['status'] == 0 )
	{ 
            if($battle_details['entry']>0) {?>
    <small style="margin-left: 58px;"><?php echo 'Charge of '.$battle_details['entry'].' battle bucks will be charged after accepting challenge' ?></small>
        <?php } ?>
    <div class="pull-right">
	<a href="<?php echo base_url().'battle/request/'.$battle_details['battle_request_id'].'/4'?>" class="btn btn-success">Accept</a>
	<a href="<?php echo base_url().'battle/request/'.$battle_details['battle_request_id'].'/2'?>" class="btn btn-small btn-danger">Reject</a>
    </div>
    
	<?php }
	    ?>	
	</header> 
        
        
        <?php if($this->session->flashdata('success')){?>
                <p class="text-muted text-center">
                    <small><font color="green"><?php echo $this->session->flashdata('success');?></font></small>
                </p>
                
            <?php } ?>
	<section class="panel panel-body">
       <div class="col-lg-12"><h4> <?php echo $battle_details['battle_name'];?></h4></div>

    
    <div class="col-lg-12"><?php echo $battle_details['description'];?>
	<input type="hidden" id="artists_id" name="artists_id">
	<input type="hidden" id="voter_id" name="voter_id" value="<?php echo $sess_data['id']?>">
	<input type="hidden" id="battle_id" name="battle_id" value="<?php echo $battle_details['battle_request_id']?>">
    <input type="hidden" id="battle_name" name="battle_name" value="<?php echo $battle_details['battle_name'];?>" />
    </div>
	</section>
                
                
                
	 <div class="col-lg-8"><?php 
	 if($battle_details['status'] == 4){
	      if($user_id == $battle_details['friend_user_id'] && $friend_media_path != '')
	        $media_count = 1 ; 
	      else if($user_id == $battle_details['user_id'] && $challenger_mediaPath != '')
		    $media_count = 1;
	      else
		  $media_count = 0;
	      
	    if ($this->session->flashdata('message')) {
		     ?>
		     <div class="alert <?php echo $this->session->flashdata('class')?>"> 
			 <button class="close" data-dismiss="alert">x</button>                
			 <?php echo $this->session->flashdata('message'); ?>
		     </div>
          <?php
                    }   
	 if( ($user_id == $battle_details['friend_user_id'] OR  $user_id == $battle_details['user_id']) && $media_count == 0  )
	{ 
	  
	     echo form_open_multipart('', $form_attr) ;
	     ?>
	    <section class="panel-default panel"> 
                 
		<header class="panel-heading"> 
		    <span class="h4">Upload Media</span> 
		</header> 
		<div class="panel-body"> 
		   
		    <div class="form-group"> 
                        <input name="challenger_user_id" value="<?=$battle_details['user_id']?>" type="hidden">
                        <input type="hidden" name="battle_category" value="<?=$battle_details['battle_category']?>">
		 <div class="form-group"> 
			    <label>Title</label> 
			    <?php echo form_input($title_data);
			    echo form_error('title', '<div class="error">', '</div>');
			    ?>
			</div> 
			 <div class="form-group"> 
			    <label>Song</label> 
			    <?php echo form_upload($media_data);
			    echo form_error('media', '<div class="error">', '</div>');
			    ?>
			</div> 
		    </div> 
		    
		<div class="text-right lter"> 
		    <?php echo form_submit($data_submit)?>
		    </div>
	    </section> 
	<?php echo form_close(); ?>
    
	 <?php }
	 
	}
    ?></div>
    </section>
    
    <?php if( ($user_id == $battle_details['friend_user_id'] OR  $user_id == $battle_details['user_id']) ) { ?>
    <div class="centered" style="text-align: center">
	
	    <div class="doc-buttons">
		<a href="#" class="btn btn-md btn-success promoteBtn" data-toggle="modal" data-target="#promote_div">Promote</a>
		<br>
	    </div>
	
    </div>
    <?php } ?>
    <div class="clear"></div>
    
    
    
    <?php if(isset($user_id) && $battle_details['entry']>0) { ?>
    <div class="centered" style="width: auto; height: auto;" >
	
	    <div class="doc-buttons">
                <a data-toggle="modal" data-target="#support_your_artist_popup" class="btn btn-md btn-success promoteBtn" href="javascript:void(0)">SUPPORT YOUR ARTIST</a>
		<br>
	    </div>
        <span>Money bag : <?php echo round($battle_details['entry']*2 + $support_amount). ' Battle Bucks'; ?></span>
        
        <!-- For Supporter List Section Start -->
            <?php 
                if(!empty($support_users)) {
            ?>
    <!--<div class="centered" style="text-align: center" >-->
            <ul class="">
                <?php foreach ($support_users as $sval) {
                    ?>
                <li class=" "> 
                    <a class="thumb-sm m-r" href="<?=  base_url('profile/view/'.$sval['supporter_id'])?>" target="_blank" >
                        <?php if($sval['profile_picture'] != '') { ?>
                        <img alt="<?=$sval['supporter_name']?>" src="<?php echo base_url('uploads/profile_picture/'.$sval['profile_picture'])?>">
                        <?php } else { ?>
                        <img alt="<?=$sval['supporter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>">
                        <?php } ?>
                    </a>
                    <a href="<?=  base_url('profile/view/'.$sval['supporter_id'])?>" target="_blank"  class="clear"> 
                        <span class="block text-ellipsis"><?=$sval['supporter_name']?></span> 
                    </a> 
                </li> 
                <?php } ?> 
            </ul>
        <!--</div>-->
            <?php } ?>
        <!-- End of Supporter List Section -->
    </div>
    <div class="clear"></div>
    
        
    <?php } ?>
    <div class="clear"></div>
    
    
    <div class="pull-left col-lg-6">
	<section class="panel panel-default">
	    <header class="panel-heading"><?php echo $battle_details['challenger'] ?></header>
	    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
		<section data-size="10px" data-height="230px" class="panel-body slim-scroll" style="overflow: hidden; width: auto; height: auto;">
		    <section class="col-lg-12 no-padder bg">
			<section class="scrollable"> 
			    <section class="scrollable hover"> 
				
				    <?php if($challenger_mediaPath != '') { 
					 if($battle_details['c_profile'] == '')
					$profile_c = 'default.png' ;
				    else
					$profile_c = 'thumb_'.$battle_details['c_profile'] ;
					?>
				<ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
				    <li class="list-group-item clearfix"> 
                                        
					<?php if($battle_details['battle_category'] == 4) { ?>
                                                <video width="400" controls="controls">
                                                    <source type="video/mp4" src="<?=base_url($challenger_mediaPath)?>"></source>
                                                </video>
                                        <?php } else { $this->view('jplayer', ['path'=>base_url($challenger_mediaPath), 'id'=>1]); } ?>
                                        
                                        <a class="pull-left thumb-sm m-r" target="_blank" href="<?=  base_url('profile/view/'.$battle_details['user_id'])?>">
					    <img alt="..." src="<?php echo base_url('uploads/profile_picture/'.$profile_c)?>">
                                        </a>
					<a href="<?php echo base_url($challenger_mediaPath) ?>" class="clear"> 
					    <span class="block text-ellipsis"><?php echo $challenger_title?></span> 
					</a> 
				    </li> 
				    </ul>
				    <?php } ?>
								   
				 </section> 
			</section> 
		    </section>
		    <section class="doc-buttons">
			
			<span class="label label-success">W: <?php echo $battle_details['c_win']?></span>
			<span class="label label-danger">L: <?php echo $battle_details['c_loss']?></span>
                        <?php if($battle_details['entry']>0) { ?>
                        <span><?php echo $battle_details['entry']. ' Battle Bucks'; ?></span>
                        <?php } ?>
			
			 <?php if( ($user_id != $battle_details['friend_user_id'] AND  $user_id != $battle_details['user_id']) ) { ?>
                        <span class="">
                            <a href="#" class="btn btn-md btn-success voteBtn" alt="<?php echo $battle_details['user_id']?>" data-target="#vote_challenger" data-toggle="modal">Vote</a>
                        </span>
                        
                        <?php if($challenger_mediaPath != '') { ?>
                        <span>
                            <a   data-toggle="button" dataid="<?php echo $challenger_song_id?>" alt='<?php echo $user_id?>' class="btn btn-default songLike active"> 
                                 <span class="text-active"> 
                                     <i class="fa fa-thumbs-o-up text"></i> 
                                     <span class="like_count_<?php echo $challenger_song_id;?>"><?php echo $challenger_like_count;?></span>
                                 </span> 
                            </a> 
                        </span>
                        <?php } ?>
                        
			 <?php } ?>
		    <div>Votes : <span id="vote_cnt_<?php echo $battle_details['user_id'] ?>"><?php echo $battle_details['user_vote_cnt'] ?></span></div>
		    <div>Likes : <span class="like_count_<?php echo $challenger_song_id;?>" ><?php echo $challenger_like_count;?></span></div>
                    
                    <!-- For Voter List Section Start -->
                        <?php 
                            if(!empty($vote_details)) {
                        ?>
                    <div>
                        <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                            <?php foreach ($vote_details as $voter) {
                                    if($voter['artist_id'] == $battle_details['user_id'] ){
                                ?>
                            <li class="list-group-item "> 
                                <a class="pull-left thumb-sm m-r" href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank">
                                    <?php if($voter['profile_picture'] != '') { ?>
                                    <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/'.$voter['profile_picture'])?>">
                                    <?php } else { ?>
                                    <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>">
                                    <?php } ?>
                                </a>
                                <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank" class="clear"> 
                                    <span class="block text-ellipsis"><?=$voter['voter_name']?></span> 
                                </a> 
                            </li> 
                            <?php }} ?> 
                        </ul>
                    </div>
                        <?php } ?>
                    <!-- End of Voter List Section -->
                    
		</section>
		</section>
	    </div>
	    </section>
    </div>
    
    
    //////////
	    <div class="pull-right col-lg-6">
		<section class="panel panel-default">
	    <header class="panel-heading"><?php echo $battle_details['friend'] ?></header>
	   <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
		<section data-size="10px" data-height="230px" class="panel-body slim-scroll" style="overflow: hidden; width: auto; height: auto;">
		    <section class="col-lg-12 no-padder bg">
			<section class="scrollable">
			    <section class="scrollable hover"> 
				<?php if($friend_media_path != '')
				 { 
				    if($battle_details['f_profile'] == '')
					$profile = 'default.png' ;
				    else
					$profile = 'thumb_'.$battle_details['f_profile'] ;
				    ?>
				<ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
				    <li class="list-group-item clearfix"> 
                                        
                                        <?php if($battle_details['battle_category'] == 4) { ?>
                                            <video width="400" controls="controls">
                                                <source type="video/mp4" src="<?=base_url($friend_media_path)?>"></source>
                                            </video>
                                        <?php } else { $this->view('jplayer', ['path'=>base_url($friend_media_path), 'id'=>2]); } ?>
                                        
                                        <a class="pull-left thumb-sm m-r" target="_blank" href="<?=  base_url('profile/view/'.$battle_details['friend_user_id'])?>">
					    <img alt="..." src="<?php echo base_url('uploads/profile_picture/'.$profile)?>">
                                        </a>
					<a href="<?php echo base_url($friend_media_path) ?>" class="clear"> 
					    <span class="block text-ellipsis"><?php echo $friend_title?></span> 
					</a> 
				    </li> 
				</ul>
			 <?php } ?>
 
	 </section> 
			</section> 
		    </section>
		<section  class="btn ">
		    <span class="label label-success">W: <?php echo $battle_details['win_cnt']?></span>
		    <span class="label label-danger">L: <?php echo $battle_details['lose_cnt']?></span>
                    <?php if($battle_details['entry']>0) { ?>
                        <span><?php echo $battle_details['entry']. ' Battle Bucks'; ?></span>
                    <?php } ?>
                    
		     <?php if( ($user_id != $battle_details['friend_user_id'] AND  $user_id != $battle_details['user_id']) ) { ?>
                    <span>
                        <a href="#" class="btn btn-md btn-success voteBtn" alt="<?php echo $battle_details['friend_user_id']?>" data-toggle="modal" data-target="#vote_1">Vote</a>
                    </span>
                        
                    <?php if($friend_media_path != '') { ?>
                    <span>
                        <a   data-toggle="button" dataid="<?php echo $friend_song_id?>" alt='<?php echo $user_id?>' class="btn btn-default songLike active"> 
                             <span class="text-active"> 
                                 <i class="fa fa-thumbs-o-up text"></i> 
                                 <span class="like_count_<?php echo $friend_song_id;?>"><?php echo $friend_like_count;?></span>
                             </span> 
                        </a> 
                    </span>
		    <?php } ?>
                        
		     <?php } ?>
		    <div>Votes : <span id="vote_cnt_<?php echo $battle_details['friend_user_id'] ?>"><?php echo $battle_details['friend_vote_cnt'] ?></span></div>
		    <div>Likes : <span class="like_count_<?php echo $friend_song_id;?>" ><?php echo $friend_like_count;?></span></div>
                    
                    <!-- For Voter List Section Start -->
                        <?php 
                            if(!empty($vote_details)) {
                        ?>
                    <div>
                        <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                            <?php foreach ($vote_details as $voter) {
                                    if($voter['artist_id'] == $battle_details['friend_user_id'] ){
                                ?>
                            <li class="list-group-item "> 
                                <a class="pull-left thumb-sm m-r" href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank" >
                                    <?php if($voter['profile_picture'] != '') { ?>
                                    <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/'.$voter['profile_picture'])?>">
                                    <?php } else { ?>
                                    <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>">
                                    <?php } ?>
                                </a>
                                <a href="<?=  base_url('profile/view/'.$voter['voter_id'])?>" target="_blank" class="clear"> 
                                    <span class="block text-ellipsis"><?=$voter['voter_name']?></span> 
                                </a> 
                            </li> 
                            <?php }} ?> 
                        </ul>
                    </div>
                        <?php } ?>
                    <!-- End of Voter List Section -->
                    
		</section>
		</section>
	    </div>
		
	    </section>
		
	    </div>
    
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
			<a  class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>"id="tw_share_btn_promote">
			    <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
			<a  class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn_promote">
			    <i class="fa fa-fw fa-facebook"></i> Facebook</a> 

		    </p>
                </div>
		
            </div>
        </div>
    </div>
    

</div>   
    
<div id="twitterbutton-example"></div>

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
			<a  <?php echo $disableTw ?> class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>"id="tw_share_btn_c">
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
			<a class="btn btn-sm btn-info" <?php echo $disableBtnTw ?> href="https://twitter.com/intent/tweet?text=Battle Page&url=<?php echo urlencode(current_url())?>"id="tw_share_btn">
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
                            <input type="number" name="amount" id="wallet_amount" required="" >
                            <input type="text" value="<?=$battle_details['battle_request_id']?>" name="battle_id" hidden="">
                            <input type="submit" value="Donate" class="btn btn-sm btn-info">
                        </div>

                    </div>
                </form>
		 
            </div>
        </div>
    </div>
<?php } ?>
</div>

<!--    <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>-->
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
	
 /* FACEBOOK SCRIPT */
 <?php /*
   window.fbAsyncInit = function() {
      FB.init({
        appId      : '<?php //echo $this->config->item('fb_api_key');?>',
        xfbml      : true,
        version    : 'v2.5'
      });
    };
  
    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));*/
  	
  	?>
		
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
                data: {artist_id: artists_id, voter_id: voter_id, battle_id: battle_id, social_media_type: social_media},
                success: function (data) {
                	console.log('Result: '+data);
                    $('#vote_cnt_'+artists_id).html("");
                    $('#vote_cnt_'+artists_id).html(data);
		    
                },
                complete:function(){
                	$.ajax({
                		type: "POST",
                		url: base_url + "ajax/place_post",
                		data:{battle_name:battle_name,subject_id: artists_id, object_id: voter_id, battle_id: battle_id, social_media_type: social_media},
                		success:function(res){
                			console.log("post"+res);
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
         
        
       // alert('hi');
        return false;
    });
});
</script>