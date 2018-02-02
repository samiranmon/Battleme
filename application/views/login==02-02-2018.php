<?php
    $this->load->view('templates/header');
    $this->load->helper('form');
    $this->config->load('config_facebook');
 ?>
<style type="text/css">
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-transition-delay: 9999s;
        -webkit-transition: color 9999s ease-out, background-color 9999s ease-out;
    }
</style>
<script type="text/javascript">
    window.fbAsyncInit = function() {
    //Initiallize the facebook using the facebook javascript sdk
    FB.init({
    appId:'<?=$this->config->item('appID')?>',
    cookie:true, // enable cookies to allow the server to access the session
    status:true, // check login status
    xfbml:true, // parse XFBML
    oauth: true, //enable Oauth
    version: 'v2.12'
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
    $(document).ready(function(){
        $('#facebook_login').click(function(e) {
            FB.login(function(response) {
                if (response.status === 'connected'){ 
                    FB.api('/me?fields=id,email,name', function(data) {
                        //console.log( data) // it will not be null ;)
                        if(data.id !='' && data.name!='') { 
                             $.ajax({
                                type: "POST",
                                url: "<?php echo base_url() ?>fb/fb_api_login/",
                                //data: {data_id: data.id, name: data.name, email: data.email},
                                data: {data: data},
                                success: function (data) {
                                    //alert(data);
                                    if(data == 1) {
                                        window.location = "<?php echo base_url() ?>home/";
                                    }
                                }
                            });
                        }
                        
                    }, {scope: 'email'}) 
                }
            });
        });
        
        if($(window).width() <= 767){
            var wraperHeight = $(window).height();
            $(".wrapper").height(wraperHeight);
        }
    });
</script>




<div class="wrapper">
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <div class="logo">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo_v1.png');?>" alt=""/></a>
            </div>
            <div class="facebook_image">
                <a href="javascript:void(0)"><img id="facebook_login" src="<?php echo base_url('public/images/fb_image.png');?>" alt=""/></a>
            </div>
            
            <?php if($this->session->flashdata('success')){ ?>
                <p class="text-center success"><?php echo $this->session->flashdata('success');?></p>
                <?php }if($this->session->flashdata('error')){ ?>
                <p class="text-center error"><?php echo $this->session->flashdata('error');?></p>
                <?php } 
                    $attributes = array('id' => 'login');
                    echo form_open('user/login', $attributes);
                ?>
            <div class="join_battle_login">
                <h2>Join the Battle</h2>
                
                <input type="text" name="email" placeholder="Email">
                <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                
                <input type="password" name="password" placeholder="Password">
                <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                
                <input type="submit" value="Sign in">
                <input type="hidden" name="action" value="login" />
                
                <ul>
                    <li><a href="<?php echo base_url().'forgetpassword';?>">Forgot your password?</a></li>
                    <li><a href="<?php echo base_url('user/registration');?>" class="hiphop" >Register to BattleMe.hiphop</a></li>
                    <!--<a href="<?php //echo base_url('user/fb_login');?>" class="btn btn-lg btn-info btn-block rounded">Login with facebook</a>--> 
                </ul>
            </div>
            <?php echo form_close();?>                
            
        </div>
    </div>
</div>
</div>
    
<?php $this->load->view('templates/footer');