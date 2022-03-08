<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Coinpayment\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/coinpayment', 'Payment_process::coinpayment');
});
$routes->group('customer', ['namespace' => 'App\Modules\Coinpayment\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_callback/conipayment_confirm', 'Payment_callback::conipayment_confirm');
    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Coinpayment\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/coinpayment_setting', 'Payment_gateway::form');
});