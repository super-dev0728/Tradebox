<?php

$ADMINMENU['user'] = array(
    'order'         => 5,
    'parent'        => display('users'),
    'status'        => 1,
    'link'          => 'user',
    'icon'          => '<i class="fa fa-users"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('create_user'),
                    'icon'          => null,
                    'link'          => 'user/add-user',
                    'segment'       => 3,
                    'segment_text'  => 'add-user',
                ),
                '1' => array(
                    'name'          => display('user_list'),
                    'icon'          => null,
                    'link'          => 'user/user-list',
                    'segment'       => 3,
                    'segment_text'  => 'user-list',
                ),
                '2' => array(
                    'name'          => display('verify_users'),
                    'icon'          => null,
                    'link'          => 'user/verify-user',
                    'segment'       => 3,
                    'segment_text'  => 'verify-user',
                ),
                '3' => array(
                    'name'          => display('subscriber_list'),
                    'icon'          => null,
                    'link'          => 'user/subscriber-list',
                    'segment'       => 3,
                    'segment_text'  => 'subscriber-list',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'user'
);