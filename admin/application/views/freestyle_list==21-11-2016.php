<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>


<div class="midsection">
    <h4 class="font-thin m-l-md m-t">
        <?php 
            if($battleType == '') echo 'My Battles';
            else
            echo $battleType == 'cash-battle' ? 'Cash Battles' : 'Regular Battles'; 
        ?>
    </h4>
     
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
    
    
    <div class="list-group alt" style="max-height: 450px; overflow-y:scroll;" > 
        <?php
        if (!empty($battleList)) {
            //echo '<pre>'; print_r($battleList); die;
            foreach ($battleList as $key => $value) {
                
                $chlngr_prof_pic = $value['c_profile'] == ''? 'default.png' : $value['c_profile'];
                $chlngr_prof_pic = base_url('uploads/profile_picture/'.$chlngr_prof_pic);
                
                $friend_prof_pic = $value['f_profile'] == ''? 'default.png' : $value['f_profile'];
                $friend_prof_pic = base_url('uploads/profile_picture/'.$friend_prof_pic);
                
                $challenger_media_array = explode(',', $value['challenger_media']);
                $challenger_media_path = $this->config->item('battle_media_path').$challenger_media_array[0];
                $challenger_media_title = isset($challenger_media_array[1]) ? $challenger_media_array[1]:'';
                $challenger_media_id = isset($challenger_media_array[2]) ? trim($challenger_media_array[2]):'';
                
                
                $friend_media_array = explode(',', $value['friend_media']);
                $friend_media_path = $this->config->item('battle_media_path').$friend_media_array[0];
                $friend_media_title = isset($friend_media_array[1]) ? $friend_media_array[1]:'';
                $friend_media_id = isset($friend_media_array[2]) ? trim($friend_media_array[2]):'';

                $link = base_url() . "battle/request/" . $value['battle_request_id'];
                ?>
        
              <?php if( $userId == $value['friend_user_id'] && $value['status'] == 0 ) { ?>
                <!-- start challenge accept or decline popup --> 
                <div class="col-md-12">
                    <div class="">
                         <!--<button data-dismiss="modal" class="close" type="button">×</button>--> 
                         <h4 class="">Would you accept <?=ucwords($value['challenger'])?> beat. 
                             Battle will take <?=ucwords($value['place'])?> at <?=date('F d, g:i a',strtotime($value['date_time']))?>.</h4>
                    </div>

                    <div class="">
                        <div class="alert-info">
                            <?php if($value['entry']>0) { ?>
                                <small style="margin-left: 58px;">
                                    <?php echo ($value['entry']).' battle bucks will be charged after accepting challenge. ' ?>
                                    Extra 1 bb will be deduct from your wallet due to lease the battle
                                </small>
                            <?php } else { ?>
                                <small style="margin-left: 58px;">
                                    1 bb will be deduct from your wallet due to lease the battle
                                </small>
                            <?php } ?>
                        </div>
                        <br>
                        <div class="pull-right">
                            <a class="btn btn-success" href="<?=base_url().'battle/lease_freestyle/'.base64_encode($value['battle_request_id']).'/1'?>">Accept</a>
                            <a class="btn btn-small btn-danger" href="<?=base_url().'battle/lease_freestyle/'.base64_encode($value['battle_request_id']).'/0'?>">Reject</a>
                        </div>
                    </div>
                </div>
                <!-- end challenge accept or decline popup --> 
              <?php } ?>
                
                <?php if($value['status'] == 4 ) { ?>
                <div class="col-md-12">
                    <div class="">
                         <h4 class="">
                             Freestyle battle will start on <?=date('F d, g:i a',strtotime($value['date_time']))?> at <?=$value['place']?>
                         </h4>
                    </div>
                </div>
                <?php } ?>
        
        
            <ul>
                <li class="list-group-item" style="width: 50%; float: left; height: 400px" > 
                    <div class="media">
                        <div class="media-body"> 
                            
                                <div class="pro_pic">
                                    <img src="<?=$chlngr_prof_pic?>" alt="<?=$value['challenger']?>" class="image-full">
                                </div> 
        
                            <div>
                                <a href="javascript:void(0)">Votes: <?=$value['challenger_vote']?></a>
                                <a href="javascript:void(0)">Likes: <span class="like_count_<?=$challenger_media_id?>"><?=$value['challenger_like']?></span></a>
                            </div> 
                            <?php if($challenger_media_array[0] != '') { ?>
                                <span>
                                    <a data-toggle="button" dataid="<?=$challenger_media_id?>" alt='<?=$userId?>' class="btn btn-default songLike active"> 
                                         <span class="text-active"> 
                                             <i class="fa fa-thumbs-o-up text"></i> 
                                             <span class="like_count_<?=$challenger_media_id?>"><?=$value['challenger_like']?></span>
                                         </span> 
                                    </a> 
                                </span>
                            <?php } ?>
                            
                            <br>
                            
                            <div>
                                <?php if($value['winner'] > 0 ) {
                                        if($value['user_id'] == $value['winner']) {
                                    ?>
                                        <a href="javascript:void(0)" style="color: green;">Winner</a>
                                <?php } else { ?> 
                                        <a href="javascript:void(0)" style="color: red;">Loser</a>
                                    <?php } } ?>
                            </div> 
                            <br>
                            
                            
                            <small class="text-muted"><?=$challenger_media_title.' ('.ucwords($value['challenger']).')'?></small><br><br>
                            <?php if($challenger_media_array[0] != '' && $value['battle_category'] != 4) {
                                    $this->view('jplayer', ['path' => base_url($challenger_media_path), 'id' => 'challenger_'.$value['battle_request_id']]);
                                }
                            ?>
                            
                            <?php if($challenger_media_array[0] != '' && $value['battle_category'] == 4) { ?>
                                <video width="350" controls="controls">
                                    <source type="video/mp4" src="<?=base_url($challenger_media_path)?>"></source>
                                </video>
                            <?php } ?>
                        </div> 
                        
                        <div style="margin-top: 50px;"><a href="<?php echo $link ?>"><button>Visit Battle Page</button></a></div>
                    </div>
                </li> 
                
                <li style="width: 50%; float: left; height: 400px">
                    <div class="media">
                        <div class="media-body"> 
                            
                            <div class="pro_pic">
                                <img src="<?=$friend_prof_pic?>" alt="<?=$value['friend']?>" class="image-full">
                            </div> &nbsp;
                            <div>
                                <a href="javascript:void(0)">Votes: <?=$value['friend_vote']?></a>
                                 <a href="javascript:void(0)">Likes: <span class="like_count_<?=$friend_media_id?>"><?=$value['friend_like']?></span></a>
                            </div> 
                            
                            <?php if($friend_media_array[0] != '') { ?>
                                <span>
                                    <a data-toggle="button" dataid="<?=$friend_media_id?>" alt='<?=$userId?>' class="btn btn-default songLike active"> 
                                         <span class="text-active"> 
                                             <i class="fa fa-thumbs-o-up text"></i> 
                                             <span class="like_count_<?=$friend_media_id?>"><?=$value['friend_like']?></span>
                                         </span> 
                                    </a> 
                                </span>
                            <?php } ?>
                            <br>
                            
                             <div>
                                <?php if($value['winner'] > 0 ) {
                                        if($value['friend_user_id'] == $value['winner']) {
                                    ?>
                                        <a href="javascript:void(0)" style="color: green;">Winner</a>
                                <?php } else { ?> 
                                        <a href="javascript:void(0)" style="color: red;">Loser</a>
                                    <?php } } ?>
                            </div> 
                            <br>
                            
                            <small class="text-muted"><?=$friend_media_title.' ('.ucwords($value['friend']).')'?></small><br><br>
                            <?php 
                                if($friend_media_array[0] != '' && $value['battle_category'] != 4) {
                                    $this->view('jplayer', ['path' => base_url($friend_media_path), 'id' => 'friend_'.$value['battle_request_id']]);
                                }
                            ?>
                            
                            <?php if($friend_media_array[0] != '' && $value['battle_category'] == 4) { ?>
                                <video width="400" controls="controls">
                                    <source type="video/mp4" src="<?=base_url($friend_media_path)?>"></source>
                                </video>
                            <?php } ?>
                            
                        </div> 
                        
                        <div style="margin-top: 50px;">
                            <?php
                            
                                if($value['status'] == 0) {
                                    echo 'Request pending';
                                } else if($value['status'] == 4) {
                                    echo 'Accepted';
                                } else if($value['status'] == 2) {
                                    echo 'Rejected';
                                } else if(strtotime($value['end_date']) >= strtotime(date('Y-m-d H:i:s')) ) {
                                    //echo ' 4 days 36 mins till battle ends';
                                    $date_a = new DateTime($value['end_date']);
                                    $date_b = new DateTime(date('Y-m-d H:i:s'));
                                    $interval = date_diff($date_a,$date_b);
                                    echo $interval->format('%d').' days '.$interval->format('%h').' hour '.$interval->format('%i').' mins till battle ends';
                                } else {
                                    echo 'Closed';
                                }
                            ?>
                           
                        </div>

                    </div>
                </li>
            </ul>
        
        
        
        <?php
    }
} else {
    ?>
            <div class="list-group-item"> 
                <p align="center">
                    <small class="text-muted">
                        Battle records not found
                    </small>
                </p>
            </div>
        <?php } ?>

  
    </div>
</div>