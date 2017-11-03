<?php if($this->router->fetch_class() == 'home') { ?>
<div class="top2artist">
    <div class="examples">
        <div id="eg2" class="eg soundWidget">
            <h3>Top 100 Songs</h3>
            <ul></ul>
        </div>
    </div>          
</div>

<?php
$song_array = [];
if (isset($top_songs) && !empty($top_songs)) {
    foreach ($top_songs as $songKey => $songValue) {
        
        $ext = pathinfo($songValue['media'], PATHINFO_EXTENSION);
        if($ext == 'mp3') {
            $song_id = $songValue['sId'];
            $media = $this->config->item('library_media_path') . $songValue['media'];
            $artist = $songValue['user_id'];
            $artistName = ucfirst($songValue['firstname']);
            $title = substr($songValue['title'], 0,14);
            $likeCount = $songValue['likeCount'];
            
            if (file_exists(getcwd().'/'. $media)) {
                $song_array[] = [base_url() . $media, $title, 'Song by ' . $artistName];
            } else if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/battleme/' . $media)) {
                $song_array[] = [base_url() . $media, $title, 'Song by ' . $artistName];
            }
        }
    }
}

 $songs_str = json_encode($song_array); 
?>

<script type="text/javascript">
    var soundArr = <?=$songs_str?>;
    var sLan = soundArr.length; 

    for (i = 0; i < sLan; i++) {
        var songCount = i + 1;
        $(".soundWidget ul").append("<li><span>" + songCount + "</span><div class=audioleft><a href=#>" + soundArr[i][1] + "</a><span class=author>" + soundArr[i][2] + "</span></div><div class=audioright><audio><source src='" + soundArr[i][0] + "'  type=audio/mpeg></audio><button class=Soundplay></button><button class=Soundpause></button></div></li>");
    }
    var aud = new Audio();
    var pp;
    $(".soundWidget ul li").each(function () {

        $(this).find(".Soundplay").click(function () {
            pp = $(this).prev().find("source").attr("src");
            aud.src = pp;
            aud.pause();
            aud.play();
        });
        $(this).find(".Soundpause").click(function () {
            aud.src = pp;
            aud.pause();
        });
    });
</script>
<?php } ?>