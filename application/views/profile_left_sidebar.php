<?php
$user_session_data = $this->session->userdata('logged_in');
$user_id = $user_session_data['id'];
//print_r($user_session_data);
?>
<style type="text/css">
    .custom_loader{
        position: absolute; top: 40%; display: none;
    }
</style>
<div class="clickleftMenu"></div>
<div class="left_side">
    <div class="logo">
        <a href="<?= base_url() ?>"><img src="<?php echo base_url(); ?>public/images/logo.png" alt=""> </a>
    </div>
    <div class="clickleftMenu1"></div>

    <div class="profile-lf-box plf-comn">
        
        <form id="profForm"  method="post">
            <div class="p-uploadimg-box">
                <div class="custom_loader"><img style="border-radius: 0% !important; width: 129px" src="<?=base_url('public/images/loader.gif')?>" /></div>
                    
                <?php if ($user_profile[0]->profile_picture != '' && file_exists(getcwd() . '/uploads/profile_picture/130x130/' . $user_profile[0]->profile_picture) ) { ?>
                <img id="profContainer" src="<?php echo base_url() . 'uploads/profile_picture/130x130/' . $user_profile[0]->profile_picture; ?>" >
                <?php } else { ?>
                <img id="profContainer" src="<?php echo base_url(); ?>uploads/profile_picture/130x130/blank-img.png" alt="img">
                <?php } ?>

                <?php if(isset($pic_update) && $pic_update == TRUE) { ?>
                <div class="fileUpload">
                    <div class="edit-p">Edit Photo</div>
                    <i class="cem-icon-s"></i>
                    <input type="file" name="profImage" class="upload" />
                </div>
                <?php } ?>
            </div>
        </form>
        
        
        <h4><?=substr($user_profile[0]->firstname . "  " . $user_profile[0]->lastname, 0,25); ?></h4> 
        <h5><span></span><?php echo $user_profile[0]->city . "," . $user_profile[0]->country; ?></h5>
        <div class="pro-ff-box">
            <span><a href="javascript:void(0)" class="follow">Followers (<?php echo $user_profile[0]->follower; ?>)</a></span>
            <span><a href="javascript:void(0)" class="following">Following (<?php echo $user_profile[0]->following; ?>)</a></span>
        </div>

        <?php if ($user_id != $user_profile[0]->id) { ?>
            <div class="pro-ff-link">

                <?php if (!empty($frnd_details)) { ?>
                    <?php if ($frnd_details[0]->active != 1) { ?>
                
                        <?php if ($frnd_details[0]->resourse_approved == 0 && $frnd_details[0]->user_approved == 1) { ?>
                                <a href="javascript:void(0)" class="removefriend" frndid="<?=$user_profile[0]->id?>">Cancel Request</a>
                        <?php } elseif ($frnd_details[0]->resourse_approved == 1 && $frnd_details[0]->user_approved == 0) { ?>
                                <a href="javascript:void(0)" class="acceptfriend" frndid="<?=$user_profile[0]->id?>">Accept Request</a>
                        <?php } else { ?>
                                <a href="javascript:void(0)" class="addasfriend" userid="<?=$user_profile[0]->id?>">Add Friend</a>
                        <?php } ?>
                    <?php } else { ?>
                            <a href="javascript:void(0)" class="removefriend" frndid="<?=$user_profile[0]->id?>">Remove Friend</a>
                    <?php } ?>

                <?php } else { ?>
                    <a href="javascript:void(0)" class="addasfriend" userid="<?= $user_profile[0]->id ?>">Add Friend</a>
                <?php } ?>

            <?php 
            
            //if( $user_id !=  $user_profile[0]->id && $user_profile[0]->user_type == 'artist' && $user_session_data['user_type'] == 'artist' && isset($frnd_details[0]->active) && $frnd_details[0]->active == 1) { 
            if($user_id !=  $user_profile[0]->id && $user_profile[0]->user_type == 'artist' && $user_session_data['user_type'] == 'artist') { 
                
                ?>
                <a href="<?=base_url().'battle/create/'.$user_profile[0]->id?>">Challenge</a>
            <?php } ?>

                <a href="<?=base_url('friends/follow_friend/'.$user_profile[0]->id)?>"> 
                    <?php if (empty($user_follow_details[0])) {
                                echo "Follow";
                            } else {
                                echo "Following";
                            }
                    ?>
                </a>
                
            </div>
        <?php } ?>

    </div>
    <div class="profile-lf-box2 plf-comn">
        <ul class="pro-lf-info">
            <li>About Me : <span><?php echo $user_profile[0]->aboutme; ?></span></li>
            <li>Info : <span><?php echo $user_profile[0]->info; ?></span></li>

            <?php
            if($user_profile[0]->user_type == 'artist') {
                if ($user_profile[0]->cups == NULL) {
                    $cups = ['gold' => 0, 'platinum' => 0, 'diamond' => 0];
                } else {
                    $cups = unserialize(base64_decode($user_profile[0]->cups));
                }
            ?>
            <li>Gold Mics : <span><?= $user_profile[0]->win_cnt ?></span></li>
            <li>Platinum Mics : <span>0</span></li>
            <li>Diamond Mics : <span>0</span></li>
            <li>Blood Mics : <span><?= $user_profile[0]->lose_cnt?></span></li>
            <?php } ?>
        </ul>
    </div>

</div>

<script type="text/javascript">
     $(document).ready(function (e) {
        $("#profForm").on('change', (function (e) {
            $('.custom_loader').css("display","block");
             var url = "<?php echo base_url(); ?>";
            e.preventDefault();
            $.ajax({
                url: url + 'profile/picture_upload/',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    $('#profContainer').attr('src',data);
                    $('.custom_loader').css("display","none");
                },
                error: function ()
                {
                }
            });
        }));
    });
            
    $(document).ready(function () {
        var url = "<?php echo base_url(); ?>";
        $(".addasfriend").click(function () {
            var userid = $(this).attr('userid');
            console.log(url + 'friends/send_frnd_req/' + userid);
            $.ajax({
                url: url + 'friends/send_frnd_req/' + userid,
                type: 'POST',
                success: function (result) {
                    window.location.reload(true);
                }
            });
        });

        $(".removefriend").click(function () {
            var frndid = $(this).attr('frndid');
            console.log(url + 'friends/remove_friend/' + frndid);
            $.ajax({
                url: url + 'friends/remove_friend/' + frndid,
                type: 'POST',
                success: function (result) {
                    window.location.reload(true);
                }
            });
        });
        $(".acceptfriend").click(function () {
            var frndid = $(this).attr('frndid');
            console.log(url + 'friends/accept_frnd_req/' + frndid);
            $.ajax({
                url: url + 'friends/accept_frnd_req/' + frndid,
                type: 'POST',
                success: function (result) {
                    window.location.reload(true);
                }
            });
        });

        $('.follow').click(function () {
            $('#userfollower').trigger('click');
        });

        $('.following').click(function () {
            $('#userfollowing').trigger('click');
        });

    });
</script>