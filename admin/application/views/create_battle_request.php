<style type="text/css">
    .own-song-list > li{
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
$battle_category = [ '' => '-- Select Battle Category --', 1 => 'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6=>'Raggeton', 7=>'Latino hip hop', 8=>'Latino songs originals', 9=>'Latino songs covers'];
//echo '<pre>';print_r($battle_category);


$selectStr = 'class="form-control"';

$title_data = array(
    'name' => 'battle_name',
    'id' => 'battle_name',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Battle Name',
    'value' => set_value('battle_name'),
    'data-required' => 'true'
);
$description_data = array(
    'name' => 'description',
    'id' => 'description',
    'class' => 'form-control',
    'maxlength' => '225',
    'rows' => '4',
    'cols' => '50',
    'placeholder' => 'Description',
    'value' => set_value('description'),
    'data-required' => 'true'
);

$media_title = array(
    'name' => 'media_title',
    'id' => 'media_title',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Media Title',
    'value' => set_value('media_title'),
        //'data-required' => 'true'
);

$place = array(
    'name' => 'place',
    'id' => 'place',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Place',
    'value' => set_value('place'),
        //'data-required' => 'true'
);
$date_time = array(
    'name' => 'date_time',
    'id' => 'date_time',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Date & Time',
    'value' => set_value('date_time'),
        //'readonly'=>'true',
        //'data-required' => 'true'
);



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
    'value' => 'Create',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Create'
);

$form_attr = array('name' => 'frm_battle', 'id' => 'frm_battle', 'class' => '', 'data-validate' => 'parsley');
?>
<?php echo form_open_multipart('', $form_attr); ?>
<div class="midsection" id="content">
    <div> 
        
        <section class="panel panel-default"> 
            <header class="panel-heading"> 
                <span class="h4">Create Battle Request</span> 
                <!--</br> <small>Fix charge of 10 coins will be charged after accepting challenge</small>-->
                <?php
                // echo "<pre>";
                // print_r($battleList);
                if ($this->session->flashdata('message')) {
                    ?>
                    <div class="alert <?php echo $this->session->flashdata('class') ?>">
                        <button class="close" data-dismiss="alert">x</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>

            </header> 
            <div class="panel-body"> 

                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Select Friend</label> 
                        <?php //echo form_dropdown('friend_user_id', $friendsOpt, $selected, $selectStr); ?>
                        <?php echo form_dropdown('friend_user_id', $friendsOpt, $selected > 0 ? $selected : set_value('friend_user_id'), $selectStr); ?>
                        <?php echo form_error('friend_user_id', '<div class="error">', '</div>'); ?>
                    </div>
                </div> 
                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Battle Name</label> 
                        <?php echo form_input($title_data); ?>
                    </div>
                </div> 

                <?php
                $sess_data = get_session_data();
                if ($sess_data['membership_id'] == 2) {
                    ?>
                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Battle Type</label>
                            <select name="cash" >
                                <option value="1" <?php echo set_select('cash', '1'); ?>>Regular Battles</option>
                                <option value="2" <?php echo set_select('cash', '2'); ?>>Cash Battles</option>
                            </select>


                            <div class="cash-battle" style="display: none;">
                                </br><label>Entry</label> 
                                <input name="entry" min="0" step="1" value="<?= set_value('entry') ?>" type="number" />Battle Bucks
                                </br> <?php echo form_error('entry', '<div class="error">', '</div>'); ?>
                                <small>Charge of cash battle bucks will be charged after accepting challenge</small>
                            </div>
                        </div>
                    </div>
<?php } ?>


                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Battle Category</label>
                        <?php echo form_dropdown('battle_category', $battle_category, set_value('battle_category'), $selectStr); ?>
<?php echo form_error('battle_category', '<div class="error">', '</div>'); ?>
                    </div>
                </div>


                <div id="freestyle_section" style="display: none;">

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Place</label> 
                            <?php
                            echo form_input($place);
                            echo form_error('place', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Date & Time</label> 
                            <?php
                            echo form_input($date_time);
                            echo form_error('date_time', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div>
                </div>


                <div id="upload_section">
                    <div class="form-group media-title"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Media Title</label> 
                            <?php
                            echo form_input($media_title);
                            echo form_error('media_title', '<div class="error">', '</div>');
                            ?>
                        </div>
                    </div> 
                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>Upload song</label> </br>
                            
                            <span>
                                Upload file : <input type="radio" name="media_type" value="1" <?=set_value('media_type')==1?'checked':'' ?> >&nbsp;
                                Media library : <input type="radio" name="media_type" value="2" <?=set_value('media_type')==2?'checked':'' ?>>
                                <?=form_error('media_type', '<div class="error">', '</div>')?>
                            </span><br><br>
                            
                            <div id="file_area" style="display: none">
                                <?php
                                    echo form_upload($media_data);
                                    echo form_error('media', '<div class="error">', '</div>');
                                ?>
                            </div>
                            <div id="library_area" style="display: none">
                                <strong><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="btn btn-sm" style="background:#449D44">Library</a></strong>
                                <?=form_error('media_id', '<div class="error">', '</div>')?>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>


                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Description</label> 
<?php echo form_textarea($description_data); ?>
                    </div>
                </div> 
            </div> 

            <footer class="panel-footer text-right bg-light lter"> 
<?php echo form_submit($data_submit) ?>
            </footer> 
        </section> 

    </div>
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Choose your song</h4>
            </div>
            <div class="">
                <div class="soundWidget">
                    <ul class="own-song-list"></ul>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Choose</button>
            </div>
      </div>
      
    </div>
  </div>
<!-- Modal -->
<?php echo form_close(); ?>



<?php
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
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('select[name="cash"]').change(function () {
            if ($('select[name=cash]').val() == 2) {
                $('.cash-battle').show();
            } else {
                $('.cash-battle').hide();
            }
        }).change();

        // Condition for freestyle battle
        $('select[name="battle_category"]').change(function () {
            if ($(this).val() != 5) {
                $('#upload_section').show();
                $('#freestyle_section').hide();
                //$('#media_title, #media').attr('data-required','true');
                //$('#place, #date_time').removeAttr('data-required');
            } else {
                $('#upload_section').hide();
                $('#freestyle_section').show();
                $('#Submit').val('Beat');
                //$('#place, #date_time').attr('data-required','true');
                //$('#media_title, #media').removeAttr('data-required');
            }
        }).change();


        //$('#date_time').on('click', function(){
        var date = new Date();
        date.setDate(date.getDate() - 0);
        $('#date_time').datetimepicker({
            showTodayButton: true,
            showClear: true,
            minDate: date
        });
        //});
        
        
        // For pick song from Lirrary
         $('input[name="media_type"]').click(function () {
            if ($('input[name=media_type]:checked').val() == 1) {
                $('#file_area, .media-title').show();
                $('#library_area').hide();
            } else {
                $('#library_area').show();
                $('#file_area, .media-title').hide();
            }
        });
        if ($('input[name=media_type]:checked').val() == 1) {
                $('#file_area, .media-title').show();
                $('#library_area').hide();
            }
        if ($('input[name=media_type]:checked').val() == 2) {
                $('#library_area').show();
                $('#file_area, .media-title').hide();
            }
    });


    var soundArr = <?=$songs_str?>;
    var sLan = soundArr.length; 

    for (i = 0; i < sLan; i++) {
        var songCount = i + 1;
        $(".soundWidget ul").append("<li><span><input type='radio' name='media_id' id='demia_data_"+soundArr[i][2]+"' value='" + soundArr[i][2] + "' ></span><div class=audioleft><a href=javascript:void(0)>" + soundArr[i][1] + "</a></div><div class=audioright><audio><source src='" + soundArr[i][0] + "'  type=audio/mpeg></audio><button class=Soundplay></button><button class=Soundpause></button></div></li>");
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
    
    $(document).ready(function(){
        <?php if(set_value('media_id') != '') { ?>
            $("#demia_data_"+<?=set_value('media_id')?>).prop("checked", true);
        <?php } ?>
    });
    
    
</script>