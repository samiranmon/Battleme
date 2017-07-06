<?php
    $user_id = $this->session->userdata('logged_in')['id'];
?>
<div class="col-sm-12"> 
    <?php if ($this->session->flashdata('profile_message')) {
        ?>
        <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
            <button class="close" data-dismiss="alert">x</button>                
            <?php echo $this->session->flashdata('profile_message'); ?>
        </div>
    <?php }
    ?>  
    <section class="panel panel-default">
        <div class="panel-body col-sm-12">
            <?php if (($user_profile[0]->cover_picture != '' || $user_profile[0]->cover_picture != NULL) && file_exists('uploads/cover_picture/' . $user_profile[0]->cover_picture)) { ?>
                <img src="<?php echo base_url() . 'uploads/cover_picture/' . $user_profile[0]->cover_picture; ?>" width = "800" height = "250">
            <?php } else { ?>
                <img src="<?php echo base_url('uploads/cover_picture/defaultcover.jpg'); ?>" width = "800" height = "250">
            <?php } ?>
        </div>
        <header class="panel-heading font-bold">Edit Profile</header> 
        <div class="panel-body">
            <?php
            $attributes = array('id' => 'editprofile1');
            echo form_open_multipart('profile/update' . '/' . $user_id, $attributes);
            ?>
            <!-- fileupload -->
            <!-- <div class="form-group">  -->
            <div class="form-group"> 
                <label>Current avtar</label>
                <!-- <input type="file" class="filestyle" data-icon="false" data-classbutton="btn btn-default" data-classinput="form-control inline v-middle input-s" id="filestyle-0" style="position: fixed; left: -500px;"> -->
                <?php if (($user_profile[0]->profile_picture != '' || $user_profile[0]->profile_picture != NULL) && file_exists('uploads/profile_picture/' . $user_profile[0]->profile_picture)) { ?>
                    <img src="<?php echo base_url() . 'uploads/profile_picture/' . $user_profile[0]->profile_picture; ?>" width = "128" height = "128">
                <?php } else { ?>
                    <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" width = "128" height = "128">
                <?php } ?>
            </div>
            <div class="form-group"> 
                <label>Update Avtar</label>
                <input type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" name="profilepicture" > 
                <?php echo form_error('profilepicture'); ?>
            </div>
            <div class="form-group"> 
                <label>Update Cover</label>
                <input type="file" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s" name="cover_picture" > 
                <?php echo form_error('cover_picture'); ?>
            </div>
            <div class="form-group"> 
                <label>First Name</label> 
                <input type="text" class="form-control" placeholder="Enter Firstname" name ="fname" value="<?php echo $user_profile[0]->firstname; ?>"> 
                <?php echo form_error('fname', '<div class="error">', '</dev>'); ?>
            </div>
            <div class="form-group"> 
                <label>Last Name</label> 
                <input type="text" class="form-control" placeholder="Enter Lastname" name ="lname" value = "<?php echo $user_profile[0]->lastname; ?>"> 
                <?php echo form_error('lname', '<div class="error">', '</dev>'); ?>
            </div>
            <div class="form-group"> 
                <label>City</label> 
                <input type="text" class="form-control" placeholder="Enter city" name ="city" value = "<?php echo $user_profile[0]->city; ?>"> 
                <?php echo form_error('city', '<div class="error">', '</dev>'); ?>
            </div>
            <div class="form-group"> 
                <label>Country</label> 
                <input type="text" class="form-control" placeholder="Enter country" name ="country" value = "<?php echo $user_profile[0]->country; ?>"> 
                <?php echo form_error('country', '<div class="error">', '</dev>'); ?>
            </div>
            <div class="form-group"> 
                <label>About me</label> 
                <input type="text" class="form-control" placeholder="About me" name ="aboutme" value = "<?php echo $user_profile[0]->aboutme; ?>"> 
                <?php echo form_error('aboutme', '<div class="error">', '</dev>'); ?>
            </div>
            <div class="form-group">
                <label>Info</label> 
                <textarea class="form-control parsley-validated" rows="6" data-minwords="6" data-required="true" placeholder="About Yourself" name="info"><?php echo $user_profile[0]->info; ?></textarea> 
                <?php echo form_error('info', '<div class="error">', '</dev>'); ?>
            </div>

            <div class="form-group"> 
                <label>Paypal Account Id</label> 
                <input type="text" class="form-control" placeholder="Account Id" name ="paypal_account_id" value = "<?php echo $user_profile[0]->paypal_account_id; ?>"> 
                <?php echo form_error('paypal_account_id', '<div class="error">', '</dev>'); ?>
            </div>


            <input type="submit" name="action" value="Update" class="btn btn-success btn-s-xs" >
            <!--<button type="submit" class="btn btn-sm btn-default">Save</button>-->
            <?php echo form_close(); ?>
        </div> 
    </section>
</div>