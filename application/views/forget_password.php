<?php
    $this->load->view('templates/header');
    $this->load->helper('form');
 ?>
<div class="wrapper">
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="logo">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo_v1.png');?>" alt=""/></a>
            </div>
            
                <?php if($this->session->flashdata('message')) { ?>
                <p class="text-center error"><?php echo $this->session->flashdata('message');?></p>
                <?php } 
                    $attributes = array('id' => 'forgetpassword');
                    echo form_open('Forgetpassword', $attributes);
                ?>
            <div class="join_battle_login">
                <h2> Forgot Password </h2>
                
                <input type="text" name="email" placeholder="Email">
                <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                
                <input type="submit" value="Submit">
                
                <ul>
                    <li><a href="<?php echo base_url().'user';?>">Login?</a></li>
                    <li><a href="<?php echo base_url('user/registration');?>" class="hiphop" >Register to BattleMe.hiphop</a></li>
                    <!--<a href="<?php //echo base_url('user/fb_login');?>" class="btn btn-lg btn-info btn-block rounded">Login with facebook</a>--> 
                </ul>
            </div>
            <?php echo form_close();?>                
            
        </div>
    </div>
</div>
</div>
    
<?php
    $this->load->view('templates/footer');
 ?>