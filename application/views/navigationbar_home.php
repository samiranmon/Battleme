<div class="info ">
<div class="infopic count_notification">
    <?php if (isset($new_notifn_count[0]['new_notification']) && $new_notifn_count[0]['new_notification'] != 0) { ?>
    <div class="infotxt badge"><?php echo $new_notifn_count[0]['new_notification']; ?></div>
    <?php } ?> 
</div>

<div class="info_downmain">
    <div id="inf_btn3" class="infob_btn notification" ></div>
    <div id="bdyopen3" class="infob_bdytx update_notification">
        <strong>You have <span class="" style="display: inline;"><?php
        if (!empty($get_notification))
            print count($get_notification);
        else
            echo "no";
        ?></span> notifications</strong> 
         <ul>
           <?php
            $currentime = date("Y-m-d H:i:s", time());
            if (!empty($get_notification)) {
                foreach ($get_notification as $data) {
                    $time_difference = '';
                    $ts1 = strtotime($data['created_on']);
                    $ts2 = strtotime($currentime);
                    $posttime = round(abs($ts1 - $ts2) / 60, 2);
                    if ($posttime < 60) {
                        $time_difference = round($posttime) . " minutes ago";
                    }
                    if ($posttime >= 60 && $posttime < 1440) {
                        $time_difference = round($posttime / 60) . " hours ago";
                    }
                    if ($posttime >= 1440) {
                        $time_difference = round($posttime / 1440) . " days ago";
                    }
                    
                    $created_post = date('F d g:i a T',strtotime($data['created_on']));
                    ?>    
                    <?php
                    if ($data['notification_type'] == 'battle_request' && $data['data_id'] > 0) {
                        ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="<?php echo base_url('battle/request/' . $data['data_id']); ?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo $data['message']; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li>
                        
                    <?php } else if ($data['notification_type'] == 'freestyle_request' && $data['data_id'] > 0) { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                <?php } ?>        
                            </div>
                            <div class="noti_content">
                                <a href="<?php echo base_url('battle/freestyle_library/'); ?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo $data['message']; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li>

                    <?php } else if($data['notification_type'] == 'someone_wrote') { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="<?php echo base_url('profile'); ?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo $data['message']; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li>
                    <?php } else if($data['notification_type'] == 'tournament_vote_request') { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="<?=$data['message']?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo "Please vote again for the next round"; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li> 
                    <?php } else if($data['notification_type'] == 'post_like') { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                                        <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                    </a>
                                <?php } else { ?> 
                                    <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                                        <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="javascript:void(0)" class="scroll_post_like" data-post-id="<?=$data['data_id']?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo $data['message']; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li> 
                    <?php } else if($data['notification_type'] == 'post_comment') { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                                        <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                    </a>
                                <?php } else { ?> 
                                    <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                                        <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="javascript:void(0)" class="scroll_post_comment" data-post-id="<?=$data['data_id']?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo $data['message']; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li> 
                    <?php } else { ?>
                        <li userid="<?php echo $data['id']; ?>">
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>uploads/profile_picture/no-image(80x80).png" alt="">
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname']; ?>
                                </a>
                                <p><?php echo $data['message']; ?></p>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li>
                    <?php } ?>
            <?php }} ?>   
             
           <li><a href="<?php echo base_url('user/notifications') ?>" >See all the notifications</a></li>

        </ul>
    </div>
    
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo base_url(); ?>";
        $('.notification').click(function () {
            $('.badge').remove();
            $.ajax({
                url: url + 'user/mark_as_read/',
                type: 'POST',
            });

        });
        var ajax_call = function () {
            var userid = $(this).attr('userid');
            $.ajax({
                url: url + 'home/notify/',
                type: 'POST',
                dataType: "json",
                success: function (data) {
                     var od = JSON.stringify(data);
                    var obj = JSON.parse(od);
                    $('.count_notification').html(obj[1]);
                    $('.update_notification').html(obj[0]);
                }
            });
        };
        setInterval(ajax_call, 5000);

    });
</script>