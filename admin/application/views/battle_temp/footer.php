<div class="footer">
    <div class="container">
        <p>Copyright © <?= date('Y') ?> battleme.hiphop, All rights reserved.  |  Powered by 
            <a href="http://brainiuminfotech.com/" target="_blank">BIT</a>.
        </p>
    </div>
</div>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('public/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.imageMask.js"></script>

<!-- For recording voice script -->
<script src="<?php echo base_url(); ?>public/js/recording/recorder.js"></script>
<script src="<?php echo base_url(); ?>public/js/recording/Fr.voice.js"></script>
<!-- For recording voice script -->
    
<script type="text/javascript">
    $(document).ready(function () {
        $(".mySelectorOne").imageMask("<?=base_url('public/images/maskred.png')?>");
        $(".mySelector").imageMask("<?=base_url('public/images/maskblue.png')?>");
    });
    
    (function ($) {
        $(window).load(function () {
            //$(".news_list").mCustomScrollbar({
            //setHeight:190,
            //theme:"dark-3"
            //});

            $(".red_ul").mCustomScrollbar({
                setHeight: 260,
                theme: "dark-3"
            });

        });
    })(jQuery);
</script>              
</body>
</html>