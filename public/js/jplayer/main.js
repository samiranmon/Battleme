$(document).ready(function(){

    $("#jquery_jplayer_1").jPlayer({
        ready: function () {
            $(this).jPlayer("setMedia", {
                mp3: "//10.0.30.42/Battle/uploads/library/1.mp3",
            }); // auto play
        },
        ended: function (event) {
            $(this).jPlayer("play");
        },
        swfPath: "/js",
        supplied: "mp3"
    })
    .bind($.jPlayer.event.play, function() { // pause other instances of player when current one play
            $(this).jPlayer("pauseOthers");
    });

});
