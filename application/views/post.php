<div class="col-lg-12">
    <section class="panel panel-default"> 
        <?php
        $attributes = array('id' => 'submitpost');
        echo form_open('post/addpost/' . $frndid, $attributes);
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
                                <a href="<?php echo base_url('profile/view/' . $frndid); ?>"><?php echo $post['firstname'] . " " . $post['lastname']; ?></a>
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
                                 if($post['media'] != '' && $post['media_type'] == 1) {
                                     echo '<br>'.'<img src="'.base_url('uploads/post/thumb_' . $post['media']).'" >';
                                 }
				 ?>
                                
                                <?php if($post['media'] != '' && $post['media_type'] == 2) { ?>
                                     <video width="400" controls="controls">
                                        <source src="<?=base_url('uploads/post/' . $post['media'])?>" type="video/mp4">
                                     </video>
                                <?php } ?>
                                
                                 <?php if($post['media'] != '' && $post['media_type'] == 3) {
                                    $this->view('responsive_player', ['path'=>base_url('uploads/post/' . $post['media']), 'id'=>'voice_'.$post['id']]);
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
//                                        echo $user_id;
//                                        echo $likedata['user_id'];
                                        ?>

                                        <a class="btn btn-default likebutton <?php echo ( $user_id == $likedata['user_id'] && $likedata['post_id'] == $post['postid']) ? 'active' : '' ?>" postid="<?php echo $post['postid']; ?>" data-toggle="button"> 
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
                                            <a href="<?php echo base_url('profile/view/' . $frndid); ?>"><?php echo $commentdata['firstname'] . " " . $commentdata['lastname'] . ":"; ?></a>
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

<div class="col-lg-12">
    <section class="panel panel-default">

    </section>    
</div>

<style>
    .postfooter {
        padding: 15px;
    }
    .writepostpanel{
        padding: 15px 15px 0px;
        margin-top: 25px;
    }
    .panel{
        margin-top: 25px;
    }
</style>
<script>
    $(document).ready(function () {
        $(".likebutton").click(function () {
            var self = $(this);
            var url = "<?php echo base_url(); ?>";
            var userid = "<?php echo $send_id; ?>";
            var frndid = "<?php echo $frndid; ?>";
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