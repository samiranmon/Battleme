<?php 
    $sessionData = get_session_data(); 
    $path_name = $this->router->fetch_class().'/'.$this->router->fetch_method();
?>
<div class="clickleftMenu"></div>
<div class="left_side">
    <div class="logo">
        <a href="<?= base_url() ?>"> <img src="<?php echo base_url(); ?>public/images/logo.png" alt=""> </a>
    </div>
    <div class="clickleftMenu1"></div>
    <div class="menumain">
        <ul class="leftMenu">

            <?php if (isset($sessionData)) { ?>
                <li <?php if($path_name == 'home/index') echo 'class="active"'; ?>><a href="<?php echo base_url('home') ?>">Home</a></li>
                <li <?php if($path_name == 'profile/index') echo 'class="active"'; ?>> <a href="<?php echo base_url('profile') ?>"> Profile</a></li>
                <li <?php if($path_name == 'user/notifications') echo 'class="active"'; ?>><a href="<?php echo base_url('user/notifications') ?>">Notifications</a></li>
                <li <?php if($path_name == 'aboutus/index') echo 'class="active"'; ?>> <a href="<?php echo base_url('aboutus') ?>"> About</a> </li>
                <li <?php if($path_name == 'tournament/all') echo 'class="active"'; ?>> <a href="<?php echo base_url('tournament/all') ?>">Tournaments</a> </li>
            <?php } ?>

            <li <?php if($path_name == 'battle/category') echo 'class="active"'; ?>> 
                <a href="javascript:void(0)" class="auto"> Battles </a> 
                <ul >
                    <li > 
                        <a href="<?= base_url('battle/all/cash-battle') ?>"  > 
                            <span>Cash Battles</span> 
                        </a> 
                    </li>
                    <li > 
                        <a href="<?= base_url('battle/all/regular-battle') ?>"  > 
                            <span>Regular Battles</span> 
                        </a> 
                    </li>
                </ul>
            </li>

            <?php if ($sessionData['user_type'] == 'artist' && isset($sessionData)) { ?>
                <li <?php if($path_name == 'battle/create') echo 'class="active"'; ?>> 
                    <a href="<?= base_url('battle/create') ?>"> 
                        <span class="font-bold">Create Battle</span> 
                    </a> 
                </li>
                
                <li <?php if($path_name == 'battle/index') echo 'class="active"'; ?>> 
                    <a href="javascript:void(0)" class="auto">My Battles </a> 
                    <ul >
                        <li > 
                            <a href="<?=base_url('battle') ?>"  > 
                                <span>My Battles</span> 
                            </a> 
                        </li>
                        <li > 
                            <a href="<?=base_url('battle/freestyle_library') ?>"  > 
                                <span>Freestyle Library</span> 
                            </a> 
                        </li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($sessionData['user_type'] == 'artist' && isset($sessionData)) { ?>
                <li <?php if($path_name == 'tournament/index') echo 'class="active"'; ?>> <a href="<?php echo base_url('tournament') ?>"> My Tournaments</a> </li>
            <?php } ?>

        </ul>
    </div>
</div>