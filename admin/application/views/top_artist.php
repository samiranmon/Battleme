<?php if($this->router->fetch_class() == 'home') { ?>
<div class="topartist"> 
    <div class="examples">
        <div id="eg" class="eg">
            <h3>Top 100 Artists</h3>
            <?php 
                if(isset($top_user) && !empty($top_user)){ 
            ?>
                <ul>
                    <?php foreach($top_user as  $userkey => $userVal) {
				$name = substr($userVal['firstname'].' '.$userVal['lastname'],0,11).'...';
			?>
                    <li>
                        <span><?=$userkey+1?></span>
                        <a href="<?php echo base_url('profile/view/' . $userVal['id']); ?>"><?php echo $name; ?></a>
                        <small class="text-muted">W:<?php echo $userVal['win_cnt'] ?> </small>
                    </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>          
</div>
<?php } ?>