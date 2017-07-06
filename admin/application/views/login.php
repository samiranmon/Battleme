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
                Please login with your Username and Password.
            </div>
            <?php if($this->session->flashdata('success')){ ?>
                <p class="text-center success"><?php echo $this->session->flashdata('success');?></p>
                <?php }if($this->session->flashdata('error')){ ?>
                <p class="text-center error" style=" font-weight: bold; color: red;"><?php echo $this->session->flashdata('error');?></p>
                <?php } 
                    $attributes = array('id' => 'adminlogin');
                    echo form_open('login/adminlogin', $attributes);
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
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <?php //echo form_error('password', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <a href="<?php echo base_url('forgetpassword') ?>"> Forgot Password?</a>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <input type="submit" class="btn btn-primary" value="Login" />
                         <input type="hidden" name="action" value="adminlogin" />
                    </p>
                </fieldset>
             <?php echo form_close();?>  
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->
