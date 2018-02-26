<?php if ($this->router->fetch_class() == 'home') { ?>
    <div class="top3artist">
        <div class="examples">
            <div id="eg3" class="eg">
                <h3>Top 100 Videos</h3>
                <ul>
                    <?php
                    if (isset($top_songs) && !empty($top_songs)) {
                        $i = 1;
                        foreach ($top_songs as $songKey => $songValue) {
                            $media = $this->config->item('library_media_path') . $songValue['media'];
                            $title = $songValue['title'];

                            if (file_exists(getcwd() . '/' . $media) && $songValue['file_type'] == 2) { ?>
                                <li>
                                    <span><?= $i ?></span>
                                    <a href="javascript:void(0)"><?= $title ?></a> 
                                    <a data-toggle="modal" data-target="#videoModal<?= $songKey ?>" href="javascript:void(0)"> <img src="<?php echo base_url(); ?>public/images/play_btn.jpg" alt=""> </a>
                                </li>
                            <?php $i++; }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>          
    </div>


    <?php
    if (isset($top_songs) && !empty($top_songs)) {
        foreach ($top_songs as $songKey => $songValue) {
            $media = $this->config->item('library_media_path') . $songValue['media'];
            if (file_exists(getcwd() . '/' . $media)) {
                ?>
                <!-- Modal -->
                <div id="videoModal<?= $songKey ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <video width="400" controls="controls">
                                    <source type="video/mp4" src="<?= base_url() . $media ?>"></source>
                                </video>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            <?php }
        }
    } ?>
<?php } ?>