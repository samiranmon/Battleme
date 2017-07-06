<?php
    $this->load->view('admin_templates/header');
    $this->load->view('admin_templates/topbar');
    $this->load->view('admin_templates/sidebar');
   
 ?>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Dashboard</a>
        </li>
    </ul>
</div>
<div class=" row">
    <div class="col-md-4 col-sm-4 col-xs-6">
        <a data-toggle="tooltip" title="Total Members  <?php echo $user; ?>" class="well top-block" href="#">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Total Members</div>
            <div><?php echo $user; ?></div>
            <span class="notification"><?php echo $user; ?></span>
        </a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-6">
        <a data-toggle="tooltip" title="Total Battles  <?php echo $battle; ?>" class="well top-block" href="javascript:void(0)">
            <img src="<?php echo base_url(); ?>public/battle.png" style=" width: 11%" />

            <div>Total Battle</div>
            <div><?php echo $battle; ?></div>
            <span class="notification"><?php echo $battle; ?></span>
        </a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-6">
        <a data-toggle="tooltip" title="Total Tournaments  <?php echo $tournament; ?>" class="well top-block" href="javascript:void(0)">
            <img src="<?php echo base_url(); ?>public/tournament.png" style=" width: 11%"/>

            <div>Total Tournament</div>
            <div><?php echo $tournament; ?></div>
            <span class="notification"><?php echo $tournament; ?></span>
        </a>
    </div>
<!--    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="4 new pro members." class="well top-block" href="javascript:void(0)">
            <i class="glyphicon glyphicon-star green"></i>

            <div>Pro Members</div>
            <div>228</div>
            <span class="notification green">4</span>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="$34 new sales." class="well top-block" href="#">
            <i class="glyphicon glyphicon-shopping-cart yellow"></i>

            <div>Sales</div>
            <div>$13320</div>
            <span class="notification yellow">$34</span>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="12 new messages." class="well top-block" href="#">
            <i class="glyphicon glyphicon-envelope red"></i>

            <div>Messages</div>
            <div>25</div>
            <span class="notification red">12</span>
        </a>
    </div>-->
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