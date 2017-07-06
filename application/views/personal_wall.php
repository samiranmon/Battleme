<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', ".scroll_post_like,.scroll_post_comment", function() { 
            var JpostId = $(this).attr('data-post-id');
            $('html, body').animate({
                  scrollTop: $(".post_"+JpostId).offset().top
            }, 1000);  
        });
    });
</script>

<?php if ($this->session->flashdata('post_message')) { ?>
    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
        <button class="close" data-dismiss="alert">x</button>  
        <?php echo $this->session->flashdata('post_message'); ?>
    </div>
<?php } ?>

<?php
$currentime = date("Y-m-d H:i:s", time());

$attributes = array('id' => 'submitpost');
$field_post = array(
    'name' => 'post',
    'id' => 'post',
    'value' => set_value('post'),
    'rows' => '5',
    'cols' => '10',
    'class' => '',
    'placeholder' => 'Write your message...',
    'required' => 'true',
);
$media_post = array(
    'placeholder' => 'Choose your media',
    'name' => 'media_post',
    'id' => 'myPost',
    'class' => '',
    'maxlength' => '225',
    'data-required' => 'true'
);
echo form_open_multipart('post/addpost/'.$friend_id, $attributes);
?>
<div class="midsection1">
    <div class="mn_top"> 
        <?php
        echo form_textarea($field_post);
        echo form_error('post', '<div class="error">', '</div>');
        ?>
    </div>
    <div class="mn_low_sec">
        <div class="cam">
            <span style="display: none"><?= form_upload($media_post) ?></span>
            <?php
            echo form_error('media_post', '<div class="error">', '</div>');
            if (isset($post_media_error)) {
                echo '<div class="error">' . $post_media_error . '</div>';
            }
            ?>
            <a onclick="fileUpload()"><img src="<?php echo base_url(); ?>public/images/cam.png" alt=""> </a>
        </div>
        <div class="frnd_list">
            <?php
            // For Who see post
            //$who_option = [''=>'Who should see this?', 3=>'Public', 1=>'Friends', 2=>'Only Me'];
            $who_option = ['' => 'Who should see this?', 1 => 'Friends', 2 => 'Only Me', 3=>'Community'];
            $who_selected = (!empty(set_value('see_post'))) ? set_value('see_post') : 1;
            echo form_dropdown('see_post', $who_option, $who_selected, 'id="sect2"');
            echo form_error('see_post', '<div class="error">', '</div>');
            ?>
        </div>
        <div class="post_btn">
            <button type="submit" name="post_message" value="1" class="btn btn-success btn-s-xs">Post</button>
        </div>
    </div>

</div>
<?php echo form_close(); ?>


<div class="midsection">
    <h3>News feed/wall</h3>

    
    <?php if (!empty($post_data)) {
            foreach ($post_data as $post) { ?>
    
    <div class="mid_bdy post_<?= $post['postid'] ?>">
        
        <div class="profile">
            <div class="pro_pic">
                <?php if ($post['profile_picture'] != '') { ?>
                        <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $post['profile_picture']); ?>" alt="...">
                <?php } else { ?>
                        <img src="<?php echo base_url(); ?>public/images/icon3.jpg" alt="">
                        <!--<img src="<?//php echo base_url('uploads/profile_picture/default.png'); ?>" alt="...">--> 
                <?php } ?>
            </div> 
            
            <div class="pro_txt">
                <?php if ($post['subject_id'] == $post['object_id']) { ?>
                <a href="<?php echo base_url('profile/view/' . $post['subject_id']); ?>"><h5><?php echo $post['firstname'] . " " . $post['lastname']; ?></h5></a> 
                <?php } else { ?>
                    <a href="<?php echo base_url('profile/view/' . $userdata[0]->id); ?>"><h5><?php echo $post['firstname'] . " " . $post['lastname']; ?></h5></a>
                <?php } ?>
                
                <p>
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
                </p>
            </div> 
            
            <?php if ($post['subject_id'] == $userdata[0]->id) { ?>
            <div class="trash_icon">
                <a href="javascript:void(0)" onclick="deletePost('<?=$post['postid']?>')" > 
                    <img src="<?=  base_url('public/images/cross.jpg')?>">
                  </a>
            </div>
           <?php } ?>
        </div>
        
        <p>
        <?php if(!is_null($post['data_id']) && $post['data_id'] > 0 ) {
                 if(!is_null($post['data_type']) && $post['data_type'] == 'tournament' ){
                     $link = "<a href='".base_url('tournament/request/'.$post['data_id'])."'>".$post['content']."</a>";
                 }else{
                     $link = "<a href='".base_url('battle/request/'.$post['data_id'])."'>".$post['content']."</a>";
                 }
             } else {
                  $link = $post['content'];
             } echo $link;
        ?></p>

        
            <?php if($post['media'] != '' && $post['media_type'] == 1) { ?>
                    <div class="mid_pic">
                        <?php 
                             if(file_exists($this->config->item('post_media_path').$post['media'])) { ?>
                               <a class="media_light" href="<?= base_url('uploads/post/' . $post['media']) ?>" >
                                    <img src="<?= base_url('uploads/post/thumb_' . $post['media']) ?>" alt="<?= $post['media'] ?>" >
                                </a>
                        <?php } else { ?>
                                <a class="media_light" href="<?= base_url('uploads/post/medium_' . $post['media']) ?>" >
                                    <img src="<?= base_url('uploads/post/thumb_' . $post['media']) ?>" alt="<?= $post['media'] ?>" >
                                </a>
                         <?php } ?>
                    </div>
                <?php } ?>

                <?php if($post['media'] != '' && $post['media_type'] == 2) { ?>
                    <div class="mid_pic">
                         <video width="531" controls="controls">
                            <source src="<?=base_url('uploads/post/' . $post['media'])?>" type="video/mp4">
                         </video>
                    </div>
                <?php } ?> 

                <?php if($post['media'] != '' && $post['media_type'] == 3) { ?>
                    <div class="mid_pic">
                        <?php $this->view('responsive_player', ['path'=>base_url('uploads/post/' . $post['media']), 'id'=>'voice_'.$post['id']]); ?>
                    </div>
                <?php } ?>
        
        <div class="mid_like">
            
            <?php
                $like_count = 0;
                $like_display = false;
                foreach ($likes as $likedata) {

                    if ($likedata['post_id'] == $post['postid']) {
                        $like_count = $likedata['likes'];
                    }

                    if ($likedata['post_id'] == $post['postid']) {
                        $like_display = true;
            ?>
                <div class="mlike">
                    <a href="javascript:void(0)" class="likebutton <?php echo ( $userdata[0]->id == $likedata['user_id'] && $likedata['post_id'] == $post['postid']) ? 'active' : '' ?>" postid="<?php echo $post['postid']; ?>" data-subject-id="<?php echo $post['subject_id']; ?>" > 
                        <img src="<?php echo base_url(); ?>public/images/like.png" alt="" > 
                        <span class="like_count"><?php echo $like_count; ?></span> Like
                    </a>
                </div>
            <?php } } ?>
            
             <?php if (!$like_display) { ?>
                <div class="mlike">
                    <a href="javascript:void(0)" class="likebutton active" postid="<?php echo $post['postid']; ?>" data-subject-id="<?php echo $post['subject_id']; ?>"> 
                        <img src="<?php echo base_url(); ?>public/images/like.png" alt="" > 
                        <span class="like_count">0</span> Like
                    </a>
                </div>
            <?php } ?>
            
            <div class="mcomnt">
                <a class="comment_btn" data-comment-btn="<?=$post['postid']?>" href="javascript:void(0)"><img src="<?php echo base_url(); ?>public/images/comment.png" alt="" > Comment</a>
            </div>
            <div class="mshare">
                 <a href="<?php echo base_url('home/sharepost/'.$post['postid'].'/'. $post['object_id'])?>"><img src="<?php echo base_url(); ?>public/images/share.png" alt="" > Share</a>
            </div>
            
        </div>
        
        
        <?php
            if (!empty($comments)) {
                foreach ($comments as $commentdata) {
                    if ($commentdata['post_id'] == $post['postid']) {
        ?>
        <div class="mchat comment-class-<?=$commentdata['comment_id']?>">
            
            <div class="trash_icon">
                 <?php if ($commentdata['userid'] == $userdata[0]->id) { ?>
                    <a class="delete_comment" href="javascript:void(0)" data-comment-id="<?=$commentdata['comment_id']?>">
                        <img src="<?=  base_url('public/images/cross.jpg')?>">
                    </a>
                 <?php } ?>
            </div>
            
            <div class="mchat_pic">
                <?php if ($post['profile_picture'] != '') { ?>
                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $commentdata['profile_picture']); ?>" alt="..."> 
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>public/images/icon4.png" alt="">
                <?php } ?>
            </div> 
            
            <div class="mchat_txt">
                <h6>
                    <?php if ($post['subject_id'] == $commentdata['userid']) { ?>
                        <a href="<?php echo base_url('profile/view/' . $post['subject_id']); ?>"><?php echo $commentdata['firstname'] . " " . $commentdata['lastname'] . ":"; ?></a> 
                    <?php } else { ?>
                        <a href="<?php echo base_url('profile/view/' . $userdata[0]->id); ?>"><?php echo $commentdata['firstname'] . " " . $commentdata['lastname'] . ":"; ?></a>
                    <?php } ?> 
                    <span><?php echo $commentdata['comment']; ?></span>
                </h6>
                <p>
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
                </p>
            </div> 
        </div>
         
    <?php }}}?>
        
        <div class="mchat">
            <div class="mchat_pic">
                <?php if ($userdata[0]->profile_picture != '') { ?>
                    <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $userdata[0]->profile_picture); ?>" alt="..."> 
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>public/images/icon4.png" alt="">
                <?php } ?>
            </div> 
            
            <?php
                $attributes = array('id' => 'submitcomment');
                if($send_id == $friend_id) {
                    echo form_open('post/addcomment/' . $post['postid'] . "/" . $post['object_id'], $attributes);
                } else {
                    echo form_open('post/addcomment/' . $post['postid'] . "/" . $post['subject_id'], $attributes);
                }
            ?> 
                 <div class="mchat_txt1">
                     <input type="text" placeholder="Post your comment" class="comment_text_<?=$post['postid']?>" required="" name="comment">
                    <?php echo form_error('comment'); ?>
                </div>
            <?php echo form_close(); ?>
        </div>

    </div>
    
    <?php } } ?>

</div>