<style type="text/css">
    .own-song-list > li{
        width: 100%; float: left; display: inline-block; 
    }
    .own-song-list span {
        float: left; margin-right: 6px;
}
</style>
<script src="<?php echo base_url() ?>public/js/parsley/parsley.min.js"></script>
<script src="<?php echo base_url() ?>public/js/parsley/parsley.extend.js"></script>
<?php
$selectStr = 'class="form-control"';

$friend_email = array(
    'name' => 'friend_email',
    'id' => 'friend_email',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => "Friend's Email",
    'value' => set_value('friend_email'),
    'data-required' => 'true'
);
 
$data_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Invite',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Create'
);

$form_attr = array('name' => 'frm_battle', 'id' => 'frm_battle', 'class' => '', 'data-validate' => 'parsley');
?>
<?php echo form_open_multipart('', $form_attr); ?>
<div class="midsection" id="content">
    <div> 
        
        <section class="panel panel-default"> 
            
            <?php
                // echo "<pre>";
                // print_r($battleList);
                if ($this->session->flashdata('message')) {
                    ?>
                    <div class="alert <?php echo $this->session->flashdata('class') ?>">
                        <button class="close" data-dismiss="alert">x</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>
            
            <header class="panel-heading"> 
                <span class="h4">Refer a friend</span> 
            </header> 
            
            <div class="panel-body"> 
                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Friend's Email</label> 
                        <?php echo form_input($friend_email); ?>
                        <?php echo form_error('friend_email', '<div class="error">', '</div>'); ?>
                    </div>
                </div> 
            </div> 

            <footer class="panel-footer text-right bg-light lter"> 
                <?php echo form_submit($data_submit) ?>
            </footer> 
        </section> 

    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () { });
</script>