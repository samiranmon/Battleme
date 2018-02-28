<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
?>
<script src="<?php echo base_url(); ?>public/admin/admin_js/script-for-delivery-cost-management.js"></script>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
    <!-- content starts -->
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="<?= base_url('admin_dashboard') ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('admin_dashboard/get_paypal_details') ?>">Paypal Setting</a>
            </li>
        </ul>
    </div>

    <div class=" row">


        <?php if ($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success'); ?></p>
            <?php
        }

        $attributes = array('id' => 'paypal', 'class' => 'form-horizontal');
        echo form_open_multipart('admin_dashboard/update_paypal_setting' . '/' . $id, $attributes);
        ?>
        <div class=" row">
            <div class="col-md-10 col-sm-10 col-xs-10">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="account_mode">Account Mode :</label>
                    <div class="col-sm-10">
                        <input type="text" readonly="" required="" class="form-control" name="account_mode" placeholder="Enter account mode" value="<?php echo $account_mode ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="api_username">Api Username :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required="" name="api_username" placeholder="Enter api username" value="<?php echo $api_username ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="api_password">Api Password :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required="" name="api_password" placeholder="Enter api password" value="<?php echo $api_password ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="api_signature">Api Signature :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required="" name="api_signature" placeholder="Enter api signature" value="<?php echo $api_signature ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="paypal_email">Paypal Email :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required="" name="paypal_email" placeholder="Enter paypal email" value="<?php echo $paypal_email ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="application_id">Application Id :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required="" name="application_id" placeholder="Enter application id" value="<?php echo $application_id ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="submit" class="btn btn-primary"value="Update" />
                    </div>
                </div>

            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">

            </div>

        </div>


<?php echo form_close(); ?> 
    </div>





    <!-- content ends -->
</div><!--/#content.col-md-0-->
</div><!--/fluid-row-->



<hr>
<script type="text/javascript">
    $(document).ready(function () {
        $('#status').on('change', function () {
            if ($(this).val() == 1) {
                $('#setting_value').val('Live Account');
            } else {
                $('#setting_value').val('Sandbox Account');
            }
        }).change();
    });
</script>

<?php
$this->load->view('admin_templates/footer');
