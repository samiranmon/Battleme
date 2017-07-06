<?php
$form_attr = array('name' => 'add_coins', 'id' => 'add_coins', 'class' => '', 'data-validate' => 'parsley');

$data_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Pay',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Pay'
);

$refund_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Cash out',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Cash out'
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
    
    
    
    

    <div class="balance_battle"><?php echo 'Balance battle bucks: ' . $user['coins']; ?></div>

<!--<br><br> $1 = <?//php echo coinsCurrencyRatio.' coins'; ?>  <br><br>
<br><br> $1.10 = 1 Battle Bucks <br><br>-->

     
     

    <?php echo form_open('', $form_attr); ?>
    <div class="row">
        <div class="col-md-12">
        <div class="thumbnail">
            <div class="thumbnail_heading">Add battle bucks</div>
            <!--<img src="< ?php echo base_url().'assets/images/'.$product['image']; ?>" alt="">-->
            <div class="caption">
                <div class="amount_field_text">
                    <div class="amount_field">$ <input name="amount" min="1" step="1" value="1" type="number" /></div>
                <h4 class="amout_text"><a href="javascript:void(0);"><?php echo 'Amount'; ?></a></h4> 
                </div>
                <?php echo form_submit($data_submit) ?>
            </div>
        </div>
    </div>
    </div>
    <?php echo form_close(); ?>
    
    
    
    <!-- for start fund transfer -->
    <?php echo form_open('fund_transfer'); ?>
    <div class="row">
        <div class="col-md-12">
        <div class="thumbnail">
            <!--<img src="< ?php echo base_url().'assets/images/'.$product['image']; ?>" alt="">-->
            <div class="thumbnail_heading">Fund transfer to your account</div> 
            <div class="caption">
                <div class="amount_field_text">
                    <div class="amount_field">$ <input name="amount" min="1" step="1" value="1" type="number"  value="<?php echo set_value('amount'); ?>" /></div>
                <?php echo form_error('amount', '<div class="error">', '</div>'); ?>

                <h4 class="amout_text"><a href="javascript:void(0);"><?php echo 'Amount'; ?></a></h4>
                </div>
                <?php echo form_submit($refund_submit) ?>
            </div>
        </div>
    </div>
    </div>
    <?php echo form_close(); ?>
    <!-- for End fund transfer -->
    
</div> 