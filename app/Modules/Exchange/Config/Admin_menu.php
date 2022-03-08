<?php
$ADMINMENU['exchange'] = array(
    'order'         => 3,
    'parent'        => display('exchange'),
    'status'        => 1,
    'link'          => 'trade',
    'icon'          => '<i class="hvr-buzz-out fas fa-exchange-alt"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('cryptocoin'),
                    'icon'          => null,
                    'link'          => 'exchange/cryptocoin',
                    'segment'       => 3,
                    'segment_text'  => 'cryptocoin',
                ),
                '1' => array(
                    'name'          => display('market'),
                    'icon'          => null,
                    'link'          => 'exchange/market',
                    'segment'       => 3,
                    'segment_text'  => 'market',
                ),
                '2' => array(
                    'name'          => display('coin_pair'),
                    'icon'          => null,
                    'link'          => 'exchange/coin-pair',
                    'segment'       => 3,
                    'segment_text'  => 'coin-pair',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'exchange'
);