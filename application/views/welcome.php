<div class="col-sm-12"> 
    <?php 
    
            //echo $this->session->userdata('buy_message');
            if ($this->session->userdata('buy_message')) {
        ?>
        <div class="alert <?php echo $this->session->userdata('class') ?>"> 
            <button class="close" data-dismiss="alert">x</button>                
            <?php echo $this->session->userdata('buy_message'); ?>
        </div>
    <?php } ?>
</div>