<?php
$this->load->view('admin_templates/header');
$this->load->view('admin_templates/topbar');
$this->load->view('admin_templates/sidebar');
?>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "sPaginationType": "full_numbers",
            "bSort": false
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
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

    <?php //print_r($user); ?>
    <div class=" row">
 <?php if($this->session->flashdata('message')) { ?>
            <p class="text-center" style=" color: green; font-weight: bold"><?php echo $this->session->flashdata('message');?></p>
                <?php }  ?>
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select_all" />Select All</th>
                    <th>User Email</th>
                    <th>User Subject</th>
                    <th>User Message</th>
                    <th>Mail Time</th>
                    <th>Status</th>
                    <th>Reply All<a href="javascript:void(0)" onclick="replyallemail()" data-toggle="modal" data-target="#replyall" title="Replay All"><i class="glyphicon glyphicon-share-alt" aria-hidden="true"></i></a>  </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Select All</th>
                    <th>User Email</th>
                    <th>User Subject</th>
                    <th>User Message</th>
                    <th>Mail Time</th>
                    <th>Status</th>
                    <th>Reply All </th>

                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($contactus as $val) { ?>
                    <tr>
                        <td><input type="checkbox" class="checkbox" onchange="updateemailid(<?php echo $val['id']; ?>)" id="<?php echo $val['id']; ?>" value="<?php echo $val['id']; ?>"/></td>
                        <td><?php echo $val['email']; ?></td>
                        <td><?php echo $val['subject']; ?></td>
                        <td><?php echo $val['message']; ?></td>
                        <td><?php echo $val['time']; ?></td>
                        <td><?php if ($val['status'] == 1) {
                        echo 'Replied';
                    } else {
                        echo 'Not Replied';
                    } ?></td>
                        <td>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal<?php echo $val['id']; ?>" title="Reply"><i class="glyphicon glyphicon-share-alt" aria-hidden="true"></i></a>  
                            <div id="myModal<?php echo $val['id']; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Send Message</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $attributes = array('id' => 'sendsinglemail', 'class' => 'form-horizontal');
                                            echo form_open_multipart('admin_dashboard/send_contactus_mail', $attributes);
                                            ?>
                                            <div class=" row">
                                                <div class="col-md-10 col-sm-10 col-xs-10">

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email">Email Subject:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="subject" id="singlesubject<?php echo $val['id']; ?>" placeholder="Enter subject" value="" required="required">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email">Email Message:</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" id="singlebody<?php echo $val['id']; ?>" name="body">  </textarea>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="replyid" value="<?php echo $val['id']; ?>"/>
                                                </div>
                                            </div>
                                           
                                               
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" name="submittest" onclick="validatesinglemail(<?php echo $val['id']; ?>)" class="btn btn-primary" value="Send" />
                                            <div style="display:none"><input type="submit" id="submitsingle<?php echo $val['id']; ?>" name="submit" class="btn btn-primary" value="Send" /></div>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                         <?php echo form_close(); ?> 
                                    </div>

                                </div>
                            </div>
                        </td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
        <div id="replyall" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Send Mass Message</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $attributes = array('id' => 'editprofile1', 'class' => 'form-horizontal');
                                            echo form_open_multipart('admin_dashboard/send_contactus_mass_mail', $attributes);
                                            ?>
                                            <div class=" row">
                                                <div class="col-md-10 col-sm-10 col-xs-10">

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email">Email Subject:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="subject" id="masssubject" placeholder="Enter Subject" value="">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="email">Email Message:</label>
                                                        <div class="col-sm-10">
                                                             <textarea class="form-control" id="massbody" name="body">  </textarea>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="replyid" id="replyid" value=""/>
                                                </div>
                                            </div>
                                            
                                                
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" onclick="validatemassmail()" name="submitmassemail" class="btn btn-primary" value="Send" />
                                            <div style="display:none">
                                                <input type="submit" name="submitmass" id="submitmassemail" class="btn btn-primary" value="Send" />
                                            </div>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                        <?php echo form_close(); ?> 
                                    </div>

            </div>
        </div>
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
        function validatesinglemail(str) {
            
            var subject = $('#singlesubject'+str).val();
            var body = $('#singlebody'+str).val();
            if ((subject!='') && (body!='')) {
                $("#submitsingle"+str).click();
            }else{
                alert('Please enter subject and message');
            }

        }
        function validatemassmail() {
            
            var subject = $('#masssubject').val();
            var body = $('#massbody').val();
            if ((subject!='') && (body!='')) {
                $("#submitmassemail").click();
            }else{
                alert('Please enter subject and message');
            }

        }
        function updateemailid(){
             var arr = $('.checkbox:checked').map(function () {
         return this.value;
     }).get();
     $('#replyid').val(arr);
        }
        function replyallemail(){
            var status = this.checked; // "select all" checked status
            var valu = [];
            $('.checkbox').each(function (i) { //iterate all listed checkbox items
                
                this.checked = status; //change ".checkbox" checked status
                
                valu[i] = $(this).val();
                $('#replyid').val(valu);
                //alert(valu);
            });
            $( ".select_all" ).prop( "checked", true );
            $( ".checkbox" ).prop( "checked", true );
        }
    </script>
    <script>
        $(".select_all").change(function () {  //"select all" change
            var status = this.checked; // "select all" checked status
            var valu = [];
            $('.checkbox').each(function (i) { //iterate all listed checkbox items
                
                this.checked = status; //change ".checkbox" checked status
                
                valu[i] = $(this).val();
                $('#replyid').val(valu);
                //alert(valu);
            });
        });

        $('.checkbox').change(function () { //".checkbox" change
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (this.checked == false) { //if this item is unchecked
                $(".select_all")[0].checked = false; //change "select all" checked status to false
            }

            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $(".select_all")[0].checked = true; //change "select all" checked status to true
            }
        });
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
?>