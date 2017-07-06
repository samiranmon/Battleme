   <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
            <p> <small>Web app framework base on Bootstrap<br>&copy; <?=date('Y')?></small> 
            </p>
        </div>
    </footer>
    <!-- / footer -->
    <!-- Bootstrap -->
    <!-- App -->
    <script src="<?php echo base_url();?>public/js/app.v1.js"></script>
    <!--<script src="<?//php echo base_url();?>public/js/app.plugin.js"></script> -->
    <!--<script src="<?//php echo base_url();?>public/js/chosen/chosen.jquery.min.js"></script>--> 
    <!--script type="text/javascript" src="<?//php echo base_url();?>public/js/jPlayer/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="<?//php echo base_url();?>public/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
    <script type="text/javascript" src="<?//php echo base_url();?>public/js/jPlayer/demo.js"></script-->
    <script src="<?php echo base_url();?>public/js/angular.min.js"></script>
    <script src="<?php echo base_url();?>public/js/battle.angular.js"></script>
    <script src="<?php echo base_url();?>public/js/file-input/bootstrap-filestyle.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>public/js/jplayer/jquery.jplayer.min.js"></script>
    <link href="<?php echo base_url();?>public/css/jplayer/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
    $(document).ready(function(){
	$('.songLike').click(function(){
	    currObj = $(this);
	 var data_id = $(this).attr('dataid');
        var like_type = 'song';
        var user_id = $(this).attr('alt');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>ajax/like/",
            data: {data_id: data_id, like_type: like_type, user_id: user_id},
            success: function (data) {
		$('.like_count_'+data_id).html(data);
		currObj.addClass('active');
//                var review_txt = $("#ideabook_like_txt_" + data_id).text();
//
//                if (review_txt == "Like") {
//                    // $("#ideabook_like_txt_" + data_id).text('Unlike');
//                } else {
//                    // $("#ideabook_like_txt_" + data_id).text('Like');
//                }
//                $("#wedding-fun-like").toggleClass("like-btn-effect")
//                // $("#ideabook_like_txt_" + data_id).toggleClass("like-btn-effect");
//                $('#ideabook_like_cnt_' + data_id).html(data);

            }
        });
	 });
    });
    
    </script>