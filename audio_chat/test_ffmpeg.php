<?php

$source1 = 'uploads/3382415651192592.wav'; // Aneel
$source2 = 'uploads/7402743258828378.ogg';
$mergedFile = 'uploads/test_ffmpeg3.mp3';
//echo shell_exec("/usr/local/bin/ffmpeg -i ".$source2." -i ".$source1." -map 1:0 -map 1:0 ".$mergedFile." 2>&1");
//ffmpeg -i input1.mp3 -i input2.mp3 -filter_complex amerge -ac 2 -c:a libmp3lame -q:a 4 output.mp3
//echo shell_exec("/usr/local/bin/ffmpeg -i ".$source2." -i ".$source1." -filter_complex amerge -ac 2 -c:a libmp3lame -q:a 4 ".$mergedFile." 2>&1");
//echo shell_exec("ffmpeg -i ".$source2." -i ".$source1." -filter_complex amerge -ac 2 -c:a libmp3lame -q:a 4 ".$mergedFile." 2>&1");
echo shell_exec("ffmpeg -i ".$source2." -vn -ab 192k -acodec libmp3lame -ac 2 ".$mergedFile." 2>&1");

//ffmpeg -i uploads/aetzlertest.mp3 -i uploads/yo9.mp3 -filter_complex amerge -ac 2 -c:a libmp3lame -q:a 4 uploads/output_merge.mp3 // Done