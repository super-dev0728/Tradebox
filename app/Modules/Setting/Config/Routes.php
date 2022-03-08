<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Setting\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin package***/
    $subroutes->add('setting/app-setting', 'SettingController::index');
    $subroutes->add('setting/security', 'SettingController::security');
    $subroutes->add('setting/block-list', 'SettingController::blocklist');
    $subroutes->add('setting/delete-block/(:any)', 'SettingController::delete_block/$1');
    $subroutes->add('setting/fees-setting', 'SettingController::fees_settig');
    $subroutes->add('setting/fees-setting-save', 'SettingController::fees_setting_save');
    $subroutes->add('setting/delete-fees-setting/(:any)', 'SettingController::delete_fees_setting/$1');
    $subroutes->add('setting/transaction-setup', 'SettingController::transaction_setup');
    $subroutes->add('setting/transaction-save', 'SettingController::transaction_save');
    $subroutes->add('setting/delete-transaction/(:any)', 'SettingController::delete_transaction/$1');
    $subroutes->add('setting/language', 'SettingController::language');
    $subroutes->add('setting/add-language', 'SettingController::addLanguage');
    $subroutes->add('setting/phrase', 'SettingController::phrase');
    $subroutes->add('setting/add-phrase', 'SettingController::addPhrase');
    $subroutes->add('setting/edit-phrase/(:any)', 'SettingController::editPhrase/$1');
    $subroutes->add('setting/search/(:any)', 'SettingController::search/$1');
    $subroutes->add('setting/add-lebel', 'SettingController::addLebel');
    $subroutes->add('setting/payment-gateway', 'SettingController::payment_gateway');
    $subroutes->add('setting/update-gateway/(:any)', 'SettingController::update_payment_gateway/$1');
    $subroutes->add('setting/affiliation', 'SettingController::affiliation');
    $subroutes->add('setting/external-api-list', 'SettingController::extrnal_api_list');
    $subroutes->add('setting/update-external-api/(:any)', 'SettingController::update_external_api/$1');
    $subroutes->add('setting/email-gateway', 'SettingController::email_gateway');
    $subroutes->add('setting/email-test', 'SettingController::test_email');
    $subroutes->add('setting/sms-gateway', 'SettingController::sms_gateway');
    $subroutes->add('setting/test-sms', 'SettingController::test_sms');
    $subroutes->add('setting/getemailsmsgateway', 'SettingController::getemailsmsgateway');
    $subroutes->add('setting/update-sms-gateway', 'SettingController::update_sms_gateway');
    $subroutes->add('setting/update-email-gateway', 'SettingController::update_email_gateway');
    $subroutes->add('setting/email-sms-template', 'SettingController::email_sms_template_list');
    $subroutes->add('setting/template-update', 'SettingController::template_update');
    $subroutes->add('setting/template-update/(:any)', 'SettingController::template_update/$1');
    $subroutes->add('setting/email-sms-settings', 'SettingController::email_sms_setting');
    $subroutes->add('setting/update-sender', 'SettingController::update_sender');
});