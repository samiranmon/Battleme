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


                                <!--<audio controls src="" id="audio"></audio>-->
                                <div style="margin:10px;">
                                    <a class="button" id="record">Record</a>
                                    <a class="button disabled one" id="pause">Pause</a>
                                    <a class="button disabled one" id="stop">Reset</a>
                                    
                                    <!--<a style="" class="button disabled one" id="play">Play</a>-->
                                    <!--<a class="button disabled one" id="download">Download</a>
                                    <a class="button disabled one" id="base64">Base64 URL</a>
                                    <a class="button disabled one" id="mp3">MP3 URL</a> -->
                                    
                                    <a class="button disabled one" id="save">Upload</a>
                                </div>
<!--                                <input class="button" type="checkbox" id="live"/>
                                <label for="live">Live Output</label>-->
                                <canvas id="level" height="200" width="500"></canvas>



                            </div> 
                        </div> 

                        <div class="text-right lter"> 
                            <?php //echo form_submit($data_submit) ?>
                        </div>
                    </div>
                </section> 
                <?php echo form_close(); ?>


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
                    url: "<?=base_url().'battle/upload_live_voice'?>",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if(parseInt(obj.status) == 1) {
                            window.location.href = obj.url;
                        }
                    }
                });
            }, "blob");
            restore();
        });
    });
</script>
