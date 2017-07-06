<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>
<style type="text/css">
    .like-place {
        float: left;
        width: 50%;
    }
</style>
<div class="midsection">
    <h4 class="battle-list-heading"><?php echo $page_details['pagename'] ?></h4>

    <?php if ($this->session->flashdata('message')) { ?>
        <div class="alert <?php echo $this->session->flashdata('class') ?>">
            <button class="close" data-dismiss="alert">x</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('reg_error_message')) { ?>
        <div class="error" style="clear: both;    text-align: center;">
            <?php echo $this->session->flashdata('reg_error_message'); ?>
        </div>
    <?php } ?>
    <div class="battle-list-block">
        <!-- Nav tabs -->
         
        <!-- Tab panes -->
        <div class="tab-content">
            <?php echo $page_details['pagecontent'] ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>