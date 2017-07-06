<style type="text/css">
    .own-song-list > li {
        width: 100%; float: left; display: inline-block; 
    }
    .own-song-list span {
        float: left;
        margin-right: 6px;
    }
</style>
<script src="<?php echo base_url() ?>public/js/parsley/parsley.min.js"></script>
<script src="<?php echo base_url() ?>public/js/parsley/parsley.extend.js"></script>
<?php
$singing_category = [ 0 => '-- Select Singing Style --', 1 => 'R&B', 2 => 'PoP', 3 => 'Spanish'];
$singer_gender = ['' => '-- Select Gender --', 1 => 'Male', 2 => 'Female'];
//echo '<pre>';print_r($battle_category);


$selectStr = 'class="form-control"';

$media_data = array(
    'name' => 'media',
    'id' => 'media',
    'class' => '',
    'maxlength' => '225',
        //'data-required' => 'true'
);

 $data_submit = array(
            'name' => 'Submit',
            'id' => 'Submit',
            'value' => 'Register',
            'type' => 'Submit',
            'class' => 'btn btn-success btn-s-xs',
            'content' => 'Create'
        );

if (isset($action) && $action == 'update') {
        $data_submit = array(
            'name' => 'Submit',
            'id' => 'Submit',
            'value' => 'Update',
            'type' => 'Submit',
            'class' => 'btn btn-success btn-s-xs',
            'content' => 'Create'
        );
}

$form_attr = array('name' => 'frm_battle', 'id' => 'frm_battle', 'class' => '', 'data-validate' => 'parsley');
?>
<?php echo form_open_multipart('', $form_attr); ?>
<div class="midsection" id="content">
    <div> 
        
        <header class="panel-heading"> 
            <span class="h4">Register as a Singer</span> 
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert <?php echo $this->session->flashdata('class') ?>">
                    <button class="close" data-dismiss="alert">x</button>
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </header> 

        <?php if (empty($register_singer) || (isset($action) && $action == 'update')) { ?>
            <section class="panel panel-default"> 

                

                <div class="panel-body"> 

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Select Gender</label> 
                            <?php echo form_dropdown('singer_gender', $singer_gender, isset($register_singer['gender'])?$register_singer['gender']:set_value('singer_gender'), $selectStr); ?>
                            <?php echo form_error('singer_gender', '<div class="error">', '</div>'); ?>
                        </div>
                    </div> 

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Singing Style</label>
                            <?php echo form_multiselect('singing_style[]', $singing_category, isset($register_singer['singing_style']) ? explode(',', $register_singer['singing_style']):set_value('singing_style'), $selectStr); ?>
                            <?php echo form_error('singing_style[]', '<div class="error">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Upload voice clip</label> 
                            <?php
                            echo form_upload($media_data);
                            echo form_error('media', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div>

                </div> 

                <footer class="panel-footer text-right bg-light lter"> 
                    <input type="hidden" name="register_id" value="<?=$register_singer['id']?>" >
                    <?php echo form_submit($data_submit) ?>
                </footer> 
            </section> 
        <?php } else { ?>
        
            <!-- For Voice Clip Listing Section -->
            <?php 
            if(file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $register_singer['profile_picture']) && $register_singer['profile_picture'] !='') {
                                            $profile_picture = $register_singer['profile_picture'];
                                        } else {
                                             $profile_picture = 'default.png';
                                        }
                                        $profile_picture = base_url('uploads/profile_picture/130x130/'.$profile_picture);
            ?>
            <div class="list_register_singer">
                <div class="prof_content">
                    <div class="shape">
                        <a class="overlay hexagon" href="<?=base_url('profile/view/'.$register_singer['user_id'])?>"></a>
                        <div class="base">
                            <img alt="" src="<?=$profile_picture?>" height="155px" width="135px">
                        </div>
                    </div>

                    <div class="prof_info">
                        <h3><?=$register_singer['user_name']?></h3>
                        <div class="rev_star">
                            <span>Rating : </span>
                            <em>
                                <?php 
                                
                                    $count_rating = (int)$register_singer['user_rating']; 
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
                            <audio id="voice_clip">
                              <source src="<?=base_url('uploads/library/'.$register_singer['voice_clip'])?>">
                            </audio>
                            <span>Voice Clip : </span>
                            <a href="javascript:void(0)" class="voice_play"><em class="play_btn"></em></a>
                            <a href="javascript:void(0)" class="voice_pause"><em class="pass_btn"></em></a>
                            <a class="hire_btn" href="<?=  base_url('hire_singer/update')?>">Edit</a> 
                            <div class="clear_fixe"></div>      

                        </div>
                        <div class="time_zoon">
                            Times Hird  :  <em>0</em>   
                        </div>

                    </div>
                    <div class="clear_fixe"></div>      
                </div>

            </div>
        <?php } ?>




    </div>
</div>


<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.voice_play').click(function() {
            document.getElementById('voice_clip').play();
        });
        $('.voice_pause').click(function() {
            document.getElementById('voice_clip').pause();
        });
    });
</script>