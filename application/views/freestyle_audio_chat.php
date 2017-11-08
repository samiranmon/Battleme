<!DOCTYPE html>
<html>
    <head>
        <!--<link rel="stylesheet" href="https://edgeportal.blob.core.windows.net/media/demotemplate.css" />-->
        <link rel="stylesheet" href="<?php echo base_url('public/js/audio_chat/audio.css'); ?>" />
    </head>
    
    
    
    <body onload='GUM()'>
        <div class="content cf">
            <section>
                <h1>SimpleWebRTC</h1>
                <h3>Use Edge's ORTC API and the WebRTC APIs in Chrome and Firefox to make cross-browser conference calls.</h3>
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
            <section id="roomContainer" class="cf">
                <h4 id="subtitle"></h4>
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
        
        <script src="<?php echo base_url('public/js/audio_chat/audio.js'); ?>"></script>
        <script src="<?php echo base_url('public/js/audio_chat/latest-v2.js'); ?>"></script>
    </body>
</html>