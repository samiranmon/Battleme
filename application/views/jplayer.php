<!--<html>
<body>-->
<?php 
if(!isset($title)) { $title = ''; }
if(!isset($id)) { $id = 1; }
?>

<div id="<?php echo 'jquery_jplayer_'.$id ;?>" class="jp-jplayer"></div>
<div id="<?php echo 'jp_container_'.$id ;?>" class="jp-audio" role="application" aria-label="media player">
	<div class="jp-type-single">
		<div class="jp-gui jp-interface">
			<div class="jp-controls">
				<button class="jp-play" role="button" tabindex="0">play</button>
				<button class="jp-stop" role="button" tabindex="0">stop</button>
			</div>
			<div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			</div>
			<div class="jp-volume-controls">
				<button class="jp-mute" role="button" tabindex="0">mute</button>
				<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			</div>
			<div class="jp-time-holder">
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-toggles">
					<button class="jp-repeat" role="button" tabindex="0">repeat</button>
				</div>
			</div>
		</div>
		<div class="jp-details">
			<div class="jp-title" aria-label="title">&nbsp;</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){

	$("<?php echo '#jquery_jplayer_'.$id ;?>").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				title: "<?php echo $title; ?>",
				mp3: "<?php echo $path; ?>"
			});
		},
		swfPath: "<?php echo base_url();?>public/js/jplayer/",
		supplied: "mp3",
		wmode: "window",
                cssSelectorAncestor: "<?php echo '#jp_container_'.$id ;?>",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
	});
});

</script>

<!--</body>
</html>-->