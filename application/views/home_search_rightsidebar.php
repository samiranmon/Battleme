<ul class="list-group no-bg no-borders auto m-t-n-xxs" id="">
    <?php 
    if (!empty($friend_data)):
        foreach ($friend_data as $data):
            ?>
            <li class="list-group-item">
                <span class="pull-left thumb-xs m-t-xs avatar m-l-xs m-r-sm"> <img src="<?php echo base_url('uploads/profile_picture/thumb_'.$data['profile_picture']); ?>" alt="..." class="img-circle"> <i class="on b-light right sm"></i> </span> 
                <div class="clear">
                    <div><a href="<?php echo base_url('profile/view/'.$data['id']);?>"><?php echo $data['firstname'] . " " . $data['lastname']; ?></a></div>
                    <small class="text-muted"><?php echo $data['country']; ?></small> 
                </div>
            </li>
        <?php
        endforeach;
    endif;
    ?>
</ul>