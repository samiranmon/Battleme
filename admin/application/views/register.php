<?php
    $this->load->view('templates/header');
    $this->load->helper('form');
    $memberOptStr = "id='membership' class='form-control rounded input-lg text-center no-border'" ;
 ?>
<div class="wrapper">
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="logo">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo_v1.png');?>" alt=""/></a>
            </div>
            
                <?php if($this->session->flashdata('success')) { ?>
                <p class="text-muted text-center"><small>
                        <font color="red"><?php echo $this->session->flashdata('success');?></font></small>
                </p>
                
            <?php }  $attributes = array('id' => 'registration');
                    echo form_open('user/registration', $attributes);
                ?>
                
            <div class="join_battle_login">
                <h2> Sign up</h2>
                <!--<h2> Sign up to find interesting things </h2>-->
                
                <input type="text" name="fname" placeholder="First Name" value="<?php echo $this->input->post('fname')?>">
                <?php echo form_error('fname', '<div class="error">', '</div>'); ?>
                
                <input type="text" placeholder="Last Name" name="lname" value="<?php echo $this->input->post('lname')?>">
                <?php echo form_error('lname', '<div class="error">', '</div>'); ?>
                
                <input type="text" placeholder="Email" name="email" value="<?php echo $this->input->post('email')?>">
                <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                
                <input type="password" placeholder="Password" name="password1" >
                <?php echo form_error('password1', '<div class="error">', '</div>'); ?>
                
                <input type="password" placeholder="Re-Type Password" name="password2" >
                <?php echo form_error('password2', '<div class="error">', '</div>'); ?>
                    
               <?php  echo form_dropdown('membership' , $membershipOpt , '1' , $memberOptStr) ;
                 echo form_error('membership', '<div class="error">', '</div>'); ?>
                 
                <input type="checkbox" name="terms" ><i></i> Agree the <a href="javascript:void(0)">Terms & Policy</a> 
                <?php echo form_error('terms', '<div class="error">', '</div>'); ?>
                    
                <input type="submit" value="Sign up">
                
                <ul>
                    <li><a href="<?php echo base_url().'user';?>">Login?</a></li>
                    <li><a href="<?php echo base_url().'forgetpassword';?>">Forgot your password?</a></li>
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