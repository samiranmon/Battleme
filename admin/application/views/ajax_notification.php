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
                            <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
                        <?php } ?>        
                    </div>
                    <div class="noti_content">
                        <a href="<?php echo base_url('battle/request/' . $data['data_id']); ?>">
                            <?php echo $data['firstname'] . " " . $data['lastname'] . " " . $data['message']; ?>
                        </a>
                        <span><?=$created_post; ?></span>
                    </div>
                </li>
                
            <?php } else if ($data['notification_type'] == 'freestyle_request' && $data['data_id'] > 0) { ?>
                <li>
                    <div class="noti_pic">
                        <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                            <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                        <?php } else { ?> 
                            <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
                        <?php } ?>        
                    </div>
                    <div class="noti_content">
                        <a href="<?php echo base_url('battle/freestyle_library/'); ?>">
                            <?php echo $data['firstname'] . " " . $data['lastname'] . " " . $data['message']; ?>
                        </a>
                        <span><?=$created_post; ?></span>
                    </div>
                </li>
            <?php } else if($data['notification_type'] == 'someone_wrote') { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="<?php echo base_url('profile'); ?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname'] . " " . $data['message']; ?>
                                </a>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li>
            <?php } else if($data['notification_type'] == 'tournament_vote_request') { ?>
                        <li>
                            <div class="noti_pic">
                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                                <?php } else { ?> 
                                    <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
                                <?php } ?>
                            </div>
                            <div class="noti_content">
                                <a href="<?=$data['message']?>">
                                    <?php echo $data['firstname'] . " " . $data['lastname'] . "  Please vote again for the next round"; ?>
                                </a>
                                <span><?=$created_post; ?></span>
                            </div>
                        </li>                        
            <?php } else { ?>
                <li userid="<?php echo $data['id']; ?>">
                    <div class="noti_pic">
                        <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL) { ?>
                            <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?=$data['profile_picture']?>">
                        <?php } else { ?> 
                            <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
                        <?php } ?>        
                    </div>
                    <div class="noti_content">
                        <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                            <?php echo $data['firstname'] . " " . $data['lastname'] . " " . $data['message']; ?>
                        </a>
                        <span><?=$created_post; ?></span>
                    </div>
                </li>
            <?php } ?>
        <?php }
    }
    ?>   

    <li><a href="<?php echo base_url('user/notifications') ?>" >See all the notifications</a></li>

</ul>
