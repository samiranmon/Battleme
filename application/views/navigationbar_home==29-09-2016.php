<div class="navbar-right " >  
    <ul class="nav navbar-nav m-n hidden-xs nav-user user"> 
        <li class="hidden-xs" id="notification"> 
            
            <a href="#" class="dropdown-toggle lt" data-toggle="dropdown" > 
                <i class="icon-bell"></i>
                <?php if (isset($new_notifn_count[0]['new_notification']) && $new_notifn_count[0]['new_notification'] != 0): ?>
                    <span class="badge badge-sm up bg-danger " style="display: inline-block;">
                        <?php echo $new_notifn_count[0]['new_notification']; ?></span> 
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
                        <a href="#" class="pull-right">
                        </a> 
                        <a href="<?php echo base_url('user/notifications') ?>" >See all the notifications</a> 
                    </div> 
                </section> 
            </section> 
        </li> 


        <li class="dropdown"> 
            <a href="#" class="dropdown-toggle bg clear" data-toggle="dropdown"> 
                <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm"> 
                    <?php if ($userdata[0]->profile_picture != '' || $userdata[0]->profile_picture != NULL) { ?>
                        <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $userdata[0]->profile_picture); ?>" alt="<?php echo $userdata[0]->profile_picture; ?>"> </span><?php echo $userdata[0]->firstname . "." . $userdata[0]->lastname; ?><b class="caret">
                    <?php } else { ?>
                        <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" alt=""> </span><?php echo $userdata[0]->firstname . "." . $userdata[0]->lastname; ?><b class="caret">
                        <?php } ?>
                    </b> </a> <ul class="dropdown-menu animated fadeInRight"> 
                <li> 
                    <span class="arrow top"></span> 
                    <!--<a href="#">Settings</a>--> 
                </li> 
                <li> <a href="<?php echo base_url('profile'); ?>">Profile</a> </li> 
                <li> <a href="<?php echo base_url('user/notifications'); ?>"> Notifications </a> </li> 
                <li> <a href="<?php echo base_url('wallet'); ?>"> Wallet </a> </li> 
                <li> <a href="<?php echo base_url('aboutus'); ?>">About us</a> </li>  
                <li class="divider"></li> 
                <li> <a href="<?php echo base_url('user/logout'); ?>">Logout</a> </li> 
            </ul>
        </li> 
    </ul> 
</div>

<script type="text/javascript">

    $(document).ready(function () {
        var url = "<?php echo base_url(); ?>";
        $('#notification').click(function () {
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
                success: function (data) {
                    $('#notification').html(data);
                }
            });
        };
        setInterval(ajax_call, 5000);

    });
</script>