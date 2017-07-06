<!DOCTYPE html>
<html lang="en" class="app" ng-app="battle">
    <?php $this->load->view('templates/header') ?>
    <?php
    $templateData = get_template_data();
    @extract($templateData);
    // print_r($templateData);
    $userdata['navigationbar_home'] = $navigationbar_home;
    $this->load->view('home_searchbar', $userdata);
    ?>
    <section  class="scrollable">
        <section class="hbox stretch">
            <!-- home sidebar begin -->
            <?php $this->load->view('home_sidebar'); ?>
            <!-- home sidebar ends -->
            <section id="content" class="">
                <section class="hbox stretch">
                    <section>
                        <?php $this->load->view($middle) ?>
                        <?php
//                        if (isset($search_html) && !empty($search_html))
//                            print $search_html;
                        ?>
                        <?php
//                        if (isset($home_content) && !empty($home_content))
//                            print $home_content;
                        ?>
                        <?php
//                        if (isset($aboutus) && !empty($aboutus))
//                            print $aboutus;
                        ?>
                    </section>
                    <!-- side content --> 
                    <?php
//                    if (isset($right_sidebar) && !empty($right_sidebar))
//                        print $right_sidebar;
                    ?>
                    <!-- / side content --> 
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a> 
            </section>
        </section>
    </section>
</section>
<!-- Bootstrap --> <!-- App --> 
<?php $this->load->view('templates/footer'); ?>




<div id="fb-root"></div>
<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?php echo base_url(); ?>";
        $('#searchfriend').keypress(function (event) {

            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var search_string = $("#searchfriend").val();
//                alert(search_string);
                $.ajax({
                    url: url + 'home/search_friend/' + search_string,
                    type: 'POST',
                    success: function (result) {
                        console.log(result);
                        $('#home_searchfriends').html(result);
                    }
                });
            }

        });
    });
</script>
</body>


</html>