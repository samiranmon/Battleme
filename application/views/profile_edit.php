<?php
$this->load->view('templates/header');
$user_id = $this->session->userdata('logged_in')['id'];
$friend_id = $frndid = $user_profile[0]->id;
$currentime = date("Y-m-d H:i:s", time());
$user_session_data = get_session_data();
$activeTab = '';
if ($this->session->flashdata('activetab') || $activeTab != '')
    $activeTab = $this->session->flashdata('activetab');
else
    $activeTab = 'wall';

/* $activeTab = 'wall';
$activeTab = 'editprofile';
$activeTab == 'friends';
$activeTab == 'following';
$activeTab == 'memberships';
$activeTab == 'library'; */

?>
<style>
    .cover_loader{
        position: absolute;  display: none; margin: 16% 5% 0 44%;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="mainbdy">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-3">
                        <?php $this->load->view('profile_left_sidebar'); ?>
                    </div>
                    
                    
                    <div class="col-md-9">
                        <div class="row">
                            <div class="top_head">
                                
                                <?php
                                    $attributes = array('id' => 'searchbar','class' => '','role' => 'search');
                                    echo form_open('home/search', $attributes); ?>
                                    <div class="tophead_left">
                                        <input type="text" placeholder="Search users" name = "home_search">
                                        <button></button>
                                    </div>
                                <?php echo form_close(); ?>
                                
                                <div class="tophead_right">
                                    <div class="charact">
                                        
                                        <div class="charpic">
                                            <?php if ($userdata[0]->profile_picture != '' || $userdata[0]->profile_picture != NULL) { ?>
                                                <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $userdata[0]->profile_picture); ?>" alt="<?php echo $userdata[0]->profile_picture; ?>">
                                            <?php } else { ?> 
                                                <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
                                            <?php } ?>
                                        </div>
                                        <div class="chartxt"><?php echo $userdata[0]->firstname . " " . $userdata[0]->lastname; ?></div>

                                        <div class="chardownmain">
                                            <div id="btn1" class="char_btn"></div>
                                            <div id="bdyopen" class="char_bdytx"> 
                                                <ul>
                                                    <li> <a href="<?php echo base_url('profile'); ?>">Profile</a> </li> 
                                                    <?php if (isset($userdata[0]->memberships_id) && !empty($userdata[0]) && ($userdata[0]->memberships_id == 2)) { ?>
                                                    <li> <a href="<?php echo base_url('user/recurring_profile_details'); ?>">Premium Membership</a> </li> 
                                                    <?php } ?>
                                                    <li> <a href="<?php echo base_url('profile/update'); ?>">Update Profile</a> </li> 
                                                    <li> <a href="<?php echo base_url('user/notifications'); ?>"> Notifications </a> </li> 
                                                    <li> <a href="<?php echo base_url('wallet'); ?>"> Wallet </a> </li> 
                                                    <li> <a href="<?php echo base_url('aboutus'); ?>">About us</a> </li>  
                                                    <li> <a href="<?php echo base_url('user/logout'); ?>">Logout</a> </li>
                                                </ul>
                                            </div> 

                                        </div>
                                    </div>
                                    
                                    <?php $this->load->view('navigationbar_home'); ?>
                                    <?php $this->load->view('right_sidebar'); ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-9 right_content">
                        
                        <form id="coverForm"  method="post">
                            <div class="pro-rh-upimg-box">
                                <div class="cover_loader">
                                    <img style="border-radius: 0% !important; width: 129px" src="<?=base_url('public/images/loader.gif')?>" />
                                </div>
                                <?php if (($user_profile[0]->cover_picture != '' || $user_profile[0]->cover_picture != NULL) && file_exists('uploads/cover_picture/' . $user_profile[0]->cover_picture)) { ?>
                                    <img id="coverContainer" src="<?php echo base_url() . 'uploads/cover_picture/' . $user_profile[0]->cover_picture; ?>" width="846px" height="287px">
                                 <?php } else { ?>
                                    <img id="coverContainer" src="<?php echo base_url('uploads/cover_picture/defaultcover.jpg'); ?>" width = "800" height = "250">
                                 <?php } ?>
                                <!--<img src="<?//php echo base_url(); ?>public/images/upload-img-big.png">-->
                                <div class="fileUpload2">
                                    <div class="edit-ewp">Edit Wall Photo</div>
                                    <i class="cem-icon-bi"></i>
                                    <input type="file" name="coverImage" class="upload" />
                                </div>
                            </div>
                        </form>
                        

                        <div class="pro-tab-wrapper">
                            <ul class="nav-tab-pro clearfix">
                                <li <?=$activeTab=='wall'? 'class="active"':''?>><a data-toggle="tab" href="#timeline">Timeline</a></li>
                                <li <?=$activeTab=='friends'? 'class="active"':''?>><a data-toggle="tab" href="#friends">Friends <span>(<?=count($userfriend)?>)</span></a></li>
                                <li <?=$activeTab=='followers'? 'class="active"':''?>><a data-toggle="tab" href="#followers">Followers</a></li>
                                <li <?=$activeTab=='following'? 'class="active"':''?>><a data-toggle="tab" href="#following">Following</a></li>
                                <li <?=$activeTab=='memberships'? 'class="active"':''?>><a data-toggle="tab" href="#memberships">Memberships</a></li>
                                <?php if(isset($user_membership) && $user_membership['memberships_id'] != 3) { ?>
                                    <li <?=$activeTab=='library'? 'class="active"':''?>><a data-toggle="tab" href="#library">Library</a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                
                                <div id="timeline" class="tab-pane fade <?=$activeTab=='wall'? 'in active':''?>">
                                    <!--<h3 class="pro-tab-head">Timeline</h3>-->
                                    <div class="row">
                                        
                                        <div class="col-md-8">
                                            <?php $this->load->view('personal_wall'); ?>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <!-- top right artist  -->
                                             <?php $this->load->view('top_artist'); ?>
                                             <!-- top right artist end  -->  

                                            <!-- top song right artist red  -->  
                                            <?php $this->load->view('top_songs'); ?>
                                            <!-- top song right artist red end  -->   

                                            <!-- top song right artist blue  --> 
                                            <?php $this->load->view('top_videos'); ?>
                                            <!-- top song right artist blue end  -->     
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div id="friends" class="tab-pane fade <?=$activeTab=='friends'? 'in active':''?>">
                                    <h3 class="pro-tab-head">Friends</h3>
                                    <ul class="clearfix friends-box">
                                        
                                        <?php if (!empty($userfriend)) {
                                            foreach ($userfriend as $data) { ?>
                                        
                                                    <li>
                                                        <div class="clearfix friend-item">
                                                            <a href="<?php echo base_url('profile/view/' . $data['id']); ?>">
                                                                <?php if ($data['profile_picture'] != ''): ?>
                                                                <img class="frind-img" src="<?php echo base_url('uploads/profile_picture/' . $data['profile_picture']); ?>" style="height: 130px; width: 130px;" alt="..."> 
                                                                     <?php else: ?>
                                                                    <img class="frind-img" src="<?php echo base_url(); ?>public/images/blank-img.png" alt="img">
                                                                <?php endif; ?>
                                                            </a>


                                                            <h5><a href="<?php echo base_url('profile/view/' . $data['id']); ?>">
                                                                <?php echo $data['firstname'] . " " . $data['lastname']; ?></a></h5>
                                                            <h6><?php echo $data['info']; ?></h6>
                                                        </div>
                                                    </li> 
	 					    
					<?php } }?>
                                         
                                    </ul>
                                </div>
                                
                                <div id="followers" class="tab-pane fade <?=$activeTab=='followers'? 'in active':''?>">
                                    <h3 class="pro-tab-head">Followers</h3>
                                    <ul class="clearfix foll-box">
                                        <?php
					     if (!empty($getfollowers)) {
						 foreach ($getfollowers as $data) {
						     ?>
	 					    <li>
                                                        <div class="clearfix followers-item">
                                                            <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL): ?>
                                                            <img class="foll-img" src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?php echo $data['profile_picture']; ?>" style="height: 80px; width: 80px;" >
                                                             <?php else: ?>
                                                                <img class="foll-img" src="<?php echo base_url(); ?>public/images/follow-blank-img.png" alt="img">
                                                             <?php endif; ?>
                                                            <h5>
                                                                <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>">
                                                                <?php echo $data['firstname'] . " " . $data['lastname'];
                                                                         if (!empty($data['message'])) {
                                                                             echo " " . $data['message'];
                                                                         }
                                                                         ?>
                                                                </a>
                                                            </h5>
                                                            <h6><?php echo $data['city'] . "," . $data['country']; ?></h6>
                                                        </div>
                                                    </li> 
                                             <?php } } ?>
                                    </ul>
                                </div>
                                
                                <div id="following" class="tab-pane fade <?=$activeTab=='following'? 'in active':''?>">
                                    <h3 class="pro-tab-head">Following</h3>
                                    <ul class="clearfix foll-box">
                                        <?php
					     if (!empty($getfollowing)) {
						 foreach ($getfollowing as $data) {
						     ?>
	 					    <li>
                                                        <div class="clearfix followers-item">
                                                            <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL): ?>
                                                                    <img class="foll-img" src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?php echo $data['profile_picture']; ?>" style="height: 80px; width: 80px;" >
                                                                <?php else: ?>
                                                                    <img class="foll-img" src="<?php echo base_url(); ?>public/images/follow-blank-img.png" alt="img">
                                                             <?php endif; ?>
                                                            <h5><a href="<?php echo base_url('profile/view/' . $data['userid']); ?>"><?php
                                                                                     echo $data['firstname'] . " " . $data['lastname'];
                                                                                     if (!empty($data['message'])) {
                                                                                         echo " " . $data['message'];
                                                                                     }
                                                                                     ?></a></h5>
                                                            <h6><?php echo $data['city'] . "," . $data['country']; ?></h6>
                                                        </div>
                                                    </li>
					<?php }} ?>
                                    </ul>
                                </div>
                                
                                <div id="memberships" class="tab-pane fade <?=$activeTab=='memberships'? 'in active':''?>">
                                    <h3 class="pro-tab-head">Memberships</h3>
                                    
                                    <?php if ($this->session->flashdata('membership_message')) { ?>
                                        <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
                                            <button class="close" data-dismiss="alert">x</button>                
                                             <?php echo $this->session->flashdata('membership_message'); ?>
                                        </div>
                                    <?php } ?>  
                                    
                                    <?php foreach ($memberships as $membership) { ?>
                                    <div class="panel-members">
                                        
                                        <div class="panel-m-heading">
                                            <?php
                                                 if (!empty($user_membership)) {
                                                     if ($user_membership['memberships_id'] == $membership['id']) {
                                                         echo "You have ";
                                                     }
                                                 }
                                                 echo $membership['membership'];
					    ?>
                                        </div>
                                        
                                        <div class="panel-members-body">
                                            <p><?=$membership['description']?></p>
                                            <p><?="Membership Amount : " . $membership['membership_amount'] . " Battle Bucks";?></p>
                                        </div>
                                        
                                        <div class="text-right">
                                             <?php
						     if (!empty($user_membership)) {
							 if ($user_membership['memberships_id'] != $membership['id']) {
                                                             if($membership['membership_amount']>0){
                                                                 $message = 'Are you sure you want to upgrade the membership and pay '.($membership['membership_amount']).' Battle Bucks from your wallet? ';
                                                             
                                                           }else{
                                                               $message = 'Are you sure you want to upgrade the membership ? ';
                                                           }
                                                           ?>
	     						<a href="<?php echo base_url() . "profile/upgrade_membership/" . $membership['id']; ?>"  onclick="return confirm(<?php echo "'".$message."'"; ?>)" class="btn-ms" title="Upgrade">Upgrade <?php echo $membership['membership']; ?></a>
							     <?php
							 }
						     } else {
							 ?>  
	 						<a href="<?php echo base_url() . "profile/upgrade_membership/" . $membership['id']; ?>"  onclick="return confirm('Are you sure you want to upgrade the membership? ')" class="btn-ms" title="Upgrade">Upgrade <?php echo $membership['membership']; ?></a>
					     <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                </div>
                                
                                <?php if(isset($user_membership) && $user_membership['memberships_id'] != 3) { ?>
                                    <div id="library" class="tab-pane fade <?=$activeTab=='library'? 'in active':''?>">
                                        <?php $this->load->view('profile_library'); ?>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        </div>

                        <div class="footer">
                            <p>
                                <?php $site_setting = getSiteSettingById(1);
                                    echo $site_setting['value'];
                                ?> 
                            </p>
                        </div>

                    </div>


                </div>



            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { 
        var topHead = $(".top_head").outerHeight();
        var bodyHeight = $(".right_content").outerHeight();
        var tHeight = topHead + bodyHeight + 28;
        $(".left_side").height(tHeight);
    });
    
    function fileUpload() {
        $("#myFile").click();
    }
    
    
    $(document).ready(function () {
        
    $(".likebutton").click(function () {
            var self = $(this);
            var frndid = self.attr('data-subject-id'); 
            var url = "<?php echo base_url(); ?>";
            var userid = "<?php echo $userdata[0]->id; ?>";
            var postid = $(this).attr('postid');
            //console.log(url + 'post/addlike/' + postid + '/' + userid);
            $.ajax({
                url: url +'post/addlike/'+ postid +'/'+ userid+'/'+frndid,
                type: 'POST',
                success: function (result) {
                        console.log(result);
                        var like_count = parseInt(self.find('.like_count').html());
                        if(result != 'dont_send_notification'){
                            like_count++;
                            self.find('.like_count').html(like_count);
                            
                            
                        }else{
                            like_count--;
                            self.find('.like_count').html(like_count);
                        }
                }
            });
        });
        
        // For image light box
        $('.media_light').lightBox();
        
        // For delete comment section
        $('.delete_comment').on('click', function(){
            var comment_id = $(this).attr('data-comment-id');
            var url = "<?php echo base_url(); ?>";
             $.ajax({
                url: url +'home/delete_comment/',
                data: {'comment_id': comment_id},
                type: 'POST',
                success: function (result) {
                        if(parseInt(result)>0) {
                             $('.comment-class-'+comment_id).slideUp(1000);
                        }
                }
            });
        });
        
        // Send mouse pointer to Comment text box
        $('.comment_btn').on('click', function(){
            var post_id = $(this).attr('data-comment-btn');
            $(".comment_text_"+post_id).focus();
        });
        
    });
    
    // for delete a post
    function deletePost(postId) { 
        var url = "<?php echo base_url(); ?>";
        if (confirm("Are you sure you want to delete this post!") == true) {
           window.location = url+"post/delete_post/"+postId;
        }  
    }
    
    function fileUpload() {
        $("#myPost").click();
    }
    
    // FOR Cover image upload
     $(document).ready(function (e) {
        $("#coverForm").on('change', (function (e) {
            $('.cover_loader').css("display","block");
             var url = "<?php echo base_url(); ?>";
            e.preventDefault();
            $.ajax({
                url: url + 'profile/cover_upload/',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    $('#coverContainer').attr('src',data);
                    $('.cover_loader').css("display","none");
                },
                error: function ()
                {
                }
            });
        }));
    });
    
</script>
<?php $this->load->view('templates/footer'); ?>