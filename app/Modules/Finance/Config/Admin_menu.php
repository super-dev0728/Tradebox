<?php

$ADMINMENU['finance'] = array(
    'order'         => 2,
    'parent'        => 'Finance',
    'status'        => 1,
    'link'          => 'finance',
    'icon'          => '<i class="fas fa-money-check"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('pending_withdraw'),
                    'icon'          => null,
                    'link'          => 'finance/pending-withdraw',
                    'segment'       => 3,
                    'segment_text'  => 'pending-withdraw',
                ),
                '1' => array(
                    'name'          => display('withdraw_list'),
                    'icon'          => null,
                    'link'          => 'finance/withdraw-list',
                    'segment'       => 3,
                    'segment_text'  => 'withdraw-list',
                ),
                '2' => array(
                    'name'          => display('pending_deposit'),
                    'icon'          => null,
                    'link'          => 'finance/pending-deposit',
                    'segment'       => 3,
                    'segment_text'  => 'pending-deposit',
                ),
                '3' => array(
                    'name'          => display('deposit_list'),
                    'icon'          => null,
                    'link'          => 'finance/deposit-list',
                    'segment'       => 3,
                    'segment_text'  => 'deposit-list',
                ),
                '4' => array(
                    'name'          => display('add_credit'),
                    'icon'          => null,
                    'link'          => 'finance/add-credit',
                    'segment'       => 3,
                    'segment_text'  => 'add-credit',
                ),
                '5' => array(
                    'name'          => display('credit_list'),
                    'icon'          => null,
                    'link'          => 'finance/credit-list',
                    'segment'       => 3,
                    'segment_text'  => 'credit-list',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'finance'
);