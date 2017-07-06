<style>
    .btn { padding: 1px 9px;}

</style>
<?php
$sess_data = get_session_data();
$user_id = $sess_data['id'];
$voterVotes = array();
$challenger_mediaPath = $challenger_title = $friend_media_path = $friend_title = '';

if ($battle_details['user_id'] == $battle_details['winner']) {
    $challengerClass = 'alert-success';
    $friendClass = 'alert-danger';
    $CText = 'Winner';
    $fText = 'Looser';
} else {
    $challengerClass = 'alert-danger';
    $friendClass = 'alert-success';
    $fText = 'Winner';
    $CText = 'Looser';
}

$challenger_like_count = 0;
$friend_like_count = 0; 
//print_r($battle_media);
if (!empty($battle_media)) {
    foreach ($battle_media as $key => $value) {
        $path = $this->config->item('battle_media_path') . $value['media'];
        $title = $value['title'];
        if ($battle_details['user_id'] == $value['artist_id']) {

            $challenger_mediaPath = $path;
            $challenger_title = $title;
            $challenger_like_count = $value['like_count'];
        }
        if ($battle_details['friend_user_id'] == $value['artist_id']) {
            $friend_media_path = $path;
            $friend_title = $title;
            $friend_like_count = $value['like_count'];
        }
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

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="midsection" >
    <section class="panel panel-default scrollable"> 


        <header class="panel-heading"> 
            <span class="h4"><?php echo $battle_details['challenger'] . ' had battle with ' . $battle_details['friend'] ?></span> 
        </header> 
        <section class="panel panel-body">
            <div class="col-lg-12"><h4> <?php echo $battle_details['battle_name']; ?></h4></div>


            <div class="col-lg-12"><?php echo $battle_details['description']; ?>
                <input type="hidden" id="artists_id" name="artists_id">
                <input type="hidden" id="voter_id" name="voter_id" value="<?php echo $sess_data['id'] ?>">
                <input type="hidden" id="battle_id" name="battle_id" value="<?php echo $battle_details['battle_request_id'] ?>">

            </div>
        </section>

    </section>

   <div class="row">
    <div class="col-lg-6">
        <section class="panel panel-default">
            <header class="panel-heading"><?php echo $battle_details['challenger'] ?>
                <span class=""><?php echo " - " . $CText ?></span>
            </header>
            <div class="slimScrollDiv" style="">
                <section data-size="10px" data-height="130px" class="panel-body slim-scroll <?php echo $challengerClass ?>" style="">
                    <section class="no-padder bg alert-warning">
                        <section class="scrollable"> 
                            <section class="scrollable hover"> 

<?php
if ($challenger_mediaPath != '') {
    if ($battle_details['c_profile'] == '')
        $profile_c = 'default.png';
    else
        $profile_c = 'thumb_' . $battle_details['c_profile'];
    ?>
                                    <div class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                                        <div class="list-group-item clearfix media_post"> 
                                            
                                            <a class="thumb-sm m-r" href="#">
                                                <div class="pro_media"><img alt="..." src="<?php echo base_url('uploads/profile_picture/' . $profile_c) ?>"></div>
                                            </a>
                                            <a href="javascript:void(0)" class="clear" target= "_blank"> 
                                                <span class="block text-ellipsis"><?php echo $challenger_title ?></span> 
                                            </a> 
                                            
                                            <br>
                                            <span class="block text-ellipsis">Like : <?=$challenger_like_count?></span> 
                                            <br><span class="block text-ellipsis">Vote : <?=$battle_details['user_vote_cnt'] ?></span> 
                                            
                                            <div class="clearfix"></div>
                                            <?php $this->view('responsive_player', ['path' => base_url($challenger_mediaPath), 'id' => 1]); ?>
                                        </div> 
                                    </div>
<?php } ?>

                            </section> 
                        </section> 
                    </section>

                </section>
            </div>
        </section>
    </div>
    <div class="col-lg-6 ">
        <section class="panel panel-default">
            <header class="panel-heading"><span class=""><?php echo $battle_details['friend'] ?></span>
                <span class=""><?php echo " - " . $fText ?></span></header>
            <div class="slimScrollDiv clearfix" style="">
                <section data-size="10px" data-height="130px" class="panel-body slim-scroll  <?php echo $friendClass ?>" style="">
                    <section class="no-padder bg alert-warning">
                        <section class="scrollable"> 
                            <section class="scrollable hover"> 


<?php
if ($friend_media_path != '') {
    if ($battle_details['f_profile'] == '')
        $profile = 'default.png';
    else
        $profile = 'thumb_' . $battle_details['f_profile'];
    ?>
                                    <div class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                                        <div class="list-group-item clearfix media_post"> 

                                            <a class="thumb-sm m-r" href="#">
                                                <div class="pro_media"><img alt="..." src="<?php echo base_url('uploads/profile_picture/' . $profile) ?>"></div>
                                            </a>
                                            
                                            <a href="javascript:void(0)" class="clear" target="_blank"> 
                                                <span class="block text-ellipsis"><?php echo $friend_title ?></span> 
                                            </a> 
                                            <br>
                                            <span class="block text-ellipsis">Like : <?=$friend_like_count?></span> 
                                            <br><span class="block text-ellipsis">Vote : <?=$battle_details['friend_vote_cnt'] ?></span> 
                                            
                                            <div class="clearfix"></div>
                                            <?php $this->view('responsive_player', ['path' => base_url($friend_media_path), 'id' => 2]); ?>
                                        </div> 
                                    </div>
                                <?php } ?>

                            </section> 
                        </section> 
                    </section>

                </section>
            </div>

        </section>

    </div>
</div>
</div>   

<!--    <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>-->
<script src="http://code.jquery.com/jquery-latest.pack.js" type="text/javascript"></script>