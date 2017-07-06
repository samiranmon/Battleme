<link href="<?php echo base_url() ?>public/css/rating.css" rel="stylesheet">
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
<script src="<?php echo base_url() ?>public/js/rating.js"></script>
<?php
//$selectStr = 'class="form-control"';

$accept_field = array(
    'name'        => 'accept',
    'id'          => 'accept',
    'value'       => 1,
    'checked'     => FALSE,
    'style'       => 'margin:10px',
    );

 $data_submit = array(
            'name' => 'Submit',
            'id' => 'Submit',
            'value' => 'Confirm',
            'type' => 'Submit',
            'class' => 'btn btn-success btn-s-xs',
            'content' => 'Create'
        );


$form_attr = array('name' => 'frm_battle', 'id' => 'frm_battle', 'class' => '', 'data-validate' => 'parsley');
?>
<?php echo form_open_multipart('', $form_attr); ?>
<div class="midsection" id="content">
    <div> 
        
        <header class="panel-heading"> 
            <span class="h4">Fund release</span> 
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert <?php echo $this->session->flashdata('class') ?>">
                    <button class="close" data-dismiss="alert">x</button>
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </header> 

        <?php if ((isset($action) && $action == 'update')) { ?>
            <section class="panel panel-default"> 
                <div class="panel-body"> 

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div  class="col-md-2 col-sm-2">
                                <label>Rating singer</label></div> 
                            <div class="col-md-10 col-sm-10">
                                <input name="rating_singer" value="" id="rating_star" type="hidden" postID="1" />
                                <?php echo form_error('rating_singer', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>
                    </div> 

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div  class="col-md-2 col-sm-2">
                                <label>I received song from singer</label>
                            </div>
                            <div class="col-md-10 col-sm-10">
                                <?php echo form_checkbox($accept_field); ?>
                                <?php echo form_error('accept', '<div class="error">', '</div>'); ?>
                            </div>
                            
                        </div>
                    </div>

                </div> 

                <footer class="panel-footer text-right bg-light lter"> 
                    <input type="hidden" name="hired_user_id" value="<?=$hiredDtl['hired_user_id']?>" >
                    <?php echo form_submit($data_submit) ?>
                </footer> 
            </section> 
        <?php } else { 
                if(!empty($hired_singer) && isset($hired_singer[0]['id'])) {
                    foreach ($hired_singer as $sval) {
            ?>
        
            <!-- For Voice Clip Listing Section -->
            <?php 
            if(file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $sval['profile_picture']) && $sval['profile_picture'] !='') {
                                            $profile_picture = $sval['profile_picture'];
                                        } else {
                                             $profile_picture = 'default.png';
                                        }
                                        $profile_picture = base_url('uploads/profile_picture/130x130/'.$profile_picture);
            ?>
            <div class="list_register_singer">
                <div class="prof_content">
                    <div class="shape">
                        <a class="overlay hexagon" href="<?=base_url('profile/view/'.$sval['user_id'])?>"></a>
                        <div class="base">
                            <img alt="" src="<?=$profile_picture?>" height="155px" width="135px">
                        </div>
                    </div>

                    <div class="prof_info">
                        <h3><?=$sval['user_name']?></h3>
                        <div class="rev_star">
                            <span>Rating : </span>
                            <em>
                                <?php 
                                
                                    $count_rating = (int)$sval['user_rating']; 
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
                              <source src="<?=base_url('uploads/library/'.$sval['voice_clip'])?>">
                            </audio>
                            <span>Voice Clip : </span>
                            <a href="javascript:void(0)" class="voice_play"><em class="play_btn"></em></a>
                            <a href="javascript:void(0)" class="voice_pause"><em class="pass_btn"></em></a>
                            <?php if($sval['status'] == 0) { ?>
                            <a class="hire_btn" href="<?=  base_url('hire_singer/rating_singer/'. base64_encode($this->encrypt->encode($sval['hired_id'])))?>">Release</a>
                            <?php } else { ?>
                                <a class="hire_btn" href="javascript:void(0)">Released</a>
                            <?php } ?>
                            <div class="clear_fixe"></div>      

                        </div>
                        <div class="time_zoon">
                            Times Hired  :  <em><?=$sval['count_hired']?></em>   
                        </div>

                    </div>
                    <div class="clear_fixe"></div>      
                </div>

            </div>
        <?php } } }?>




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
    
    $(function() {
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '<?= set_value('rating_singer') == NULL ? 3:set_value('rating_singer')?>',
        callbackFunctionName: 'processRating',
        imageDirectory: '<?=  base_url('public/images/')?>',
        inputAttr: 'postID'
    });
});

function processRating(val, attrVal){
    return false;
    $.ajax({
        type: 'POST',
        url: '',
        data: 'postID='+attrVal+'&ratingPoints='+val,
        dataType: 'json',
        success : function(data) {
            if (data.status == 'ok') {
                 
            }else{
                alert('Some problem occured, please try again.');
            }
        }
    });
}
</script>