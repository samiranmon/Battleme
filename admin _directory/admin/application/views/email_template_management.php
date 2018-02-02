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
            <script>
                $(document).ready(function() {
    $('#example').DataTable();
} );
            </script>

            <?php //print_r($user);?>
<div class=" row">
    <div style=" margin-bottom: 15px; "><a style="border: 0px; padding: 5px 8px 5px 8px; border-radius: 5px;" href="<?php echo base_url(); ?>admin_dashboard/add_template_management" class="button btn-primary" >Add New</a></div>
   <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Email Name</th>
                <th>Email Subject</th>
                <th>Email Content</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                 <th>Id</th>
                <th>Email Name</th>
                 <th>Email Subject</th>
                <th>Email Content</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach($emailtemplate as $val) {?>
            <tr>
                 <td><?php echo $val['id']; ?></td>
                <td><?php echo $val['name']; ?></td>
                <td><?php echo $val['subject']; ?></td>
                <td><?php echo $val['content']; ?></td>
                 <td><?php if($val['status']==1){ echo 'Active'; }else{     echo 'Inactive'; } ?></td>
                <td>
                    <a href='<?=  base_url('admin_dashboard/edit_email_management/'.$val['id'])?>' title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>  
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