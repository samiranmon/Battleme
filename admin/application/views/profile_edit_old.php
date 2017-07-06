<?php
$this->load->view('templates/header');
$user_id = $this->session->userdata('logged_in')['id'];
$frndid = $user_profile[0]->id;
$currentime = date("Y-m-d H:i:s", time());
$user_session_data = get_session_data() ;
?>

<section id="content">
    <section class="vbox">
        <section class="scrollable">
            <section class="hbox stretch">
                <?php $this->load->view('aside', $user_profile); ?>
                <aside class="bg-white">
                    <section class="vbox">
                        <header class="header bg-light lt">
                            <ul class="nav nav-tabs nav-white">
                                <li class="active"><a href="#wall" data-toggle="tab">Wall</a>
                                </li>
                                <li class=""><a href="#editprofile" data-toggle="tab" id="editprofile_tab">Edit Profile</a>
                                </li>
                                <li class=""><a href="#friends" data-toggle="tab">Friends</a>
                                </li>
                                <li class=""><a href="#follower" data-toggle="tab" id="userfollower" >Follower</a>
                                </li>
                                <li class=""><a href="#following" data-toggle="tab" id="userfollowing" >Following</a>
                                </li>
                                <li class=""><a href="#memberships" data-toggle="tab"  >Memberships</a>
                                </li>
				<?php if($user_profile[0]->user_type == 'artist' && $user_session_data['membership_id'] < 3 )
				{ ?>
				    <li class=""><a href="#library" data-toggle="tab"  >Songs Library</a>
                                </li>
				<?php } ?>
                                
                                
                                </li>
                                <li style="float:right;">
				    <?php if (isset($navigationbar_home) || $navigationbar_home != '') print $navigationbar_home; ?>
                                    <?php //print $navigationbar_home; ?>
                                </li>
                                <li style="float:right;">

                                    <a href ="<?php echo base_url('home'); ?>">Home</a>

                                </li>
                            </ul>
                        </header>

                        <section class="scrollable">
                            <div class="tab-content">
                                <div class="tab-pane active" id="wall">
                                    <!--begin form for post -->
                                    <?php include('post.php'); ?>   
                                    <!-- end form for post -->
                                </div>
                                <div class="tab-pane" id="editprofile">
                                    <!-- <div class="text-center wrapper"> <i class="fa fa-spinner fa fa-spin fa fa-large"></i>  -->
                                    <br><br>
                                    <div class="col-sm-12"> 
                                        <section class="panel panel-default">
                                            <div class="panel-body col-sm-12">
                                                <?php if (($user_profile[0]->cover_picture != '' || $user_profile[0]->cover_picture != NULL) && file_exists('uploads/cover_picture/' . $user_profile[0]->cover_picture)) { ?>
                                                    <img src="<?php echo base_url() . 'uploads/cover_picture/' . $user_profile[0]->cover_picture; ?>" width = "800" height = "250">
                                                <?php } else { ?>
                                                    <img src="<?php echo base_url('uploads/cover_picture/defaultcover.jpg'); ?>" width = "800" height = "250">
                                                <?php } ?>
                                            </div>
                                            <header class="panel-heading font-bold">Edit Profile</header> 
                                            <div class="panel-body">
                                                <?php
                                                $attributes = array('id' => 'editprofile1');
                                                echo form_open_multipart('profile/edit_profile' . '/' . $user_id, $attributes);
                                                ?>
                                                <!-- fileupload -->
                                                <!-- <div class="form-group">  -->
                                                <div class="form-group"> 
                                                    <label>Current avtar</label>
                                                    <!-- <input type="file" class="filestyle" data-icon="false" data-classbutton="btn btn-default" data-classinput="form-control inline v-middle input-s" id="filestyle-0" style="position: fixed; left: -500px;"> -->
                                                    <?php if (($user_profile[0]->profile_picture != '' || $user_profile[0]->profile_picture != NULL) && file_exists('uploads/profile_picture/' . $user_profile[0]->profile_picture)) { ?>
                                                        <img src="<?php echo base_url() . 'uploads/profile_picture/' . $user_profile[0]->profile_picture; ?>" width = "128" height = "128">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" width = "128" height = "128">
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>Update Avtar</label>
                                                    <input type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" name="profilepicture" > 
                                                    <?php echo form_error('profilepicture'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>Update Cover</label>
                                                    <input type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" name="cover_picture" > 
                                                    <?php echo form_error('cover_picture'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>First Name</label> 
                                                    <input type="text" class="form-control" placeholder="Enter Firstname" name ="fname" value="<?php echo $user_profile[0]->firstname; ?>"> 
                                                    <?php echo form_error('fname'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>Last Name</label> 
                                                    <input type="text" class="form-control" placeholder="Enter Lastname" name ="lname" value = "<?php echo $user_profile[0]->lastname; ?>"> 
                                                    <?php echo form_error('lname'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>City</label> 
                                                    <input type="text" class="form-control" placeholder="Enter city" name ="city" value = "<?php echo $user_profile[0]->city; ?>"> 
                                                    <?php echo form_error('city'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>Country</label> 
                                                    <input type="text" class="form-control" placeholder="Enter country" name ="country" value = "<?php echo $user_profile[0]->country; ?>"> 
                                                    <?php echo form_error('country'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>About me</label> 
                                                    <input type="text" class="form-control" placeholder="About me" name ="aboutme" value = "<?php echo $user_profile[0]->aboutme; ?>"> 
                                                    <?php echo form_error('aboutme'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>Info</label> 
                                                    <textarea class="form-control parsley-validated" rows="6" data-minwords="6" data-required="true" placeholder="About Yourself" name="info"><?php echo $user_profile[0]->info; ?></textarea> 
                                                    <?php echo form_error('info'); ?>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-default">Save</button>
                                                <?php echo form_close(); ?>
                                            </div> 
                                        </section>
                                    </div>
                                </div>

                                <!-- events begins -->
                                <div class="tab-pane" id="friends">
                                    <div class="text-center wrapper"> 
                                        <!--<i class="fa fa-spinner fa fa-spin fa fa-large"></i>--> 
                                        <div class="row">
                                            <!-- friends tab -->
                                            <?php if (!empty($userfriend)): foreach ($userfriend as $data): ?>
                                                    <div class="col-lg-4"> 
                                                        <section class="panel panel-default"> 
                                                            <div class="panel-body"> 
                                                                <div class="clearfix text-center m-t"> 
                                                                    <div class="inline"> 
                                                                        <div class="easypiechart easyPieChart" data-percent="75" data-line-width="5" data-bar-color="#4cc0c1" data-track-color="#f5f5f5" data-scale-color="false" data-size="134" data-line-cap="butt" data-animate="1000" style="width: 134px; height: 134px; line-height: 134px;"> 
                                                                            <div class="thumb-lg"> 
                                                                                <a href="<?php echo base_url('profile/view/' . $data['id']); ?>"> 
                                                                                    <?php if ($data['profile_picture'] != ''): ?>
                                                                                        <img src="<?php echo base_url('uploads/profile_picture/' . $data['profile_picture']); ?>" class="img-circle" alt="..."> 
                                                                                    <?php else: ?>
                                                                                        <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" class="img-circle" alt="..."> 
                                                                                    <?php endif; ?>
                                                                                </a>
                                                                            </div> 
                                                                            <canvas width="120" height="120"></canvas>
                                                                        </div> 
                                                                        <div class="h4 m-t m-b-xs"><a href="<?php echo base_url('profile/view/' . $data['id']); ?>"> <?php echo $data['firstname'] . " " . $data['lastname']; ?></a></div> 
                                                                        <small class="text-muted m-b"><?php echo $data['info']; ?></small> 
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                        </section> <br>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <div class="text-center wrapper">
                                                    <ul class="alt col-lg-12">
                                                        <li class="list-group-item"> 
                                                            <p align="center">
                                                                <small class="text-muted">
                                                                    No friends found!!
                                                                </small>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                            <!-- friends tab -->
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="friend_request">
                                        <!-- friend request div -->
                                    </div>
                                </div>
                                <!-- events end -->

                                <div class="tab-pane" id="follower">
                                    <span style="float:left" class="alt col-lg-4">
                                        <h4 class="font-thin m-l-md m-t">Followers:</h4>
                                    </span>
                                    <div class="text-center wrapper">
                                        <ul class="alt col-lg-12"> 
                                            <?php
                                            if (!empty($getfollowers)):
                                                foreach ($getfollowers as $data):
                                                    ?>
                                                    <li class="list-group-item col-lg-4"> 
                                                        <div class="media">
                                                            <div class="media-body"> 
                                                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL): ?>
                                                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>". alt="<?php echo $data['profile_picture']; ?>" class="img-circle"></span> 
                                                                <?php else: ?>
                                                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>". alt="default" class="img-circle"></span> 
                                                                <?php endif; ?>
                                                                <div>
                                                                    <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>"><?php
                                                                        echo $data['firstname'] . " " . $data['lastname'];
                                                                        if (!empty($data['message'])) {
                                                                            echo " " . $data['message'];
                                                                        }
                                                                        ?></a>
                                                                </div> 
                                                                <small class="text-muted"><?php echo $data['city'] . "," . $data['country']; ?></small> 
                                                            </div> 
                                                        </div>
                                                    </li> 
                                                    <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <li class="list-group-item"> 
                                                    <p align="center">
                                                        <small class="text-muted">
                                                            You are not following anyone
                                                        </small>
                                                    </p>
                                                </li>
                                            <?php endif; ?>
                                        </ul> 

                                    </div>
                                </div>

                                <div class="tab-pane" id="following">
                                    <span style="float:left" class="alt col-lg-4">
                                        <h4 class="font-thin m-l-md m-t">Following:</h4>
                                    </span>
                                    <div class="text-center wrapper ">
                                        <ul class="alt col-lg-12"> 
                                            <?php
                                            if (!empty($getfollowing)):
                                                foreach ($getfollowing as $data):
                                                    ?>
                                                    <li class="list-group-item col-lg-4"> 
                                                        <div class="media">
                                                            <div class="media-body"> 
                                                                <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL): ?>
                                                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>". alt="<?php echo $data['profile_picture']; ?>" class="img-circle"></span> 
                                                                <?php else: ?>
                                                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>". alt="default" class="img-circle"></span> 
                                                                <?php endif; ?>
                                                                <div>
                                                                    <a href="<?php echo base_url('profile/view/' . $data['userid']); ?>"><?php
                                                                        echo $data['firstname'] . " " . $data['lastname'];
                                                                        if (!empty($data['message'])) {
                                                                            echo " " . $data['message'];
                                                                        }
                                                                        ?></a>
                                                                </div> 
                                                                <small class="text-muted"><?php echo $data['city'] . "," . $data['country']; ?></small> 
                                                            </div> 
                                                        </div>
                                                    </li> 
                                                    <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <li class="list-group-item"> 
                                                    <p align="center">
                                                        <small class="text-muted">
                                                            You are not following anyone
                                                        </small>
                                                    </p>
                                                </li>
                                            <?php endif; ?>
                                        </ul> 

                                    </div>
                                </div>
                                <div class="tab-pane" id="memberships">
                                    <br><br>
                                    <div class="col-sm-12"> 

                                        <?php foreach ($memberships as $membership) { ?>
                                            <section class="panel panel-default">
                                                <header class="panel-heading font-bold">
                                                    <?php
                                                    if (!empty($user_membership)) {
                                                        if ($user_membership['memberships_id'] == $membership['id']) {
                                                            echo "You have ";
                                                        }
                                                    }
                                                    echo $membership['membership'];
                                                    ?>
                                                </header>
                                                <div class="panel-body wrapper-lg">
                                                    <p>
                                                        <?php echo $membership['description'];
                                                        ?>
                                                    </p>
                                                    <p>
                                                        <?php
                                                        echo "Membership Amount : " . $membership['membership_amount']." $";
                                                        ?>
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <?php
                                                    if (!empty($user_membership)) {
                                                        if ($user_membership['memberships_id'] != $membership['id']) {
                                                            ?>
                                                            <a href="<?php echo base_url() . "profile/upgrade_membership/" . $membership['id']; ?>"  onclick="return confirm('Are you sure you want to upgrade the membership? ')" class="btn btn-sm btn-success" title="Upgrate">Upgrade <?php echo $membership['membership']; ?></a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>  
                                                        <a href="<?php echo base_url() . "profile/upgrade_membership/" . $membership['id']; ?>"  onclick="return confirm('Are you sure you want to upgrade the membership? ')" class="btn btn-sm btn-success" title="Upgrate">Upgrade <?php echo $membership['membership']; ?></a>
                                                    <?php }
                                                    ?>
                                                </div>
                                            </section>
                                        <?php }
                                        ?>

                                    </div>
                                </div>
				<div class="tab-pane" id="library">
				    <?php
				     //set logged in user id as friend user id as this is used in below view
				     $data['friend_id'] = $user_id ;
				     //$this->load->view('song_library' ,$data ); ?>
				</div>
                            </div>
                        </section>
                    </section>
                </aside>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
</section>
<script>
    $(document).ready(function () {
	
	var url = "<?php echo base_url(); ?>";
	
	var user_id = "<?php echo $this->session->userdata('logged_in')['id']; ?>";
	console.log(url + "\n" + user_id);
	$.ajax({
	    url: url + "friends/getall_frnd_req/" + user_id,
	    success: function (result) {
		$("#friend_request").append(result);
	    }
	});



    });
    
</script>
<?php // $this->load->view('templates/footer'); ?>
<!--<script src="<?php //echo base_url('public/js/jquery.min.js'); ?>"></script>-->


<?php
//print_r($validation_error_set);
if (!empty($validation_error_set)) {
    ?>
    <script>
        // alert("ok");
        $(document).ready(function () {
             $('.nav-tabs a[href="#editprofile"]').tab('show');
              $('#editprofile_tab a[href="#editprofile"]').tab('show');
            /* $(document).ready(function () {*/

            //   window.location.replace('<?php echo base_url() . "profile#editprofile"; ?>');
        });
    </script>
<?php }
?>

<!--<script src="<?php ///echo base_url('public/js/jquery.min.js'); ?>"></script>-->

