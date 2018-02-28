<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
?>

<script>
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
                <a href="<?= base_url() ?>">Dashboard</a>
            </li>

        </ul>
    </div>

    <?php //print_r($user); ?>
    <div class=" row">
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Account Mode</th>
                    <th>Paypal Email</th>
                    <th>API Username</th>
                    <th>API Password</th>
                    <th>API Signature</th>
                    <th>Application Id</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Account Mode</th>
                    <th>Paypal Email</th>
                    <th>API Username</th>
                    <th>API Password</th>
                    <th>API Signature</th>
                    <th>Application Id</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($paypalsetting as $key => $val) { ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td><?php echo $val['account_mode']; ?></td>
                        <td><?php echo $val['paypal_email']; ?></td>
                        <td><?php echo $val['api_username']; ?></td>
                        <td><?php echo $val['api_password']; ?></td>
                        <td><?php echo $val['api_signature']; ?></td>
                        <td><?php echo $val['application_id']; ?></td>
                        <td>
                            <a href='<?= base_url('admin_dashboard/update_paypal_setting/'.$val['id']) ?>' title="Edit">
                                <i class="fa fa-pencil" aria-hidden="true"></i></a>  
                        </td>
                    </tr>
<?php } ?>
            </tbody>
        </table>

    </div>


    <script>
        function edituser(uid) {
            alert(uid);
        }
        function deleteuser(uid) {

            var r = confirm("Delete This User");
            if (r == true) {
                //alert(uid);
                window.location.href = "<?php echo base_url() ?>admin_dashboard/delete_user_details/" + uid;
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
<?php
$this->load->view('admin_templates/footer');
