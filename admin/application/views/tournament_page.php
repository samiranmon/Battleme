<?php
$this->config->load('config_facebook');
$tournament_id = $this->uri->segment(3);
$sess_data = get_session_data();
$user_id = $sess_data['id'];
$voterVotes = array();
$challenger_mediaPath = $challenger_title = $friend_media_path = $friend_title = '';
//$("#"+elemId).attr('disabled' , 'disabled');
//upload media form data

$title_data = array(
    'name' => 'title',
    'id' => 'title',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Media Title',
    'value' => set_value('title'),
    'required' => 'true'
);
$media_data = array(
    'name' => 'media',
    'id' => 'media',
    'class' => '',
    'maxlength' => '225',
    'required' => 'true'
);
$data_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Create',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Upload'
);
$data_submit_2 = array(
    'name' => 'Enter',
    'id' => 'Enter',
    'value' => 'Enter',
    'type' => 'Submit',
    'class' => 'btn btn-s-xs',
    'style' => 'background:#2E75B5; color:#fff;',
    'content' => 'Upload'
);

$form_attr = array('name' => 'battle_media', 'id' => 'battle_media', 'class' => '', 'data-validate' => 'parsley');

$form_attr_2 = array('name' => 'add_member', 'id' => 'add_member', 'class' => '', 'data-validate' => 'parsley');
?>

<div class="wrapper_tournament">

    <div class="logo_tour">
        <a href="<?= base_url() ?>"><img src="<?= base_url() ?>public/images/logo_v1.png" alt=""></a>
    </div>
</div>

<div class="clearfix"></div>

<div class="tournament_bord_wappper">
    
    <div class="col-lg-12 col-xs-12">
        <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
                <button class="close" data-dismiss="alert">x</button>                
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        <?php } ?>
    </div>

    <section class="panel panel-default scrollable"> 
        <header class="panel-heading"> 
            <span class="h4"><?php echo $tournament_details[0]['challenger'] . ' has created tournament' ?></span> 	
        </header>

        <section class="panel-body tourna">
            <div class="col-lg-12">
                <h4> <?php echo $tournament_details[0]['tournament_name']; ?></h4>
            </div>
            <?php //echo '<pre>'; print_r($tournament_details); die;   ?>
            <div class="col-lg-12">
                <?php echo $tournament_details[0]['description']; ?>
                <!-- <?//php echo '<br>Entry fee: '.$tournament_details[0]['entry'].' Coins'; ?>
                <?//php echo '<br>Prize: '.$tournament_details[0]['prize'].' Coins'; ?>-->
                <?php echo '<br>Entry fee: ' . tournamentEntry . ' Battle Bucks'; ?>
                <?php echo '<br>1st Prize: ' . tournamentFirstPrize . ' Battle Bucks'; ?>
                <?php echo '<br>2nd Prize: ' . tournamentSecondPrize . ' Battle Bucks'; ?>
                <?php echo '<br>3rd Prize: ' . tournamentThirdPrize . ' Battle Bucks'; ?>
                <input type="hidden" id="artists_id" name="artists_id">
                <input type="hidden" id="voter_id" name="voter_id" value="<?= $sess_data['id'] ?>">
                <input type="hidden" id="tournament_request_id" name="tournament_request_id" value="<?= $tournament_details[0]['tournament_request_id'] ?>">
            </div>
        </section>
    </section>

    <?php 
        if(!isset($sess_data['membership_id'])) { $sess_data['membership_id'] = null; }
        if (!in_array($user_id, $friend_user_ids) && $sess_data['user_type'] == 'artist' && $sess_data['membership_id'] == 2) { ?>    
        <section class="panel panel-default scrollable"> 
            <header class="panel-heading"> 
                <span class="h4">Enter tournament</span> 	
            </header>

            <section class="panel-body tourna">
                <div class="col-lg-12"> 
                    <h4 class="h4">Upload Media</h4> 
                </div> 
                <?php echo form_open_multipart('tournament/entry_tournament', $form_attr_2); ?>
                <div class="col-lg-12">
                    <div class="form-group"> 
                        <label>Title</label> 
                        <?php
                        echo form_input($title_data);
                        echo form_error('title');
                        ?>
                        <input type="hidden" name="tournament_id" value="<?= $tournament_details[0]['tournament_request_id'] ?>">
                    </div> 

                    <div class="form-group"> 
                        <label>Song</label> 
                        <?php
                        echo form_upload($media_data);
                        echo form_error('media');
                        ?>
                    </div> 

                    <div class="form-group">
                        <?php echo form_submit($data_submit_2) ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </section>
        </section>
    <?php } ?>    

</div>


<!--avik-->
<div class="tournament_bord_wappper">
    <div class="col-lg-8 col-xs-8">
        <?php
        if (!isset($tournament_details[0]['start_date'])) {
            echo 'Tournament not started yet: ';
            if (isset($tournament_details[0]['friend_user_id'])) {
                echo ' ' . count($friend_user_ids) . '/32';
            } else {
                echo '0/32';
            }
            echo '<br><br>';
        }

        if ($round > 0) { 
            echo 'Tournament Started<br>Round: ' . $round;
            ?>
            <input type="hidden" id="round" name="round" value="<?= $round ?>">
        <?php } ?>
    </div>

    <?php
//echo $user_id.'<pre>'; print_r($friend_user_ids);
    if ((in_array($user_id, $friend_user_ids) OR $user_id == $tournament_details[0]['user_id'])) {
        ?>
        <div class="col-lg-4 col-xs-4">
            <div class="doc-buttons">
                <a href="#" class="btn btn-md btn-success promoteBtn modified" data-toggle="modal" data-target="#promote_div">Promote</a>
                <br>
            </div>
        </div>
    <?php } ?>

</div>



<div class="tournament_bord_wappper">
    <h2>Tournament score board</h2>
    <div class="round_section">
        <div class="tournament_bord_wappper_row">
            <div class="one_colmn">
                <div class="round_button">1st Round</div>
            </div>
            <div class="one_colmn">
                <div class="round_button">2nd Round</div>
            </div>
            <div class="one_colmn">
                <div class="round_button">3rd Round</div>
            </div>
            <div class="one_colmn">
                <div class="round_button">4th Round</div>
            </div>
            <div class="one_colmn">
                <div class="round_button">5th Round</div>
            </div>
            <div class="one_colmn">
                <div class="round_button">Finals</div>
            </div>
        </div>
    </div>
    <div class="tournament_bord_wappper_row">

        <?php
        if (!isset($tournament_details[0]['start_date'])) {
            if (isset($tournament_details[0]['friend_user_id'])) {
                ?>

                <!-- 1st round structure-->
                <div class="one_colmn">
                    <div class="first_round_team_structure">
                        <?php
                        $id = 1;
                        foreach ($tournament_details as $tournament_detail) {

                            if ($tournament_detail['f_profile'] == '') {
                                $profile = 'default.png';
                            } else {
                                $profile = 'thumb_' . $tournament_detail['f_profile'];
                            }
                            /* $tournament_detail['friend_user_id']
                              $profile;
                              $tournament_detail['win_cnt']
                              $tournament_detail['lose_cnt'] */
                            ?>
                                <?php if (($id % 2) != 0) { ?>
                                <div class="round_against_team">
                                <?php } ?>
                                    <div class="round_team">
                                        <h4><?= substr($tournament_detail['friend'],0,18) ?></h4>
                                        <p><?= $tournament_detail['title']==''?'N/A': substr($tournament_detail['title'],0,18)?></p>
                                    </div>
                                <?php if (($id % 2) == 0) { ?>     
                                    </div>
                                <?php } ?>

            <?php $id++;
        } ?>
                    </div>
                </div>
                <!-- end of 1st round structure-->
    <?php } ?>




        <?php
        } else {

            $class = 'item_active';
            $id = 1;

            //echo '<pre>'; print_r($tournament_groups); die; 
            ?>

            <!-- 1st round structure-->
            <div class="one_colmn">
                <div class="first_round_team_structure">
                    <?php
                    $id = 1;
                    $first_count = 0;
                    
                    for ( $index = 0; $index < count($tournament_groups['1st']); $index +=2) {
                        $first_groups[] = $tournament_groups['1st'][$index]['user_id'] . "/" . $tournament_groups['1st'][$index+1]['user_id'];
                    }
                    //echo '<pre>'; print_r($first_groups); die;
                    foreach ($tournament_groups['1st'] as $tournament_group) {

                        if ($tournament_group['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                            $profile = 'thumb_' . $tournament_group['f_profile'];
                        }
                        /* $tournament_detail['friend_user_id']
                          $profile;
                          $tournament_detail['win_cnt']
                          $tournament_detail['lose_cnt'] */
                        ?>
                            <?php if (($id % 2) != 0) { ?>
                            <div class="round_against_team">
                            <?php } ?>
                                <div class="round_team">
                                    <h4><?= substr($tournament_group['friend'],0,18) ?></h4>
                                    <p>
                                        <a href="<?=base_url('tournament/voting/'.$tournament_id.'/1st/'.base64_encode($first_groups[$first_count]))?>">
                                            <?= $tournament_group['title']==''?'N/A': substr($tournament_group['title'],0,18)?>
                                        </a>
                                    </p>
                                </div>
                            <?php if (($id % 2) == 0) { $first_count +=1; ?>     
                                </div>
                            <?php } ?>

                            <?php $id++;
                        } ?>
                    </div>
                </div>
            <!-- end of 1st round structure-->

            <!-- 2nd team structure-->
            <div class="one_colmn">
                <div class="second_round_team_structure">
                    
                    <?php
                    $id = 1;
                    $first_count = 0;
                    
                    for ( $index = 0; $index < count($tournament_groups['2nd']); $index +=2) {
                        $second_groups[] = $tournament_groups['2nd'][$index]['user_id'] . "/" . $tournament_groups['2nd'][$index+1]['user_id'];
                    }
                    //echo '<pre>'; print_r($second_groups); die;
                    foreach ($tournament_groups['2nd'] as $tournament_group) {

                        if ($tournament_group['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                            $profile = 'thumb_' . $tournament_group['f_profile'];
                        }
                        /* $tournament_detail['friend_user_id']
                          $profile;
                          $tournament_detail['win_cnt']
                          $tournament_detail['lose_cnt'] */
                        ?>
                            <?php if (($id % 2) != 0) { ?>
                            <div class="round_against_team">
                            <?php } ?>
                                <div class="round_team">
                                    <h4><?= substr($tournament_group['friend'],0,18) ?></h4>
                                    <p>
                                        <a href="<?=base_url('tournament/voting/'.$tournament_id.'/2nd/'.base64_encode($second_groups[$first_count]))?>">
                                            <?= $tournament_group['title']==''?'N/A': substr($tournament_group['title'],0,18)?>
                                        </a>
                                    </p>
                                </div>
                            <?php if (($id % 2) == 0) { $first_count +=1; ?>     
                                </div>
                            <?php } ?>

                            <?php $id++;
                        } ?>
                    
                </div>
            </div>

            <!-- 3rd team structure-->
            <?php if(isset($tournament_groups['3rd'])) { ?>
            <div class="one_colmn">
                <div class="third_round_team_structure">
                    
                    <?php
                    $id = 1;
                    $first_count = 0;
                    
                    for ( $index = 0; $index < count($tournament_groups['3rd']); $index +=2) {
                        $third_groups[] = $tournament_groups['3rd'][$index]['user_id'] . "/" . $tournament_groups['3rd'][$index+1]['user_id'];
                    }
                    //echo '<pre>'; print_r($second_groups); die;
                    foreach ($tournament_groups['3rd'] as $tournament_group) {

                        if ($tournament_group['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                            $profile = 'thumb_' . $tournament_group['f_profile'];
                        }
                        /* $tournament_detail['friend_user_id']
                          $profile;
                          $tournament_detail['win_cnt']
                          $tournament_detail['lose_cnt'] */
                        ?>
                            <?php if (($id % 2) != 0) { ?>
                            <div class="round_against_team">
                            <?php } ?>
                                <div class="round_team">
                                    <h4><?= substr($tournament_group['friend'],0,18) ?></h4>
                                    <p>
                                        <a href="<?=base_url('tournament/voting/'.$tournament_id.'/3rd/'.base64_encode($third_groups[$first_count]))?>">
                                            <?= $tournament_group['title']==''?'N/A': substr($tournament_group['title'],0,18)?>
                                        </a>
                                    </p>
                                </div>
                            <?php if (($id % 2) == 0) { $first_count +=1; ?>     
                                </div>
                            <?php } ?>

                            <?php $id++;
                        } ?>

                </div>
            </div>
            <?php } ?>
            <!-- 3rd team structure-->

            <!-- 4th team structure-->
            <?php if(isset($tournament_groups['4th'])) { ?>
            <div class="one_colmn">
                <div class="fourth_round_team_structure">
                    
                     <?php
                    $id = 1;
                    $first_count = 0;
                    
                    for ( $index = 0; $index < count($tournament_groups['4th']); $index +=2) {
                        $fourth_groups[] = $tournament_groups['4th'][$index]['user_id'] . "/" . $tournament_groups['4th'][$index+1]['user_id'];
                    }
                    //echo '<pre>'; print_r($second_groups); die;
                    foreach ($tournament_groups['4th'] as $tournament_group) {

                        if ($tournament_group['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                            $profile = 'thumb_' . $tournament_group['f_profile'];
                        }
                        /* $tournament_detail['friend_user_id']
                          $profile;
                          $tournament_detail['win_cnt']
                          $tournament_detail['lose_cnt'] */
                        ?>
                            <?php if (($id % 2) != 0) { ?>
                            <div class="round_against_team">
                            <?php } ?>
                                <div class="round_team">
                                    <h4><?= substr($tournament_group['friend'],0,18) ?></h4>
                                    <p>
                                        <a href="<?=base_url('tournament/voting/'.$tournament_id.'/4th/'.base64_encode($fourth_groups[$first_count]))?>">
                                            <?= $tournament_group['title']==''?'N/A': substr($tournament_group['title'],0,18)?>
                                        </a>
                                    </p>
                                </div>
                            <?php if (($id % 2) == 0) { $first_count +=1; ?>     
                                </div>
                            <?php } ?>

                            <?php $id++;
                        } ?>

                </div>
            </div>
            <?php } ?>
            <!-- 4th team structure-->


            <!-- 5th team structure-->
            <?php if(isset($tournament_groups['5th'])) { ?>
            <div class="one_colmn">
                <div class="fifth_round_team_structure">
                     <?php
                    $id = 1;
                    $first_count = 0;
                    
                    for ( $index = 0; $index < count($tournament_groups['5th']); $index +=2) {
                        $fifth_groups[] = $tournament_groups['5th'][$index]['user_id'] . "/" . $tournament_groups['5th'][$index+1]['user_id'];
                    }
                    //echo '<pre>'; print_r($second_groups); die;
                    foreach ($tournament_groups['5th'] as $tournament_group) {

                        if ($tournament_group['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                                $profile = 'thumb_' . $tournament_group['f_profile'];
                            }
                        ?>
                            <?php if (($id % 2) != 0) { ?>
                            <div class="round_against_team">
                            <?php } ?>
                                <div class="round_team">
                                    <h4><?= substr($tournament_group['friend'],0,18) ?></h4>
                                    <p>
                                        <a href="<?=base_url('tournament/voting/'.$tournament_id.'/5th/'.base64_encode($fifth_groups[$first_count]))?>">
                                            <?= $tournament_group['title']==''?'N/A': substr($tournament_group['title'],0,18)?>
                                        </a>
                                    </p>
                                </div>
                            <?php if (($id % 2) == 0) { $first_count +=1; ?>     
                                </div>
                            <?php } ?>

                            <?php $id++;
                        } ?>
                </div>
            </div>
            <?php } ?>
            <!-- 5th team structure-->


            <!-- 6th team structure-->
            <?php if(isset($tournament_groups['6th'])) { ?>
            <div class="one_colmn">
                <div class="final_round_team_structure">
                    <div class="round_against_team">
                        <div class="round_team">
                            <h4><?= $tournament_groups['6th'][0]['friend'] ?></h4>
                            <p><?= $tournament_groups['6th'][0]['title']==''?'N/A': $tournament_groups['6th'][0]['title']?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- 6th team structure-->

        <?php } ?>         
    </div>
</div>  

<div id="promote_div" class="modal fade common-modal-popup promote-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Promote The Tournament</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    <a class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Tournament Page&url=<?php echo urlencode(current_url()) ?>" id="tw_share_btn_promote">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <a  class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn_promote">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 
                </p>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
<script type="text/javascript">
    window.twttr = (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0], t = window.twttr || {};
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
        t._e = [];
        t.ready = function (f) {
            t._e.push(f);
        };
        return t;
    }(document, "script", "twitter-wjs"));

</script>

<script type="text/javascript">
    $(document).ready(function () {

        twttr.ready(function (twttr) {
            //get  twitter event
            twttr.events.bind('tweet', function (event) {
                elemId = event.target.id;
            });
        });

        /* FACEBOOK SCRIPT */
        window.fbAsyncInit = function () {
            //Initiallize the facebook using the facebook javascript sdk
            FB.init({
                appId: '<?= $this->config->item('appID') ?>',
                cookie: true, // enable cookies to allow the server to access the session
                status: true, // check login status
                xfbml: true, // parse XFBML
                oauth: true, //enable Oauth
                version: 'v2.8'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        var URL = window.location.href;

        /* FACEBOOK SHARE CODE */
        $("#msg").removeClass();
        $("#msg").html('');
        $('.fb_share_btn').click(function (e) {
            e.preventDefault();
            evnt = e;
            obj = $(this);
            elemId = e.target.id;
            FB.ui({
                method: 'feed',
                //href: URL,
                name: 'Battle me',
                link: URL,
                caption: 'To vote your friend please visit ',
                description: URL,
                message: '',
            }, function (response) {
                if (response && !response.error_code) {
                    //console.log("OK: "+JSON.stringify(response));
                    $("#msg").removeClass();
                    $("#msg").addClass('alert');
                    $("#msg").addClass('alert-success');
                    $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> You have successfully promoted");
                }
            });
        });

    });
</script>