<div>
    <h3>Dear Member</h3>
    <p>We are sorry! Your last transaction was cancelled.</p>
    <?php 
            $message = $this->session->userdata('message');
            if ($this->session->userdata('message')) {
        ?>
        <div class="alert <?php echo $this->session->userdata('class') ?>"> 
            <button class="close" data-dismiss="alert">x</button>                
            <?php 
                if(is_array($message)) {
                    echo '<pre>';
                    print_r($message);
                } else { echo $message; } 
            ?>
        </div>
    <?php } ?>
</div>