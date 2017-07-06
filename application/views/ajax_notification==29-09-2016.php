<a href="#" class="dropdown-toggle lt" data-toggle="dropdown"> 
    <i class="icon-bell"></i>
    <?php if ($new_notifn_count[0]['new_notification'] != 0): ?>
        <span class="badge badge-sm up bg-danger " style="display: inline-block;">
            <?php echo $new_notifn_count[0]['new_notification']; ?>
        </span> 
    <?php endif; ?> 
</a> 

<section class="dropdown-menu aside-xl animated fadeInUp"> 
    <section class="panel bg-white"> 
        <div class="panel-heading b-light bg-light"> 
            <strong>You have <span class="" style="display: inline;"><?php
                    if (!empty($get_notification))
                        print count($get_notification);
                    else
                        echo "no";
                    ?></span> notifications</strong> 
        </div>

        <div class="list-group-alt" id="replace_on_ajax">
            <?php
            $currentime = date("Y-m-d H:i:s", time());
            //echo '<pre>';            print_r($get_notification); die;

            if (!empty($get_notification)):
                foreach ($get_notification as $data):
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
                    ?>   

                    <?php
                    if ($data['notification_type'] == 'battle_request' && $data['data_id'] > 0) {
                        ?>

                        <a href="<?php echo base_url('battle/request/' . $data['data_id']); ?>" class="media list-group-item notifications_list" style="display: block;">
                            <span class="pull-left thumb-sm text-center"><i></i></span>
                            <span class="media-body block m-b-none"><?php echo $data['firstname'] . " " . $data['lastname'] . " " . $data['message']; ?><br><small class="text-muted">
                                    <?php echo $time_difference; ?> 
                                </small>
                            </span>
                        </a>


                    <?php } else { ?>

                        <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>" class="media list-group-item notifications_list" userid="<?php echo $data['id']; ?>" style="display: block;">
                            <span class="pull-left thumb-sm text-center"><i></i></span>
                            <span class="media-body block m-b-none"><?php echo $data['firstname'] . " " . $data['lastname'] . " " . $data['message']; ?><br><small class="text-muted">
                                    <?php echo $time_difference; ?> 
                                </small>
                            </span>
                        </a>

                    <?php } ?>
                    <?php
                endforeach;
            endif;
            ?>   
        </div> 
        <div class="panel-footer text-sm"> 
            <a href="#" class="pull-right"></a> 
            <a href="<?php echo base_url('user/notifications') ?>" >See all the notifications</a> 
        </div> 
    </section> 
</section> 