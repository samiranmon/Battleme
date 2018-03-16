<style type="text/css">
    .own-song-list > li{
        width: 100%; float: left; display: inline-block; 
    }
    .own-song-list span {
        float: left;
        margin-right: 6px;
    }
    .required {
        color: red;
    }
</style>
<script src="<?php echo base_url() ?>public/js/parsley/parsley.min.js"></script>
<script src="<?php echo base_url() ?>public/js/parsley/parsley.extend.js"></script>
<?php
$selectStr = 'class="form-control"';

$name = array(
    'name' => 'name',
    'id' => 'name',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Your name',
    'value' => set_value('name')==null?$user_dtl['name']:set_value('name'),
    'data-required' => 'true'
);
$email = array(
    'name' => 'email',
    'id' => 'email',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Email Id',
    'value' => set_value('email')==null?$user_dtl['email']:set_value('email'),
    'data-required' => 'true'
);
$message = array(
    'name' => 'message',
    'id' => 'message',
    'class' => 'form-control',
    'maxlength' => '225',
    'rows' => '4',
    'cols' => '50',
    'placeholder' => 'Message',
    'value' => set_value('message'),
    'data-required' => 'true'
);

$subject = array(
    'name' => 'subject',
    'id' => 'subject',
    'class' => 'form-control',
    'maxlength' => '125',
    'placeholder' => 'Subject',
    'value' => set_value('subject'),
    'data-required' => 'true'
);

$data_submit = array(
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Send',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Send'
);

$form_attr = array('name' => 'frm_touch', 'id' => 'frm_touch', 'class' => '', 'data-validate' => 'parsley');
?>
<?php echo form_open_multipart('contactUs/get_in_touch', $form_attr); ?>
<div class="midsection" id="content">
    <div> 

        <section class="panel panel-default"> 
            <header class="panel-heading"> 
                <span class="h4">GET IN TOUCH</span> 
                <!--</br> <small>Fix charge of 10 coins will be charged after accepting challenge</small>-->
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

            </header> 
            <div class="panel-body"> 


                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Your Name</label> 
                        <?php echo form_input($name); ?>
                    </div>
                </div> 

                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Email</label> 
                        <?php echo form_input($email); ?>
                    </div>
                </div> 
                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Subject</label> 
                        <?php echo form_input($subject); ?>
                    </div>
                </div> 
                
                <div class="form-group"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Message</label> 
                        <?php echo form_textarea($message); ?>
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
    $(document).ready(function () {

    });
</script>