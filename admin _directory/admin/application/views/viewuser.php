<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
$base_url = 'http://mydevfactory.com/~pranay/samiran/battleme';
?>
<script src="<?php echo base_url(); ?>public/admin/admin_js/script-for-delivery-cost-management.js"></script>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
    <!-- content starts -->
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Dashboard</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin_dashboard/get_user_details/">User List</a>
            </li>
        </ul>
    </div>

    <div class=" row">

        <div class=" row">
            <div class="col-md-1 col-sm-1 col-xs-1">

            </div>
            <div class="col-md-11 col-sm-11 col-xs-11 form-horizontal">

                <div class="form-group">
                    <label class=" col-sm-2" for="email">First Name:</label>
                    <div class="col-sm-10">
                        <?php echo $firstname ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class=" col-sm-2" for="email">Last Name:</label>
                    <div class="col-sm-10">
                        <?php echo $lastname ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class=" col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <?php echo $email ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class=" col-sm-2" for="pwd">Profile Image:</label>
                    <div class="col-sm-10">
                        <?php
                         $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
                        if (($profile_picture != '') && (file_exists($getcwd.'/uploads/profile_picture/'.$profile_picture)==1) ) { ?>
                            <img src="<?php echo $base_url; ?>/uploads/profile_picture/<?php echo $profile_picture ?>" style="height: 200px; width: 200px;" />
                        <?php } else { ?>
                            <img id="coverContainer" src="<?php echo $base_url; ?>/uploads/profile_picture/default.png" width = "50" height = "50">
                        <?php } ?>


                    </div>
                </div>
                <div class="form-group">
                    <label class=" col-sm-2" for="pwd">Cover Image:</label>
                    <div class="col-sm-10">
                        <?php
                         $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
                        
                        if (($cover_picture != '') && (file_exists($getcwd.'/uploads/cover_picture/'.$cover_picture)==1)) { ?>
                            <img src="<?php echo $base_url; ?>/uploads/cover_picture/<?php echo $cover_picture ?>" style="height: 200px; width: 200px;" />
                        <?php } else { ?>
                            <img id="coverContainer" src="<?php echo $base_url; ?>/uploads/cover_picture/defaultcoveradmin.jpg" width = "800" height = "250">
                        <?php } ?>


                    </div>
                </div>
                <div class="form-group">
                    <label class=" col-sm-2" for="pwd">Phone No:</label>
                    <div class="col-sm-10">
                        <?php echo $phone_no ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="pwd">Address:</label>
                    <div class="col-sm-10">
                        <?php echo $address1 ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2" for="pwd">City:</label>
                    <div class="col-sm-10">
                        <?php echo $city ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class=" col-sm-2" for="pwd">Country:</label>
                    <div class="col-sm-10">
                        <?php echo $country ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class=" col-sm-2" for="pwd">About me:</label>
                    <div class="col-sm-10">
                        <?php echo $aboutme ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="pwd">Info:</label>
                    <div class="col-sm-10">
                        <?php echo $info ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="pwd">Coins:</label>
                    <div class="col-sm-10">
                        <?php echo $coins ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="pwd">Cups:</label>
                    <div class="col-sm-10">
                        <?php echo $cups ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" for="pwd">Paypal account ID:</label>
                    <div class="col-sm-10">
                        <?php echo $paypal_account_id ?>
                    </div>
                </div>


            </div>


        </div>

    </div>





    <!-- content ends -->
</div><!--/#content.col-md-0-->
</div><!--/fluid-row-->



<hr>

<!--    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here settings can be configured...</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a>
                </div>
            </div>
        </div>
    </div>-->

<?php
$this->load->view('admin_templates/footer');
?>