<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--<div class="col-lg-12">-->
<?php
//echo $friend_id  = 7 ;

$songs = get_user_songs($friend_id);
$sessionData = get_session_data();
$user_id = $sessionData['id'];
if ($friend_id == $user_id)
    $addForm = true;
else
    $addForm = false;


if (isset($userdata)) {
    $user_coins = $userdata[0]->coins;
}


if ($addForm) {
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

    $form_attr = array('name' => 'add_song', 'id' => 'add_song', 'class' => '', 'data-validate' => 'parsley');
    echo form_open_multipart('', $form_attr);
    ?>
    <section class="panel-default panel"> 
        <header class="panel-heading"> 
            <span class="h4">Upload Song</span> 
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
        </div>

        <div class="text-right lter"> 
            <?php echo form_submit($data_submit) ?>
        </div>
    </section> 
    <?php echo form_close(); ?>

<?php }
?>

<h3 class="pro-tab-head">Songs library</h3>

<div  class="col-lg-12">
    <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs"> 

        <?php
        if (!empty($songs)) { 
            foreach ($songs as $key => $value) {
                
                $song_id = $value['sId'];
                $media = $this->config->item('library_media_path') . $value['media'];
                $artist = $value['user_id'];
                $title = $value['title'];
                $likeCount = $value['likeCount'];
                if(file_exists(getcwd() . '/uploads/library/' . $value['media']) && $value['media'] !='') {
                ?>
                <li class="list-group-item clearfix">
                    <span class="pull-right padder">
                        <a data-toggle="button" dataid="<?php echo $song_id ?>" alt='<?php echo $user_id ?>' class="btn btn-default songLike active"> 
                            <span class="text-active"> 
                                <i class="fa fa-thumbs-o-up text"></i> 
                                <span class="like_count_<?php echo $song_id; ?>"><?php echo $likeCount; ?></span>
                            </span> 

        <!--		 <span class="text-active"> 
                     <i class="fa fa-thumbs-o-up text"></i> 
                     <span class="like_count">0</span>
                 </span>     -->
                        </a> 
                    </span>

                    <?php $this->view('responsive_player', ['path' => base_url() . $media, 'id' => $key]); ?>

                    <a class="clear" href="#"> 
                        <span class="block text-ellipsis"><?php echo $title ?></span>  
                    </a>
                    
                    <?php  //if($value['battle_category'] == 1 || $value['battle_category'] == 2 || $value['battle_category'] == 9) { ?>
                    <!--<a class="btn-md btn-success buy-media buy-download-btn" href="<?//=  base_url('download/cover_song/'.base64_encode($this->encrypt->encode($song_id)))?>">Download</a>-->
                        <?php //} ?>
                    
                        <?php if(isset($user_profile[0]->memberships_id) && $user_profile[0]->memberships_id == 2) {
                            ?>
                            <a data-toggle="modal" media-id="<?= $song_id ?>" data-target="#buy_popup" class="btn-md btn-success buy-media buy-download-btn" href="javascript:void(0)">Buy</a>
                        <?php } ?>

                </li> 
                <?php
            } }
        } else {
            echo "<div class='alert alert-danger'>User has not uploaded any song</div>";
        }
        ?>
    </ul>
</div>


<!-- == Buy media pop-up == -->
<?php if (isset($user_id)) { ?>
    <div id="buy_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <h4 class="modal-title">Buys a song or video</h4>
                </div>
                <form action="<?= base_url() . 'profile/buy_media' ?>" method="post" id="support_your_artist" >
                    <div class="modal-body">
                        <div class="alert-info">Your Balance: <strong id="user_bb"><?= $user_coins ?></strong> Battle bucks</div>
                        <br>
                        <div>
                            <p>1 <strong>Battle buck</strong> is deducted from your wallet to download the media</p>

                            <?php if ($user_coins >= 1) { ?>
                                <br>
                                <input type="hidden" name="media_id">
                                <input type="hidden" name="profile_id" value="<?= $friend_id ?>">
                                <input type="submit" value="Buy" class="btn btn-sm btn-info">
                            <?php } else { ?>
                                <br>
                                <a href="<?= base_url() . 'wallet' ?>">Add Battle bucks to wallet</a>
                            <?php } ?>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.buy-media').on('click', function () {
            var media_id = $(this).attr("media-id");
            $("[name='media_id']").val(media_id);
        });
    });
</script>