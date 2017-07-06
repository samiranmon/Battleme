<?php
$user_session_data = $this->session->userdata('logged_in');
$user_id = $user_session_data['id'];
//print_r($user_session_data);
?>
<aside class="aside-lg bg-light lter b-r">
    <section class="vbox">
        <section class="scrollable">
            <div class="wrapper">
                <div class="text-center m-b m-t">
                    <a  class="thumb-lg">
                        <?php if (($user_profile[0]->profile_picture != '' || $user_profile[0]->profile_picture != NULL) && file_exists('uploads/profile_picture/' . $user_profile[0]->profile_picture)) { ?>
                            <img src="<?php echo base_url() . 'uploads/profile_picture/thumb_' . $user_profile[0]->profile_picture; ?>" class="img-circle">
                        <?php } else { ?>
                            <img src="<?php echo base_url() . 'uploads/profile_picture/default.png'; ?>" class="img-circle">
                        <?php } ?>
                    </a>
                    <div>
                        <div class="h3 m-t-xs m-b-xs"><?php echo $user_profile[0]->firstname . "  " . $user_profile[0]->lastname; ?></div> 
                        <small class="text-muted"><i class="fa fa-map-marker"></i><?php echo $user_profile[0]->city . "," . $user_profile[0]->country; ?>.</small> 
                    </div>
                </div>
                <div class="panel wrapper">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <a href="javascript:void(0);"> <span class="m-b-xs h4 block follow"><?php echo $user_profile[0]->follower; ?></span>  <small class="text-muted">Followers</small> 
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0);"> <span class="m-b-xs h4 block following"><?php echo $user_profile[0]->following; ?></span>  <small class="text-muted">Following</small> 
                            </a>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                <?php if ($user_id != $user_profile[0]->id): ?>
                <?php if(!empty($frnd_details)):?>
                <?php if ($frnd_details[0]->active != 1): ?>
                <?php if ($frnd_details[0]->resourse_approved == 0 && $frnd_details[0]->user_approved == 1  ): ?>
                <div class="btn-group btn-group-justified m-b">
                    <a  class="btn btn-s-md btn-default removefriend" frndid ="<?php echo $user_profile[0]->id; ?>">&nbsp;Cancel Request</a>
                </div>
                <?php elseif($frnd_details[0]->resourse_approved == 1 && $frnd_details[0]->user_approved == 0):?>
                <div class="btn-group btn-group-justified m-b">
                    <a  class="btn btn-s-md btn-default acceptfriend" frndid ="<?php echo $user_profile[0]->id; ?>">&nbsp;Accept Request</a>
                </div>
                <?php else: ?>
                <div class="btn-group btn-group-justified m-b">
                    <a  class="btn btn-s-md btn-default addasfriend" userid ="<?php echo $user_profile[0]->id; ?>">&nbsp;Add Friend</a>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="btn-group btn-group-justified m-b">
                    <a  class="btn btn-s-md btn-danger removefriend" frndid ="<?php echo $user_profile[0]->id; ?>">&nbsp;Remove Friend</a>
                </div>
                <?php endif; ?>
                <?php else: ?>
                
                
                
                
                <div class="btn-group btn-group-justified m-b">
                    <a  class="btn btn-s-md btn-default addasfriend" userid ="<?php echo $user_profile[0]->id; ?>">&nbsp;Add Friend</a>
                </div>
                <?php endif; ?>
                
                
                
		<?php if( $user_id !=  $user_profile[0]->id && $user_profile[0]->user_type == 'artist' && $user_session_data['user_type'] == 'artist')
		    {?>
		
		<div class="btn-group btn-group-justified m-b">
                    <a  class="btn btn-s-md btn-info challenge" href ="<?php echo base_url().'battle/create/'.$user_profile[0]->id; ?>">&nbsp;Challenge</a>
                </div>
		<?php }?>
		
                    <div class="btn-group btn-group-justified m-b">
                        <a href="<?php echo base_url('friends/follow_friend/'.$user_profile[0]->id); ?>" class="follow btn btn-success btn-rounded"> 
                            <span class="text"> <i class="fa fa-eye"></i> <?php
                                if (empty($user_follow_details[0])) {
                                    echo "Follow";
                                } else {
                                    echo "Following";
                                }
                                ?>
                        </a>
                        <a class="btn btn-dark btn-rounded"> <i class="fa fa-comment-o"></i> Chat</a>
                    </div>
                <?php endif; ?>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <div> 
                    <small class="text-uc text-xs text-muted">about me</small> 
                    <p><?php echo $user_profile[0]->aboutme; ?></p> 
                    <small class="text-uc text-xs text-muted">info</small> 
                    <p><?php echo $user_profile[0]->info; ?></p>
                    
                    <small class="text-uc text-xs text-muted">Cups 
                    <p>
                        <?php if($user_profile[0]->cups == NULL){
                        $cups = ['gold'=>0, 'platinum'=>0, 'diamond'=>0];
                    }else{
                         $cups = unserialize(base64_decode($user_profile[0]->cups));
                    }
                    echo 'Gold: '. $cups['gold']; 
                    echo '<br>Platinum: '. $cups['platinum']; 
                    echo '<br>Diamond: '. $cups['diamond'];?>
                    
                    </p>
                    </small>
                    
                    <div class="line"></div> <small class="text-uc text-xs text-muted">connection</small> 
                    <p class="m-t-sm"> <a href="#" class="btn btn-rounded btn-twitter btn-icon"><i class="fa fa-twitter"></i></a> 
                        <a href="#" class="btn btn-rounded btn-facebook btn-icon"><i class="fa fa-facebook"></i></a> 
                        <a href="#" class="btn btn-rounded btn-gplus btn-icon"><i class="fa fa-google-plus"></i>
                        </a>
                    </p>
                </div>
            </div>
        </section>
    </section>
</aside>
<script src="<?php echo base_url('public/js/jquery.min.js'); ?>"></script>
<script>
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
        
        $('.follow').click(function(){
            $('#userfollower').trigger('click');
        });
        
        $('.following').click(function(){
            $('#userfollowing').trigger('click');
        });
        
    });
</script>
