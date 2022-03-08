<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Token\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/token', 'Payment_process::token');
    $subroutes->add('payment_callback/token_confirm', 'Payment_callback::token_confirm');
    
});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Token\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/

    
});

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Token\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/token_setting', 'Payment_gateway::form');

});