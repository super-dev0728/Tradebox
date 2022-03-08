<body class="fixed">
    <!-- HEADER: MENU -->
    <div class="wrapper">
        <nav class="sidebar sidebar-bunker">
            <div class="sidebar-header">
                <a href="<?php echo base_url() ?>" class="logo"><img
                        src="<?php echo base_url(!empty($settings->logo) ? esc($settings->logo) : "assets/images/icons/logo.png"); ?>"
                        alt=""></a>

            </div>
            <!--/.sidebar header-->
            <div class="profile-element d-flex align-items-center flex-shrink-0">
                <div class="avatar online">
                    <img src="<?php echo base_url() . session('image') ?>" class="img-fluid rounded-circle" alt="">
                </div>
                <div class="profile-text">
                    <h6 class="m-0"><?php echo session('fullname') ?></h6>
                    <span><?php echo session('email') ?></span>
                </div>
            </div>
            <!--/.profile element-->
            <div class="sidebar-body">
                <nav class="sidebar-nav">
                    <ul class="metismenu">

                        <?php
                        helper('filesystem');
                        $path = 'app/Modules/';
                        $map  = directory_map($path);
                        $CUSTOMERMENU   = array();

                        if (is_array($map) && sizeof($map) > 0) {
                            foreach ($map as $key => $value) {
                                $menu = str_replace("\\", '/', $path . $key . 'Config/Customer_menu.php');
                                if (file_exists($menu)) {

                                    @include($menu);

                                    // if (file_exists(APPPATH . 'modules/' . $key . '/assets/data/env')) {
                                    //     @include($menu);
                                    // }
                                }
                            }
                        }
                        
                        $shortkeys = array_column($CUSTOMERMENU, 'order');
                        array_multisort($shortkeys, SORT_ASC, $CUSTOMERMENU);

                        foreach ($CUSTOMERMENU as $module => $parent) {

                            if ($parent['status'] == 0) {
                        ?>

                        <li
                            class="<?php echo (($uri->setSilent()->getSegment($parent['segment']) == $parent['segment_text']) ? "mm-active" : null) ?>">
                            <a class="<?php echo (($uri->setSilent()->getSegment($parent['segment']) == $parent['segment_text']) ? "mm-active" : null) ?> material-ripple"
                                href="<?php echo base_url("customer/" . $parent['link']) ?>">
                                <?php if ($parent['icon']) {
                                            echo $parent['icon'];
                                        } ?>
                                <?php echo trim($parent['parent']); ?>
                            </a>
                        </li>
                        <?php
                            } else if ($parent['status'] == 1) {
                            ?>
                        <li >
                            <a class="has-arrow material-ripple <?php echo (($uri->setSilent()->getSegment($parent['segment']) == $parent['segment_text']) ? "mm-active" : null) ?>"
                                href="#">
                                <?php if ($parent['icon']) {
                                            echo $parent['icon'];
                                        } ?>
                                <?php echo trim($parent['parent']); ?>
                            </a>
                            <ul class="nav-second-level">
                                <?php
                                        foreach ($parent['submenu'] as $key => $child) {
                                        ?>
                                <li
                                    class="<?php echo (($uri->setSilent()->getSegment($child['segment']) == $child['segment_text']) ? "mm-active" : null) ?>">
                                    <a href="<?php echo base_url("customer/" . $child['link']) ?>">
                                        <?php if ($child['icon']) {
                                                        echo $child['icon'];
                                                    } ?>
                                        <?php echo trim($child['name']); ?> </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div><!-- sidebar-body -->
        </nav>