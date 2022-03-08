<!-- CONTENT -->
<div class="content-wrapper">
    <div class="main-content">
       <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div> 
        <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
            <div class="sidebar-toggle-icon" id="sidebarCollapse">
                sidebar toggle<span></span>
            </div>
            <!--/.sidebar toggle icon-->
            <div class="d-flex flex-grow-1">
                <ul class="navbar-nav flex-row align-items-center ml-auto">
                    <?php 
                        if($max_version > $current_version && ($settings->update_notification == 1)){
                          if(session('isAdmin') == 1){
                    ?> 
                        <li> <a class="blink_text" href="<?php echo base_url('backend/auto_update')?>" > <?php echo 'Version '.$max_version.' available'; ?></a>
                        </li>
                    <?php } } ?>
                    <li class="nav-item dropdown user-menu">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="typcn typcn-user-outline"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header d-sm-none">
                                <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                            </div>
                            <div class="user-header">
                                <div class="img-user">
                                    <?php if(!empty($session->get('image'))){ ?>
                                        <img src="<?php echo IMAGEPATH.$session->get('image') ?>" alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo IMAGEPATH.'assets/website/img/img-user.png' ?>" alt="">
                                    <?php } ?>
                                </div><!-- img-user -->
                                <h6><?php echo session('fullname') ?></h6>
                                <span><?php echo session('email') ?></span>
                            </div><!-- user-header -->
                            <a href="<?php echo base_url('backend/profile'); ?>" class="dropdown-item"><i class="typcn typcn-user-outline"></i> <?php echo display('profile') ?></a>
                            <a href="<?php echo base_url('backend/edit-profile'); ?>" class="dropdown-item"><i class="typcn typcn-edit"></i> <?php echo display('edit_profile') ?></a>
                            <a href="<?php echo base_url('admin/logout') ?>" class="dropdown-item"><i
                                    class="typcn typcn-key-outline"></i> Sign Out</a>
                        </div>
                        <!--/.dropdown-menu -->
                    </li>
                </ul>
                <!--/.navbar nav-->
                <div class="nav-clock">
                    <div class="time">
                        <span class="time-hours"></span>
                        <span class="time-min"></span>
                        <span class="time-sec"></span>
                    </div>
                </div><!-- nav-clock -->
            </div>
        </nav>
        <!--/.navbar-->
        <div class="content-header row align-items-center m-0">
            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?php echo base_url('backend/home'); ?>">Dashboard</a>
                    </li>
                </ol>
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="fab fa-pagelines"></i></div>
                    <div class="media-body">
                        <h5 class="font-weight-bold">
                            <?php echo display(ucwords($uri->setSilent()->getSegment(2))); ?>
                        </h5>
                        <small><?php echo display(ucwords($uri->setSilent()->getSegment(3))); ?></small>
                    </div>
                </div>
            </div>
        </div>