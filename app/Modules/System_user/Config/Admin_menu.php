<?php

$ADMINMENU['admin'] = array(
    'order'         => 5,
    'parent'        => display('admin'),
    'status'        => 1,
    'link'          => 'Admin',
    'icon'          => '<i class="hvr-buzz-out fas fa-user-tie"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('add_admin'),
                    'icon'          => null,
                    'link'          => 'add-admin',
                    'segment'       => 3,
                    'segment_text'  => 'add-admin',
                ),
                '1' => array(
                    'name'          => display('admin_list'),
                    'icon'          => null,
                    'link'          => 'admin-list',
                    'segment'       => 3,
                    'segment_text'  => 'admin-list',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'admin'
);