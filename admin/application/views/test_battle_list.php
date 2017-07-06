<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sess_data = get_session_data();
?>
<div class="midsection">
    <h4 class="battle-list-heading">
        <?php
        if ($battleType == '')
            echo 'BATTLE LIST';
        ?>
    </h4>

    <div class="battle-list-block">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs responsive-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#01" aria-controls="01" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-01.png" alt="battle-img-01">
                </a>
            </li>
            <li role="presentation">
                <a href="#02" aria-controls="02" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-02.png" alt="battle-img-02">
                </a>
            </li>
            <li role="presentation">
                <a href="#03" aria-controls="03" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-03.png" alt="battle-img-03">
                </a>
            </li>
            <li role="presentation">
                <a href="#04" aria-controls="04" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-04.png" alt="battle-img-04">
                </a>
            </li>
            <li role="presentation">
                <a href="#05" aria-controls="05" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-05.png" alt="battle-img-05">
                </a>
            </li>
            <li role="presentation">
                <a href="#06" aria-controls="06" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-06.png" alt="battle-img-06">
                </a>
            </li>
            <li role="presentation">
                <a href="#07" aria-controls="07" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-07.png" alt="battle-img-07">
                </a>
            </li>
            <li role="presentation">
                <a href="#08" aria-controls="08" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-08.png" alt="battle-img-08">
                </a>
            </li>
            <li role="presentation">
                <a href="#09" aria-controls="09" role="tab" data-toggle="tab">
                    <img src="<?= base_url() ?>public/images/battle-img-09.png" alt="battle-img-09">
                </a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="01">
                <h2>01</h2>
                <div class="examples">
                    <div id="tab01" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>


            </div>
            <div role="tabpanel" class="tab-pane" id="02">
                <h2>02</h2>
                <div class="examples">
                    <div id="tab02" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="03">
                <h2>03</h2>
                <div class="examples">
                    <div id="tab03" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="04">
                <h2>04</h2>

                <div class="examples">
                    <div id="tab04" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="05">
                <h2>05</h2>
                <div class="examples">
                    <div id="tab05" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="06">
                <h2>06</h2>
                <div class="examples">
                    <div id="tab06" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="07">
                <h2>07</h2>
                <div class="examples">
                    <div id="tab07" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="08">
                <h2>08</h2>
                <div class="examples">
                    <div id="tab08" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="09">
                <h2>09</h2>
                <div class="examples">
                    <div id="tab09" class="eg tab-block">

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-01.jpg" alt="user-img-01">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like-green.png" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-05.jpg" alt="user-img-05">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-02.jpg" alt="user-img-02">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-06.jpg" alt="user-img-06">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-03.jpg" alt="user-img-03">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-07.jpg" alt="user-img-07">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>

                        <div class="user-battle">
                            <div class="user-battle-left">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-04.jpg" alt="user-img-04">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-battle-right">
                                <div class="userbattle-img">
                                    <img src="<?= base_url() ?>public/images/user-img-08.jpg" alt="user-img-08">
                                </div>
                                <div class="userbattle-text">
                                    <h2>User Name</h2>
                                    <p>Song Name</p>
                                    <div class="like-place">
                                        <div class="like-btn">
                                            <a href=""><img src="<?= base_url() ?>public/images/like.jpg" alt="like"></a>
                                        </div>
                                        <div class="like-point">0</div>
                                    </div>
                                </div>
                            </div>

                            <div class="go-to-battel"> <a href=""> Go to Battle </a></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>



</div>