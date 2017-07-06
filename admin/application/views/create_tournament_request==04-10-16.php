<script src="<?php echo base_url()?>public/js/parsley/parsley.min.js"></script>
<script src="<?php echo base_url()?>public/js/parsley/parsley.extend.js"></script>
<?php
 $selectStr = 'class="form-control"';

 $title_data = array(
     'name'          => 'tournament_name',
     'id'            => 'tournament_name',
     'class'         => 'form-control',
     'maxlength'     => '125',
     'placeholder'   => 'Tournament Name',
     'value'         => set_value('tournament_name'),
     'data-required' => 'true'
 );
 
 $description_data = array(
     'name'          => 'description',
     'id'            => 'description',
     'class'         => 'form-control',
     'maxlength'     => '225',
     'placeholder'   => 'Description',
     'value'         => set_value('description'),
     'data-required' => 'true'
 );
 
  $entry_data = array(
     'name'          => 'entry',
     'id'            => 'entry',
     'class'         => 'form-control',
     'maxlength'     => '225',
     'placeholder'   => 'Entry',
     'type'          => 'number',
     'value'         => set_value('entry'),
     'data-required' => 'true'
 );
  
   $prize_data = array(
     'name'          => 'prize',
     'id'            => 'prize',
     'class'         => 'form-control',
     'maxlength'     => '225',
     'placeholder'   => 'Prize',
     'type'          => 'number',
     'value'         => set_value('prize'),
     'data-required' => 'true'
 );
 
 $data_submit = array(
      'name'    => 'Submit',
      'id'      => 'Submit',
      'value'   => 'Create',
      'type'    => 'Submit',
      'class'   => 'btn btn-success btn-s-xs',
      'content' => 'Create'
);

 $form_attr = array('name' => 'frm_tournament', 'id' => 'tournament_battle' , 'class' => '' , 'data-validate' => 'parsley');
?>
<section id="content">
    <div> 
	<?php echo form_open('' , $form_attr); ?>
	    <section class="panel panel-default"> 
                <?php 
	 
	    if ($this->session->flashdata('message')) {
		     ?>
		     <div class="alert <?php echo $this->session->flashdata('class')?>"> 
			 <button class="close" data-dismiss="alert">x</button>                
			 <?php echo $this->session->flashdata('message'); ?>
		     </div>
          
         <?php  } ?>
		<header class="panel-heading"> 
		    <span class="h4">Create Tournament Request</span> 
		</header> 
		<div class="panel-body"> 
		    
		    <div class="form-group"> 
			<!--<label>Select Friends</label> 
			   < ?php echo form_multiselect('friend_user_id[]' , $friendsOpt , $selectStr) ;?>
			</div> -->
			 <div class="form-group"> 
			    <label>Tournament Name</label> 
			    <?php echo form_input($title_data);?>
			</div>
                        <div class="form-group"> 
			    <label>Tournament Entry fees</label> 
			    <?php echo form_input($entry_data);?>
			</div>
                        <div class="form-group"> 
			    <label>Tournament winning prize</label> 
			    <?php echo form_input($prize_data);?>
			</div>
			 <div class="form-group"> 
			    <label>Description</label> 
			    <?php echo form_textarea($description_data);?>
			</div> 
		    </div> 
		    
		<footer class="panel-footer text-right bg-light lter"> 
		    <?php echo form_submit($data_submit)?>
		</footer> 
	    </section> 
	<?php echo form_close(); ?>
			</div>

</section>

