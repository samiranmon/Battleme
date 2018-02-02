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
            <a href="<?php echo base_url(); ?>admin_dashboard/get_membership_details/">Membership Details</a>
        </li>
    </ul>
</div>
            
<div class=" row">
   
    
 <?php if($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success');?></p>
                <?php }   
                   
                    $attributes = array('id' => 'editprofile1', 'class'=>'form-horizontal');
            echo form_open_multipart('admin_dashboard/save_membership_details' . '/' . $id, $attributes);
                ?>
<div class=" row">
    <div class="col-md-10 col-sm-10 col-xs-10">
        
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Membership Name:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="membership" id="membership" placeholder="Enter Membership" value="<?php echo $membership?>">
      <?php echo form_error('membership', '<div class="error">', '</div>'); ?>
    </div>
  </div>
            <div class="form-group">
    <label class="control-label col-sm-2" for="email">Description:</label>
    <div class="col-sm-10">
        <textarea class="form-control" name="description" id="description" style=" height: 140px;">
            <?php echo $description?>
        </textarea>
      
      <?php echo form_error('description', '<div class="error">', '</div>'); ?>
    </div>
  </div>
 
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Membership Days:</label>
    <div class="col-sm-10">
      
        <input name="membership_days" type="number" value="<?php echo $membership_days?>" class="form-control" id="membership_days" placeholder="Enter Membership Days">
         <?php echo form_error('membership_days', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Membership Amount:</label>
    <div class="col-sm-10">
        <input name="membership_amount" type="number" value="<?php echo $membership_amount?>" class="form-control" id="membership_amount" placeholder="Enter Membership Amount">
         <?php echo form_error('membership_amount', '<div class="error">', '</div>'); ?>
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