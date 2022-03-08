<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}






$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Payeer\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/payeer', 'Payment_process::payeer');
    $subroutes->add('payment_callback/payeer_success', 'Payment_callback::payeer_success');
    $subroutes->add('customer/payment_callback/payeer_cancel', 'Payment_callback::payeer_cancel');
    
});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Payeer\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/

    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Payeer\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/payeer_setting', 'Payment_gateway::form');

});