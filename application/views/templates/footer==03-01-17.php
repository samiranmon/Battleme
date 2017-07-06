<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.jsscroll.js"></script>
<!--<script type="text/javascript" src="js/jquery.jsscroll.min.js"></script>-->


<?php
//$this->router->fetch_class() == 'user';
//$this->router->fetch_class().'/'.$this->router->fetch_method();   
?>

<?php if ($this->router->fetch_class() == 'home' || $this->router->fetch_class() == 'profile' ) { ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/css/jquery.lightbox-0.5.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.lightbox-0.5.min.js"></script>
<?php } ?>  
    
<?php if ($this->router->fetch_class() == 'battle') { ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/js/datepicker/datepicker.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/datepicker/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/datepicker/bootstrap-datetimepicker.js"></script>
    
<?php } ?>  

<script type="text/javascript">
/*
        VIEWPORT BUG FIX
        iOS viewport scaling bug fix, by @mathias, @cheeaun and @jdalton
*/
(function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
</script>

<!--<script type="text/javascript" src="<?//php echo base_url(); ?>public/js/jplayer/jquery.jplayer.min.js"></script>
<link href="<?//php echo base_url(); ?>public/css/jplayer/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />-->

<link href="<?php echo base_url(); ?>public/css/responsive_player/audioplayer.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/responsive_player/audioplayer.js"></script>
<script>$( function() { $( '.audio_' ).audioPlayer(); 
    } );</script>

<script type="text/javascript">
    $('#eg').jsScroll({
        height: '380px',
        alwaysVisible: true
    })

    $('#eg3').jsScroll({
        height: 'auto',
        height: '380px',
                railColor: '#61a8e9',
        barColor: '#163465',
        allowPageScroll: false,
        alwaysVisible: true
    });
    
    $('#eg2').jsScroll({
        height: '380px',
        railColor: '#f85253',
        barColor: '#a40809',
        alwaysVisible: true
    });
    
    $('#eg4').jsScroll({
		        height: '255px',
		        alwaysVisible: true
		    });

</script>


<script>
    $(document).ready(function () {
        $("#btn1").click(function () {
            if ($("#bdyopen2, #bdyopen3").is(":visible"))
            {
                $("#bdyopen2, #bdyopen3").slideUp();
            }
            $("#bdyopen").slideToggle("slow");
        });
    });

    $(document).ready(function () {
        $("#btn2").click(function () {
            if ($("#bdyopen, #bdyopen3").is(":visible"))
            {
                $("#bdyopen, #bdyopen3").slideUp();
            }
            $("#bdyopen2").slideToggle("slow");
        });
    });

    $(document).ready(function () {
        $("#inf_btn3").click(function () {
            if ($("#bdyopen2, #bdyopen").is(":visible"))
            {
                $("#bdyopen2, #bdyopen").slideUp();
            }
            $("#bdyopen3").slideToggle("slow");
        });
    });
</script>

<script type="text/javascript">
    var topHead = $(".top_head").outerHeight();
    var bodyHeight = $(".right_content").outerHeight();
    var tHeight = topHead + bodyHeight + 298;
    $(".left_side").height(tHeight);
</script>

<script type="text/javascript">
     $(".leftMenu li").click(function() {
         if ($(this).siblings().children("ul").is(":visible")) {
            $(this).siblings().children("ul").slideUp();
        }
        $(this).children().next("ul").slideToggle();
    });
	
	$('.clickleftMenu').click(function() {
		$('.left_side').toggleClass('sideOpen');
		return false;
	});	
    $('.clickleftMenu1').click(function() {
		$('.left_side').removeClass('sideOpen');
		return false;
	});
	
</script>




<script type="text/javascript">
    $(document).ready(function () {
        $('.songLike').click(function () {
            currObj = $(this);
            var data_id = $(this).attr('dataid');
            var like_type = 'song';
            var user_id = $(this).attr('alt');
            if (user_id == '') {
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
</body>
</html>