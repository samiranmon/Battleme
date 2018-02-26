<?php $this->load->view('templates/header'); 
    $currentime = date("Y-m-d H:i:s", time());
    //print_r($userdata);
?>
<div class="container-fluid">
        <div class="row">
            <div class="mainbdy">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <?php $this->load->view('home_sidebar'); ?>
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
                                            <div class="chartxt"> <?php echo $userdata[0]->firstname . " " . $userdata[0]->lastname; ?></div>
                                            
                                            <div class="chardownmain">
                                                <div id="btn1" class="char_btn"></div>
                                                <div id="bdyopen" class="char_bdytx"> 
                                                <ul>
                                                    <li> <a href="<?php echo base_url('profile'); ?>">Profile</a> </li> 
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
                            
                           
                            
                            <div class="row">
                                
                            <div class="col-md-4 col-md-push-8">
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
                                
                            <div class="col-md-8 col-md-pull-4">
                                <?php $this->load->view('post_home'); ?>
                            </div>
                            

                             
                           
                            </div>
                            
                            <div class="footer"><p>Copyright © <?=date('Y')?> battleme.hiphop, All rights reserved.  |  Powered by BIT. </p></div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


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
           window.location = url+"home/delete_post/"+postId;
        }  
    }
    
    function fileUpload() {
        $("#myPost").click();
    }
</script>

<?php $this->load->view('templates/footer'); ?>