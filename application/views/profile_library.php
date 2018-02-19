<h3 class="pro-tab-head">Add Songs to library</h3>

<?php if ($this->session->flashdata('song_message')) { ?>
    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
        <button class="close" data-dismiss="alert">x</button>                
         <?php echo $this->session->flashdata('song_message'); ?>
    </div>
<?php } ?>  

<?php
     $user_id = $this->session->userdata('logged_in')['id'];
     $songs = get_user_songs($user_id);
     //echo '<pre>';     print_r($songs);
//					    $sessionData = get_session_data();
//					    $user_id = $sessionData['id'];
//					    if($friend_id == $user_id)
     $addForm = true;
//					    else
//						$addForm = false;

     if ($addForm) {
         //upload media form data

         $title_data = array(
             'name' => 'title',
             'id' => 'title',
             'class' => 'form-control input-b',
             'maxlength' => '125',
             'placeholder' => 'Media Title',
             'value' => set_value('title'),
             'data-required' => 'true'
         );
         $media_data = array(
             'name' => 'media',
             'id' => 'media',
             'class' => '',
             'maxlength' => '225',
             'data-required' => 'true'
         );
         $data_submit = array(
             'name' => 'Submit',
             'id' => 'Submit',
             'value' => 'Create',
             'type' => 'Submit',
             'class' => 'btn btn-success btn-s-xs',
             'content' => 'Upload'
         );

         $form_attr = array('name' => 'add_song', 'id' => 'add_song', 'class' => '', 'data-validate' => 'parsley');
         echo form_open_multipart('profile/add_song', $form_attr);
?>

<div class="librarypanel-body"> 
    <div class="form-group for-b-la"> 
        <label>Title</label> 
        <?php
             echo form_input($title_data);
             echo form_error('title','<div class="error">','</dev>');
             ?>
    </div> 
    <div class="form-group for-b-la"> 
        <label>Song</label> 
         <?php
             echo form_upload($media_data);
             echo form_error('media');
             ?>
    </div> 
    <?php echo form_submit($data_submit) ?>
</div>
<?php echo form_close(); ?>
<?php } ?>
    
    <div  class="col-lg-12">

        <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs"> 
            <?php
             if (!empty($songs)) {
                 //echo '<pre>'; print_r($songs);
                 foreach ($songs as $key => $value) {
                     $song_id = $value['sId'];
                     $media = $this->config->item('library_media_path') . $value['media'];
                     //$media = base_url() . 'uploads/library/'.$value['media'];
                     $artist = $value['user_id'];
                     $title = $value['title'];
                     $likeCount = $value['likeCount'];

                     $file_ext = pathinfo($value['media'], PATHINFO_EXTENSION);
                     if(file_exists(getcwd() . '/uploads/library/' . $value['media']) && $value['media'] !='') {
                     ?>


                    <li class="list-group-item ">
                        

                             <?php 
                                 if ( in_array($file_ext, ['mp4','ogg','webm'] ) ) { ?>
                                        <video width="100%" controls="controls">
                                            <source type="video/mp4" src="<?=base_url().$media?>"></source>
                                        </video>
                                 <?php } else { 
                                     $this->view('responsive_player', ['path'=>base_url().$media, 'id'=>$key]); 
                                     //$this->view('jplayer', ['path'=>base_url().$media, 'id'=>$key]); 
                                 }
                             ?> 

                        <a class="clear" href="javascript:void(0)"> 
                            <span class="block text-ellipsis"><?php echo $title ?></span>
                        </a>&nbsp;
                        
                        <span class="pull-right padder">
                            <a data-toggle="button" dataid="<?php echo $song_id; ?>" alt="<?php echo $user_id ?>" class="btn btn-default  active songLike"> 
                                <span class="text-active"> 
                                    <i class="fa fa-thumbs-o-up text"></i> 
                                    <span class="like_count_<?php echo $song_id; ?>"><?php echo $likeCount; ?></span>
                                </span>     
                            </a> 
                        </span>
                        
                        <?php //if($value['battle_media']==NULL && $value['tournament_media']==NULL) { ?>
                            <a title="Delete Library" class="clear glyphicon glyphicon-trash" onclick="deleteLibrary('<?=  base64_encode($value['sId'])?>')" href="javascript:void(0);"> 
                            </a>
                        <?php //} ?>

                    </li> 
                 <?php
                 } }
             } else {
                 echo "<div class='alert alert-danger'>User has not uploaded any song</div>";
             }
            ?>
        </ul>

    </div>

<script type="text/javascript">
    function deleteLibrary(libId) { 
        var url = "<?php echo base_url(); ?>";
        if (confirm("Are you sure you want to delete this library!") == true) {
           window.location = url+"profile/delete_library/"+libId;
        }  
    }
</script>