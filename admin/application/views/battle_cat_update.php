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
                <a href="<?php echo base_url(); ?>battle_category/">Battle Category</a>
            </li>
            
        </ul>
    </div>

    <div class=" row">


        <?php if ($this->session->flashdata('Success')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('Success'); ?></p>
        <?php
        }

        $attributes = array('id' => 'editprofile1', 'class' => 'form-horizontal');
        echo form_open_multipart('battle_category/update' . '/' . $bcategory['id'], $attributes);
        ?>
        <div class=" row">
            <div class="col-md-10 col-sm-10 col-xs-10">

                <div class="form-group">
                    <label class="control-label col-sm-2" for="title">Parent Category :</label>
                    <div class="col-sm-10">
                        <?php 
                            $options = [''=>'--Select parent category--', 1=>'Audio',2=>'Video',3=>'Freestyle'];
                            echo form_dropdown('parent_id', $options, $bcategory['parent_id']==''?set_value('parent_id'):$bcategory['parent_id'], 'class="form-control" id="parent_id" placeholder="Enter Parent Category"');
                        ?>
                        <?php echo form_error('parent_id', '<div class="error">', '</div>'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="title">Category Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name" value="<?php echo $bcategory['name'] ?>">
                        <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="title">Time duration :</label>
                    <div class="col-sm-10">
                        <input type="number" min="1" max="100" class="form-control" name="time_duration" id="time_duration" placeholder="Enter battle time duration" value="<?php echo $bcategory['time_duration'] ?>">
                        <?php echo form_error('time_duration', '<div class="error">', '</div>'); ?>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="media">Category Logo :</label>
                    <div class="col-sm-10">
                        <?php 
                            if(isset( $bcategory['id'])) {
                                $getcwd = substr(getcwd(), 0, strpos(getcwd(), "admin"));
                                $m_path = base_url();
                                $media_path = substr($m_path, 0, strpos($m_path, "admin"));
                                //echo getcwd().'/uploads/freestyle_library/'.$val['media'];
                                if($bcategory['media'] != '' && file_exists($getcwd.'/uploads/battle_category/'.$bcategory['media'])) { ?>
                                    <img src="<?=$media_path.'uploads/battle_category/'.$bcategory['media']?>" alt="<?=$bcategory['name']?>" >
                            <?php } else {
                                    echo 'N/A';
                                }
                            }
                            ?>

                        <input type="file" name="media" <?php if(!isset( $bcategory['id'])) { ?>required="" <?php } ?> size="20" />
                        <?php echo form_error('media', '<div class="error">', '</div>'); ?>
                        <div class="charpic"> </div>
                    </div>
                </div>
                
                
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="status">Status :</label>
                    <div class="col-sm-10">
                        <?php
                                $battle_cat = [1 =>'Rnb & pop Originals', 2 => 'RnB & Pop Covers', 3 => 'Hiphop', 4 => 'Video Battles', 5 => 'Freestyle', 6 => 'Raggeton', 7=> 'Latino hip hop', 8 => 'Latino songs originals', 9 => 'Latino songs covers'];
                                if(array_key_exists($bcategory['id'], $battle_cat)){
                            ?>
                        <?php echo $bcategory['status']==0? 'Inactive':'Active' ?>
                        <input type="hidden" name="status" value="1">
                        <?php } else { ?>
                        Active <input class="" type="radio" name="status" value="1" <?php if($bcategory['status']==1) { ?> checked=checked <?php } ?>>
                        Inactive <input class="" type="radio" name="status" value="0" <?php if($bcategory['status']==0) { ?> checked=checked <?php } ?>>
                        <?php echo form_error('active', '<div class="error">', '</div>'); ?>
                        <?php } ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $bcategory['id'] == null?"Add":"Update"?>"  />
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