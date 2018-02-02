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
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Dashboard</a>
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
   <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>User About</th>
                <th>Created On</th>
               <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>User About</th>
                <th>Created On</th>
                <th>Actions</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach($user as $val) {?>
            <tr>
                <td><?php echo $val['firstname']; ?></td>
                <td><?php echo $val['lastname']; ?></td>
                <td><?php echo $val['email']; ?></td>
                <td><?php echo $val['user_type']; ?></td>
                <td><?php echo $val['aboutme']; ?></td>
                <td><?php echo $val['created_on']; ?></td>
                <td><a href='javascript:void(0)' >Edit</a>  <a href='javascript:void(0);' >Delete</a></td>
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
                    alert(uid);
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