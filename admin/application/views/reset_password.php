<?php
    $this->load->view('admin_templates/header');
    $this->load->helper('form');
   
 ?>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to Battleme Admin Panel</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Reset Password
            </div>
            <?php  
            	    error_reporting(0);
                    $attributes = array('id' => 'resetpassword');
                    echo form_open('forgetpassword/update_password/'.$id, $attributes);
                ?>
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="password" name="password1" placeholder="New Password" class="form-control rounded input-lg text-center no-border">
                        <?php echo form_error('password1'); ?>
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                       <input type="password" name="password2" placeholder="confirm Password" class="form-control rounded input-lg text-center no-border">
                        <?php echo form_error('password2'); ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <a href="<?php echo base_url('forgetpassword') ?>"> Forgot Password?</a>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <input type="submit" class="btn btn-primary" value="Reset" />
                         
                    </p>
                </fieldset>
             <?php echo form_close();?>  
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->
