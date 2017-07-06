<?php
$this->load->view('templates/header');
$currentime = date("Y-m-d H:i:s", time());
//print_r($userdata);
?>
<div class="container-fluid">
    <div class="row">
        <div class="mainbdy">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
<?php $this->load->view('home_sidebar'); ?>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="top_head">


                                <?php
                                $attributes = array('id' => 'searchbar', 'class' => '', 'role' => 'search');
                                echo form_open('home/search', $attributes);
                                ?>
                                <div class="tophead_left">
                                    <input type="text" placeholder="Search users" name = "home_search">
                                    <button></button>
                                </div>
<?php echo form_close(); ?>


                                <div class="tophead_right">

                                    <div class="charact">
                                        <div class="charpic">
                                            <?php if ($userdata[0]->profile_picture != '' || $userdata[0]->profile_picture != NULL) { ?>
                                                <img src="<?php echo base_url('uploads/profile_picture/thumb_' . $userdata[0]->profile_picture); ?>" alt="<?php echo $userdata[0]->profile_picture; ?>">
                                            <?php } else { ?> 
                                                <img src="<?php echo base_url(); ?>public/images/icon1.png" alt="">
<?php } ?>
                                        </div>
                                        <div class="chartxt"> <?php echo $userdata[0]->firstname . "." . $userdata[0]->lastname; ?></div>

                                        <div class="chardownmain">
                                            <div id="btn1" class="char_btn"></div>
                                            <div id="bdyopen" class="char_bdytx"> 
                                                <ul>
                                                    <li> <a href="<?php echo base_url('profile'); ?>">Profile</a> </li> 
                                                    <li> <a href="<?php echo base_url('user/notifications'); ?>"> Notifications </a> </li> 
                                                    <li> <a href="<?php echo base_url('wallet'); ?>"> Wallet </a> </li> 
                                                    <li> <a href="<?php echo base_url('aboutus'); ?>">About us</a> </li>  
                                                    <li> <a href="<?php echo base_url('user/logout'); ?>">Logout</a> </li> 
                                                </ul>

                                            </div> 

                                        </div>
                                    </div>


<?php $this->load->view('navigationbar_home'); ?>
<?php $this->load->view('right_sidebar'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 right_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="midsection">
                                    <h4 class="font-thin m-l-md m-t"><?php echo $title;?>:</h4>
                                    <br><br>
                                    <ul class="list-group alt notification_listing_pro"> 
                                        <?php 
                                        if (!empty($get_result)):
                                            foreach ($get_result as $data):
                                                ?>
                                                <li class="list-group-item"> 
                                                    <div class="media">
                                                        <div class="media-body"> 
                                                            <?php if ($data['profile_picture'] != '' || $data['profile_picture'] != NULL): ?>
                                                            <span class="pull-left thumb-sm">
                                                                <img style="width: 50px; height: 50px;" src="<?php echo base_url('uploads/profile_picture/thumb_' . $data['profile_picture']); ?>" alt="<?php echo $data['profile_picture']; ?>" class="img-circle">
                                                            </span> 
                                                            <?php else: ?>
                                                            <span class="pull-left thumb-sm">
                                                                <img style="width: 50px; height: 50px;" src="<?php echo base_url('public/images/icon4.png'); ?>" alt="default" class="img-circle">
                                                            </span> 
                                                            <?php endif; 
                                                            if( isset($data['notification_type']) && $data['notification_type'] == 'battle_request')
                                                            {
                                                                if(!is_null($data['data_id']))
                                                                    $link = base_url()."battle/request/".$data['data_id'] ;
                                                            }
                                                            else
                                                                $link = base_url('profile/view/' . $data['userid']);
                                                            ?>
                                                            <div>
                                                                <a href="<?php echo  $link?>"><?php echo $data['firstname'] . " " . $data['lastname']; ?></a>
                                                                <p><?php if(!empty($data['message'])){echo " ".$data['message'];} ?></p>
                                                            </div> 
                                                            <small class="text-muted"><?php echo $data['city']==''?'':$data['city'] . ", "; echo $data['country']; ?></small> 
                                                        </div> 
                                                    </div>
                                                </li> 
                                                <?php
                                            endforeach;
                                        else:
                                            ?>
                                            <li class="list-group-item"> 
                                                <p align="center">
                                                    <small class="text-muted">
                                                        No result found
                                                    </small>
                                                </p>
                                            </li>
                                        <?php endif; ?>
                                    </ul> 
                                </div>
                            </div>


                            <div class="col-md-4">
                                <!-- top right artist  -->
                                <?php $this->load->view('top_artist'); ?>
                                <!-- top right artist end  -->  

                                <!-- top song right artist red  -->  
                                <?php $this->load->view('top_songs'); ?>
                                <!-- top song right artist red end  -->   

                                <!-- top song right artist blue  --> 
                                <?php $this->load->view('top_videos'); ?>
                                <!-- top song right artist blue end  -->                                                                                                         
                            </div>

                        </div>

                        <div class="footer">
                            <p>
                                <?php $site_setting = getSiteSettingById(1);
                                    echo $site_setting['value'];
                                ?> 
                            </p>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?php echo base_url(); ?>";
        $('#searchfriend').keypress(function (event) {

            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var search_string = $("#searchfriend").val();
//                alert(search_string);
                $.ajax({
                    url: url + 'home/search_friend/' + search_string,
                    type: 'POST',
                    success: function (result) {
                        //console.log(result);
                        $('#home_searchfriends').html(result);
                    }
                });
            }

        });
    });
 
</script>

<?php $this->load->view('templates/footer'); ?>