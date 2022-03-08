<?php

$ADMINMENU['setting'] = array(
    'order'         => 6,
    'parent'        => display('setting'),
    'status'        => 1,
    'link'          => 'setting',
    'icon'          => '<i class="fa fa ti-settings"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('app_setting'),
                    'icon'          => null,
                    'link'          => 'setting/app-setting',
                    'segment'       => 3,
                    'segment_text'  => 'app-setting',
                ),
                '1' => array(
                    'name'          => display('security'),
                    'icon'          => null,
                    'link'          => 'setting/security',
                    'segment'       => 3,
                    'segment_text'  => 'security',
                ),
                '2' => array(
                    'name'          => display('fees_setting'),
                    'icon'          => null,
                    'link'          => 'setting/fees-setting',
                    'segment'       => 3,
                    'segment_text'  => 'fees-setting',
                ),
                '3' => array(
                    'name'          => display('transaction_setup'),
                    'icon'          => null,
                    'link'          => 'setting/transaction-setup',
                    'segment'       => 3,
                    'segment_text'  => 'transaction-setup',
                ),
                '4' => array(
                    'name'          => display('email_gateway'),
                    'icon'          => null,
                    'link'          => 'setting/email-gateway',
                    'segment'       => 3,
                    'segment_text'  => 'email-gateway',
                ),
                '5' => array(
                    'name'          => display('sms_gateway'),
                    'icon'          => null,
                    'link'          => 'setting/sms-gateway',
                    'segment'       => 3,
                    'segment_text'  => 'sms-gateway',
                ),
                '6' => array(
                    'name'          => display('email_sms_template'),
                    'icon'          => null,
                    'link'          => 'setting/email-sms-template',
                    'segment'       => 3,
                    'segment_text'  => 'email-sms-template',
                ),
                '7' => array(
                    'name'          => display('email_sms_settings'),
                    'icon'          => null,
                    'link'          => 'setting/email-sms-settings',
                    'segment'       => 3,
                    'segment_text'  => 'email-sms-settings',
                ),
                '8' => array(
                    'name'          => display('language'),
                    'icon'          => null,
                    'link'          => 'setting/language',
                    'segment'       => 3,
                    'segment_text'  => 'language',
                ),
                '9' => array(
                    'name'          => display('affiliation'),
                    'icon'          => null,
                    'link'          => 'setting/affiliation',
                    'segment'       => 3,
                    'segment_text'  => 'affiliation',
                ),
                '10' => array(
                    'name'          => display('external_api_list'),
                    'icon'          => null,
                    'link'          => 'setting/external-api-list',
                    'segment'       => 3,
                    'segment_text'  => 'external-api-list',
                )

    ),
    'segment'       => 2,
    'segment_text'  => 'setting'
);