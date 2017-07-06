<?php
    $this->load->view('templates/header');
    $this->load->helper('form');
    $memberOptStr = "id='membership' class='reg-select-box'" ;
    
    //$battle_category = [ '0' => 'Select the battle categories that you will be battling in', 1 => 'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6=>'Raggeton', 7=>'Latino hip hop', 8=>'Latino songs originals', 9=>'Latino songs covers'];
    $battle_category = $battleCategory;
    $selectStr = 'class="reg-select-box"';
 ?>
<div class="wrapper">
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="logo">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo_v1.png');?>" alt=""/></a>
            </div>
            
                <?php if($this->session->flashdata('success')) { ?>
                <p class="text-muted text-center"><small>
                        <font color="red"><?php echo $this->session->flashdata('success');?></font></small>
                </p>
                
            <?php }  $attributes = array('id' => 'registration');
                    echo form_open('user/registration', $attributes);
                ?>
                
            <div class="join_battle_login">
                <h2> Sign up</h2>
                <!--<h2> Sign up to find interesting things </h2>-->
                
                <input type="text" name="fname" placeholder="First Name" value="<?php echo $this->input->post('fname')?>">
                <?php echo form_error('fname', '<div class="error">', '</div>'); ?>
                
                <input type="text" placeholder="Last Name" name="lname" value="<?php echo $this->input->post('lname')?>">
                <?php echo form_error('lname', '<div class="error">', '</div>'); ?>
                
                <input type="text" placeholder="Email" name="email" value="<?php echo $this->input->post('email')?>">
                <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                
                <input type="password" placeholder="Password" name="password1" >
                <?php echo form_error('password1', '<div class="error">', '</div>'); ?>
                
                <input type="password" placeholder="Re-Type Password" name="password2" >
                <?php echo form_error('password2', '<div class="error">', '</div>'); ?>
                    
               <?php  echo form_dropdown('membership' , $membershipOpt , set_value('membership') , $memberOptStr) ;
                 echo form_error('membership', '<div class="error">', '</div>'); ?>
                
                <div id="member_suggestion" class="member_suggestion"></div>
                
                <div id="battle_cat_area" style="display: none;">
                    <?php 
                        echo form_multiselect('battle_category[]', $battle_category, empty(set_value('battle_category[]')) ? 0 : set_value('battle_category[]'), $selectStr); 
                        echo form_error('battle_category', '<div class="error">', '</div>'); 
                        ?>
                </div>
                 
                <p class="terms-condi"><input type="checkbox" name="terms" >Agree the <a href="<?php echo base_url('page/terms_and_conditions'); ?>" target="_blank">Terms & Policy</a> </p>
                <?php echo form_error('terms', '<div class="error">', '</div>'); ?>
                    
                <input type="submit" value="Sign up">
                
                <ul>
                    <li><a href="<?php echo base_url().'user';?>">Login?</a></li>
                    <li><a href="<?php echo base_url().'forgetpassword';?>">Forgot your password?</a></li>
                    <!--<a href="<?php //echo base_url('user/fb_login');?>" class="btn btn-lg btn-info btn-block rounded">Login with facebook</a>--> 
                </ul>
            </div>
            <?php echo form_close();?>                
            
        </div>
    </div>
</div>
</div>

<?php  $memToolTip = json_encode($membershipTooltip); ?>

<script type="text/javascript">
$(document).ready(function(){

    var mem_tool_tip = <?php echo  $memToolTip; ?>

    $('#membership').change(function() {
        if($(this).val() != 0) {
            $('#member_suggestion').html(mem_tool_tip[$(this).val()]).slideDown();
        } else {
            $('#member_suggestion').html('').slideUp();
        }

        if($(this).val() == 0 || $(this).val() == 3) {
            $('#battle_cat_area').slideUp();
        } else {
            $('#battle_cat_area').slideDown();
        }
    }).change();
});
</script>
    
<?php
    $this->load->view('templates/footer');