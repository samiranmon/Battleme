<div class="footer_section">
    <p>Copyright © <?= date('Y') ?> battleme.hiphop, All rights reserved.  |  Powered by 
        <a href="http://www.brainiuminfotech.com/" target="_blank">BIT</a>.
    </p>
</div>
</div>


<script src="<?php echo base_url(); ?>public/js/app.v1.js"></script>

<!--<script src="<?//php echo base_url(); ?>public/js/angular.min.js"></script>-->
<!--<script src="<?//php echo base_url(); ?>public/js/battle.angular.js"></script>-->

<!--<script src="<?//php echo base_url(); ?>public/js/file-input/bootstrap-filestyle.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jplayer/jquery.jplayer.min.js"></script>
<link href="<?php echo base_url(); ?>public/css/jplayer/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

<?php 
    if($this->router->fetch_class() == 'user' ) {
        if($this->router->fetch_class().'/'.$this->router->fetch_method() != 'user/notifications') {
?>
<script src="<?php echo base_url(); ?>public/js/bootstrap.js"></script>
    <?php } } ?>


<?php if($this->router->fetch_class() == 'home' ) { ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.lightbox-0.5.min.js"></script>
<?php } ?>  

<script type="text/javascript">
    $(document).ready(function () {
        $('.songLike').click(function () {
            currObj = $(this);
            var data_id = $(this).attr('dataid');
            var like_type = 'song';
            var user_id = $(this).attr('alt');
            if(user_id == '') {
                return false;
            }
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>ajax/like/",
                data: {data_id: data_id, like_type: like_type, user_id: user_id},
                success: function (data) {
                    $('.like_count_' + data_id).html(data);
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