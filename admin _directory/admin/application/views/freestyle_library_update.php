<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
?>
<style type="text/css">
    .error{
        color: red;
    }
</style>

<div id="content" class="col-lg-10 col-sm-10" style=" min-height: 500px;">
    <!-- content starts -->
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Dashboard</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>freestyle_library/">Freestyle Beat Library</a>
            </li>
            
        </ul>
    </div>

    <div class=" row">


        <?php if ($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success'); ?></p>
        <?php
        }

        $attributes = array('id' => 'editprofile1', 'class' => 'form-horizontal');
        echo form_open_multipart('freestyle_library/update_freestyle_library' . '/' . $freestyle['id'], $attributes);
        ?>
        <div class=" row">
            <div class="col-md-10 col-sm-10 col-xs-10">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="title">Media Title :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Media Title" value="<?php echo $freestyle['title'] ?>">
<?php echo form_error('title', '<div class="error">', '</div>'); ?>
                    </div>
                </div>




                <div class="form-group">
                    <label class="control-label col-sm-2" for="media">Freestyle Media :</label>
                    <div class="col-sm-10">
                        <?php 
                            if(isset( $freestyle['id'])) {
                                $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
                                $m_path = base_url();
                                $media_path = substr($m_path, 0, strpos($m_path, "admin"));
                                //echo getcwd().'/uploads/freestyle_library/'.$val['media'];
                                if($freestyle['media'] != '' && file_exists($getcwd.'/uploads/freestyle_library/'.$freestyle['media'])) { ?>
                                     
                                    <audio controls>
                                      <source src="<?=$media_path.'uploads/freestyle_library/'.$freestyle['media']?>" type="audio/ogg">
                                      <source src="<?=$media_path.'uploads/freestyle_library/'.$freestyle['media']?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                            <?php    } else {
                                    echo 'N/A';
                                }
                            }
                            ?>

                        <input type="file" name="media" <?php if(!isset( $freestyle['id'])) { ?>required="" <?php } ?> size="20" />
                        <?php echo form_error('media', '<div class="error">', '</div>'); ?>
                        <div class="charpic"> </div>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="status">Status :</label>
                    <div class="col-sm-10">
                        Active <input class="" type="radio" name="status" value="1" <?php if($freestyle['status']==1) { ?> checked=checked <?php } ?>>
                        Inactive <input class="" type="radio" name="status" value="0" <?php if($freestyle['status']==0) { ?> checked=checked <?php } ?>>
                        <?php echo form_error('active', '<div class="error">', '</div>'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $freestyle['id'] == null?"Add":"Update"?>"  />
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

<?php
$this->load->view('admin_templates/footer');