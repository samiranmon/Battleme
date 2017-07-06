<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>


<section class="panel panel-default col-lg-12">
    <br>
    <h4 class="font-thin m-l-md m-t">Battles</h4>
    <div class="doc-buttons pull-right">

        <?php
        if ($sess_data['user_type'] == 'artist') {
            if (isset($tournament_status)) {
                if (count($tournament_status) < 1 && $sess_data['membership_id'] == 2) {
                    ?>
                    <a href="<?php echo base_url() ?>tournament/create" class="btn btn-s-md btn-dark">Create Tournament Request</a>
                <?php } else { ?>
                    <a href="" title="Already in a tournament or not authorised" class="disabled btn btn-s-md btn-dark">Create Tournament Request</a>
                    <br><small>Already in a tournament or not authorized</small>
                <?php }
            } else {
                ?>
                <a href="<?php echo base_url() ?>battle/create" class="btn btn-s-md btn-dark">Create Battle Request</a>
    <?php }
}
?>


    </div>
    <div class="clearfix"></div>
    <?php
// echo "<pre>";
// print_r($battleList);
    if ($this->session->flashdata('message')) {
        ?>
        <div class="alert <?php echo $this->session->flashdata('class') ?>">
            <button class="close" data-dismiss="alert">x</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
<?php } ?>
    <br><br>
    <div class="error" style="clear: both;    text-align: center;">                   
        <?php echo $this->session->flashdata('reg_error_message'); ?>
    </div>
    <ul class="list-group alt" style="max-height: 450px; overflow-y:scroll;" > 
        <?php
        if (!empty($battleList)) {
            foreach ($battleList as $key => $value) {
                $text = '';
                if ($value['user_id'] == $userId)
                    $text = ' You ';
                else
                    $text = $value['challenger'];
                $text .= ' have challenged ' . $value['friend'];

                $link = base_url() . "battle/request/" . $value['battle_request_id'];
                ?>
                <li class="list-group-item"> 
                    <div class="media">
                        <div class="media-body"> 
                            <?php if ($value['c_profile'] != '' || $value['c_profile'] != NULL) { ?>
                                <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/thumb_' . $value['c_profile']); ?>" alt="<?php echo $value['c_profile']; ?>" class="img-circle"></span> 
        <?php } else { ?>
                                <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" alt="default" class="img-circle"></span> 
        <?php }
        ?>
                            <div>
                                <a href="<?php echo $link ?>"><?php echo $text; ?></a>
                            </div> 
                            <small class="text-muted"><?php echo date("d M Y", strtotime($value['start_date'])) ?></small> 
                        </div> 
                        <div class="pull-right"><a href="<?php echo $link ?>"><button>View</button></a></div>


                    </div>
                </li> 
        <?php
    }
} else {
    ?>
            <li class="list-group-item"> 
                <p align="center">
                    <small class="text-muted">
                        ---
                    </small>
                </p>
            </li>
        <?php } ?>

        <?php
        if (!empty($tournamentList)) {
            $arr = [];
            foreach ($tournamentList as $key => $value) {

                if (!in_array($value['tournament_request_id'], $arr)) {
                    $arr[] = $value['tournament_request_id'];

                    $text = '';
                    if ($value['user_id'] == $userId)
                        $text = ' You have started a tournament';
                    else
                        $text = $value['challenger'] . ' have started a tournament';


                    $link = base_url() . "tournament/request/" . $value['tournament_request_id'];
                    ?>
                    <li class="list-group-item"> 
                        <div class="media">
                            <div class="media-body"> 
                                <?php if ($value['c_profile'] != '' || $value['c_profile'] != NULL) { ?>
                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/thumb_' . $value['c_profile']); ?>" alt="<?php echo $value['c_profile']; ?>" class="img-circle"></span> 
                                <?php } else { ?>
                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" alt="default" class="img-circle"></span> 
            <?php }
            ?>
                                <div>
                                    <a href="<?php echo $link ?>"><?php echo $text; ?></a>
                                </div> 
                                <small class="text-muted"><?php if (($value['start_date']) != '') {
                echo date("d M Y", strtotime($value['start_date']));
            } else {
                echo 'Not started yet';
            } ?></small> 
                            </div> 
                            <div class="pull-right"><a href="<?php echo $link ?>"><button>View</button></a></div>
                        </div>
                    </li> 
            <?php
        }
    }
} else {
    ?>

            <li class="list-group-item"> 
                <p align="center">
                    <small class="text-muted">
                        --- 
                    </small>
                </p>
            </li>
<?php } ?>
    </ul> 
</section>