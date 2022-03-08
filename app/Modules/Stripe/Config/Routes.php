<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('customer', ['namespace' => 'App\Modules\Stripe\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/stripe', 'Payment_process::stripe');
    $subroutes->add('payment_callback/stripe_confirm/(:any)', 'Payment_callback::stripe_confirm/$1');
    
});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Stripe\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/

    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Stripe\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
     $subroutes->add('payment_gateway/stripe_setting', 'Payment_gateway::form');

});