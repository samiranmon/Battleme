<div class="col-sm-12"> 
    <section class="panel panel-default scrollable"> 

        <header class="panel-heading"> 
            <span class="h4"></span> 
            <small style="margin-left: 58px;"></small>
        </header> 



        <?php if ($this->session->flashdata('buy_message')) { ?>
            <div class="alert <?php echo $this->session->flashdata('class') ?>"> 
                <button class="close" data-dismiss="alert">x</button>                
                <?php echo $this->session->flashdata('buy_message'); ?>
            </div>
            <?php } ?>

            <section class="panel panel-body">
                <div class="col-lg-12">
                    <h4><?php //$file_name ?></h4>
                </div>

                
                <?php if (!is_null($file_path)) { ?>
                <div class="col-lg-12">
                    <a id="test" href="<?=base_url('download/index/'.$file_name.'/'.  base64_encode($file_path))?>" disabled>Download</a>
                </div>
                <?php } ?>
            </section>

    </section>

</div> 

<script type="text/javascript">
    var downloadButton = document.getElementById("test");
    var counter = 10;

    downloadButton.innerHTML = "You can download the file in 10 seconds.";
    var id;



    id = setInterval(function () {
        counter--;
        if (counter < 0) {
            downloadButton.innerHTML = "Download";
            downloadButton.removeAttribute('disabled');
            downloadButton.click();
            clearInterval(id);
        } else {
            downloadButton.innerHTML = "You can download the file in " + counter.toString() + " seconds.";
        }
    }, 1000);
</script>        