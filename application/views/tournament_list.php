<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>


<div class="midsection">
    <h4 class="font-thin m-l-md m-t">Tournaments</h4>
    
    <div class="doc-buttons pull-right">
        <?php
        if ($sess_data['user_type'] == 'artist') {
            if (isset($tournament_status)) {
                if (isset($tournament_status['count_user']) && $tournament_status['count_user'] >= 32 && isset($sess_data['membership_id']) && $sess_data['membership_id'] == 2) { ?>
                        <a href="<?php echo base_url() ?>tournament/create" class="btn btn-s-md btn-dark" style="color: #34a853;">Create Tournament</a>
                <?php } else { ?>
                        <a href="javascript:void(0)" class="disabled btn btn-s-md btn-dark">Create Tournament</a>
                <?php
                }
            }
        }
        ?>
    </div>
    <div style="width: 300px; float: left; margin-top: 10px;">
        All positions in current Tournament must be filled before another tournament can be created
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
    
    <ul class="list-group alt" > 
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
                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/thumb_' . $value['c_profile']); ?>" style="width:50px; height: 50px;" alt="<?php echo $value['c_profile']; ?>" class="img-circle"></span> 
                                <?php } else { ?>
                                    <span class="pull-left thumb-sm"><img src="<?php echo base_url('uploads/profile_picture/default.png'); ?>" style="width:50px; height: 50px;" alt="default" class="img-circle"></span> 
            <?php }
            ?>
                                <div>
                                    <a href="<?php echo $link ?>"><?php echo $text; ?></a>
                                </div> 
                                <small class="text-muted"><?php
                                    if (($value['start_date']) != '') {
                                        echo date("d M Y", strtotime($value['start_date']));
                                    } else {
                                        echo 'Not started yet';
                                    }
                                    ?></small> 
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
                        Not found 
                    </small>
                </p>
            </li>
<?php } ?>
    </ul> 
    
</div>