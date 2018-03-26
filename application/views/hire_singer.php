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
    <h4 class="battle-list-heading">Hire a singer</h4>

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
        <ul class="nav nav-tabs responsive-tabs tab2" role="tablist">
            <li role="presentation" <?php if (!empty($singerList) && isset($singerList[1])) { echo 'class="active"'; } ?>> 
                <a href="#01" aria-controls="01" role="tab" data-toggle="tab">
                   Male
                </a> 
            </li>
            <li role="presentation"> <a href="#02" aria-controls="02" role="tab" data-toggle="tab">Female</a> </li>
        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
            
            <?php
             if (!empty($singerList)) { 
             //echo '<pre>'; print_r($singerList); die;
             foreach ($singerList as $key => $singerListArray) {
            ?>

            <div role="tabpanel" class="tab-pane tab-pane2 <?=$key==1?'active':''?>" id="0<?=$key?>">
                <div class="regis_examples">
                    <div id="tab0<?=$key?>" class="eg tab-block">
                        <div class="registry_user_battle_section">
                            <div class="row">
                                
                                <?php
                                    foreach ($singerListArray as $key1 => $value) {
                                        
                                        if(file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $value['profile_picture']) && $value['profile_picture'] !='') {
                                            $profile_picture = $value['profile_picture'];
                                        } else {
                                             $profile_picture = 'default.png';
                                        }
                                        $profile_picture = base_url('uploads/profile_picture/130x130/'.$profile_picture);
                                ?>

                                <div class="col-sm-12">
                                   <div class="prof_content">
                                        <div class="shape">
                                            <a href="<?=base_url('profile/view/'.$value['user_id'])?>" class="overlay hexagon"></a>
                                            <div class="base">
                                                <img src="<?=$profile_picture?>" height="155px" width="135px" alt="">
                                            </div>
                                        </div>

                                        <div class="prof_info">
                                            <h3><?=$value['user_name']?></h3>
                                            <div class="rev_star">
                                                <span>Rating : </span>
                                                <em>
                                                    <?php 
                                                        $count_rating = (int)$value['user_rating']; 
                                                        for($r=1; $r <= $count_rating; $r++) { 
                                                    ?>
                                                    <img alt="javascript:void(0);" src="<?=base_url()?>public/images/star1.png">
                                                    <?php } 
                                                        for($r=1; $r <= 5-$count_rating; $r++) {
                                                    ?>
                                                        <img alt="javascript:void(0);" src="<?=base_url()?>public/images/star2.png">
                                                    <?php } ?>
                                                    
                                                       <div class="clear_fixe"></div>  
                                                </em>
                                                  <div class="clear_fixe"></div>  
                                            </div>
                                            
                                             <div class="video_clip">
                                                    <audio id="voice_clip_<?=$value['id']?>">
                                                        <source src="<?=base_url('uploads/library/'.$value['voice_clip'])?>">
                                                    </audio>
                                                    <span>Voice Clip : </span>
                                                    <a href="javascript:void(0)" class="voice_play" song-id="<?=$value['id']?>"><em class="play_btn"></em></a>
                                                    <a href="javascript:void(0)" class="voice_pause" song-id="<?=$value['id']?>"><em class="pass_btn"></em></a>
                                                    
                                                    <?php 
                                                        $hire_status = $this->hire->getIsHired($value['user_id']);
                                                    if($hire_status['status'] == 0 && $hire_status['status'] != NULL ) { ?>
                                                        <a href="javascript:void(0)" class="hire_btn">Hired</a> 
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0)" data-toggle="modal" hired-uid="<?=$value['user_id']?>" data-target="#hireModal" class="hire_btn">Hire</a> 
                                                    <?php } ?>
                                                    
                                                    <div class="clear_fixe"></div>      
                                             </div>
                                            
                                             <div class="time_zoon">
                                                 Times Hired  :  <em><?=$value['count_hired']?></em>   
                                             </div>

                                        </div>
                                        <div class="clear_fixe"></div>      
                                   </div>
                                </div>
                                
                                <?php } ?>

                               
                            </div>
                        </div>

                    </div>
                </div>
            </div>

             <?php } } ?>
             



        </div>
    </div>
    <div class="clearfix"></div>
</div>


<!-- Modal -->
<form action="<?=base_url('hire_singer/doHired')?>" name="hired_form" method="POST" >
    <div id="hireModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Hire a Singer</h4>
          </div>
          <div class="modal-body">
            <p>Balance : <?=$userdata[0]->coins?> <img alt="" src="<?=base_url('/public/images/dolar_b.png')?>"></p>
            <p>Hiring charges : 175 <img alt="" src="<?=base_url('/public/images/dolar_b.png')?>"></p>
            <?php if((int)$userdata[0]->coins < 175) { ?>
                <p>Add Battle Bucks : <a href="<?=base_url('wallet')?>">Wallet</a></p>
            <?php } ?>
                <p><input type="checkbox" name="terms" required="" value="1"> Agree the 
                    <a href="<?php echo base_url('page/terms_and_conditions'); ?>" target="_blank">Terms &amp; Conditions</a></p>
                <input type="hidden" name="hired_user" value="">
                <input type="hidden" name="current_balance" value="<?=$userdata[0]->coins?>">
          </div>
          <div class="modal-footer">
               <?php if((int)$userdata[0]->coins >= 175) { ?>
                    <button type="submit" class="btn btn-default" >Done</button>
              <?php } ?>
          </div>
        </div>

      </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        
        $('.hire_btn').on('click', function() {
            var hired_uid = $(this).attr('hired-uid');
            $('[name=hired_user]').val(hired_uid);
        });
        
        $('.voice_play').click(function() {
            var songId = $(this).attr('song-id');
            document.getElementById('voice_clip_'+songId).play();
        });
        $('.voice_pause').click(function() {
            var songId = $(this).attr('song-id');
            document.getElementById('voice_clip_'+songId).pause();
        });
    });
</script>