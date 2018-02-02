<?php
    $this->load->view('admin_templates/header');
    $this->load->view('admin_templates/topbar');
    $this->load->view('admin_templates/sidebar');

 ?>

<script>
                $(document).ready(function() {
    $('#example').DataTable({
         "sPaginationType": "full_numbers"
    });
} );
            </script>
<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url() ?>">Dashboard</a>
        </li>
        
    </ul>
</div>
            
            <?php //print_r($user);?>
<div class=" row">
    
   <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Battle Id</th>
                <th>Battle Category </th>
                <th>User</th>
                <th>Battle With</th>
                <th>Battle Name</th>   
                <th>Battle Type</th>   
                <th>View Details</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                 <th>Battle Id</th>
                <th>Battle Category </th>
                <th>User</th>
                <th>Battle With</th>
                <th>Battle Name</th>   
                <th>Battle Type</th>   
                <th>View Details</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach($battle as $val) {?>
            <tr>
                 <td><?php echo $val['battle_request_id']; ?></td>
                <td>
                    <?php
                    if($val['battle_category']==1){
                        echo 'Rnb & pop Originals';
                    }
                    if($val['battle_category']==2){
                        echo 'RnB & Pop Covers';
                    }
                    if($val['battle_category']==3){
                        echo 'Hiphop';
                    }
                    if($val['battle_category']==4){
                        echo 'Video Battles';
                    }
                    if($val['battle_category']==5){
                        echo 'Freestyle';
                    }
                    if($val['battle_category']==6){
                        echo 'Raggeton';
                    }
                    if($val['battle_category']==7){
                        echo 'Latino hip hop';
                    }
                    if($val['battle_category']==8){
                        echo 'Latino songs originals';
                    }
                    if($val['battle_category']==8){
                        echo 'Latino songs covers';
                    }
                   ?>
                
                </td>
                <td><?php echo $val['username']; ?></td>
                <td><?php echo $val['userfname']; ?></td>
                <td> <?php echo $val['battle_name'];  ?></td>
                <th><?php if($val['entry']==0){ echo 'Regular Battle'; } else {
                    echo 'cash battle'; 
                   if($val['donate']!=0){
                       echo '( '.$val['donate'].'BB )';
                   }
                    
                    
                }  ?> </th>   
                <td>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal<?php echo $val['battle_request_id']; ?>"><i class="fa fa-user-o" aria-hidden="true"></i></a>
<!-- Modal -->
<div id="myModal<?php echo $val['battle_request_id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Battle Details</h4>
      </div>
      <div class="modal-body">
           
          <?php
          if($val['status']==3 ){
                    ?>
          <label>Winner:</label> <?php echo $val['winner'];  ?><br>
          <?php
                }
          ?>
          
          <label>Status:</label> 
              
              <?php 
              if($val['status']==0 ){
              echo 'Pending ';
                }
                if($val['status']==1 ){
              echo 'started ';
                }
                if($val['status']==2 ){
                    echo 'Reject';
                }
                if($val['status']==3 ){
                    echo 'Completed';
                }
                if($val['status']==4 ){
                    echo 'Accepted';
                }
                ?><br>
                <h2>Likes</h2><br>
                <strong>Total likes: <?php echo $val['battlelike'];?></strong><br>
          <strong><?php echo $val['username']; ?></strong> likes : <?php echo $val['userlike']; ?><br>
          <strong><?php echo $val['userfname']; ?></strong> likes : <?php echo $val['frinedlike']; ?><br>
          <h2>Votes</h2><br>
          <strong>Total Battle Votes : </strong><?php echo $val['battlevote']; ?><br>
          <strong><?php echo $val['username']; ?> Votes : </strong><?php echo $val['uservote']; ?><br>
          <strong><?php echo $val['userfname']; ?> Votes : </strong><?php echo $val['friendvote']; ?><br>
          <table>
              <th>Name</th><th>Song</th>
          <?php
          if($val['songs']!=''){
             
          foreach( $val['songs'] as $dat)
          {
           echo '<tr style="height:20px;"><td ><strong>'.  $dat->firstname.'</strong></td>';
                                $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
                                $m_path = base_url();
                                $media_path = substr($m_path, 0, strpos($m_path, "admin"));
                                //echo getcwd().'/uploads/freestyle_library/'.$val['media'];
                                if($dat->media != '' && file_exists($getcwd.'/uploads/library/'.$dat->media)) {
                                    //echo  $dat->firstname;
                                    ?>
          <td>
                                    <audio controls>
                                      <source src="<?=$media_path.'uploads/library/'.$dat->media?>" type="audio/ogg">
                                      <source src="<?=$media_path.'uploads/library/'.$dat->media?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
              </td>
      </div>
          <br>
              
          <?php
                            } else {
                                    echo '<td>N/A</td></tr>';
                                    //echo '<br>';
                                }
                            
              //print_r($dat);
              //print_r($dat->firstname.$dat->songuser.$dat->media);echo '<pre>';
          }
          }
          ?>
          </table>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
                </td>
            </tr>
           <?php } ?>
        </tbody>
    </table>

</div>


            <script>
                function edituser(uid){
                    alert(uid);
                }
                function deleteuser(uid){
                    
                    var r = confirm("Delete This User");
                    if (r == true) {
                       //alert(uid);
                       window.location.href = "<?php echo base_url()?>admin_dashboard/delete_user_details/"+uid;
                    }   
                    
                }
                </script>
                <style>
                    #example_first, #example_last{
                        background: #ffd700;
                    }
                    #example_previous,#example_next{
                        background: #e5c100;
                    }
                    .paginate_active{
                        background: #ffeb7f;
                        padding: 10px;
                        border-radius: 3px;
                        margin: 0px 1px 0px 3px;
                    }
                    .paginate_button{
                        background: #ffdf32;
                        
                    }
                </style>

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