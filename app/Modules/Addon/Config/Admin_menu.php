<?php

$ADMINMENU['addons'] = array(
    'order'         => 8,
    'parent'        => 'Addons',
    'status'        => 1,
    'link'          => 'Addons',
    'icon'          => '<i class="fas fa-project-diagram"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('add_theme'),
                    'icon'          => null,
                    'link'          => 'module/add_theme',
                    'segment'       => 3,
                    'segment_text'  => 'add_theme',
                ),
                '1' => array(
                    'name'          => display('add_module'),
                    'icon'          => null,
                    'link'          => 'module/add_module',
                    'segment'       => 3,
                    'segment_text'  => 'add_module',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'addons'
);