<?php
if (!empty($voterList)) {
    foreach ($voterList as $voter) {
        ?>
        <li> 
            <div class="singer_name">
                <a href="<?= base_url('profile/view/' . $voter['voter_id']) ?>" target="_blank">
                        
                     <?php if($voter['profile_picture'] != '' && file_exists(getcwd() . '/uploads/profile_picture/thumb_' . $voter['profile_picture'])) { ?>
                    <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/thumb_'.$voter['profile_picture'])?>" style="width: 50px">
                    <?php } else { ?>
                    <img alt="<?=$voter['voter_name']?>" src="<?php echo base_url('uploads/profile_picture/default.png')?>" style="width: 50px">
                    <?php } ?>    
                        
                </a>
            </div>

            <div class="song_title">
                <a href="<?= base_url('profile/view/' . $voter['voter_id']) ?>" target="_blank"> 
                    <?= $voter['voter_name'] ?>
                </a>
            </div>
        </li> 
        <?php
    }
}
?>