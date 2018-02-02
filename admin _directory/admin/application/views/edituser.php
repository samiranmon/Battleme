<?php
    $this->load->view('admin_templates/header');
    $this->load->view('admin_templates/topbar');
    $this->load->view('admin_templates/sidebar');
   $base_url='http://mydevfactory.com/~pranay/samiran/battleme/';
 ?>
<script src="<?php echo base_url(); ?>public/admin/admin_js/script-for-delivery-cost-management.js"></script>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url() ?>">Dashboard</a>
        </li>
        <li>
                <a href="<?php echo base_url(); ?>admin_dashboard/get_user_details/">User List</a>
            </li>
    </ul>
</div>
            
<div class=" row">
   
    
 <?php if($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success');?></p>
                <?php }   
                   
                    $attributes = array('id' => 'editprofile1', 'class'=>'form-horizontal');
            echo form_open_multipart('admin_dashboard/save_user_details' . '/' . $id, $attributes);
                ?>
<div class=" row">
    <div class="col-md-10 col-sm-10 col-xs-10">
        
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">First Name:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter First Name" value="<?php echo $firstname?>">
      <?php echo form_error('firstname', '<div class="error">', '</div>'); ?>
    </div>
  </div>
            <div class="form-group">
    <label class="control-label col-sm-2" for="email">Last Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="lastname" value="<?php echo $lastname?>" id="lastname" placeholder="Enter Last Name">
      <?php echo form_error('lastname', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        
  
        
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Profile Image:</label>
    <div class="col-sm-10">
        <?php if (($profile_picture != '')) { ?>
                                    <img src="<?php echo $base_url; ?>/uploads/profile_picture/<?php echo $profile_picture?>" style="height: 50px; width: 50px;" />
                                 <?php } else { ?>
                                    <img id="coverContainer" src="<?php echo $base_url;?>uploads/profile_picture/default.png" width = "50" height = "50">
                                 <?php } ?>
        
        <input type="file" name="profilepicture" size="20" />
       <div class="charpic">
                                           
                                        </div>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Cover Image:</label>
    <div class="col-sm-10">
        <?php if (($cover_picture != '')) { ?>
                                    <img src="<?php echo $base_url; ?>/uploads/cover_picture/<?php echo $cover_picture?>" style="height: 250px; width: 800px;" />
                                 <?php } else { ?>
                                    <img id="coverContainer" src="<?php echo $base_url;?>uploads/cover_picture/defaultcoveradmin.jpg" width = "800" height = "250">
                                 <?php } ?>
        
        <input type="file" name="cover_picture" size="20" />
       <div class="charpic">
                                           
                                        </div>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Coins :</label>
    <div class="col-sm-10">
        <input name="coins" type="text" value="<?php echo $coins?>" class="form-control" id="phone_no" placeholder="Enter Coins">
         <?php echo form_error('coins', '<div class="error">', '</div>'); ?>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Phone No:</label>
    <div class="col-sm-10">
        <input name="phone_no" type="text" value="<?php echo $phone_no?>" class="form-control" id="phone_no" placeholder="Enter Phone">
         <?php echo form_error('phone_no', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">City:</label>
    <div class="col-sm-10">
        <input name="city" type="text" value="<?php echo $city?>" class="form-control" id="phone_no" placeholder="Enter city">
         <?php echo form_error('city', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Country:</label>
    <div class="col-sm-10">
        <input name="country" type="text" value="<?php echo $country?>" class="form-control" id="country" placeholder="Enter country">
         <?php echo form_error('country', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">About me:</label>
    <div class="col-sm-10">
        <input name="aboutme" type="text" value="<?php echo $aboutme?>" class="form-control" id="phone_no" placeholder="Enter About Me">
         <?php echo form_error('aboutme', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Info:</label>
    <div class="col-sm-10">
        <input name="info" type="text" value="<?php echo $info?>" class="form-control" id="info" placeholder="Enter info">
         <?php echo form_error('info', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Paypal account ID:</label>
    <div class="col-sm-10">
        <input name="paypal" type="text" value="<?php echo $paypal_account_id?>" class="form-control" id="paypal" placeholder="Enter paypal account">
         <?php echo form_error('paypal', '<div class="error">', '</div>'); ?>
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
</div>





    <!-- content ends -->
    </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->

    

    <hr>

<!--    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here settings can be configured...</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a>
                </div>
            </div>
        </div>
    </div>-->
 
<?php
    $this->load->view('admin_templates/footer');
   
 ?>