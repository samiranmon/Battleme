<?php  $sessionData = get_session_data(); ?>
<aside class="bg-black dk aside hidden-print" id="nav">
          <section class="vbox">
            <section class="w-f-md scrollable">
              <!-- <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2"> -->
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <!-- nav --> 
                <nav class="nav-primary hidden-xs">
                    
                  <ul class="nav bg clearfix" data-ride="collapse">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted"> Discover </li>

                    <?php  if (isset($sessionData)) { ?>
                    <li> <a href="<?php echo base_url('home')?>"> 
                            <i class="icon-disc icon text-success"></i>
                            <b class="badge bg-primary pull-right"></b> 
                            <span class="font-bold">Home</span> 
                        </a> 
                    </li>
                    <li> <a href="<?php echo base_url('profile')?>"> 
                            <i class="icon-disc icon text-success"></i>
                            <b class="badge bg-primary pull-right"></b> 
                            <span class="font-bold">Profile</span> 
                        </a> 
                    </li>
                    <li> <a href="<?php echo base_url('user/notifications')?>"> 
                            <i class="icon-disc icon text-success"></i> 
                            <span class="font-bold">Notifications</span> 
                        </a> 
                    </li>
                    <li> <a href="<?php echo base_url('aboutus')?>"> <i class="icon-drawer icon text-primary-lter"></i> <b class="badge bg-primary pull-right"></b> <span class="font-bold">About</span> </a> </li>
                    <li> <a href="<?php echo base_url('tournament/all')?>"> <i class="icon-target icon text-primary-lter"></i> <b class="badge bg-primary pull-right"></b> <span class="font-bold">All Tournaments</span> </a> </li>
                    <?php } ?>
                    
                    <li > <?php //echo base_url('battle/all')?>
                      <a href="javascript:void(0)" class="auto"> 
                          <i class="icon-screen-desktop icon"> </i> 
                          <span>Battles</span> 
                      </a> 
                      <ul class="nav dk text-sm">
                        <li > 
                            <a href="<?=base_url('battle/category/cash-battle')?>" class="auto"> 
                                <i class="fa fa-angle-right text-xs"></i> 
                                <span>Cash Battles</span> 
                            </a> 
                        </li>
                        <li > 
                            <a href="<?=base_url('battle/category/regular-battle')?>" class="auto"> 
                                <i class="fa fa-angle-right text-xs"></i> 
                                <span>Regular Battles</span> 
                            </a> 
                        </li>
                      </ul>
                    </li>
                    
                    <?php  if ($sessionData['user_type'] == 'artist' && isset($sessionData)) { ?>
                    <li> 
                        <a href="<?=base_url('battle/create') ?>"> 
                            <i class="icon-target icon text-primary-lter"></i> 
                            <b class="badge bg-primary pull-right"></b> 
                            <span class="font-bold">Create Battle</span> 
                        </a> 
                    </li>
                    <li> 
                        <a href="<?php echo base_url('battle')?>"> 
                            <i class="icon-target icon text-primary-lter"></i> 
                            <b class="badge bg-primary pull-right"></b>
                            <span class="font-bold">My Battles</span> 
                        </a> 
                    </li>
                    <?php } ?>
                    
                    <?php if($sessionData['user_type'] == 'artist' && isset($sessionData)) { ?>
                    <li> <a href="<?php echo base_url('tournament')?>"> <i class="icon-target icon text-primary-lter"></i> <b class="badge bg-primary pull-right"></b> <span class="font-bold">My Tournaments</span> </a> </li>
		    <?php } ?>
                    
                    
                     

                    
		    <li class="m-b hidden-nav-xs"></li>
                  </ul>
                    
                    
<!--                  <ul class="nav" data-ride="collapse">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted"> Interface </li>
                    <li >
                      <a href="#" class="auto"> <span class="pull-right text-muted"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-down text-active"></i> </span> <i class="icon-screen-desktop icon"> </i> <span>Layouts</span> </a> 
                      <ul class="nav dk text-sm">
                        <li > <a href="layout-color.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Color option</span> </a> </li>
                        <li > <a href="layout-boxed.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Boxed layout</span> </a> </li>
                        <li > <a href="layout-fluid.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Fluid layout</span> </a> </li>
                      </ul>
                    </li>
                    <li >
                      <a href="#" class="auto"> <span class="pull-right text-muted"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-down text-active"></i> </span> <i class="icon-chemistry icon"> </i> <span>UI Kit</span> </a> 
                      <ul class="nav dk text-sm">
                        <li > <a href="buttons.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Buttons</span> </a> </li>
                        <li > <a href="icons.html" class="auto"> <b class="badge bg-info pull-right">369</b> <i class="fa fa-angle-right text-xs"></i> <span>Icons</span> </a> </li>
                        <li > <a href="grid.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Grid</span> </a> </li>
                        <li > <a href="widgets.html" class="auto"> <b class="badge bg-dark pull-right">8</b> <i class="fa fa-angle-right text-xs"></i> <span>Widgets</span> </a> </li>
                        <li > <a href="components.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Components</span> </a> </li>
                        <li > <a href="list.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>List group</span> </a> </li>
                        <li >
                          <a href="#table" class="auto"> <span class="pull-right text-muted"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-down text-active"></i> </span> <i class="fa fa-angle-right text-xs"></i> <span>Table</span> </a> 
                          <ul class="nav dker">
                            <li > <a href="table-static.html"> <i class="fa fa-angle-right"></i> <span>Table static</span> </a> </li>
                            <li > <a href="table-datatable.html"> <i class="fa fa-angle-right"></i> <span>Datatable</span> </a> </li>
                          </ul>
                        </li>
                        <li >
                          <a href="#form" class="auto"> <span class="pull-right text-muted"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-down text-active"></i> </span> <i class="fa fa-angle-right text-xs"></i> <span>Form</span> </a> 
                          <ul class="nav dker">
                            <li > <a href="form-elements.html"> <i class="fa fa-angle-right"></i> <span>Form elements</span> </a> </li>
                            <li > <a href="form-validation.html"> <i class="fa fa-angle-right"></i> <span>Form validation</span> </a> </li>
                            <li > <a href="form-wizard.html"> <i class="fa fa-angle-right"></i> <span>Form wizard</span> </a> </li>
                          </ul>
                        </li>
                        <li > <a href="chart.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Chart</span> </a> </li>
                        <li > <a href="portlet.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Portlet</span> </a> </li>
                        <li > <a href="timeline.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Timeline</span> </a> </li>
                      </ul>
                    </li>
                    <li >
                      <a href="#" class="auto"> <span class="pull-right text-muted"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-down text-active"></i> </span> <i class="icon-grid icon"> </i> <span>Pages</span> </a> 
                      <ul class="nav dk text-sm">
                        <li > <a href="<?//php echo base_url('profile');?>" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Profile</span> </a> </li>
                        <li > <a href="blog.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Blog</span> </a> </li>
                        <li > <a href="invoice.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Invoice</span> </a> </li>
                        <li > <a href="gmap.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Google Map</span> </a> </li>
                        <li > <a href="jvectormap.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Vector Map</span> </a> </li>
                        <li > <a href="signin.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Signin</span> </a> </li>
                        <li > <a href="signup.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>Signup</span> </a> </li>
                        <li > <a href="404.html" class="auto"> <i class="fa fa-angle-right text-xs"></i> <span>404</span> </a> </li>
                      </ul>
                    </li>
                  </ul>-->

                   
                   
                  

                </nav>
                
              </div>
            </section>
           
          </section>
        </aside>