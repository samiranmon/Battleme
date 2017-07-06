<?php
 $this->load->view('templates/header');
 $user_id = $this->session->userdata('logged_in')['id'];
 $friend_id = $frndid = $user_profile[0]->id;
 $currentime = date("Y-m-d H:i:s", time());
 $user_session_data = get_session_data();
$activeTab = '' ;
if($this->session->flashdata('activetab') || $activeTab != '')
    $activeTab = $this->session->flashdata('activetab') ;
else
    $activeTab = 'wall';


?>
<section id="content">
    <section class="vbox">
        <section class="scrollable">
            <section class="hbox stretch">
		<?php $this->load->view('aside', $user_profile); ?>
		<?php
//                if (isset($aside)) {
//                    print $aside;
//                }
		?>
                <aside class="bg-white">
                    <section class="vbox">
                        <header class="header bg-light lt">
                            <ul class="nav nav-tabs nav-white">
                                <li class="<?php echo ($activeTab == 'wall' ? "active" : '' )?>"><a href="#wall" data-toggle="tab">Wall </a>
                                </li>
                                <li class="<?php echo ($activeTab == 'editprofile' ? "active" : '' )?>"><a href="#editprofile" data-toggle="tab" id="editprofile_tab">Profile</a>
                                </li>
                                <li class=""><a href="#friends" data-toggle="tab">Friends</a>
                                </li>
                                <li class=""><a href="#follower" data-toggle="tab" id="userfollower" >Follower</a>
                                </li>
                                <li class=""><a href="#following" data-toggle="tab" id="userfollowing" >Following</a>
                                </li>
				<li class="<?php echo ($activeTab == 'memberships' ? "active" : "" )?>"><a href="#memberships" data-toggle="tab">Memberships</a> </li>
				<?php if ($user_session_data['user_type'] == 'artist') { ?>
     				<li class="<?php echo ($activeTab == 'library' ? "active" : '' )?>"><a href="#library" data-toggle="tab">Library</a></li>
				 <?php } ?>
                                <!--                                <li class=""><a href="#interaction" data-toggle="tab">Activity</a>
                                                                </li>-->
                                <li style="float:right;">
				    <?php //if (isset($navigationbar_home) || $navigationbar_home != '') print $navigationbar_home; ?>
                                </li>
                                <li style="float:right;">

                                    <a href ="<?php echo base_url('home'); ?>">Home</a>

                                </li>
                            </ul>   
                        </header>
                        <section class="scrollable">
                            <div class="tab-content">

                                <div class="tab-pane <?php echo ($activeTab == 'wall' ? "active" : '' )?>" id="wall">
                                    <!--begin form for post -->
				    <?php include('post.php'); ?>   
                                    <!-- end form for post -->
                                </div>
                                
                                <div class="tab-pane <?php echo ($activeTab == 'editprofile' ? "active" : '' )?>" id="editprofile">
                                    <br><br>
				    <div class="col-sm-12"> 
					<?php if ($this->session->flashdata('profile_message')) {
						     ?>
	 					    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
	 						<button class="close" data-dismiss="alert">x</button>                
							 <?php echo $this->session->flashdata('profile_message'); ?>
	 					    </div>
						     <?php }
						 ?>  
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
						    <?php echo form_error('fname','<div class="error">','</dev>'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>Last Name</label> 
                                                    <input type="text" class="form-control" placeholder="Enter Lastname" name ="lname" value = "<?php echo $user_profile[0]->lastname; ?>"> 
						    <?php echo form_error('lname','<div class="error">','</dev>'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>City</label> 
                                                    <input type="text" class="form-control" placeholder="Enter city" name ="city" value = "<?php echo $user_profile[0]->city; ?>"> 
						    <?php echo form_error('city','<div class="error">','</dev>'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>Country</label> 
                                                    <input type="text" class="form-control" placeholder="Enter country" name ="country" value = "<?php echo $user_profile[0]->country; ?>"> 
						    <?php echo form_error('country','<div class="error">','</dev>'); ?>
                                                </div>
                                                <div class="form-group"> 
                                                    <label>About me</label> 
                                                    <input type="text" class="form-control" placeholder="About me" name ="aboutme" value = "<?php echo $user_profile[0]->aboutme; ?>"> 
						    <?php echo form_error('aboutme','<div class="error">','</dev>'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>Info</label> 
                                                    <textarea class="form-control parsley-validated" rows="6" data-minwords="6" data-required="true" placeholder="About Yourself" name="info"><?php echo $user_profile[0]->info; ?></textarea> 
						    <?php echo form_error('info','<div class="error">','</dev>'); ?>
                                                </div>
                                                
                                                <div class="form-group"> 
                                                    <label>Paypal Account Id</label> 
                                                    <input type="text" class="form-control" placeholder="Account Id" name ="paypal_account_id" value = "<?php echo $user_profile[0]->paypal_account_id; ?>"> 
						    <?php echo form_error('paypal_account_id','<div class="error">','</dev>'); ?>
                                                </div>
                                                
                                                
						<input type="submit" name="action" value="Update" >
<!--                                                <button type="submit" class="btn btn-sm btn-default">Save</button>-->
						<?php echo form_close(); ?>
                                            </div> 
                                        </section>
                                    </div>
                                </div>
                                
                                <div class="tab-pane <?php echo ($activeTab == 'friends' ? "active" : '' )?>" id="friends">
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
                                
                                <div class="tab-pane <?php echo ($activeTab == 'follower' ? "active" : '' )?>" id="follower">
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

                                <div class="tab-pane <?php echo ($activeTab == 'following' ? "active" : '' )?>" id="following">
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
     							User is not following anyone
     						    </small>
     						</p>
     					    </li>
					    <?php endif; ?>
                                        </ul> 

                                    </div>
                                </div>
                                
				<div class="tab-pane <?php echo ($activeTab == 'memberships' ? "active" : '' )?>" id="memberships">
                                    <br><br>
                                    <div class="col-sm-12"> 
					<?php if ($this->session->flashdata('membership_message')) {
						     ?>
	 					    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
	 						<button class="close" data-dismiss="alert">x</button>                
							 <?php echo $this->session->flashdata('membership_message'); ?>
	 					    </div>
						     <?php }
						 ?>  
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
							 echo "Membership Amount : " . $membership['membership_amount'] . " Battle Bucks";
							 ?>
     						</p>
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
	     						<a href="<?php echo base_url() . "profile/upgrade_membership/" . $membership['id']; ?>"  onclick="return confirm(<?php echo "'".$message."'"; ?>)" class="btn btn-sm btn-success" title="Upgrade">Upgrade <?php echo $membership['membership']; ?></a>
							     <?php
							 }
						     } else {
							 ?>  
	 						<a href="<?php echo base_url() . "profile/upgrade_membership/" . $membership['id']; ?>"  onclick="return confirm('Are you sure you want to upgrade the membership? ')" class="btn btn-sm btn-success" title="Upgrade">Upgrade <?php echo $membership['membership']; ?></a>
						     <?php }
						     ?>
     					    </div>
     					</section>
					 <?php }
					?>

                                    </div>
                                </div>
                                
				<div class="tab-pane <?php echo ($activeTab == 'library' ? "active" : '' )?>" id="library">
				    <span style="float:left" class="alt col-lg-4">
                                        <h4 class="font-thin m-l-md m-t">Add Songs to library:</h4>
                                    </span>
				    <div class="wrapper ">

					<?php
					 $songs = get_user_songs($user_id);
//					    $sessionData = get_session_data();
//					    $user_id = $sessionData['id'];
//					    if($friend_id == $user_id)
					 $addForm = true;
//					    else
//						$addForm = false;

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
					     ?>
     					<div  class="col-lg-12">
						 <?php if ($this->session->flashdata('song_message')) {
						     ?>
	 					    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
	 						<button class="close" data-dismiss="alert">x</button>                
							 <?php echo $this->session->flashdata('song_message'); ?>
	 					    </div>
						     <?php }
						 ?>  
						 <?php echo form_open_multipart('profile/add_song', $form_attr);
						 ?>


     					    <section class="panel-default panel"> 

     						<div class="panel-body"> 

     						    <div class="form-group"> 
     							<div class="form-group"> 
     							    <label>Title</label> 
								 <?php
								 echo form_input($title_data);
								 echo form_error('title','<div class="error">','</dev>');
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

     						<div class="text-right"> <br>
     <?php echo form_submit($data_submit) ?>
     						</div>
     					    </section> 
     <?php echo form_close(); ?>


 <?php } ?>

					    <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs"> 
						<?php
						 if (!empty($songs)) {
                                                     //echo '<pre>'; print_r($songs);
						     foreach ($songs as $key => $value) {
							 $song_id = $value['sId'];
							 $media = $this->config->item('library_media_path') . $value['media'];
							 //$media = base_url() . 'uploads/library/'.$value['media'];
							 $artist = $value['user_id'];
							 $title = $value['title'];
							 $likeCount = $value['likeCount'];
                                                         
                                                         $file_ext = pathinfo($value['media'], PATHINFO_EXTENSION);
							 ?>


	 						<li class="list-group-item ">
	 						    <span class="pull-right padder">
	 							<a   data-toggle="button" dataid="<?php echo $song_id; ?>" alt="<?php echo $user_id ?>" class="btn btn-default  active songLike"> 
	 							    <span class="text"> 
	 								<i class="fa fa-thumbs-o-up text"></i> 
	 								<span class="like_count_<?php echo $song_id; ?>"><?php echo $likeCount; ?></span>
	 							    </span> 

	 							    <span class="text-active"> 
	 								<i class="fa fa-thumbs-o-up text"></i> 
	 								<span class="like_count_<?php echo $song_id; ?>"><?php echo $likeCount; ?></span>
	 							    </span>     
	 							</a> 
	 						    </span>
                                                            
                                                                 <?php 
                                                                 if(file_exists('/home2/pranay/public_html/samiran/battleme/uploads/library/'.$value['media'])){
                                                                     if ( in_array($file_ext, ['mp4','ogg','webm'] ) ) { ?>
                                                                            <video width="400" controls="controls">
                                                                                <source type="video/mp4" src="<?=base_url().$media?>"></source>
                                                                            </video>
                                                                     <?php } else { $this->view('jplayer', ['path'=>base_url().$media, 'id'=>$key]); }
                                                                 } else if(file_exists($_SERVER["DOCUMENT_ROOT"].'/battleme/uploads/library/'.$value['media'])) {  
                                                                         if ( in_array($file_ext, ['mp4','ogg','webm'] ) ) { ?>
                                                                            <video width="400" controls="controls">
                                                                                <source type="video/mp4" src="<?=base_url().$media?>"></source>
                                                                            </video>
                                                                     <?php } else { $this->view('jplayer', ['path'=>base_url().$media, 'id'=>$key]); }
                                                                 } ?> 
                                                            
	 						    <a class="clear" href="#"> 
	 							<span class="block text-ellipsis"><?php echo $title ?></span>
                                                            </a>

	 						</li> 
						     <?php
						     }
						 } else {
						     echo "<div class='alert alert-danger'>User has not uploaded any song</div>";
						 }
						?>
					    </ul>

					</div>
				    </div>

				</div>
                                
			    </div>                    
                        </section>
                    </section>
                </aside>

            </section>
        </section>
    </section>
</section>
<?php $this->load->view('templates/footer'); ?>