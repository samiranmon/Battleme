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
                <a href="<?php echo base_url(); ?>battle_category/">Battle Category</a>
            </li>
            <li style="float: right;">
                <a href="<?php echo base_url(); ?>battle_category/add/">Add Category</a>
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
                    <th>Category Name</th>
                    <th>Battle time duration</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#ID</th>
                    <th>Category Name</th>
                    <th>Battle time duration</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if(!empty($category_details)) { foreach ($category_details as $k=>$val) { ?>
                    <tr>
                        <td><?php echo $k; ?></td>
                        <td><?php echo $val['name']; ?></td>
                        <td><?php echo $val['time_duration'].' days'; ?></td>
                        <td><?php echo $val['status']==0? 'Inactive':'Active' ?></td>
                        <td><?php echo $val['created_on']; ?></td>
                        <td>
                            <a href='<?=  base_url('battle_category/update/'.$val['id'])?>' title="Update">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>  
                            <?php
                                $battle_cat = [1 =>'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6 => 'Raggeton', 7=> 'Latino hip hop', 8 => 'Latino songs originals', 9 => 'Latino songs covers'];
                                if(!array_key_exists($val['id'], $battle_cat)){
                            ?>
                                <a href='javascript:void(0);' title="Delete" onclick="deleteuser(<?php echo $val['id']; ?>)">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
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

            var r = confirm("Delete This Battle Category");
            if (r == true) {
                //alert(uid);
                window.location.href = "<?php echo base_url() ?>battle_category/delete/" + uid;
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


<?php
$this->load->view('admin_templates/footer');
