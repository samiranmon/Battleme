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
            <a href="<?= base_url() ?>">Dashboard</a>
        </li>
        
    </ul>
</div>
          
            <?php if($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success');?></p>
                <?php }   
                    $attributes = array('id' => 'profile', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data');
                    echo form_open('profile/saveprofile', $attributes);
                ?>
<div class=" row">
    <div class="col-md-10 col-sm-10 col-xs-10">
        
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $name?>">
      <?php echo form_error('name', '<div class="error">', '</div>'); ?>
    </div>
  </div>
            <div class="form-group">
    <label class="control-label col-sm-2" for="email">Email:</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email" value="<?php echo $email?>" id="email" placeholder="Enter Email">
      <?php echo form_error('email', '<div class="error">', '</div>'); ?>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Image:</label>
    <div class="col-sm-10">
        <img src="<?php echo base_url(); ?>/uploads/<?php echo $logo?>" style="height: 200px; width: 200px;" />
        <input type="file" name="userfile" size="20" />
       <?php if($this->session->flashdata('message')) { ?>
            <p class="text-center" style=" color: red; font-weight: bold"><?php 
            $error=array();
            $error=$this->session->flashdata('message');
            print_r($error['error']);
            ?></p>
                <?php }  ?>
    </div>
  </div>
        
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Phone No:</label>
    <div class="col-sm-10">
        <input name="phone" type="text" value="<?php echo $phone?>" class="form-control" id="pwd" placeholder="Enter Phone">
         <?php echo form_error('phone', '<div class="error">', '</div>'); ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" name="submit" class="btn btn-primary"value="Update" />
      
    </div>
  </div>

    </div>
    <div class="col-md-2 col-sm-2 col-xs-2">
        
    </div>

</div>


 <?php echo form_close();?>  


    <!-- content ends -->
    </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->

    

    <hr
<?php
    $this->load->view('admin_templates/footer');
   
 ?>