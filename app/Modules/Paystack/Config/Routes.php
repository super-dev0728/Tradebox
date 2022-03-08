<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Paystack\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/paystack', 'Payment_process::paystack');
    $subroutes->add('payment_callback/paystack_confirm', 'Payment_callback::paystack_confirm');
    
});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Paystack\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/

    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Paystack\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/paystack_setting', 'Payment_gateway::form');

});