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
                                    for chart section
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
                            <p><?php $site_setting = getSiteSettingById(1);
                                echo $site_setting['value'];
                            ?></p>
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
                        console.log(result);
                        $('#home_searchfriends').html(result);
                    }
                });
            }

        });
    });
 
</script>

<?php $this->load->view('templates/footer'); ?>