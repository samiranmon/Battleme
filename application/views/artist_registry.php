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
    <h4 class="battle-list-heading">Artist Registry</h4>

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
             if (!empty($artistList)) { 
             //echo '<pre>'; print_r($artistList); die;
             foreach ($artistList as $key => $artistListArray) {
            ?>
            <div role="tabpanel" class="tab-pane <?=$key==1?'active':''?>" id="0<?=$key?>">
                <div class="regis_examples">
                    <div id="tab0<?=$key?>" class="eg tab-block">
                        <div class="registry_user_battle_section">
                            <div class="row">
                                
                                <?php
                                    foreach ($artistListArray as $key1 => $value) {
                                        
                                        if(file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $value['profile_picture']) && $value['profile_picture'] !='') {
                                            $profile_picture = $value['profile_picture'];
                                        } else {
                                             $profile_picture = 'default.png';
                                        }
                                        $profile_picture = base_url('uploads/profile_picture/130x130/'.$profile_picture);
                                ?>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="registry_user_battle">
                                        <a href="<?=base_url('profile/view/'.$value['user_id'])?>">
                                            <div class="registry_user_battle_img">
                                                <img src="<?=$profile_picture?>" alt="<?=$value['user_name']?>">
                                            </div>
                                        </a>
                                        <div class="registry_user_battle_text">
                                            <h4>
                                                <a href="<?=base_url('profile/view/'.$value['user_id'])?>">
                                                    <?=$value['user_name']?>
                                                    <?php if($value['memberships_id'] == 2) { ?>
                                                        <img src="<?= base_url() ?>public/images/dolar_b.png" alt="">
                                                    <?php } else { ?>
                                                        <img src="<?= base_url() ?>public/images/panja.png" alt="">
                                                    <?php } ?>
                                                </a>
                                            </h4>
                                            <p><?=$value['info']?></p>
                                            <ul>
                                                <li><a href="<?=base_url('battle/create/'.$value['user_id'])?>">Challenge</a></li>
                                                <li class="goldern_mike"><a href="javascript:void(0);"><?=$value['win_cnt']?></a></li>
                                                <li class="silver_mike"><a href="javascript:void(0);">0</a></li>
                                                <li class="white_mike"><a href="javascript:void(0);">0</a></li>
                                                <li class="red_mike"><a href="javascript:void(0);"><?=$value['lose_cnt']?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                 
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
             <?php }} ?>
            
            
            
        </div>
    </div>
    <div class="clearfix"></div>
</div>