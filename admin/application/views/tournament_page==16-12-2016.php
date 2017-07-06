<?php
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
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Upload'
);

$form_attr = array('name' => 'battle_media', 'id' => 'battle_media', 'class' => '', 'data-validate' => 'parsley');

$form_attr_2 = array('name' => 'add_member', 'id' => 'add_member', 'class' => '', 'data-validate' => 'parsley');
?>
<!--<div class="midsection">-->
    <div>
        <section class="panel panel-default scrollable"> 

            <header class="panel-heading"> 
                <span class="h4"><?php echo $tournament_details[0]['challenger'] . ' has created tournament' ?></span> 	
            </header>

            <section class="panel panel-body">
                <div class="col-lg-12">
                    <h4> <?php echo $tournament_details[0]['tournament_name']; ?></h4>
                </div>
                <?php //echo '<pre>'; print_r($tournament_details); die;   ?>
                <div class="col-lg-12">
                    <?php echo $tournament_details[0]['description']; ?>
                    <!-- <?//php echo '<br>Entry fee: '.$tournament_details[0]['entry'].' Coins'; ?>
                    <?//php echo '<br>Prize: '.$tournament_details[0]['prize'].' Coins'; ?>-->
                    <?php echo '<br>Entry fee: ' . tournamentEntry . ' Coins'; ?>
                    <?php echo '<br>1st Prize: ' . tournamentFirstPrize . ' Coins'; ?>
                    <?php echo '<br>2nd Prize: ' . tournamentSecondPrize . ' Coins'; ?>
                    <?php echo '<br>3rd Prize: ' . tournamentThirdPrize . ' Coins'; ?>
                    <input type="hidden" id="artists_id" name="artists_id">
                    <input type="hidden" id="voter_id" name="voter_id" value="<?= $sess_data['id'] ?>">
                    <input type="hidden" id="tournament_request_id" name="tournament_request_id" value="<?= $tournament_details[0]['tournament_request_id'] ?>">
                </div>
            </section>

            <div class="col-lg-8">
                <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
                        <button class="close" data-dismiss="alert">x</button>                
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>

                <?php
                if (!isset($tournament_details[0]['start_date'])) {
                    echo 'Tournament not started yet: ';
                    if (isset($tournament_details[0]['friend_user_id'])) {
                        echo ' ' . count($friend_user_ids) . '/96';
                    } else {
                        echo '0/96';
                    }
                    echo '<br><br>';
                }

                if ($round > 0) {
                    echo '</br>Tournament Started<br>Round: ' . $round;
                    ?>
                    <input type="hidden" id="round" name="round" value="<?= $round ?>">
                    <?php
                    }

                    //echo '<pre>'; print_r($sess_data); 

                    if (!in_array($user_id, $friend_user_ids) && $sess_data['user_type'] == 'artist' && $sess_data['membership_id'] == 2) {
                        ?>
                    <div> 
                        <?php echo form_open_multipart('', $form_attr_2); ?>
                        <section class="panel panel-default"> 
                            <header class="panel-heading"> 
                                <span class="h4">Enter tournament</span> 
                            </header> 

                            <header class="panel-heading"> 
                                <span class="h4">Upload Media</span> 
                            </header> 
                            <div class="panel-body"> 

                                <div class="form-group"> 
                                    <div class="form-group"> 
                                        <label>Title</label> 
                                        <?php
                                        echo form_input($title_data);
                                        echo form_error('title');
                                        ?>
                                    </div> 
                                    <div class="form-group"> 
                                        <label>Song</label> 
                                    <?php
                                    echo form_upload($media_data);
                                    echo form_error('media');
                                    ?>
                                    </div> 
                                </div>


                                <footer class="panel-footer text-right bg-light lter"> 
                            <?php echo form_submit($data_submit_2) ?>
                                </footer> 
                        </section> 
                        <?php echo form_close(); ?>
                    </div>

    <?php } ?>     
            </div>
        </section>
    </div>

<?php
//echo $user_id.'<pre>'; print_r($friend_user_ids);

if ((in_array($user_id, $friend_user_ids) OR $user_id == $tournament_details[0]['user_id'])) { ?>
        <div class="centered" style="text-align: center">
            <div class="doc-buttons">
                <a href="#" class="btn btn-md btn-success promoteBtn" data-toggle="modal" data-target="#promote_div">Promote</a>
                <br>
            </div>
        </div>
<?php } ?>

<?php if (!isset($tournament_details[0]['start_date'])) { ?>    

    <?php
    if (isset($tournament_details[0]['friend_user_id'])) {
        $id = 1;
        foreach ($tournament_details as $tournament_detail) {
            if ($tournament_detail['f_profile'] == '') {
                $profile = 'default.png';
            } else {
                $profile = 'thumb_' . $tournament_detail['f_profile'];
            }
            ?>

                <div class="pull-left col-lg-2">
                    <section class="panel panel-default">
                        <header class="panel-heading"><?php echo $tournament_detail['friend'] ?></header>

                        <div class="slimScrollDiv" >
                            <section class="panel-body slim-scroll" >
                                <section class="col-lg-12 no-padder bg">
                                    <section class="scrollable">
                                        <section class="scrollable hover"> 

                                                    <?php
                                                    $friend_media_path = '';
                                                    foreach ($tournament_media as $key => $value) {
                                                        if ($tournament_detail['friend_user_id'] == $value['artist_id']) {
                                                            $friend_media_path = $this->config->item('battle_media_path') . $value['media'];
                                                        }
                                                    }
                                                    if ($friend_media_path != '') {
                                                        ?>
                                                <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                                                    <li class="list-group-item clearfix"> 
                                                <?php $this->view('jplayer', ['path' => base_url($friend_media_path), 'id' => $id]);
                                                $id++; ?>
                                                        <!--					<a  class="jp-play-me pull-right m-t-sm m-l text-md" href="< ?php echo base_url($friend_media_path) ?>"> 
                                                                                                    <i class="icon-control-play text"></i> 
                                                                                                    <i class="icon-control-pause text-active"></i>
                                                                                                </a> -->
                                                        <a class="pull-left thumb-sm m-r" href="#">
                                                            <img alt="..." src="<?php echo base_url('uploads/profile_picture/thumb_' . $profile) ?>"></a>
                                                        <a href="#<?php //echo base_url($friend_media_path)  ?>" class="clear"> 
                                                            <span class="block text-ellipsis"><?php echo $friend_title ?></span> 
                                                        </a> 
                                                    </li> 
                                                </ul>
            <?php } ?>

                                        </section> 
                                    </section> 
                                </section>
                                <section  class="btn ">
                                    <span class="label label-success">W: <?php echo $tournament_detail['win_cnt'] ?></span>
                                    <span class="label label-danger">L: <?php echo $tournament_detail['lose_cnt'] ?></span>


                                </section>
                            </section>
                        </div>

                    </section>

                </div>
        <?php }
    } ?>

    <?php if (isset($tournament_details[0]['friend_user_id'])) {
        $mems = count($friend_user_ids);
    } else {
        $mems = 0;
    }
    for ($i = 0; $i < (96 - $mems); $i++) {
        ?>

            <div class="pull-left col-lg-2">
                <section class="panel panel-default">
                    <header class="panel-heading">Empty Spot</header>
                    <div class="slimScrollDiv">
                        <section data-size="10px" data-height="230px" class="panel-body slim-scroll" style="overflow: hidden; width: auto; height: 230px;">
                            <section class="col-lg-12 no-padder bg">
                                <section class="scrollable">
                                    <section class="scrollable hover"> 

                                    </section> 
                                </section> 
                            </section>

                        </section>
                    </div>

                </section>

            </div>
        <?php } ?>

    <?php } else {
        
        $class = 'item_active';
        $id = 1;
        
        //echo '<pre>'; print_r($tournament_groups); die; ?>
            
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
            <div class="round_button">Fanals</div>
        </div>
        </div>
    </div>
    <div class="tournament_bord_wappper_row">
       <!-- 1st team structure-->
       
        <div class="one_colmn">
    <div class="first_round_team_structure">
       <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>

           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>

            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
            </div>
        </div>
        
      <!-- 2nd team structure-->
       <div class="one_colmn">
    <div class="second_round_team_structure">
       <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
            </div>
        </div>
        
        <!-- 3rd team structure-->
       <div class="one_colmn">
    <div class="third_round_team_structure">
       <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           
            </div>
        </div>
        
        <!-- 4th team structure-->
        <div class="one_colmn">
    <div class="fourth_round_team_structure">
       <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
           
           
            </div>
        </div>
        
        
        <!-- 5th team structure-->
        <div class="one_colmn">
    <div class="fifth_round_team_structure">
       <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
            
       </div>
       
           
           
            </div>
        </div>
        
        
         <!-- 5th team structure-->
        <div class="one_colmn">
    <div class="final_round_team_structure">
       <div class="round_against_team">
           <div class="round_team">
               <h4>Jmi Albart</h4>
               <p>My heart will go on...</p>
           </div>
         
            
       </div>
       
           
           
            </div>
        </div>
        
    </div>
</div>       
            
        
<?php $tournament_groups = [];        foreach ($tournament_groups as $group) {

            foreach ($group as $member_id) {
                
                foreach ($tournament_details as $tournament_detail) {

                    if ($tournament_detail['friend_user_id'] == $member_id) {

                        if ($tournament_detail['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                            $profile = 'thumb_' . $tournament_detail['f_profile'];
                        }


                        if ($tournament_detail['f_profile'] == '') {
                            $profile = 'default.png';
                        } else {
                            $profile = 'thumb_' . $tournament_detail['f_profile'];
                        }
                        ?>

                        <div class="pull-left col-lg-2">
                            <section class="panel panel-default">
                                <header class="panel-heading"><?php echo $tournament_detail['friend'] ?></header>
                                <a class="pull-left thumb-sm m-r" href="#">
                                    <img alt="..." src="<?php echo base_url('uploads/profile_picture/thumb_' . $profile) ?>"></a>
                                <div class="slimScrollDiv" >
                                    <section  >
                                        <section class="col-lg-12 no-padder bg">
                                            <section class="scrollable">
                                                <section class="scrollable hover"> 

                    <?php
                    $friend_media_path = '';
                    foreach ($tournament_media as $key => $value) {
                        if ($tournament_detail['friend_user_id'] == $value['artist_id']) {
                            $friend_media_path = $this->config->item('battle_media_path') . $value['media'];
                        }
                    }
                    if ($friend_media_path != '') {
                        ?>
                                                        <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                                                            <li class="list-group-item clearfix"> 
                        <?php $this->view('jplayer', ['path' => base_url($friend_media_path), 'id' => $id]);
                        $id++; ?>
                        <!--					<a  class="jp-play-me pull-right m-t-sm m-l text-md" href="<?php echo base_url($friend_media_path) ?>"> 
                                                                    <i class="icon-control-play text"></i> 
                                                                    <i class="icon-control-pause text-active"></i>
                                                                </a> -->

                                                                <a href="<?//php echo base_url($friend_media_path) ?>" class="clear"> 
                                                                    <span class="block text-ellipsis"><?php echo $friend_title ?></span> 
                                                                </a> 
                                                            </li> 
                                                        </ul>
                    <?php } ?>

                                                </section> 
                                            </section> 
                                        </section>
                                        <section  class="btn ">
                                            <span class="label label-success">W: <?php echo $tournament_detail['win_cnt'] ?></span>
                                            <span class="label label-danger">L: <?php echo $tournament_detail['lose_cnt'] ?></span>
                                            <br>
                        <?php if ($sess_data['user_type'] == 'fan') { ?>
                                                <div class="doc-buttons">
                                                    <br>
                            <?php if ($tournament_detail['start_date'] != null && $tournament_detail['end_date'] > date('Y-m-d')) { ?>
                                                        <a href="#" class="btn btn-md btn-success voteBtn" alt="<?php echo $tournament_detail['friend_user_id'] ?>" data-toggle="modal" data-target="#vote_1">Vote</a> 
                            <?php } ?>
                                                </div>
                        <?php } ?>
                                            <div>Votes : <span id="vote_cnt_<?php echo $tournament_detail['friend_user_id'] ?>"><?php echo ( isset($vote_count[$tournament_detail['friend_user_id']])) ? $vote_count[$tournament_detail['friend_user_id']] : 0; ?></span></div>
                                        </section>
                                    </section>
                                </div>

                            </section>

                        </div>
                    <?php
                    }
                }
            }
            
        }

    }
?>         


<div id="promote_div" class="modal fade common-modal-popup promote-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Promote for your Tournament</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="alert-info"></div>
                <p id="social-buttons"> 
                    <a  class="btn btn-sm btn-info" href="https://twitter.com/intent/tweet?text=Tournament Page&url=<?php echo urlencode(current_url()) ?>"id="tw_share_btn_promote">
                        <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                    <a  class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn_promote">
                        <i class="fa fa-fw fa-facebook"></i> Facebook</a> 

                </p>
            </div>
        </div>
    </div>
</div>




    <div id="twitterbutton-example"></div>
    <div id="vote_1" class="modal fade common-modal-popup vote-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
<?php
$disableBtnFb = $disableBtnTw = '';
if (!empty($sess_data)) {
    /* if(array_key_exists($battle_details['friend_user_id'] , $voterVotes))
      {
      $socialMediaArr = $voterVotes[$battle_details['friend_user_id']]['social_media'] ;
      if(array_key_exists('fb' , $socialMediaArr))
      $disableBtnFb = 'disabled="disabled"';
      if(array_key_exists('tw' , $socialMediaArr))
      $disableBtnTw = 'disabled="disabled"';
      }
     */
    ?>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <h4 class="modal-title">Share this page on either of the site</h4>
                    </div>
                    <div class="modal-body">
                        <div id="msg" class="alert-info"></div>
                        <p id="social-buttons"> 
                            <a class="btn btn-sm btn-info" <?php echo $disableBtnTw ?> href="https://twitter.com/intent/tweet?text=Tournament Page&url=<?php echo urlencode(current_url()) ?>"id="tw_share_btn">
                                <i class="fa fa-fw fa-twitter"></i> Twitter</a> 
                            <a <?php echo $disableBtnFb ?> class="btn btn-sm btn-primary fb_share_btn" href="#" id="fb_share_btn">
                                <i class="fa fa-fw fa-facebook"></i> Facebook</a> 
                            <!--			<a class="btn btn-sm btn-danger" href="#">
                                                        <i class="fa fa-fw fa-instagram"></i> Instagram</a>-->
                        </p>
                    </div>
<?php } else {
    ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        Vote for Artists
                    </div> 
                    <div class="modal-body">
                        <p>
                            Please <a href="<?php echo base_url() ?>" class="text-info">Login</a> OR 
                            <a href="<?php echo base_url('user/registration') ?>" class="text-info">Sign Up</a> to place Vote.
                        </p>
                    </div>
    <?php
}
?>
            </div>
        </div>
    </div>

<!--</div>--> 

<!--    <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>-->
<script src="http://code.jquery.com/jquery-latest.pack.js" type="text/javascript"></script>
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
<!--<script src="<?php //echo base_url('public/js/jquery.twitterbutton.1.1.js') ?>" type="text/javascript"></script>-->
<script>
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
<!--script>
  window.twttr = (function (d,s,id) {
      var t, js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
      js.src="https://platform.twitter.com/widgets.js";
      fjs.parentNode.insertBefore(js, fjs);
      return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
  }(document, "script", "twitter-wjs"));
</script-->
<script>

    $(document).ready(function () {

        /* Twitter btn integration */
//	
//	$('#twitterbutton-example').twitterbutton({
//   user:'BattleMe',
//   title:'',
//   onfollow:function(response){
//       alert(response);
//    $('.twitterbutton-uncontent:visible').hide('fade');
//    $('.twitterbutton-content').show('fade');
//    $.cookie('tw','followed');
//   },
//   ontweet:function(response){
//     alert("hello");
//   },
//   onretweet:function(response){
//
//   },
//   lang:'en'
//  });
        /* End of twitter button Integration */

        $(".voteBtn").click(function (event) {
            var obj = $(this);
            var artist_id;
            event.preventDefault();
            artist_id = $(this).attr('alt');
            $('#artists_id').val(artist_id);

        });

        twttr.ready(function (twttr) {
            //get  twitter event
            twttr.events.bind('tweet', function (event) {
                elemId = event.target.id;
                if (elemId !== 'tw_share_btn_promote')
                {
                    placeVote('tw');
                    $("#msg").removeClass();
                    $("#msg").addClass('alert');
                    $("#msg").addClass('alert-success');
                    $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> Thank you for your vote.");

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
  }(document, 'script', 'facebook-jssdk')); */
?>

        var URL = window.location.href;

        /* FACEBOOK SHARE CODE */
        $('.fb_share_btn').click(function (e) {
            e.preventDefault();
            evnt = e;
            obj = $(this);
            elemId = e.target.id;
            FB.ui({
                method: 'share',
                href: URL
            }, function (response) {
                if (elemId != 'fb_share_btn_promote') {
                    if (response && !response.error_code) {

                        console.log("OK: " + JSON.stringify(response));
                        placeVote('fb');
                        $("#msg").removeClass();
                        $("#msg").addClass('alert');
                        $("#msg").addClass('alert-success');
                        $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button> Thank you for your vote.");
                        // $("#vote").dialog('close');
                        setTimeout(function () {
                            $("#msg").removeClass();
                            $("#msg").html('');


                        }, 4000);

                        $(".close").trigger("click");

                    } else {
                        console.log("Not OK: " + JSON.stringify(response));
                        $("#msg").removeClass();
                        $("#msg").addClass('alert');
                        $("#msg").addClass('alert-info');
                        $("#msg").html("<button data-dismiss='alert' class='close' type='button'>×</button>Your vote can not be placed untill you share this tournament");
                        $(".close").trigger("click");
                    }
                }
                else
                {
                    $(".close").trigger("click");
                }

            });
        });

    });



    function placeVote(socialMedia)
    {
        var artists_id = $('#artists_id').val();
        var social_media = socialMedia;
        var voter_id = $('#voter_id').val();
        var tournament_request_id = $('#tournament_request_id').val();
        var round = $('#round').val();
        $.ajax({
            type: "POST",
            url: base_url + "ajax/place_tournament_vote",
            data: {artist_id: artists_id, voter_id: voter_id, tournament_request_id: tournament_request_id, social_media_type: social_media, round: round},
            success: function (data) {
                $('#vote_cnt_' + artists_id).html("");
                $('#vote_cnt_' + artists_id).html(data);
            },
        });
    }
</script>