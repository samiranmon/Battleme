<?php
    $this->load->view('admin_templates/header');
    $this->load->view('admin_templates/topbar');
    $this->load->view('admin_templates/sidebar');
   $base_url='http://mydevfactory.com/~pranay/samiran/battleme/';
 ?>
<script type="text/javascript" src="<?php echo $base_url; ?>public/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
  selector: 'textarea',  // change this value according to your HTML
  plugins : 'advlist autolink link image lists charmap print preview'
});

</script>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url() ?>">Dashboard</a>
        </li>
        <li>
                <a href="<?php echo base_url(); ?>admin_dashboard/get_emailtemplate_details/">Email Template List</a>
            </li>
    </ul>
</div>
            
<div class=" row">
   
    
 <?php if($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success');?></p>
                <?php }   
                   $id='';
                    $attributes = array('id' => 'editemailtemplate', 'class'=>'form-horizontal');
            echo form_open_multipart('admin_dashboard/save_email_template_details' . '/' . $id, $attributes);
                ?>
<div class=" row">
    <div class="col-md-10 col-sm-10 col-xs-10">
        
  <div class="form-group">
    <label class="control-label col-sm-2" for="pagename">Email Name:</label>
    <div class="col-sm-10">
        
        <input type="text" class="form-control" name="emailname" placeholder="Enter Email Name" value="">
        <?php echo form_error('emailname', '<div class="error">', '</div>'); ?>
    </div>
  </div>
         <div class="form-group">
    <label class="control-label col-sm-2" for="pageurl">Email Subject:</label>
    <div class="col-sm-10">
        
        <input type="text" class="form-control" name="emailsubject" placeholder="Enter Email Subject" value="">
         <?php echo form_error('subject', '<div class="error">', '</div>'); ?>
    </div>
  </div>
        <div class="form-group">
    <label class="control-label col-sm-2" for="pageurl">Email Body:</label>
    <div class="col-sm-10">
         <?php //echo $this->ckeditor->editor('emailcontent',@$default_value);?> <?php echo form_error('emailcontent','<p class="error">'); ?>
        <textarea name="emailcontent"></textarea>
    </div>
  </div>
       
        
        
        
        
        
        <div class="form-group">
    <label class="control-label col-sm-2" for="status">Status:</label>
    <div class="col-sm-10">
        <select class="form-control" name="status" id="status">
            <option value="1" <?php //if($status==1){ echo 'selected' ;} ?> >Active</option>
            <option value="0" <?php //if($status==0){ echo 'selected' ;} ?> >Inactive</option>
        </select>
        
      
    </div>
  </div>
           
        
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" name="submit" class="btn btn-primary"value="Add" />
      
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