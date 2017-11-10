<?php
$form_attr = array('name' => 'battle_media', 'id' => 'battle_media', 'class' => '', 'data-validate' => 'parsley',);
$title_data = array(
    'name' => 'title',
    'id' => 'title',
    'class' => 'form-control',
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
    'value' => 'Upload',
    'type' => 'Submit',
    'class' => 'btn btn-success btn-s-xs',
    'content' => 'Upload'
);
?>
<style type="text/css">
    .button{
        display: inline-block;
        vertical-align: middle;
        margin: 0px 5px;
        padding: 5px 12px;
        cursor: pointer;
        outline: none;
        font-size: 13px;
        text-decoration: none !important;
        text-align: center;
        color:#fff;
        background-color: #4D90FE;
        background-image: linear-gradient(top,#4D90FE, #4787ED);
        background-image: -ms-linear-gradient(top,#4D90FE, #4787ED);
        background-image: -o-linear-gradient(top,#4D90FE, #4787ED);
        background-image: linear-gradient(top,#4D90FE, #4787ED);
        border: 1px solid #4787ED;
        box-shadow: 0 1px 3px #BFBFBF;
    }
    a.button{
        color: #fff;
    }
    .button:hover{
        box-shadow: inset 0px 1px 1px #8C8C8C;
    }
    .button.disabled{
        box-shadow:none;
        opacity:0.7;
    }
    canvas{
        display: block;
    }
</style>

<div id="file_upload_popup" class="modal fade common-modal-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Upload your voice</h4>
            </div>

            <div class="modal-body">

                <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
                        <button class="close" data-dismiss="alert">x</button>                
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>

                <?= form_open_multipart('battle/upload_live_voice', $form_attr) ?>
                <section class="panel-default panel"> 

                    <header class="panel-heading"> 
                        <span class="h4">Upload Recording</span> 
                    </header> 
                    <div class="panel-body"> 

                        <div class="form-group"> 
                            <input name="challenger_user_id" value="<?= $battle_details['user_id'] ?>" type="hidden">
                            <input type="hidden" name="battle_id" value="<?= $battle_details['battle_request_id'] ?>">

                            <div class="form-group"> 
                                <label>Title</label> 
                                <?php
                                echo form_input($title_data);
                                echo form_error('title', '<div class="error">', '</div>');
                                ?>
                            </div> 

                            <div class="form-group"> 

                                <?php
                                //echo form_upload($media_data);
                                //echo form_error('media', '<div class="error">', '</div>');
                                ?>


                                <audio controls src="" id="audio"></audio>
                                <div style="margin:10px;">
                                    <a class="button" id="record">Record</a>
                                    <a class="button disabled one" id="pause">Pause</a>
                                    <a class="button disabled one" id="stop">Reset</a>

                                    <a style="" class="button disabled one" id="play">Play</a>
                                    <!--<a class="button disabled one" id="download">Download</a>
                                    <a class="button disabled one" id="base64">Base64 URL</a>
                                    <a class="button disabled one" id="mp3">MP3 URL</a> -->

                                    <a class="button disabled one" id="save">Upload</a>
                                </div>
<!--                                <input class="button" type="checkbox" id="live"/>
                                <label for="live">Live Output</label>-->
                                <canvas id="level" height="200" width="500"></canvas>


                                <div class="progress" style="display: none">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" process-val="0" style="width:0%">
                                        <span class="sr-only red1" style="width: 0%; background-color: red; display: block; float: left;height: 22px;z-index: 100; position: relative;">&nbsp;</span>
                                        <!--<span class="sr-only blue1" style="width: 0%; background-color: blue; display: block; float: left;height: 22px;z-index: 100; position: relative;">&nbsp;</span>-->
                                        <!--<span class="sr-only red2" style="width: 0%; background-color: red; display: block; float: left;height: 22px;z-index: 100; position: relative;">&nbsp;</span>-->
                                        <!--<span class="sr-only blue1" style="width: 0%; background-color: blue; display: block; float: left;height: 22px;z-index: 100; position: relative;">&nbsp;</span>'-->
                                    </div>
                                </div>
                                <h3>Time clock <span class="time_clock">0</span> seconds</h3>
                                
                                
                            </div> 
                        </div> 

                        <div class="text-right lter"> 
                            <?php //echo form_submit($data_submit) ?>
                        </div>
                    </div>
                </section> 
                <?php echo form_close(); ?>



                <!--//For chat section-->
                <div class="" style="display: none;">
                    <section>
                        <div id="requirements">
                            <p>To use this demo, you'll need the most recent version of the Edge browser, Chrome or Firefox , and a microphone attached to your Windows 10 device.</p>
                        </div>
                        <div id="supportWarning" class="block-note--error">
                            <p>Warning - Your browser does not support the ORTC or WebRTC APIs. Please switch to a PC with a recent version of Windows 10 and try again.</p>
                        </div>
                        <div id="microphoneWarning" class="block-note--error">
                            <p>Error - we can't find a microphone attached to your PC. Please switch to a PC with a microphone attached and try again.</p>
                        </div>
                    </section>
                    
                    <section id="roomContainer" >
                        <form id="createRoom">
                            <button disabled type="submit" class="button">Create conference</button>
                        </form>

                        <div class='peerContainer local'>
                            <div class="local-details">
                                <input id="nickInput" placeholder="Add your name"/>
                                <audio id="localAudio" controls oncontextmenu="return false;" disabled></audio>
                                <img id="snapshot" src="img/avatar-default.png" class="avatar"/>
                                <video id="snapshotvideo" class="avatar"></video> 
                                <div id='countdown'></div>
                                <!-- add class of 'muted' when so -->
                                <a class="button button-small button-mute">Mute</a>
                            </div>
                            <div class="local-controls">
                                <button class="button button-small" id="snapshotButton">Take a snapshot</button>
                            </div>
                        </div>
                        
                        <div id="remotes"></div>
                    </section>
                </div>




            </div>

        </div>
    </div>
</div>

<!-- For recording voice -->
<script type="text/javascript">
    function restore() {
        $("#record, #live").removeClass("disabled");
        $("#pause").replaceWith('<a class="button one" id="pause">Pause</a>');
        $(".one").addClass("disabled");
        Fr.voice.stop();
    }
    $(document).ready(function () {
        $(document).on("click", "#record:not(.disabled)", function () {
            elem = $(this);
            Fr.voice.record($("#live").is(":checked"), function () {
                elem.addClass("disabled");
                $("#live").addClass("disabled");
                $(".one").removeClass("disabled");

                /**
                 * The Waveform canvas
                 */
                analyser = Fr.voice.context.createAnalyser();
                analyser.fftSize = 2048;
                analyser.minDecibels = -90;
                analyser.maxDecibels = -10;
                analyser.smoothingTimeConstant = 0.85;
                Fr.voice.input.connect(analyser);

                var bufferLength = analyser.frequencyBinCount;
                var dataArray = new Uint8Array(bufferLength);

                WIDTH = 500, HEIGHT = 200;
                canvasCtx = $("#level")[0].getContext("2d");
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                function draw() {
                    drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);
                    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    var sliceWidth = WIDTH * 1.0 / bufferLength;
                    var x = 0;
                    for (var i = 0; i < bufferLength; i++) {
                        var v = dataArray[i] / 128.0;
                        var y = v * HEIGHT / 2;

                        if (i === 0) {
                            canvasCtx.moveTo(x, y);
                        } else {
                            canvasCtx.lineTo(x, y);
                        }

                        x += sliceWidth;
                    }
                    canvasCtx.lineTo(WIDTH, HEIGHT / 2);
                    canvasCtx.stroke();
                }
                ;
                draw();
            });
        });

        $(document).on("click", "#pause:not(.disabled)", function () {
            if ($(this).hasClass("resume")) {
                Fr.voice.resume();
                $(this).replaceWith('<a class="button one" id="pause">Pause</a>');
            } else {
                Fr.voice.pause();
                $(this).replaceWith('<a class="button one resume" id="pause">Resume</a>');
            }
        });

        $(document).on("click", "#stop:not(.disabled)", function () {
            restore();
        });

        $(document).on("click", "#play", function () {
            Fr.voice.export(function (url) {
                $("#audio").attr("src", url);
                $("#audio")[0].play();
            }, "URL");
            restore();
        });

        $(document).on("click", "#download:not(.disabled)", function () {
            Fr.voice.export(function (url) {
                $("<a href='" + url + "' download='MyRecording.wav'></a>")[0].click();
            }, "URL");
            restore();
        });

        $(document).on("click", "#base64:not(.disabled)", function () {
            Fr.voice.export(function (url) {
                console.log("Here is the base64 URL : " + url);
                alert("Check the web console for the URL");

                $("<a href='" + url + "' target='_blank'></a>")[0].click();
            }, "base64");
            restore();
        });

        $(document).on("click", "#mp3:not(.disabled)", function () {
            alert("The conversion to MP3 will take some time (even 10 minutes), so please wait....");
            Fr.voice.export(function (url) {
                console.log("Here is the MP3 URL : " + url);
                alert("Check the web console for the URL");

                $("<a href='" + url + "' target='_blank'></a>")[0].click();
            }, "mp3");
            restore();
        });

        $(document).on("click", "#save:not(.disabled)", function () {
            //$('#play').trigger("click");
            Fr.voice.export(function (blob) {
                var formData = new FormData();
                formData.append('media', blob);
                formData.append('Submit', 'Upload');
                formData.append('battle_id', $("input[name='battle_id']").val());
                formData.append('title', $("input[name='title']").val());

                $.ajax({
                    url: "<?= base_url() . 'battle/upload_live_voice' ?>",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (parseInt(obj.status) == 1) {
                            window.location.href = obj.url;
                        }
                    }
                });
            }, "blob");
            restore();
        });
        
        
        // For check room is created
        var checkRoom = function() {
            
             if( $('#remotes').is(':empty') ) {
                $('.progress').hide();
                $('.time_clock').html(0);
                $('.progress-bar').attr("process-val", 0);
                $('.progress-bar,.red1').css("width", 0);
            } else {
                $('.progress').show();
                
                $('.time_clock').each(function() {
                    
                  var count = parseInt($(this).html());
                  var process_val = parseFloat($('.progress-bar').attr('process-val'));
                  
                      if (count !== 240 && count <= 240 ) {
                        $(this).html(count + 1);
                        $('.progress-bar').attr("process-val", process_val+ 0.416);
                        $('.progress-bar').css("width", process_val+ 0.416+"%");
                        
                        if(process_val+ 0.416 > 0 && process_val+ 0.416 <= 25) {
                            $('.red1').css("width", process_val+ 0.416"%");
                        }
                        
                      } else {

                      }
                });
                
            }
          };
        setInterval(checkRoom, 1000);
        
    });
</script>
