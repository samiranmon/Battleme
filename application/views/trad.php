<?php
$form_attr = array('name' => 'trad_form', 'id' => 'trad_form', 'class' => '', 'data-validate' => 'parsley');

$data_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Submit',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Pay'
);
?>

<div class="midsection">
    <?php 
     //$this->session->set_userdata('error', '');
     $success_msg = $this->session->userdata('fund_success');
     $error_msg   = $this->session->userdata('fund_error');
    
    
    if(isset($success_msg)){ ?>
    <p class="text-center success"><?php echo $success_msg;?></p>
    <?php $this->session->set_userdata('fund_success', null); } ?> 
        
        <?php if(isset($error_msg)) { ?>
    <p class="text-center error"> 
        <?php 
                //echo '<pre>'; print_r($error_msg[0]);
                echo isset($error_msg[0]['Message'])? $error_msg[0]['Message'] : 'Error has been occurred !';
                $this->session->set_userdata('fund_error', null);
        ?>
    </p>
    <?php  } ?>
    
    
    
    

    <div class="balance_battle">Upload script</div>

    <?php echo form_open_multipart('', $form_attr); ?>
    <div class="row">
        <div class="col-md-12">
        <div class="thumbnail">
            <div class="thumbnail_heading">Script sheet</div>
            <div class="caption">
                <div class="amount_field_text">
                    <input type="file" name="sheet" required="" size="20" />
                </div>
                <?php echo form_submit($data_submit) ?>
            </div>
        </div>
    </div>
    </div>
    <?php echo form_close(); ?>
    
</div> 