<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <title><?php echo esc($settings->title) ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo $settings->favicon?IMAGEPATH.$settings->favicon:''; ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="<?php echo BASEPATH.'exchange/assets/plugins/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/plugins/fontawesome/css/all.min.css' ?>" rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/plugins/feather-icons/feather.css' ?>" rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/plugins/datatables/dataTables.bootstrap5.min.css' ?>"
        rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/plugins/datatables/responsive.bootstrap5.min.css' ?>"
        rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/plugins/bootstrap-slider/dist/css/bootstrap-slider.min.css' ?>"
        rel="stylesheet">
    <link href="<?php echo BASEPATH.'assets/css/toastr.css?v=1' ?>" rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/css/custom.css?v=1' ?>" rel="stylesheet">
    <link href="<?php echo BASEPATH.'exchange/assets/css/mystyle.css?v=1' ?>" rel="stylesheet">
    <script type='text/javascript' src="<?php echo site_url('Adapter/javascript?market='.$adapter_symbol) ?>"></script>
</head>

<body class="dark-theme">
    <!-- Preloader -->
    <div class="loader-wrapper">
        <img src="<?php echo BASEPATH.'exchange/assets/img/hero-glow.svg' ?>" alt="">
        <div class="loader">Loading
            <div class="dots"><span class="dot z"></span><span class="dot f"></span><span class="dot s"></span><span
                    class="dot t"><span class="dot l"></span></span></div>
        </div>
    </div>
    <!-- /.Preloader -->
    <div class="wrapper">
        <div class="main-content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg custom-navbar">
                <div class="container-fluid">
                    <!-- Navbar Brand Logo -->
                    <a class="navbar-brand" href="<?php echo base_url(); ?>">
                        <!-- Logo For Dark Theme -->
                        <img src="<?php echo IMAGEPATH.$settings->logo ?>" alt="" class="navbar-brand-logo logo-white">
                        <!-- Logo For Light Theme -->
                        <img src="<?php echo IMAGEPATH.$settings->logo ?>" alt="" class="navbar-brand-logo logo-dark">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Navbar Toggler Close Button -->
                        <div class="text-end">
                            <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <i class="feather-x"></i>
                            </button>
                        </div>
                        <!-- /.Navbar Toggler Close Button -->
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#"><?php echo display('home'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active"
                                    href="<?php echo base_url("exchange?market=".@$query_pair->symbol) ?>"><?php echo display('exchange') ?></a>
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
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo trim($parent['parent']); ?>
                                </a>

                            </li>
                            <?php } else if ($parent['status'] == 1) { ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo trim($parent['parent']); ?>
                                    <i class="feather-chevron-down caret"></i>
                                </a>
                                <ul class="dropdown-menu slideIn" aria-labelledby="navbarDropdown">
                                    <?php
                                                foreach ($parent['submenu'] as $key => $child) {
                                                ?>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url($child['link']) ?>"><?php echo $child['name'] ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php }} ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo display('finance'); ?>
                                    <i class="feather-chevron-down caret"></i>
                                </a>
                                <ul class="dropdown-menu slideIn" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?php echo base_url('balances') ?>"><i
                                                class="feather-credit-card"></i> <?php echo display('balance');?></a>
                                    </li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('deposit') ?>"><i
                                                class="feather-droplet"></i> <?php echo display('deposit') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('withdraw') ?>"><i
                                                class="feather-dollar-sign"></i> <?php echo display('withdraw') ?></a>
                                    </li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('transfer') ?>"><i
                                                class="feather-book"></i> <?php echo display('transfer') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('transactions') ?>"><i
                                                class="feather-droplet"></i> <?php echo display('transection') ?></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo display('trade'); ?>
                                    <i class="feather-chevron-down caret"></i>
                                </a>
                                <ul class="dropdown-menu slideIn" aria-labelledby="navbarDropdown2">
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('open-order') ?>"><?php echo display('open_order') ?></a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('complete-order') ?>"><?php echo display('complete_order') ?></a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('trade-history') ?>"><?php echo display('trade_history') ?></a>
                                    </li>
                                </ul>
                            </li>
                            <?php  if($session->get('user_id') != NULL){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo display('account'); ?>
                                    <i class="feather-chevron-down caret"></i>
                                </a>
                                <ul class="dropdown-menu slideIn" aria-labelledby="navbarDropdown3">
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('bank-setting'); ?>"><?php echo display('bank_setting') ?></a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('payout-setting'); ?>"><?php echo display('payout_setup') ?></a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?php echo base_url('profile'); ?>"><?php echo display('profile') ?></a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                        <ul class="navbar-nav">
                            <!-- Language Select  -->
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="javascript:void(0)"
                                    data-bs-toggle="modal" data-bs-target="#languaheModal">
                                    <div><?php echo isset($lang) && $lang =="english"?'English':$web_language->name; ?>
                                    </div>
                                </a>
                            </li>
                            <!-- Login Option For Large Device (Breakpoints: ≥992px) -->
                            <li class="nav-item d-none d-lg-block">
                                <?php  if($session->get('user_id') == NULL){ ?>
                                <a class="nav-link" href="<?php echo base_url('login'); ?>"><i
                                        class="feather-log-in me-1"></i><?php echo display('login'); ?></a>
                                <?php } else { ?>
                                <a class="nav-link" href="<?php echo base_url('customer/auth/logout') ?>"><i
                                        class="feather-log-out me-1"></i><?php echo display('logout'); ?></a>
                                <?php } ?>
                            </li>
                        </ul>
                        <!-- Login & Register Button For Mobile (Breakpoints: <991px) -->
                        <div class="mt-3 d-lg-none">
                            <?php  if($session->get('user_id') == NULL){ ?>
                            <a href="<?php echo base_url('login'); ?>"
                                class="btn btn-login w-100 mb-2"><?php echo display('login'); ?></a>
                            <a href="<?php echo base_url('register'); ?>"
                                class="btn btn-register w-100"><?php echo display('register'); ?></a>
                            <?php } else { ?>
                            <a href="<?php echo base_url('customer/auth/logout') ?>"
                                class="btn btn-login w-100 mb-2"><?php echo display('logout'); ?></a>
                            <?php }?>
                        </div>
                        <!-- /.Login & Register Button For Mobile (Breakpoints: <991px) -->
                    </div>

                    <div class="d-flex align-items-center">
                        <?php  if($session->get('user_id') == NULL){ ?>
                        <a class="nav-link btn btn-register ms-2"
                            href="<?php echo base_url('register'); ?>"><?php echo display('register'); ?></a>
                        <?php } ?>
                        <div class="toolbar-link ms-2 d-none d-sm-block">
                            <label class="switch ml-auto">
                                <input type="checkbox" id="switcher"><span></span>
                            </label>
                        </div>
                        <!-- Navbar Toggler Button For Mobile (Breakpoints: <991px) -->
                        <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>

                </div>
            </nav>
            <!-- /. Navbar -->
            <!-- Body Content -->
            <div class="body-content">
                <!-- Chart Content -->
                <div class="chart-content">
                    <header class="trade-box-header d-flex align-items-center">
                        <div class="coin-name flex-shrink-0 pe-2 me-2 pe-sm-3 me-sm-3 me-md-0">
                            <div class="dropdown disable-autohide">
                                <span class="coin-title dropdown-toggle" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>
                                        <span class="coin d-block"><?php echo $market_symbol; ?></span>
                                        <span
                                            class="coin-name_full text-truncate d-block"><?php echo $market_history->full_name; ?></span>
                                    </span>
                                    <i class="feather-chevron-down caret"></i>
                                </span>
                                <div class="dropdown-menu market-symbol" aria-labelledby="dropdownMenuButton1">
                                    <div class="form-group has-search mb-1">
                                        <span class="feather-search form-control-feedback"></span>
                                        <input id="myInput" type="text" class="form-control"
                                            placeholder="<?php echo display('search_pair'); ?>"
                                            onkeyup="marketSearch()">
                                    </div>
                                    <div class="p-3">
                                        <ul class="nav nav-tabs mb-3" id="myTab1" role="tablist">
                                            <?php 
                                                $i = 1;
                                                foreach ($coin_markets as $key => $value) {
                                                 $coin_symbol = explode('_', $market_symbol);
                                                if($i <= 3){
                                            ?>
                                            <li class="nav-item" role="presentation">

                                                <button
                                                    class="nav-link <?php if($coin_symbol[1] == $value->symbol) echo "active" ?>"
                                                    id="tab-one_<?php echo esc($value->symbol) ?>" data-bs-toggle="tab"
                                                    data-bs-target="#tabOne_<?php echo esc($value->symbol) ?>"
                                                    type="button" role="tab"
                                                    aria-controls="tabOne_<?php echo esc($value->symbol) ?>"
                                                    aria-selected="true"><?php echo esc(strtoupper($value->symbol)) ?></button>
                                            </li>
                                            <?php $i++; }} ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                                    role="button"
                                                    aria-expanded="false"><?php echo display('more'); ?></a>
                                                <ul id="morehide" class="dropdown-menu">
                                                    <?php 
                                                        $i = 1;
                                                        foreach ($coin_markets as $key => $value) { 
                                                            $coin_symbol = explode('_', $market_symbol);
                                                        if($i++ > 3){
                                                     ?>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="dropdown-item nav-link <?php if($coin_symbol[1] == $value->symbol) echo "active" ?>"
                                                            id="tab-one_<?php echo esc($value->symbol) ?>"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#tabOne_<?php echo esc($value->symbol) ?>"
                                                            type="button" role="tab"
                                                            aria-controls="tabOne_<?php echo esc($value->symbol) ?>"
                                                            aria-selected="true"
                                                            href="#"><?php echo esc(strtoupper($value->symbol)) ?></a>
                                                    </li>
                                                    <?php }} ?>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent1">
                                            <?php foreach ($coin_markets as $key => $value) { ?>
                                            <div class="tab-pane fade show <?php if($coin_symbol[1] == strtoupper($value->symbol)) echo "active"; ?>"
                                                id="tabOne_<?php echo esc($value->symbol) ?>" role="tabpanel"
                                                aria-labelledby="tab-one_<?php echo esc($value->symbol) ?>">
                                                <table id="myTable<?php echo $value->id; ?>"
                                                    class="table table-borderless trade-market-table display mb-0 width100percent">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo display('pair'); ?></th>
                                                            <th class="text-end"><?php echo display('price'); ?></th>
                                                            <th class="text-end"><?php echo display('change'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                                foreach ($coin_pairs as $keyp => $valuep) { 
                                                                    if($valuep->market_symbol == $value->symbol){ 
                                                            ?>
                                                        <tr data-href="#"
                                                            onclick="window.location='<?php echo base_url("exchange?market=$valuep->symbol") ?>';">
                                                            <td>
                                                                <div class="item-symbol d-flex align-items-center">
                                                                    <div class="favorite primary me-1">
                                                                        <i class="fas fa-star"></i>
                                                                    </div>
                                                                    <div class="item-symbol-text">
                                                                        <?php echo esc($valuep->currency_symbol)."/".esc($valuep->market_symbol) ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end"
                                                                id="price_<?php echo esc($valuep->symbol) ?>">
                                                                <?php echo esc($valuep->initial_price)==''?'0.00':esc($valuep->initial_price) ?>
                                                            </td>
                                                            <td class="text-end"><span class="item-color-sell"
                                                                    id="price_change_<?php echo esc($valuep->symbol) ?>">
                                                                    0.00%</span>
                                                            </td>
                                                        </tr>
                                                        <?php } } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ticker-last-box mt-2 d-xl-none">
                                <span class="trade-price_title"><?php echo display('last_price') ?></span>
                                <span class="chg d-block coin-last-price">0.00</span>
                            </div>
                        </div>
                        <div class="d-xl-inline-flex align-items-center flex-grow-1">
                            <div class="d-none d-xl-block justify-content-between ms-md-3 mb-1 mb-md-0">
                                <div class="trade-price_title"><?php echo display('last_price') ?></div>
                                <div class="market-price coin-last-price">0.00</div>
                            </div>
                            <div class="d-flex d-xl-block justify-content-between ms-md-3 mb-1 mb-md-0">
                                <div class="trade-price_title"><?php echo display('24hr_change') ?></div>
                                <div class="trade-price number-style"><span class="coin-change-price">0.00</span></div>
                            </div>
                            <div class="d-flex d-xl-block justify-content-between ms-md-3 mb-1 mb-md-0">
                                <div class="trade-price_title"><?php echo display('24hr_high') ?></div>
                                <div class="trade-price number-style coin-price-high">0.00</div>
                            </div>
                            <div class="d-flex d-xl-block justify-content-between ms-md-3">
                                <div class="trade-price_title"><?php echo display('24hr_low') ?></div>
                                <div class="trade-price number-style coin-price-low">0.00</div>
                            </div>
                            <div class="d-flex d-xl-block justify-content-between ms-md-3">
                                <div class="trade-price_title"><?php echo display('24h_volume') ?></div>
                                <div class="trade-price number-style coin-volume">0.00</div>
                            </div>

                        </div>
                    </header>
                    <ul id="chartTab" class="justify-content-end nav nav-pills p-2 m-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="original">Original Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="tradingview">TradingView Chart</a>
                        </li>
                    </ul>
                    <div class="control">
                        <span>Time Range: </span>
                        <span class="range" data-range="15" id="quarter">15m</span>
                        <span class="range" data-range="60" id="hour">1H</span>
                        <span class="range" data-range="240" id="4hr">4H</span>
                        <span class="range" data-range="1440" id="day">1D</span>
                        <span class="range" data-range="10080" id="week">1W</span>
                        <span class="range dropdown active">1m <i class="fa fa-sort-down"></i></span>
                        <div class="range-dropdown">
                            <div class="title">Select Intervals</div>
                            <div class="close"><i class="fa fa-times"></i></div>
                            <div class=" sub-range" data-range="1">1m</div>
                            <div class="sub-range" data-range="3">3m</div>
                            <div class="sub-range active" data-range="5">5m</div>
                            <div class="sub-range" data-range="15">15m</div>
                            <div class="sub-range" data-range="30">30m</div>
                            <div class="sub-range" data-range="60">1H</div>
                            <div class="sub-range" data-range="120">2H</div>
                            <div class="sub-range" data-range="240">4H</div>
                            <div class="sub-range" data-range="720">12H</div>
                            <div class="sub-range" data-range="1440">1D</div>
                            <div class="sub-range" data-range="10080">1W</div>
                            <div class="sub-range" data-range="43200">1M</div>
                        </div>
                    </div>
                    <!-- Chart -->
                    <canvas width="1390" height="500" id="chart_div"></canvas>
                    <div id="tv_chart_container"></div>
                </div>
                <!-- /.Chart Content -->
                <!-- Orderbook -->
                <div class="orderbook">
                    <div class="orderbook-nav_wrap">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="order-book-tab" data-bs-toggle="tab"
                                    data-bs-target="#order-book" type="button" role="tab" aria-controls="order-book"
                                    aria-selected="true"><?php echo display('order_book') ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="trades-tab" data-bs-toggle="tab" data-bs-target="#trades"
                                    type="button" role="tab" aria-controls="trades"
                                    aria-selected="false"><?php echo display('trades') ?></button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane show active" id="order-book" role="tabpanel"
                            aria-labelledby="order-book-tab">
                            <div class="orderbook-wrap">
                                <div class="widget-header_title d-none d-sm-block d-md-none d-xl-block">
                                    <?php echo display('order_book') ?>
                                </div>
                                <!-- Orderbook list -->
                                <div class="orderbook-list position-relative">
                                    <table
                                        class="orderbook-list_table orderbook-list_ask table table-borderless table-hover position-relative overflow-hidden mb-0">
                                        <thead>
                                            <tr>
                                                <th class="coin"><?php echo display('price') ?>
                                                    <?php echo esc($coin_symbol[0]) ?></th>
                                                <th class="price"><?php echo esc($coin_symbol[0]) ?>
                                                    <?php echo display('amount') ?></th>
                                                <th class="change"><?php echo display('total') ?>:
                                                    (<?php echo esc($coin_symbol[1]) ?>)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body" id="selltrades">
                                            <!-- biding sell order show here -->
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.Orderbook list -->
                                <!-- Orderbook Ticker -->
                                <div class="orderbook-ticker d-flex price_updown">
                                    <!-- price updown show here -->
                                    <span class="contract-price status-primary">0.00
                                        <!-- contract price status class name.status-sell.status-buy .status-primary -->
                                        <i class="feather-corner-right-down arrow-icon ms-1"></i>
                                        <i class="feather-corner-right-up arrow-icon ms-1"></i>
                                    </span>
                                </div>
                                <!-- /.Orderbook Ticker -->
                                <!-- Orderbook list -->
                                <div class="orderbook-list position-relative">
                                    <table
                                        class="orderbook-list_table orderbook-list_bid table table-borderless table-hover position-relative overflow-hidden mb-0">
                                        <tbody class="table-body" id="buytrades">
                                            <!-- biding buy order show here -->
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.Orderbook list -->
                            </div>
                        </div>
                        <div class="tab-pane" id="trades" role="tabpanel" aria-labelledby="trades-tab">
                            <div class="trades-wrap position-relative h-100">
                                <div class="widget-header_title d-none d-sm-block d-md-none d-xl-block">
                                    <?php echo display('trade_history');?>
                                </div>
                                <div class="trades-table-wrap position-absolute">
                                    <table
                                        class="orderbook-list_table orderbook-list_ask table table-fixed table-borderless table-hover mb-0 h-100 d-flex flex-column">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('amount') ?></th>
                                                <th><?php echo display('price') ?></th>
                                                <th><?php echo display('time');?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tradeHistory">
                                            <!-- tradehistory show here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Orderbook -->
                <!-- Place Order Container -->
                <div class="place-order_container">
                    <!-- Place Order Container Header For Mobile (Breakpoints: <767px)-->
                    <div class="place-order_header d-flex align-items-center justify-content-between d-md-none">
                        <h6 class="mb-0"><?php echo display('order_placement');?></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- /.Place Order Container Header For Mobile (Breakpoints: <767px)-->
                    <div class="place-order_form">
                        <!-- Place Order Form Tabs Nav -->
                        <ul class="nav nav-tabs order-form-tabs mb-2" id="myTab3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy"
                                    type="button" role="tab" aria-controls="buy"
                                    aria-selected="true"><?php echo display('buy') ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sell-tab" data-bs-toggle="tab" data-bs-target="#sell"
                                    type="button" role="tab" aria-controls="sell"
                                    aria-selected="false"><?php echo display('sell') ?></button>
                            </li>
                        </ul>
                        <!-- /.Place Order Form Tabs Nav -->
                        <!-- Place Order Form Tab Content -->
                        <div class="tab-content" id="myTabContent3">
                            <div class="tab-pane show active" id="buy" role="tabpanel" aria-labelledby="buy-tab">
                                <div class="buy-sell-order">
                                    <div class="my-3">
                                        <span
                                            class="text-uppercase"><?php echo esc($coin_symbol[1]) ?>&nbsp;<?php echo display('balance') ?>:</span>&nbsp;
                                        <span
                                            id="balance_buy"><?php echo esc(@$balance_to->balance)?@(float)esc($balance_to->balance):'0.00' ?></span>
                                    </div>
                                    <?php echo form_open('buy','id="buyform" class="buy-form" name="buyform"'); ?>
                                    <?php echo form_hidden('market', esc(@$market_details->symbol)); ?>
                                    <div class="tab-content" id="myTabContent4">
                                        <div class="tab-pane fade show active" id="limit" role="tabpanel"
                                            aria-labelledby="limit-tab">
                                            <!-- Input Group Form -->
                                            <div class="input-group-form">
                                                <span
                                                    class="input-group-form__text"><?php echo display('price') ?></span>
                                                <input id="buypricing" name="buypricing" step="any" min="0"
                                                    type="number" class="form-control" placeholder="0.00">
                                                <span
                                                    class="input-group-form__text--currency"><?php echo esc($coin_symbol[1]) ?></span>
                                            </div>
                                            <!-- Input Group Form -->
                                            <div class="input-group-form">
                                                <span
                                                    class="input-group-form__text"><?php echo display('amount') ?></span>
                                                <input id="buyamount" name="buyamount" step="any" min="0" type="number"
                                                    class="form-control" placeholder="0.00">
                                                <span
                                                    class="input-group-form__text--currency"><?php echo esc($coin_symbol[0]) ?></span>
                                            </div>
                                            <!-- Slider Ticks -->
                                            <div class="my-3 text-center">
                                                <input id="ex13" type="text" data-slider-ticks="[0, 25, 50, 75, 100]"
                                                    data-slider-ticks-snap-bounds="1"
                                                    data-slider-ticks-labels='["0%", "25%", "50%", "75%", "100%"]' />
                                            </div>

                                            <div class="form-group row no-gutters mb-2">
                                                <div class="buyloginMessage"></div>
                                                <div class="col-sm-7 font-size-12">
                                                    <?php echo display('estimated_open_price') ?>:</div>
                                                <div class="col-sm-5 text-right font-size-12" id="buywithout_fees">0.00
                                                </div>
                                                <input type="hidden" name="buywithout_feesval"
                                                    id="buywithout_feesval" />
                                                <div class="col-sm-7 font-size-12"><?php echo display('open_fees') ?>:
                                                </div>
                                                <div class="col-sm-5 text-right font-size-12" id="buyfees">0.00
                                                    <?php echo esc($coin_symbol[1]) ?>
                                                    (<?php echo esc(@$fee_usd->fees) ?>%)</div>
                                                <input type="hidden" name="buyfeesval" id="buyfeesval" value="" />
                                                <div class="col-sm-7 font-size-12"><?php echo display('total') ?>:</div>
                                                <div class="total col-sm-5 text-right font-size-12" id="buytotal">0.00
                                                </div>
                                                <input readonly="readonly" type="hidden" class="form-control"
                                                    name="buytotalval" id="buytotalval">
                                            </div>

                                            <!-- Input Group Form -->
                                            <?php if($session->get('user_id')){ ?>
                                            <button id="buyButton" type="submit" class="btn btn-success w-100">Buy
                                                <?php echo esc($coin_symbol[0]) ?></button>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane fade" id="market" role="tabpanel"
                                            aria-labelledby="market-tab">...</div>
                                        <div class="tab-pane fade" id="stop-limit" role="tabpanel"
                                            aria-labelledby="stop-limit-tab">...</div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                                <?php echo form_open('sell','id="sellform" class="buy-form" name="sellform"'); ?>
                                <?php echo form_hidden('market', esc(@$market_details->symbol)) ?>
                                <div class="buy-sell-order">
                                    <div class="tab-content" id="myTabContent5">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                            aria-labelledby="home-tab">
                                            <div class="my-3">
                                                <?php echo esc($coin_symbol[0]) ?> <?php echo display('balance') ?>:
                                                <span
                                                    id="balance_sell"><?php echo esc(@$balance_from->balance)?@(float)esc($balance_from->balance):'0.00' ?></span>
                                            </div>
                                            <!-- Input Group Form -->
                                            <div class="input-group-form">
                                                <span
                                                    class="input-group-form__text"><?php echo display('price') ?></span>
                                                <input id="sellpricing" name="sellpricing" step="any" min="0"
                                                    type="number" class="form-control" placeholder="0.00">
                                                <span
                                                    class="input-group-form__text--currency"><?php echo $coin_symbol[1] ?></span>
                                            </div>
                                            <!-- Input Group Form -->
                                            <div class="input-group-form">
                                                <span
                                                    class="input-group-form__text"><?php echo display('amount') ?></span>
                                                <input id="sellamount" name="sellamount" step="any" min="0"
                                                    type="number" class="form-control" placeholder="0.00">
                                                <span
                                                    class="input-group-form__text--currency"><?php echo esc($coin_symbol[0]) ?></span>
                                            </div>

                                            <div class="my-3 text-center">
                                                <input id="ex14" type="text" data-slider-ticks="[0, 25, 50, 75, 100]"
                                                    data-slider-ticks-snap-bounds="1"
                                                    data-slider-ticks-labels='["0%", "25%", "50%", "75%", "100%"]' />
                                            </div>

                                            <div class="form-group row no-gutters mb-2">

                                                <div class="sellloginMessage"></div>
                                                <div class="col-sm-7 font-size-12 mt-2">
                                                    <?php echo display('estimated_open_price') ?>:</div>
                                                <div class="col-sm-5 text-right font-size-12 mt-2"
                                                    id="sellwithout_fees">0.00</div>
                                                <input type="hidden" name="sellwithout_feesval"
                                                    id="sellwithout_feesval" />
                                                <div class="col-sm-7 font-size-12"><?php echo display('open_fees') ?>:
                                                </div>
                                                <div class="col-sm-5 text-right font-size-12" id="sellfees">0.00
                                                    <?php echo esc($coin_symbol[0]) ?>
                                                    (<?php echo esc(@$fee_coin->fees) ?>%)</div>
                                                <input type="hidden" name="sellfeesval" id="sellfeesval" value="" />

                                                <div class="col-sm-7 font-size-12"><?php echo display('total') ?>:</div>
                                                <div class="total col-sm-5 text-right font-size-12" id="selltotal">0.00
                                                </div>
                                                <input type="hidden" name="selltotalval" id="selltotalval" value="" />
                                            </div>

                                            <?php  if($session->get('user_id')){ ?>
                                            <button id="sellButton" type="submit"
                                                class="btn btn-danger w-100"><?php echo display('sell');?>
                                                <?php echo esc($coin_symbol[0]) ?></button>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">...</div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel"
                                            aria-labelledby="contact-tab">...</div>
                                    </div>
                                </div>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                        <!-- /.Place Order Form Tab Content -->
                        <!-- Register Or Login Link -->

                        <?php  if($session->get('user_id') == NULL){ ?>
                        <div class="register-link d-flex align-items-center justify-content-center mt-3">
                            <a href="<?php echo base_url('login'); ?>"><?php echo display('login'); ?></a>
                            <div class="or mx-2">or</div>
                            <a href="<?php echo base_url('register'); ?>"><?php echo display('register'); ?></a>
                        </div>
                        <?php } ?>
                        <!-- /.Register Or Login Link -->
                    </div>
                </div>
                <!-- /.Place Container -->
                <!-- Account Box -->
                <div class="account-box">
                    <div class="account-box_content">
                        <ul class="nav nav-tabs account-box-tabs mb-2" id="myTab6" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="open-orders-tab" data-bs-toggle="tab"
                                    data-bs-target="#openOrders" type="button" role="tab" aria-controls="openOrders"
                                    aria-selected="true"><?php echo display('open_order') ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="order-history-tab" data-bs-toggle="tab"
                                    data-bs-target="#orderHistory" type="button" role="tab" aria-controls="orderHistory"
                                    aria-selected="false"><?php echo display('complete_order') ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="trade-history-tab" data-bs-toggle="tab"
                                    data-bs-target="#allTrade" type="button" role="tab" aria-controls="tradeHistory"
                                    aria-selected="false"><?php echo display('trade_history') ?></button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent6">
                            <div class="tab-pane fade show active" id="openOrders" role="tabpanel"
                                aria-labelledby="open-orders-tab">
                                <table class="account-box_table table table-borderless dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('trade') ?></th>
                                            <th><?php echo display('rate') ?></th>
                                            <th title="<?php echo display('required_qty') ?>">Req.Qty</th>
                                            <th title="<?php echo display('available_qty') ?>">Av.qty</th>
                                            <th class="text-right" title="<?php echo display('required_amount') ?>">
                                                Req.Amt</th>
                                            <th class="text-right" title="<?php echo display('available_amount') ?>">
                                                Av.Amt</th>
                                            <th><?php echo display('market') ?></th>
                                            <th><?php echo display('open') ?></th>
                                            <th width="30"><?php echo display('status') ?></th>
                                            <th class="text-right"><?php echo display('action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($open_trade as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo esc($value->bid_type); ?></td>
                                            <td><?php echo esc($value->bid_price); ?></td>
                                            <td><?php echo esc($value->bid_qty); ?></td>
                                            <td><?php echo esc($value->bid_qty_available); ?></td>
                                            <td><?php echo esc($value->total_amount); ?></td>
                                            <td><?php echo esc($value->amount_available); ?></td>
                                            <td><?php echo esc($value->market_symbol); ?></td>
                                            <td><?php echo esc($value->open_order); ?></td>
                                            <td width="30">
                                                <div class="progress">
                                                    <div title="Running"
                                                        class="progress-bar progress-bar-striped width100percent">
                                                        Running</div>
                                                </div>
                                            </td>
                                            <td><a href="<?php echo base_url("order-cancel/$value->id") ?>"
                                                    class="bg-danger text-white text-center" data-toggle="tooltip"
                                                    data-placement="left"
                                                    title="Cancel"><?php echo display('cancel') ?></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="orderHistory" role="tabpanel"
                                aria-labelledby="order-history-tab">
                                <table class="account-box_table table table-borderless dt-responsive nowrap">
                                    <thead>
                                        <tr class="table-bg">
                                            <th><?php echo display('trade') ?></th>
                                            <th><?php echo display('rate') ?></th>
                                            <th><?php echo display('qty') ?></th>
                                            <th><?php echo display('amount') ?></th>
                                            <th><?php echo display('market') ?></th>
                                            <th><?php echo display('open') ?></th>
                                            <th><?php echo display('status') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="usercompleteTrade">
                                        <?php foreach ($complete_trade as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo esc($value->bid_type); ?></td>
                                            <td><?php echo esc($value->bid_price); ?></td>
                                            <td><?php echo esc($value->bid_qty); ?></td>
                                            <td><?php echo esc($value->total_amount); ?></td>
                                            <td><?php echo esc($value->market_symbol); ?></td>
                                            <td><?php echo esc($value->open_order); ?></td>
                                            <td class="text-left">
                                                <i title='<?php echo display('success'); ?>'
                                                    class='feather-check-circle text-success'></i>
                                                <?php echo display('success'); ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="allTrade" role="tabpanel"
                                aria-labelledby="trade-history-tab">
                                <table class="account-box_table table table-borderless dt-responsive nowrap">
                                    <thead>
                                        <tr class="table-bg">
                                            <th title="<?php echo display('trade') ?>"><?php echo display('trade') ?>
                                            </th>
                                            <th title="<?php echo display('rate') ?>"><?php echo display('rate') ?></th>
                                            <th title="<?php echo display('required_qty') ?>">Req.Qty</th>
                                            <th title="<?php echo display('available_qty') ?>">Av.Qty</th>
                                            <th title="<?php echo display('required_amount') ?>">Req.Amt</th>
                                            <th title="<?php echo display('available_amount') ?>">Av.Amt</th>
                                            <th title="<?php echo display('market') ?>"><?php echo display('market') ?>
                                            </th>
                                            <th title="<?php echo display('open') ?>"><?php echo display('open') ?></th>
                                            <th title="<?php echo display('complete_qty') ?>">C.Qty</th>
                                            <th title="<?php echo display('complete_amount') ?>">C.Amt</th>
                                            <th title="<?php echo display('trade_time') ?>">
                                                <?php echo display('trade_time') ?></th>
                                            <th title="<?php echo display('status') ?>"><?php echo display('status') ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($user_trade_history as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo esc($value->bid_type) ?></td>
                                            <td><?php echo esc($value->bid_price) ?></td>
                                            <td><?php echo esc($value->bid_qty) ?></td>
                                            <td><?php echo esc($value->bid_qty_available) ?></td>
                                            <td><?php echo esc($value->total_amount) ?></td>
                                            <td><?php echo esc($value->amount_available) ?></td>
                                            <td><?php echo esc($value->market_symbol) ?></td>
                                            <td><?php echo esc($value->open_order) ?></td>
                                            <td><?php echo esc($value->complete_qty?$value->complete_qty:"0.00") ?></td>
                                            <td><?php echo esc($value->complete_amount?$value->complete_amount:"0.00") ?>
                                            </td>
                                            <td><?php echo esc($value->success_time?$value->success_time:$value->open_order) ?>
                                            </td>
                                            <td><?php echo esc($value->status) == 0 ? "<i title='Canceled' class='feather-x-circle text-danger'></i>Canceled" : (esc($value->status) == 1 ? "<i title='Complete' class='feather-check-circle text-success'></i>Complete" : '<div class="progress"><div title="Running" class="progress-bar progress-bar-striped width100percent">Running</div></div>') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Empty Box -->
                        <?php  if($session->get('user_id') == NULL){ ?>
                        <div class="empty-box">
                            <div class="no-login">
                                <a
                                    href="<?php echo base_url('login'); ?>"><?php echo display('login') ?></a>&nbsp;or&nbsp;<a
                                    href="<?php echo base_url('register'); ?>"><?php echo display('register') ?></a>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- /.Empty Box -->
                    </div>
                </div>
                <!-- /.Account Box -->
            </div>

            <!-- /.Body Content -->
            <!-- Footer -->
            <Footer class="footer">
                <?php echo esc($settings->footer_text); ?>
            </Footer>
            <!-- /.Footer -->
        </div>
    </div>
    <!-- Orderform Button -->
    <div class="orderform d-flex align-items-center justify-content-center d-md-none">
        <button type="button" class="btn btn-success profile-collapse btn-buy"><?php echo display('buy'); ?></button>
        <button type="button" class="btn btn-danger profile-collapse btn-sell"><?php echo display('sell'); ?></button>
    </div>
    <div class="overlay orderform-overlay"></div>
    <!-- /.Orderform Button -->
    <!-- Language Modal -->
    <div class="modal select-modal" id="languaheModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header p-0 pe-3">
                    <ul class="nav nav-tabs select-tabs" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true"><?php echo display('language'); ?></button>
                        </li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <ul class="select-list">
                                <li class="<?php echo isset($lang) && $lang =="english"?'active':''; ?>"><a href="#"
                                        class="english" data-id="english">English</a></li>
                                <li class="<?php echo isset($lang) && $lang =="french"?'active':''; ?>"><a href="#"
                                        class="french" data-id="french"><?php echo esc($web_language->name); ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Language Modal -->
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/jQuery/jquery.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/datatables/jquery.dataTables.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/datatables/dataTables.bootstrap5.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/datatables/dataTables.responsive.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/datatables/responsive.bootstrap5.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/apexcharts/apexcharts.min.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/bootstrap-slider/dist/bootstrap-slider.min.js' ?>">
    </script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/blockUI/jquery.blockUI.js' ?>">
    </script>
    <script src="<?php echo BASEPATH.'assets/js/toastr.js?v=1' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/js/pingpoliWebSocket.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/js/pingpoliCandlestickChart.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/js/CandlestickStream.js' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/js/custom.js?v=1.0' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/js/exchange.js?v=1.10' ?>"></script>
    <script src="<?php echo BASEPATH.'exchange/assets/plugins/apexcharts/apexcharts.active.js?v=1' ?>"></script>

</body>

</html>