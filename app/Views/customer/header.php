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
                                    <img src="<?php echo base_url() . session('image') ?>" alt="">
                                </div><!-- img-user -->
                                <h6><?php echo session('fullname') ?></h6>
                                <span><?php echo session('email') ?></span>
                            </div><!-- user-header -->
                            <a href="<?php echo base_url('customer/profile/edit_profile') ?>" class="dropdown-item"><i
                                    class="typcn typcn-edit"></i> Edit Profile</a>
                            <a href="<?php echo base_url('customer/profile/change_password') ?>"
                                class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Change Password</a>
                            <a href="<?php echo base_url('customer/logout') ?>" class="dropdown-item"><i
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
                    <li class="breadcrumb-item"><a href="#"><?php echo !empty($title) ? $title : null; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo ucwords($uri->setSilent()->getSegment(3)); ?>
                    </li>
                </ol>
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
                    <div class="media-body">
                        <h1 class="font-weight-bold"><?php echo !empty($title) ? $title : null; ?>
                        </h1>
                        <small><?php echo ucwords($uri->setSilent()->getSegment(3)); ?></small>
                    </div>
                </div>
            </div>
        </div>