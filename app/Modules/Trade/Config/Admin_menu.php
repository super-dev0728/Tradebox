<?php

$imagpath = IMAGEPATH."assets/images/icons/icon.png";

$ADMINMENU['trade'] = array(
    'order'         => 2,
    'parent'        => display('trade'),
    'status'        => 1,
    'link'          => 'trade',
    'icon'          => '<img class="pal15" height="25" width="25" src="'.$imagpath.'">',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('open_order'),
                    'icon'          => null,
                    'link'          => 'trade/open-order',
                    'segment'       => 3,
                    'segment_text'  => 'open-order',
                ),
                '1' => array(
                    'name'          => display('trade_history'),
                    'icon'          => null,
                    'link'          => 'trade/trade-history',
                    'segment'       => 3,
                    'segment_text'  => 'trade-history',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'trade'
);