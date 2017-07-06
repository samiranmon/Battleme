<div>
    <h2>Dear Member</h2>
    <span>Your premium membership has done successfully, Your will billing start from next month.</span><br/>

    <span>Amount Paid /Month: 
        <strong>$<?php echo $payment_amt.' '.$currency_code; ?></strong>
    </span><br/>
    <span>Membership Status : 
        <strong><?php echo $status; ?></strong>
    </span><br/>
    Please login and manage your membership <br>
    <a href="<?php echo base_url() ?>">Login<a/>&nbsp;
        
    <a href="<?php echo base_url().'wallet/' ?>">Go to wallet<a/>
    
</div>