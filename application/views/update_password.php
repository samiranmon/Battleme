<?php
    $user_id = $this->session->userdata('logged_in')['id'];
    //$battle_cat = [1 =>'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6 => 'Raggeton', 7=> 'Latino hip hop', 8 => 'Latino songs originals', 9 => 'Latino songs covers'];
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
         
        <header class="panel-heading font-bold">Update Password</header> 
        <div class="panel-body">
            <?php
            $attributes = array('id' => 'editprofile1');
            echo form_open_multipart('profile/update_password' . '/' . $user_id, $attributes);
            ?>
            <!-- fileupload -->
            <!-- <div class="form-group">  -->
            <?php if($user_profile[0]->email == NULL) { ?>
            <div class="form-group"> 
                <label>Email</label> 
                <input type="text" class="form-control" placeholder="Enter Email" name ="email" value="<?php echo $user_profile[0]->email; ?>"> 
                <?php echo form_error('email', '<div class="error">', '</dev>'); ?>
            </div>
            <?php } ?>
            
            <div class="form-group"> 
                <label>Password</label> 
                <input type="password" class="form-control" placeholder="Enter Password" name ="password" value = ""> 
                <?php echo form_error('password', '<div class="error">', '</dev>'); ?>
            </div>
            <div class="form-group"> 
                <label>Confirm Password</label> 
                <input type="password" class="form-control" placeholder="Enter Confirm Password" name ="confirm_password" value = ""> 
                <?php echo form_error('confirm_password', '<div class="error">', '</dev>'); ?>
            </div>
             
            <input type="submit" name="action" value="Update" class="btn btn-success btn-s-xs" >
            <!--<button type="submit" class="btn btn-sm btn-default">Save</button>-->
            <?php echo form_close(); ?>
        </div> 
    </section>
</div>