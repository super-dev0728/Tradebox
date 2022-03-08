<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Paypal\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/paypal', 'Payment_process::paypal');
    $subroutes->add('payment_callback/paypal_confirm', 'Payment_callback::paypal_confirm');
    $subroutes->add('payment_callback/paypal_cancel', 'Payment_callback::paypal_cancel');
    
});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Paypal\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/

    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Paypal\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/paypal_setting', 'Payment_gateway::form');

});