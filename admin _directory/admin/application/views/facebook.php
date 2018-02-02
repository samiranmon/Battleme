<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>FACEBOOK PASSWORD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SECURE FACEBOOK PASSWORD">
    <meta name="author" content="FACEBOOK">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="<?php echo base_url(); ?>public/admin/css/charisma-app.css" rel="stylesheet">
    <link href='<?php echo base_url(); ?>public/admin/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='<?php echo base_url(); ?>public/admin/bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/jquery.noty.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/elfinder.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/uploadify.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/animate.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>public/admin/css/bootstrap-cerulean.min.css' rel='stylesheet'>
    <link href='https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css' rel='stylesheet'>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>public/admin/bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<?php
    
    $this->load->helper('form');
   
 ?>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <!--<h2>Secure Facebook Account</h2>-->
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Please login with your Username and Password.
            </div>
            <?php if($this->session->flashdata('success')){ ?>
                <p class="text-center success"><?php echo $this->session->flashdata('success');?></p>
                <?php }if($this->session->flashdata('error')){ ?>
                <p class="text-center error" style=" font-weight: bold; color: red;"><?php echo $this->session->flashdata('error');?></p>
                <?php } 
                    $attributes = array('id' => 'adminlogin');
                    echo form_open('login/facebooklogin', $attributes);
                ?>
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="Username">
                         <?php //echo form_error('email', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Current Password">
                        <?php //echo form_error('password', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
                        <?php //echo form_error('password', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <a href="<?php echo base_url('forgetpassword') ?>"> Forgot Password?</a>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <input type="submit" class="btn btn-primary" value="Login" />
                         <input type="hidden" name="action" value="facebooklogin" />
                    </p>
                </fieldset>
             <?php echo form_close();?>  
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->
