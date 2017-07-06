<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable({
            "sPaginationType": "full_numbers"
        });
    });
</script>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
    <!-- content starts -->
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="<?=  base_url()?>">Dashboard</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>freestyle_library/">Freestyle Beat Library</a>
            </li>
            <li style="float: right;">
                <a href="<?php echo base_url(); ?>freestyle_library/add_library/">Add Freestyle</a>
            </li>
        </ul>
    </div>

    <?php //print_r($user); ?>
    <div class=" row">
        
        <?php if ($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success'); ?></p>
        <?php } ?>
        
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Media Name</th>
                    <th>Freestyle</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#ID</th>
                    <th>Media Name</th>
                    <th>Freestyle</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if(!empty($library_details)) { foreach ($library_details as $k=>$val) { ?>
                    <tr>
                        <td><?php echo $k; ?></td>
                        <td><?php echo $val['title']; ?></td>
                        <td>
                            <?php 
                            
                                $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
                                $m_path = base_url();
                                $media_path = substr($m_path, 0, strpos($m_path, "admin"));
                                //echo getcwd().'/uploads/freestyle_library/'.$val['media'];
                                if($val['media'] != '' && file_exists($getcwd.'/uploads/freestyle_library/'.$val['media'])) { ?>
                                     
                                    <audio controls>
                                      <source src="<?=$media_path.'uploads/freestyle_library/'.$val['media']?>" type="audio/ogg">
                                      <source src="<?=$media_path.'uploads/freestyle_library/'.$val['media']?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                            <?php    } else {
                                    echo 'N/A';
                                }
                            ?>
                        </td>
                        <td><?php echo $val['status']==0? 'Inactive':'Active' ?></td>
                        <td><?php echo $val['created_on']; ?></td>
                        <td>
                            <a href='<?=  base_url('freestyle_library/update_library/'.$val['id'])?>' title="Update">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>  
                            <a href='javascript:void(0);' title="Delete" onclick="deleteuser(<?php echo $val['id']; ?>)">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>

    </div>


    <script type="text/javascript">
        function edituser(uid) {
            alert(uid);
        }
        function deleteuser(uid) {

            var r = confirm("Delete This Freestyle Library");
            if (r == true) {
                //alert(uid);
                window.location.href = "<?php echo base_url() ?>freestyle_library/delete_library/" + uid;
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
