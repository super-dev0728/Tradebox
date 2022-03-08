<?php 
    $request = \Config\Services::request();
    $home_menu = $request->uri->setSilent()->getSegment(1);;
    $menu_cls = '';
    $div_start = '';
    $div_end = '';
    if ($home_menu) {

        $menu_cls ='navbar-dark bg-kingfisher-daisy';   
                     
    } else {

        $menu_cls = 'bg-transparent';
    }
    if ($home_menu=='exchange') {
        $div_start = '<div class="exchange-wrapper">';
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo esc($settings->title) ?></title>
        <link rel="shortcut icon" href="<?php echo IMAGEPATH.$settings->favicon; ?>">
         <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
        <link href="<?php echo BASEPATH.'assets/website/css/bootstrap.css' ?>" rel="stylesheet"/>
        <link href="<?php echo BASEPATH.'assets/website/css/vendors.bundle.min.css' ?>" rel="stylesheet"/>
        <link href="<?php echo BASEPATH.'assets/website/fontawesome/css/fontawesome-all.min.css' ?>" rel="stylesheet">
        <link href="<?php echo BASEPATH.'assets/website/css/toastr.css' ?>" rel="stylesheet">
        <link href="<?php echo BASEPATH.'assets/website/css/style.css?v=106' ?>" rel="stylesheet">
        <link href="<?php echo BASEPATH.'assets/website/css/custom.css' ?>" rel="stylesheet">
        <link href="<?php echo BASEPATH.'assets/js/sweetalert/sweetalert.css'?>" rel="stylesheet" type="text/css"/>
        <script src="<?php echo BASEPATH.'assets/website/js/jquery-3.5.1.min.js'?>"></script>

        <script type='text/javascript' src="<?php echo base_url('Adapter/javascript') ?>"></script>
        <link type="text/css" href="<?php echo base_url('Adapter/css') ?>" rel="stylesheet"/>

        <script type="text/javascript">
             var path = '<?php echo $request->uri->setSilent()->getSegment(1); ?>';
        </script>
    </head>
    <body>
            <nav class="navbar navbar-expand-lg <?php echo esc($menu_cls) ?>">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo base_url() ?>"><img class="logo" src="<?php echo IMAGEPATH.esc($settings->logo_web) ?>" alt=""></a>
                    <button type="button" class="navbar-toggler" id="sidebarCollapse"  >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link active" href="<?php echo base_url() ?>"><?php echo display('home') ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url("exchange?market=".@$query_pair->symbol) ?>"><?php echo display('exchange') ?></a>
                            </li>

                                <?php
                                  helper('filesystem');
                                  $path       = 'app/Modules/';
                                  $map        = directory_map($path);
                                  $CUSTOMERMENU  = array();
                                  
                                  if (is_array($map) && sizeof($map) > 0) {
                                      foreach ($map as $key => $value) {
                                          $menu = str_replace("\\", '/', $path . $key . 'Config/Customer_menu.php');

                                          if (file_exists(APPPATH . 'Modules/' . $key . '/Assets/data/env')|| file_exists(APPPATH . 'Modules/' . $key . '/assets/data/env')) {
                                               @include($menu);
                                          }
                                      }
                                  }
                                  
                                  $shortkeys = array_column($CUSTOMERMENU, 'order');
                                  array_multisort($shortkeys, SORT_ASC, $CUSTOMERMENU);
                                  
                                  foreach ($CUSTOMERMENU as $module => $parent) {


                                  if ($parent['status'] == 0) {
                                  ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo trim($parent['parent']); ?>
                                        </a>
                                        
                                    </li>
                                <?php } else if ($parent['status'] == 1) { ?>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="<?php echo base_url($parent['link']) ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo trim($parent['parent']); ?>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <?php
                                                foreach ($parent['submenu'] as $key => $child) {
                                                ?>
                                            <a class="dropdown-item" href="<?php echo base_url($child['link']) ?>"><?php echo $child['name'] ?></a>
                                            <?php } ?>
                                        </div>
                                    </li>
                            <?php }} ?>                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo display('finance') ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo base_url('balances') ?>"><?php echo display('balance');?></a>
                                    <a class="dropdown-item" href="<?php echo base_url('deposit') ?>"><?php echo display('deposit') ?></a>
                                    <a class="dropdown-item" href="<?php echo base_url('withdraw') ?>"><?php echo display('withdraw') ?></a>
                                    <a class="dropdown-item" href="<?php echo base_url('transfer') ?>"><?php echo display('transfer') ?></a>
                                    <a class="dropdown-item" href="<?php echo base_url('transactions') ?>"><?php echo display('transection') ?></a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo display('trade') ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo base_url('open-order') ?>"><?php echo display('open_order') ?></a>
                                    <a class="dropdown-item" href="<?php echo base_url('complete-order') ?>"><?php echo display('complete_order') ?></a>
                                    <a class="dropdown-item" href="<?php echo base_url('trade-history') ?>"><?php echo display('trade_history') ?></a>
                                </div>
                            </li>

                            <?php 
                                if($session->get('user_id') != NULL){
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo display('account') ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo base_url('bank-setting'); ?>"><?php echo display('bank_setting') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('payout-setting'); ?>"><?php echo display('payout_setup') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><?php echo display('profile') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('customer/auth/logout'); ?>"><?php echo display('logout'); ?></a></li>
                                </ul>
                            </li>
                            <?php } else{ ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('login') ?>"><?php echo display('login') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('register') ?>"><?php echo display('register') ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php  if($session->get('user_id') != NULL){ ?>

                            <ul class="pull-right">
                                <li>
                                    <a class="f_profile" href="<?php echo base_url('profile') ?>"><span class ="f_name"><?php echo esc($userinfo->first_name." ".$userinfo->last_name) ?></span>
                                        <img class="f_img" src="<?php echo $userinfo->image?IMAGEPATH.$userinfo->image: IMAGEPATH."assets/images/icons/user.png" ?>" alt="">
                                    </a>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </nav>  
            <!-- /.End of navbar -->
            <nav id="sidebar">
                <div id="dismiss">
                    <i class="fas fa-times"></i>
                </div>
                <ul class="metismenu list-unstyled" id="mobile-menu">
                    <li class="active"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
                    
                    <li><a href="<?php echo base_url("exchange?market=".@$query_pair->symbol) ?>"><?php echo display('exchange') ?></a></li>
                    <?php
                      helper('filesystem');
                      $path       = 'app/Modules/';
                      $map        = directory_map($path);
                      $CUSTOMERMENU  = array();
                      
                      if (is_array($map) && sizeof($map) > 0) {
                          foreach ($map as $key => $value) {
                              $menu = str_replace("\\", '/', $path . $key . 'Config/Customer_menu.php');

                              if (file_exists(APPPATH . 'Modules/' . $key . '/Assets/data/env')|| file_exists(APPPATH . 'Modules/' . $key . '/assets/data/env')) {
                                   @include($menu);
                              }
                          }
                      }
                      
                      $shortkeys = array_column($CUSTOMERMENU, 'order');
                      array_multisort($shortkeys, SORT_ASC, $CUSTOMERMENU);

                      foreach ($CUSTOMERMENU as $module => $parent) {
                      if ($parent['status'] == 0) {
                      ?>
                        <li><a href="<?php echo base_url($parent['link']) ?>" aria-expanded="false"><?php echo trim($parent['parent']); ?><span class="fa arrow"></span></a></li>
                    <?php } else if ($parent['status'] == 1) { ?>

                        <li>
                            <a href="#" aria-expanded="false"><?php echo trim($parent['parent']); ?><span class="fa arrow"></span></a>
                              
                             <ul aria-expanded="false">
                                <?php foreach ($parent['submenu'] as $key => $child) { ?>
                                    <li><a href="<?php echo base_url($child['link']) ?>"><?php echo $child['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php }} ?>   
                    <li>
                        <a href="#" aria-expanded="false"><?php echo display('finance') ?><span class="fa arrow"></span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo base_url('balances') ?>"><?php echo display('balance');?></a></li>
                            <li><a href="<?php echo base_url('deposit') ?>"><?php echo display('deposit') ?></a></li>
                            <li><a href="<?php echo base_url('withdraw') ?>"><?php echo display('withdraw') ?></a></li>
                            <li><a href="<?php echo base_url('transfer') ?>"><?php echo display('transfer') ?></a></li>
                            <li><a href="<?php echo base_url('transactions') ?>"><?php echo display('transection') ?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false"><?php echo display('trade') ?><span class="fa arrow"></span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo base_url('open-order') ?>"><?php echo display('open_order') ?></a></li>
                            <li><a href="<?php echo base_url('complete-order') ?>"><?php echo display('complete_order') ?></a></li>
                            <li><a href="<?php echo base_url('trade-history') ?>"><?php echo display('trade_history') ?></a></li>
                        </ul>
                    </li>
                    <?php if($session->get('user_id') != NULL){?>

                    <li>
                        <a href="#" aria-expanded="false"><?php echo display('account') ?><span class="fa arrow"></span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo base_url('bank-setting'); ?>"><?php echo display('bank_setting') ?></a></li>
                            <li><a href="<?php echo base_url('payout-setting'); ?>"><?php echo display('payout_setup') ?></a></li>
                            <li><a href="<?php echo base_url('profile'); ?>"><?php echo display('profile') ?></a></li>
                            <li><a href="<?php echo base_url('customer/auth/logout'); ?>"><?php echo display('logout'); ?></a></li>
                        </ul>
                    </li>                           
                    <?php } else { ?>
                    <li><a href="<?php echo base_url('login') ?>"><?php echo display('login') ?></a></li>
                    <li><a href="<?php echo base_url('register') ?>"><?php echo display('register') ?></a></li>
                    <?php } ?>                    

                </ul>
            </nav>
            <div class="overlay"></div>
            <!-- /.End of sidebar nav -->
            