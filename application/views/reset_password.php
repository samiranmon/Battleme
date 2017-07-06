<!DOCTYPE html>
<html lang="en" class="bg-info">
<!-- Mirrored from flatfull.com/themes/musik/signin.html by HTTrack Website Copier/3.x [XR&CO'2007], Sun, 26 Apr 2015 01:19:41 GMT -->
<?php
    $this->load->view('templates/header');
    $this->load->helper('form');
 ?>


<body class="bg-info">
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xl">
            <a class="" href="<?php echo base_url();?>" style="margin-left:20%;">
               <img src="<?php echo base_url();?>public/images/logo-battle.png" alt="BatleMe.org" class="">
           </a> 
            <section class="m-b-lg">
                <header class="wrapper text-center"> <strong>Reset Password</strong> 
                </header>
                <?php  
                    $attributes = array('id' => 'resetpassword');
                    echo form_open('forgetpassword/update_password/'.$id, $attributes);
                ?>
                    <div class="form-group">
                        <input type="password" name="password1" placeholder="New Password" class="form-control rounded input-lg text-center no-border">
                        <?php echo form_error('password1'); ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password2" placeholder="confirm Password" class="form-control rounded input-lg text-center no-border">
                        <?php echo form_error('password2'); ?>
                    </div>
                    <button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Reset</span>
                    </button>
                    
                <?php echo form_close();?>
            </section>
        </div>
    </section>
 <?php
    $this->load->view('templates/footer');
 ?>
</body>
</html>