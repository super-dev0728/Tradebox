<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Finance\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('deposit/add_deposit', 'Deposit::index');
    $subroutes->add('deposit/payment_gateway', 'Deposit::payment_gateway');
    $subroutes->add('deposit/show_list', 'Deposit::show');
    $subroutes->add('deposit/deposit_list/(:any)', 'Deposit::deposit_list/$1');
    $subroutes->add('withdraw/withdraw_ajax_list/(:any)', 'Withdraw::withdraw_ajax_list/$1');
    $subroutes->add('withdraw/confirm_withdraw/(:num)', 'Withdraw::confirm_withdraw/$1');
    $subroutes->add('withdraw/withdraw_verify', 'Withdraw::withdraw_verify');
    $subroutes->add('withdraw/withdraw_details/(:num)', 'Withdraw::withdraw_details/$1');
    $subroutes->add('withdraw/withdraw_list', 'Withdraw::withdraw_list');    
    $subroutes->add('withdraw/store', 'Withdraw::store');
    $subroutes->add('withdraw/withdraw_money', 'Withdraw::index');
    $subroutes->add('withdraw/withdraw_list', 'Withdraw::withdraw_list');

    $subroutes->add('transfer/transfer_amount', 'Transfer::index');
    $subroutes->add('transfer/store', 'Transfer::store');
    $subroutes->add('transfer/confirm_transfer/(:num)', 'Transfer::confirm_transfer/$1');
    $subroutes->add('transfer/transfer_verify', 'Transfer::transfer_verify');
    $subroutes->add('transfer/transfer_recite/(:num)', 'Transfer::transfer_recite/$1');
    $subroutes->add('transfer/transfer_list', 'Transfer::transfer_list');
    $subroutes->add('transfer/send_details/(:num)', 'Transfer::send_details/$1');
    $subroutes->add('transfer/receive_details/(:num)', 'Transfer::receive_details/$1');
    $subroutes->add('transection/transection_list', 'Transection::index');
    

});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Finance\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('internal_api/gateway', 'Internal_api::gateway');
    $subroutes->add('ajaxload/fees_load', 'Ajaxload::fees_load');
    $subroutes->add('ajaxload/walletid', 'Ajaxload::walletid');
    $subroutes->add('ajaxload/checke_reciver_id', 'Ajaxload::checke_reciver_id');

});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Finance\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('', 'Dashboard::index');

    $subroutes->add('finance/withdraw-list', 'FinanceController::withdraw_list');
    $subroutes->add('finance/withdraw-list/(:any)', 'FinanceController::withdraw_list/$1');
    $subroutes->add('finance/pending-withdraw', 'FinanceController::pending_withdraw');
    $subroutes->add('finance/pending-withdraw/(:any)', 'FinanceController::pending_withdraw/$1');
    $subroutes->add('finance/confirm-withdraw', 'FinanceController::confirm_withdraw');
    $subroutes->add('finance/cancel-withdraw', 'FinanceController::cancel_withdraw');

    $subroutes->add('finance/deposit-list', 'FinanceController::deposit_list');
    $subroutes->add('finance/deposit-list/(:any)', 'FinanceController::deposit_list/$1');
    $subroutes->add('finance/pending-deposit', 'FinanceController::pending_deposit');
    $subroutes->add('finance/pending-deposit/(:any)', 'FinanceController::pending_deposit/$1');
    $subroutes->add('finance/confirm-deposit', 'FinanceController::confirm_deposit');
    $subroutes->add('finance/cancel-deposit', 'FinanceController::cancel_deposit');

    $subroutes->add('finance/credit-list', 'FinanceController::credit_list');
    $subroutes->add('finance/credit-list/(:any)', 'FinanceController::credit_list/$1');
    $subroutes->add('finance/credit-details/(:any)', 'FinanceController::credit_details/$1');
    $subroutes->add('finance/add-credit', 'FinanceController::add_credit');
    $subroutes->add('finance/user-info-load', 'FinanceController::user_info_load');

});