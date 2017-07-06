<!DOCTYPE html>
<html lang="en" class="app" ng-app="battle">
    <?php $this->load->view('templates/header'); ?>
    <?php $this->load->view('home_searchbar', $userdata); 
    $currentime = date("Y-m-d H:i:s", time());
    //print_r($userdata);
    ?>
    <!--<link href="<?//=base_url('public/css/audiojs.css')?>"  rel="stylesheet" type="text/css" media="screen">-->
    
    
    <!-- for wall section start -->
    <div class="col-lg-12">
    <section class="panel panel-default"> 
        <?php
        $attributes = array('id' => 'submitpost');
        echo form_open('post/addpost/' . $userdata[0]->id, $attributes);
        ?>
        <div class="panel-body writepostpanel"> 
            <div class="form-group"> 
                <!-- <label>Write Post</label>  -->
                <textarea class="form-control parsley-validated col-lg-12" rows="5" data-minwords="6" data-required="true" placeholder="Type your message" name="post" style="margin: 0px -0.5px 0px 0px; width: 100%; height: 100px;"></textarea> 
                <?php echo form_error('post'); ?>
            </div> 
        </div> 
        <footer class="text-right postfooter"> 
            <button type="submit" class="btn btn-success btn-s-xs">POST</button> 
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

                                        <a class="btn btn-default likebutton <?php echo ( $userdata[0]->id == $likedata['user_id'] && $likedata['post_id'] == $post['postid']) ? 'active' : '' ?>" postid="<?php echo $post['postid']; ?>" data-toggle="button"> 
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
                                    <a class="btn btn-default likebutton active" postid="<?php echo $post['postid']; ?>" data-toggle="button"> 
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
                            <article id="comment-id-2" class="comment-item comment-reply"> 
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
                        echo form_open('post/addcomment/' . $post['postid'] . "/" . $post['subject_id'], $attributes);
                        ?> 
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Input your comment here" name="comment"> 
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
    
    
    
    
    
    

    <section class="scrollable">
        <section class="hbox stretch">
            <!-- home sidebar begin -->
            <?php $this->load->view('home_sidebar'); ?>
            <!-- home sidebar ends -->
            <section id="content">
                <section class="hbox stretch">
		  
<!--		    <section class="panel panel-heading">
			<span>Top 100 Songs</span>
		    </section>-->
                    <section class=" panel-body">
			<?php  
			 if(isset($top_songs) && !empty($top_songs)){
			    ?>
			<div class="col-lg-8 scrollable">
			<ul style="max-height: 400px; overflow-y:scroll;">
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
			 <div class="col-lg-8 scrollable"> 
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
            var url = "<?php echo base_url(); ?>";
            var userid = "<?php echo $userdata[0]->id; ?>";
            var frndid = "<?php echo $userdata[0]->id; ?>";
            var postid = $(this).attr('postid');
            console.log(url + 'post/addlike/' + postid + '/' + userid);
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
    });
</script>
</body>

</html>