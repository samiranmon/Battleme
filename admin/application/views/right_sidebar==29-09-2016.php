<aside class="aside-sm bg-light dk" id="sidebar">
    <section class="vbox animated fadeInRight">
        <section class="w-f-md scrollable hover">
            <h4 class="font-thin m-l-md m-t">Connected</h4>
            <ul class="list-group no-bg no-borders auto m-t-n-xxs" id="home_searchfriends">
                <?php
                if (!empty($rightsidebar)):
                    foreach ($rightsidebar as $data):
                        ?>
                        <li class="list-group-item">
                            <span class="pull-left thumb-xs m-t-xs avatar m-l-xs m-r-sm"> 
                            <?php if($data['profile_picture'] != ''):?>
                            <img src="<?php echo base_url('uploads/profile_picture/thumb_'.$data['profile_picture']); ?>" alt="..." class="img-circle">
                            <?php else: ?>
                            <img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" alt="..." class="img-circle">
                            <?php endif; ?>
                             <i class="on b-light right sm"></i> 
                             </span> 
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
        </section>
        <footer class="footer footer-md bg-black">
            <form class="" role="search">
                <div class="form-group clearfix m-b-none">
                    <div class="input-group m-t m-b"> <span class="input-group-btn"> <button type="submit" class="btn btn-sm bg-empty text-muted btn-icon"><i class="fa fa-search"></i></button> </span> <input type="text" class="form-control input-sm text-white bg-empty b-b b-dark no-border" id="searchfriend" placeholder="Search members"> </div>
                </div>
            </form>
        </footer>
    </section>
</aside>

