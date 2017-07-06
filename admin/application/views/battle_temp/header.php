<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no">

        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <meta name="viewport" content="width=1242">
        <title>Welcome to Battle</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet"> 
        <link href="<?php echo base_url(); ?>public/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/jquery.mCustomScrollbar.css">
        <link href="<?php echo base_url(); ?>public/css/battle_page_style.css" rel="stylesheet" type="text/css">
        
        <style type="text/css">
            .leftSVG,
            .rightSVG {
                width: 100%;
                height: 410px;
                display: inline-block;
                vertical-align: top;
                position: relative;
            }

            .leftSVG svg,
            .rightSVG svg {
                position: absolute;
                z-index: 2;
            }

            svg #glowRed {
                stroke: #d41713;
                filter: url(#blur-red);
            }

            svg #glowBlue {
                stroke: #0359d0;
                filter: url(#blur-blue);
            }

            .leftSVG img,
            .rightSVG img {
                height: 100%;
            }

            #clipLeftImg,
            #clipRightImg {
                position: absolute;
                z-index: 1;
            }

            #clipLeftImg {
                -webkit-clip-path: url(#svgLeftPath);
                clip-path: url(#svgLeftPath);
            }

            #clipRightImg {
                -webkit-clip-path: url(#svgRightPath);
                clip-path: url(#svgRightPath);
            }
            
            /* Sam adding css */
            .modal-body input {
                color: black;
            }
            .error {
                color: red;
            }
        </style>

        <script type="text/javascript">
            var base_url = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url('public/js/jquery.min.js'); ?>"></script>
    </head>

    <body>