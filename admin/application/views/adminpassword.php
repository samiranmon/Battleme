<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
?>
<style>
    .error{
        color: red;
        font-weight: bold;
    }
</style>
<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
    <!-- content starts -->
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Profile</a>
            </li>
        </ul>
    </div>
    <?php if ($this->session->flashdata('error')) { ?>
        <p class="text-center" style=" color: red; font-weight: bold"><?php echo $this->session->flashdata('error'); ?></p>
    <?php
    }
     if ($this->session->flashdata('Success')) { ?>
        <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success'); ?></p>
    <?php
    }
    $attributes = array('id' => 'profile', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data');
    echo form_open('changeadminpassword/reset', $attributes);
    ?>
    <div class=" row">
        <div class="col-md-10 col-sm-10 col-xs-10">

            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Current password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Enter Current Password" value="">
                    <?php echo form_error('cpassword', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">New password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="npassword" value="" id="npassword" placeholder="Enter New Password">
                    <?php echo form_error('npassword', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Confirm New password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="cnpassword" value="" id="cnpassword" placeholder="Confirm New Password">
                    <?php echo form_error('cnpassword', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <input type="submit" name="submit" class="btn btn-primary" value="Change Password" />

                </div>
            </div>

        </div>
        <div class="col-md-2 col-sm-2 col-xs-2">

        </div>

    </div>


    <?php echo form_close(); ?>  


    <!-- content ends -->
</div><!--/#content.col-md-0-->
</div><!--/fluid-row-->



<hr
    <?php
    $this->load->view('admin_templates/footer');
    ?>