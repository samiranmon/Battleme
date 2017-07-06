<div class="con_menu">
    <a href=""><img src="<?php echo base_url(); ?>public/images/icon2.png" alt=""></a>
    <div class="con_menu_downmain">
        <div id="btn2" class="con_men_btn"></div>
        <div id="bdyopen2" class="con_men_bdytx">
            <h4>Connected</h4>
            <ul id="now_connected_user">
                <?php
                if (!empty($rightsidebar)) {
                    foreach ($rightsidebar as $data) {
                        ?>
                            <li>
                                <div class="d_pic_left">
                                     <?php if ($data['profile_picture'] != ''): ?>
                                    <img style="height: 40px; width: 40px;" src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="..." class="img-circle">
                                        <?php else: ?>
                                            <img src="<?php echo base_url(); ?>public/images/d_icon1.png" alt="..." class="img-circle">
                                        <?php endif; ?>
                                </div>

                                <div class="d_pic_txt">
                                    <a href="<?php echo base_url('profile/view/' . $data['id']); ?>"> 
                                        <?php 
                                             $namelen = strlen($data['firstname'] . " " . $data['lastname']);
                                             if($namelen > 11) {
                                                 
                                                 if(strlen($data['firstname']) > 11) {
                                                     echo ucwords(substr($data['firstname'], 0,11)).'..'; 
                                                 } else {
                                                     echo ucwords($data['firstname'] . " " . substr($data['lastname'], 0,1)); 
                                                 }
                                                 
                                             } else {
                                                 echo ucwords($data['firstname'] . " " . $data['lastname']); 
                                             }
                                        ?> 
                                        <?php echo !is_null($data['country'])? '('.substr($data['country'],0,7).')':''; ?>
                                    </a>
                                </div>
                                <div class="d_pic_right"><img src="<?php echo base_url(); ?>public/images/d_active.png" alt="" > </div>
                            </li>
                        <?php
                    };
                };
                ?>

            </ul>

        </div>
    </div>
</div>                                                                                           