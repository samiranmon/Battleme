<?php
/* $data_submit = array(
    'name' => 'Submit',
    'id' => 'Submit',
    'value' => 'Cancel',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Create'
);

$form_attr = array('name' => '', 'id' => '', 'class' => '' ); */
?>
<?php //echo form_open_multipart('', $form_attr); ?>
<div class="midsection" id="content">
    <div> 
        
        <section class="panel panel-default"> 
            <header class="panel-heading"> 
                <span class="h4">Recurring profile information</span> 
                <?php
                        $message = $this->session->flashdata('message');
                        if (isset($message)) {
                ?>
                    <div class="alert <?php echo $this->session->flashdata('class') ?>">
                        <button class="close" data-dismiss="alert">x</button>
                        <?php if (is_array($message) && !empty($message)) { ?>
                            <?php echo '<pre>'; print_r($message); ?>
                        <?php } else { ?>
                            <?=$message?> 
                        <?php } ?>
                    </div>
                <?php } ?>
            </header> 
            
            <div class="panel-body"> 
                
                <?php 
                    if(isset($recurring_info) && !is_array($recurring_info)) { ?>
                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?=$recurring_info?></label> 
                        </div>
                    </div> 
                <?php } ?>
                
                <?php 
                    if(isset($recurring_info['ERRORS']) && is_array($recurring_info['ERRORS']) && !empty($recurring_info['ERRORS'])) { ?>
                    <div class="form-group"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>
                                <?php 
                                    echo '<pre>';
                                    print_r($recurring_info);
                                ?>
                            </label> 
                        </div>
                    </div> 
                <?php } ?>

                <?php 
                    if(isset($recurring_info) && is_array($recurring_info)) { ?>
                        <?php 
                                    //echo '<pre>';
                                    //print_r($recurring_info);
                                ?>
                
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Profile Id : </label> 
                                 <?=$recurring_info['PROFILEID']?>
                            </div>
                        </div> 
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Profile status : </label> 
                                <?=$recurring_info['STATUS']?>
                            </div>
                        </div> 
                
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Subscriber Name : </label> 
                                 <?=$recurring_info['SUBSCRIBERNAME']?>
                            </div>
                        </div> 
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Profile Started On : </label> 
                                 <?=date('F d, Y  g:i a T', strtotime($recurring_info['PROFILESTARTDATE']))?>
                            </div>
                        </div> 
                
                        <?php if(isset($recurring_info['NEXTBILLINGDATE'])) { ?>
                            <div class="form-group"> 
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>Next Billing Date : </label> 
                                    <?=date('F d, Y  g:i a T', strtotime($recurring_info['NEXTBILLINGDATE']))?>
                                </div>
                            </div> 
                        <?php } ?>
                
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Billing Period : </label> 
                                 <?=$recurring_info['BILLINGPERIOD']?>
                            </div>
                        </div> 
                
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Billing Amount : </label> 
                                 <?=$recurring_info['AMT']?>
                            </div>
                        </div> 
                        <div class="form-group"> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>Currency Code : </label> 
                                 <?=$recurring_info['CURRENCYCODE']?>
                            </div>
                        </div> 
                <?php } ?>
                 
            </div> 

            <footer class="panel-footer text-right bg-light lter"> 
                <?php //echo form_submit($data_submit) 
                    if(isset($recurring_info['STATUS']) && $recurring_info['STATUS']=='Active') {
                ?>
                    <a href="<?=base_url('user/change_profile_status/cancel')?>" class="btn btn-success btn-s-xs">Cancel</a>
                <?php } ?>
                <?php if(isset($recurring_info['STATUS']) && $recurring_info['STATUS']=='Cancelled') { ?>
                    <a href="<?=base_url('user/change_profile_status/reactivate')?>" class="btn btn-success btn-s-xs">Reactivate</a>
                <?php } ?>
                    
                     
                    
            </footer> 
        </section> 

    </div>
</div>

 
<?php //echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
         
       
    });
</script>