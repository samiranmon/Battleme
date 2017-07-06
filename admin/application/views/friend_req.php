<?php foreach($frnd_reqs as $req_data):?>
<div class='col-lg-4' id="div<?php echo $req_data['id']; ?>">
        <section class='panel panel-info'>
                <div class='panel-body'> 
                        <a href='' class='thumb pull-right m-l m-t-xs avatar'> 
                        		<?php if($req_data['profile_picture'] != ''):?>
                                <img src='<?php echo base_url('uploads/profile_picture/thumb_'.$req_data['profile_picture']);?>' alt=''> 
                           		<?php else: ?>
                           		<img src='<?php echo base_url('uploads/profile_picture/default.png');?>' alt=''> 
                           		<?php endif; ?>	
                                <i class='on md b-white bottom'></i> 
                        </a> 
                        <div class='clear'> 
                                <a href="<?php echo base_url('profile/view/'.$req_data['id']);?>" class='text-info'><?php echo $req_data['firstname']." ".$req_data['lastname']; ?><i class='icon-twitter'></i>
                                </a> 
                                <small class='block text-muted'><?php echo $req_data['city'].",".$req_data['country']; ?></small> 
                                <a  class='btn btn-xs btn-success m-t-xs req' userid="<?php echo $req_data['id']; ?>">accept</a> 
                        </div> 
                </div> 
        </section>
</div> 
<?php endforeach; ?>

<script src="<?php echo base_url('public/js/jquery.min.js'); ?>"></script>
<script>
$(document).ready(function(){
$(".req").click(function () {
        var url = "<?php echo base_url();?>";
            var frndid = $(this).attr('userid');
            console.log(url + 'friends/accept_frnd_req/'+frndid);
            $.ajax({
                url: url + 'friends/accept_frnd_req/'+frndid,
                type: 'POST',
                success: function(result){
                        $("#div"+frndid).remove();
                }
            });
        });
});
</script>       
