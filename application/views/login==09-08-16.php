<!DOCTYPE html>
<html lang="en" class="bg-info">
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
               
                
                
<img src="<?php echo base_url('public/images/fb_login.png');?>" id="facebook_login">

<script type="text/javascript">
window.fbAsyncInit = function() {
//Initiallize the facebook using the facebook javascript sdk
FB.init({
appId:'<?php $this->config->load('config_facebook'); echo $this->config->item('appID');?>',
cookie:true, // enable cookies to allow the server to access the session
status:true, // check login status
xfbml:true, // parse XFBML
oauth: true //enable Oauth
});
};
//Read the baseurl from the config.php file
(function(d){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/en_US/all.js";
ref.parentNode.insertBefore(js, ref);
}(document));
//Onclick for fb login
$('#facebook_login').click(function(e) {
 
FB.login(function(response) {
if(response.authResponse) {
parent.location ='<?php echo base_url('fb/fblogin'); ?>'; //redirect uri after closing the facebook popup
}
},{scope: 'email,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
});
</script>

                <header class="wrapper text-center"> <strong>Sign in to get in touch</strong> 
                </header>
                <?php if($this->session->flashdata('success')){ ?>
                <p class="text-center success"><?php echo $this->session->flashdata('success');?></p>
                <?php }if($this->session->flashdata('error')){ ?>
                <p class="text-center error"><?php echo $this->session->flashdata('error');?></p>
                <?php } 
                    $attributes = array('id' => 'login');
                    echo form_open('user/login', $attributes);
                ?>
                    <div class="form-group">
                        <input name="email" type="email" placeholder="Email" class="form-control rounded input-lg text-center no-border">
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control rounded input-lg text-center no-border">
                        <?php echo form_error('password'); ?>
                    </div>
                    <button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Sign in</span>
                    </button>
                    <input type="hidden" name="action" value="login" />
                    <div class="text-center m-t m-b"><a href="<?php echo base_url().'forgetpassword';?>"><small>Forgot password?</small></a>
                    </div>
                    <div class="line line-dashed"></div>
                    <p class="text-muted text-center"><small>Do not have an account?</small>
                    </p>
                    <!--<a href="<?php //echo base_url('user/fb_login');?>" class="btn btn-lg btn-info btn-block rounded">Login with facebook</a>--> 
                    <a href="<?php echo base_url('user/registration');?>" class="btn btn-lg btn-info btn-block rounded">Create an account</a> 
            
                <?php echo form_close();?>
            </section>
        </div>
    </section>
 <?php
    $this->load->view('templates/footer');
 ?>
</body>
</html>