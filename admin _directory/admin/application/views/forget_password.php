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
                Please Enter Your Email Id
            </div>
             <?php if($this->session->flashdata('message')) { ?>
                <p class="text-center error"><?php echo $this->session->flashdata('message');?></p>
                <?php } 
                    $attributes = array('id' => 'forgetpassword');
                    echo form_open('Forgetpassword', $attributes);
                ?>
                <fieldset>
                   
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input class="form-control" type="text" name="email" placeholder="Email">
                <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <a href="<?php echo base_url('login') ?>"> Back to login </a>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <input type="submit" class="btn btn-primary" value="Submit" />
                         
                    </p>
                </fieldset>
             <?php echo form_close();?>  
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->

    
