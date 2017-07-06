<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();

$battleType = $this->uri->segment(3);
if(!($battleType == 'regular-battle' || $battleType == 'cash-battle')) 
    redirect('home');

?>


<div class="midsection">
    
    <h4 class="font-thin m-l-md m-t">Battle categories</h4> <br>

    <div class="doc-buttons">
        <?php if(isset($battle_category)) { 
                foreach ($battle_category as $k=>$btl) {
            ?>
        <a href="<?=base_url('battle/all/'.$battleType.'/'.base64_encode($k))?>" class="btn btn-md btn-success" ><?=$battle_category[$k]?></a>
        <?php } } ?>
    </div>



    <div class="clearfix"></div>
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
    <br><br>
    <div class="error" style="clear: both;    text-align: center;">                   
        <?php echo $this->session->flashdata('reg_error_message'); ?>
    </div>



</div>