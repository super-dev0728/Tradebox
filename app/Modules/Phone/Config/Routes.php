<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Phone\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/phone', 'Payment_process::phone');
    $subroutes->add('payment_callback/phone_confirm', 'Payment_callback::phone_confirm');
    
});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Phone\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/

    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Phone\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/phone_setting', 'Payment_gateway::form');

});