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
                <th>Tournament Name</th>
                <th>Tournament Creator</th>
                <th>Tournament Description</th>
                <th>Tournament Prize</th>
                <th>Tournament Entry</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Tournament Name</th>
                <th>Tournament Creator</th>
                <th>Tournament Description</th>
                <th>Tournament Prize</th>
                <th>Tournament Entry</th>       
                 <th>Actions</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach($tour as $val) {
                        
                ?>
            <tr>
                 <td><?php echo $val['tournament_name']; ?></td>
                <td>
                   
                   <?php echo $val['firstname']; ?></td>
                <td>
                   
                   <?php echo $val['description']; ?></td>
                
                <td><?php echo $val['prize']; ?></td>
                <td> <?php echo $val['entry']; ?></td>
                <td> </td>
            </tr>
                        <?php  } ?>
        </tbody>
    </table>

</div>          <style>
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