<!DOCTYPE html>
<html lang="en" class="app" ng-app="battle">
    <?php $this->load->view('templates/header'); ?>
    <?php $this->load->view('home_searchbar', $userdata); 
    $currentime = date("Y-m-d H:i:s", time());
    //print_r($userdata);
    ?>

    <section class="scrollable">
        <section class="hbox stretch">
            <!-- home sidebar begin -->
            <?php $this->load->view('home_sidebar'); ?>
            <!-- home sidebar ends -->
            
            <?php if ($this->session->flashdata('post_message')) { ?>
                <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
                    <button class="close" data-dismiss="alert">x</button>  
                    <?php echo $this->session->flashdata('post_message'); ?>
                </div>
            <?php } ?>
            
            <!-- for wall section start -->
    <div class="col-lg-12">
    <section class="panel panel-default"> 
        <?php
        $attributes = array('id' => 'submitpost');
         $field_post = array(
              'name'        => 'post',
              'id'          => 'post',
             'value' => set_value('post'),
              'rows'        => '5',
              'cols'        => '10',
              'class'       => 'form-control parsley-validated col-lg-12',
              'placeholder' => 'Type your message',
              'data-required' => 'true',
        );
         $media_post = array(
             'placeholder' => 'Choose your media',
             'name' => 'media_post',
             'id' => 'media_post',
             'class' => '',
             'maxlength' => '225',
             'data-required' => 'true'
         );
        echo form_open_multipart('home/', $attributes);
        ?>
        <div class="panel-body writepostpanel"> 
            <div class="form-group"> 
                <?php 
                    echo form_textarea($field_post);
                    echo form_error('post', '<div class="error">', '</div>'); 
                ?>
            </div> 
            
            <div class="form-group"> 
                <?php
                    echo form_upload($media_post);
                    echo form_error('media_post', '<div class="error">', '</div>');
                    if(isset($post_media_error)) {
                        echo '<div class="error">'.$post_media_error.'</div>';
                    }
                     
                    // For Who see post
                    //$who_option = [''=>'Who should see this?', 3=>'Public', 1=>'Friends', 2=>'Only Me'];
                    $who_option = [''=>'Who should see this?', 1=>'Friends', 2=>'Only Me'];
                    $who_selected = (!empty(set_value('see_post'))) ? set_value('see_post') : 1;
                        echo form_dropdown('see_post', $who_option, $who_selected);
                        echo form_error('see_post', '<div class="error">', '</div>'); 
                ?>
            </div> 
        </div> 
        <footer class="text-right postfooter"> 
            <button type="submit" name="post_message" value="1" class="btn btn-success btn-s-xs">POST</button> 
            <?php echo form_close(); ?>
    </section>
</div>

<!-- <div class="line line-dashed b-b line-lg pull-in">
</div> -->
<?php
if (!empty($post_data)):
    foreach ($post_data as $post):
        ?>
        <!--begin user posts -->
        <div class="col-lg-12"> 
            <section class="comment-list block"> 
                <article id="comment-id-1" class="comment-item"> 
                    <a class="pull-left thumb-sm avatar"> 
                        <?php if ($post['profile_picture'] != ''): ?>
                            <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $post['profile_picture']); ?>" class="img-circle" alt="..."> 
                        <?php else: ?>
                            <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" class="img-circle" alt="..."> 
                        <?php endif; ?>
                    </a>
                    <span class="arrow left"></span> 
                    <section class="comment-body panel panel-default"> 
                        <header class="panel-heading bg-white">
                            <?php if ($post['subject_id'] == $post['object_id']): ?>
                                <a href="<?php echo base_url('profile/view/' . $post['subject_id']); ?>"><?php echo $post['firstname'] . " " . $post['lastname']; ?></a> 
                            <?php else: ?>
                                <a href="<?php echo base_url('profile/view/' . $userdata[0]->id); ?>"><?php echo $post['firstname'] . " " . $post['lastname']; ?></a>
                            <?php endif; ?>
                            <!--<label class="label bg-info m-l-xs">Editor</label>--> 
                            
                            <!-- Start delete post -->
                            <?php if ($post['subject_id'] == $userdata[0]->id) { ?>
                            <span class="text-muted m-l-sm pull-right">
                                <div class="nav-primary ">
                                    <ul class="nav clearfix" data-ride="collapse">
                                        <li> 
                                              <a href="javascript:void(0)" class="auto"> 
                                                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                                              </a> 
                                              <ul class="nav dk text-sm">
                                                <li > 
                                                    <a href="javascript:void(0)" onclick="deletePost('<?=$post['postid']?>')" class="auto"> 
                                                        <span>Delete Post</span> 
                                                    </a> 
                                                </li>
                                              </ul>
                                        </li>
                                    </ul>
                                </div>
                            </span>
                            <?php } ?>
                            <!-- End of delete post -->
                            
                            
                            <span class="text-muted m-l-sm pull-right"> 
                                <i class="fa fa-clock-o"></i>
                                <?php
                                $ts1 = strtotime($post['post_timestamp']);
                                $ts2 = strtotime($currentime);
                                $posttime = round(abs($ts1 - $ts2) / 60, 2);
                                if ($posttime < 60) {
                                    echo round($posttime) . " minutes ago";
                                }
                                if ($posttime >= 60 && $posttime < 1440) {
                                    echo round($posttime / 60) . " hours ago";
                                }
                                if ($posttime >= 1440) {
                                    echo round($posttime / 1440) . " days ago";
                                }
                                ?>
                            </span> 
                            
                            
                            
                        </header> 
                        <div class="panel-body"> 
                            <div>
                                <?php 
				 if(!is_null($post['data_id']) && $post['data_id'] > 0 )
				 {
                                     if(!is_null($post['data_type']) && $post['data_type'] == 'tournament' ){
                                         $link = "<a href='".base_url('tournament/request/'.$post['data_id'])."'>".$post['content']."</a>";
                                     }else{
                                         $link = "<a href='".base_url('battle/request/'.$post['data_id'])."'>".$post['content']."</a>";
                                     }
				 }
				 else
				     $link = $post['content'];
				 echo $link;
				 ?>
                                
                                <?php if($post['media'] != '' && $post['media_type'] == 1) { ?>
                                     <br>
                                     <a class="media_light" href="<?=base_url('uploads/post/' . $post['media'])?>" >
                                         <img src="<?=base_url('uploads/post/thumb_' . $post['media'])?>" alt="<?=$post['media']?>" >
                                     </a>
                                <?php } ?>
                                
                                <?php if($post['media'] != '' && $post['media_type'] == 2) { ?>
                                     <video width="400" controls="controls">
                                        <source src="<?=base_url('uploads/post/' . $post['media'])?>" type="video/mp4">
                                     </video>
                                <?php } ?> 
                                     
                                <?php if($post['media'] != '' && $post['media_type'] == 3) {
                                    $this->view('jplayer', ['path'=>base_url('uploads/post/' . $post['media']), 'id'=>'voice_'.$post['id']]);
                                } ?>
                            </div> 

                             
                            <div class="comment-action m-t-sm"> 
                                <?php
                                $like_count = 0;
                                $like_display = false;
                                foreach ($likes as $likedata):
                                    if ($likedata['post_id'] == $post['postid']):
                                        $like_count = $likedata['likes'];
                                    endif;
                                    if ($likedata['post_id'] == $post['postid']) {
                                        $like_display = true;
//                                        echo $userdata[0]->id;
//                                        echo $likedata['user_id'];
                                        ?>

                                        <a class="btn btn-default likebutton <?php echo ( $userdata[0]->id == $likedata['user_id'] && $likedata['post_id'] == $post['postid']) ? 'active' : '' ?>" postid="<?php echo $post['postid']; ?>" data-subject-id="<?php echo $post['subject_id']; ?>" data-toggle="button"> 
                                            <span class="text-active"> 
                                                <i class="fa fa-thumbs-o-up text"></i> 
                                                <span class="like_count"><?php echo $like_count; ?></span>
                                            </span> 

                                            <span class="text"> 
                                                <i class="fa fa-thumbs-o-up text"></i> 
                                                <span class="like_count"><?php echo $like_count; ?></span>
                                            </span>     

                                        </a>
                                    <?php
                                    }
//                                    fa fa-thumbs-up text-success
                                endforeach;
                                if (!$like_display):
                                    ?>
                                    <a class="btn btn-default likebutton active" postid="<?php echo $post['postid']; ?>" data-subject-id="<?php echo $post['subject_id']; ?>" data-toggle="button"> 
                                        <span class="text"> 
                                            <i class="fa fa-thumbs-o-up text"></i> 
                                            <span class="like_count">0</span>
                                        </span> 

                                        <span class="text-active"> 
                                            <i class="fa fa-thumbs-o-up text"></i> 
                                            <span class="like_count">0</span>
                                        </span>     

                                    </a>
                                    <?php
                                endif;
                                ?>
                            </div> 


                        </div> 
                    </section> 
                </article>             
                <!-- .comment-reply --> 
                <?php
                if (!empty($comments)):
                    foreach ($comments as $commentdata):
                        if ($commentdata['post_id'] == $post['postid']):
                            ?>
                            <article id="comment-id-2" class="comment-item comment-reply comment-class-<?=$commentdata['comment_id']?>"> 
                                <a class="pull-left thumb-sm avatar"> 
                                    <?php if ($post['profile_picture'] != ''): ?>
                                        <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $commentdata['profile_picture']); ?>" class="img-circle" alt="..."> 
                                    <?php else: ?>
                                        <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" class="img-circle" alt="..."> 
                                    <?php endif; ?> 
                                </a> 
                                <span class="arrow left">

                                </span> 
                                <section class="comment-body panel panel-default text-sm"> 
                                    <div class="panel-body"> 
                                        <span class="text-muted m-l-sm pull-right"> 
                                            <i class="fa fa-clock-o"></i> 
                                            <?php
                                            $ts1 = strtotime($commentdata['comment_timestamp']);
                                            $ts2 = strtotime($currentime);
                                            $posttime = round(abs($ts1 - $ts2) / 60, 2);
                                            if ($posttime < 60) {
                                                echo round($posttime) . " minutes ago";
                                            }
                                            if ($posttime >= 60 && $posttime < 1440) {
                                                echo round($posttime / 60) . " hours ago";
                                            }
                                            if ($posttime >= 1440) {
                                                echo round($posttime / 1440) . " days ago";
                                            }
                                            ?>
                                            &nbsp; 
                                             <?php if ($commentdata['userid'] == $userdata[0]->id) { ?>
                                            <a class="delete_comment" href="javascript:void(0)" data-comment-id="<?=$commentdata['comment_id']?>"><i class="fa fa-trash-o"></i></a>
                                             <?php } ?>
                                        </span> 
                                        <?php if ($post['subject_id'] == $commentdata['userid']): ?>
                                            <a href="<?php echo base_url('profile/view/' . $post['subject_id']); ?>"><?php echo $commentdata['firstname'] . " " . $commentdata['lastname'] . ":"; ?></a> 
                                        <?php else: ?>
                                            <a href="<?php echo base_url('profile/view/' . $userdata[0]->id); ?>"><?php echo $commentdata['firstname'] . " " . $commentdata['lastname'] . ":"; ?></a>
                                        <?php endif; ?> 
                                        <!--<label class="label bg-dark m-l-xs">Admin</label>--> 
                                        <?php echo $commentdata['comment']; ?>
                                    </div>
                                </section> 
                            </article> 
                            <?php
                        endif;
                    endforeach;
                endif;
                ?>
                <!-- / .comment-reply -->
                <!-- comment form --> 
                <article class="comment-item media" id="comment-form"> 
                    <a class="pull-left thumb-sm avatar">
                        <?php if ($userdata[0]->profile_picture != ''): ?>
                            <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $userdata[0]->profile_picture); ?>" alt="..."> 
                        <?php else: ?>
                            <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" alt="...">
                        <?php endif; ?>
                    </a>
                    <section class="media-body"> 
                        <?php
                        $attributes = array('id' => 'submitcomment');
                        echo form_open('home/addcomment/' . $post['postid'] . "/" . $post['subject_id'], $attributes);
                        ?> 
                        <div class="input-group">
                            <input type="text" class="form-control" required="" placeholder="Input your comment here" name="comment"> 
                            <span class="input-group-btn"> 
                                <button class="btn btn-primary" type="submit" >add comment</button> 
                            </span> 
                            <?php echo form_error('comment'); ?>
                        </div> 
                        <?php echo form_close(); ?>
                    </section> 
                </article>
            </section> 
            <!-- comment form -->
        </div>
        <!-- end users post -->
        <?php
    endforeach;
endif;
?>
    <!-- end of the wall section -->
            
            
            
            <section id="content">
                <section class="hbox stretch">
		  
<!--		    <section class="panel panel-heading">
			<span>Top 100 Songs</span>
		    </section>-->
                    <section class=" panel-body">
			<?php  
			 if(isset($top_songs) && !empty($top_songs)){
			    ?>
			<div class=" scrollable">
			<ul style="max-height: 400px; overflow-y:scroll; margin-left: -43px;">
			    <header class="panel-heading"><h4>Top 100 Songs</header>
		    <?php foreach($top_songs as $songKey => $songValue) { 
			   // print_r($songValue);
			$song_id = $songValue['sId'] ;
			$media = $this->config->item('library_media_path').$songValue['media'];
			$artist = $songValue['user_id'];
			$artistName = $songValue['firstname']." ".$songValue['lastname'];
			$title = $songValue['title'];
			$likeCount = $songValue['likeCount'];
	             ?>
	     
                       <li class="list-group-item">
                        
                         <?php if(file_exists('/home2/pranay/public_html/samiran/battleme/'.$media)){  
                                $this->view('jplayer', ['path'=>base_url().$media, 'id'=>$songKey]);
                         } else if(file_exists($_SERVER["DOCUMENT_ROOT"].'/battleme/'.$media)) {  
                                $this->view('jplayer', ['path'=>base_url().$media, 'id'=>$songKey]);
                         } ?>     
                         
                           
                         <a class="clear" href="#"><?php echo $title?>
                                <span class="block text-ellipsis"></span>
                         </a>
                         <small class="text-muted">by <?php echo $artistName ;?></small>

                       </li> 
			   
		   <?php } ?>
			    </ul>
			    
			</div>
			 <?php
			}
			 if(isset($top_user) && !empty($top_user)){ 
			     ?>
			 <div class=" scrollable"> 
				<header class="panel-heading">
				    <h4> Top 100 Artists </h4>
				</header>
			     <ul class="list-group alt" style="max-height: 400px; overflow-y:scroll;">
				 <?php 
			    foreach($top_user as  $userkey => $userVal)
			    {
				$name = $userVal['firstname'].' '.$userVal['lastname'] ;
				?>
				 
				 <li class="list-group-item">
				    <div class="media">
					<span class="pull-left thumb-sm">
					    <?php if ($userVal['profile_picture'] != ''): ?>
						<img src="<?php echo base_url('uploads/profile_picture/' . $userVal['profile_picture']); ?>" class="img-circle" alt="..."> 
					    <?php else: ?>
						<img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" class="img-circle" alt="..."> 
					    <?php endif; ?>
					</span>
					<div class="pull-right text-success m-t-sm"> 
					    <i class="fa fa-circle"></i> </div> 
					<div class="media-body"> 
					    <div><a href="<?php echo base_url('profile/view/' . $userVal['id']); ?>"><?php echo $name; ?></a></div>
					    <small class="text-muted">W:<?php echo $userVal['win_cnt'] ?> </small> </div>
				    </div>
				 </li>
				 
				 
				 
					   <br>
			  <?php  }
				?>
			</div>
		    </ul>
			 <?php
			 }
			?>
                        <?php
                        if (isset($search_html) && !empty($search_html))
                            print $search_html;
                        ?>
                        <?php
                        if (isset($home_content) && !empty($home_content))
                            print $home_content;
                        ?>
                        <?php
                        if (isset($aboutus) && !empty($aboutus))
                            print $aboutus;
                        ?>
                    </section>
                    <!-- side content --> 
                    <?php
                    if (isset($right_sidebar) && !empty($right_sidebar))
                        print $right_sidebar;
                    ?>
                    <!-- / side content --> 
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a> 
            </section>
        </section>
    </section>
</section>
<!-- Bootstrap -->  
<?php $this->load->view('templates/footer'); ?>
 
<div id="fb-root"></div>
<script type="text/javascript">
    $(document).ready(function () {
        
        var url = "<?php echo base_url(); ?>";
        $('#searchfriend').keypress(function (event) {
            
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var search_string = $("#searchfriend").val();
//                alert(search_string);
                $.ajax({
                url: url+'home/search_friend/'+search_string,
                type: 'POST',
                success: function (result) {
                    console.log(result);
                    $('#home_searchfriends').html(result);
                }
            });
            }

        });
        
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
        
    });
    
    // for delete a post
    function deletePost(postId) { 
        var url = "<?php echo base_url(); ?>";
        if (confirm("Are you sure you want to delete this post!") == true) {
           window.location = url+"home/delete_post/"+postId;
        }  
    }
</script>
</body>

</html>