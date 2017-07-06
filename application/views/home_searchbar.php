<body class="" ng-controller="battleCtrl">
  <section class="vbox">
    <header class="bg-white-only header header-md navbar navbar-fixed-top-xs">
      <!-- <div class="navbar-header aside bg-info nav-xs"> --> 
      <div class="navbar-header aside bg-info"> 
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html"> 
          <i class="icon-list"></i> 
        </a> 
        
        <a href="<?php echo base_url('home');?>" class="navbar-brand text-lt"> 
          <i class="icon-earphones visible-nav-xs" style="padding-top:20px;"></i> 
          <img src="<?php echo base_url();?>public/images/logo.png" alt="." class="hide visible-nav-xs">
          <div class="hidden-nav-xs m-l-sm"><img src="<?php echo base_url();?>public/images/logo-battle.png" alt="BatleMe.org" class=""></div> 
          <!-- <span class="hidden-nav-xs m-l-sm">BattleMe.org</span> -->
        </a> 

        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"> <i class="icon-settings"></i> </a> </div>
      <ul class="nav navbar-nav hidden-xs">
        <li> <a href="#nav,.navbar-header" data-toggle="class:nav-xs,nav-xs" class="text-muted"> <i class="fa fa-indent text"></i> <i class="fa fa-dedent text-active"></i> </a> </li>
      </ul>
      <?php
      // get_instance()->load->helper('form');
      $attributes = array('id' => 'searchbar','class' => 'navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs','role' => 'search');
      echo form_open('home/search', $attributes);
      ?>
        <div class="form-group col-sm-12">
          <!-- <div class="input-group"> <span class="input-group-btn"> <button type="submit" class="btn-sm bg-white btn-icon rounded"><i class="fa fa-search"></i></button> </span>  -->
          <input type="text" class="form-control input-sm no-border rounded col-sm-12" placeholder="Search users" name = "home_search"> </div>
        </div>
      <?php echo form_close(); ?>
     <?php print $navigationbar_home;  ?>

    </header>
<!--      </section>-->
    