<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Gourl\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_gateway/bitcoin', 'Payment_process::bitcoin');
    $subroutes->add('payment_callback/bitcoin_confirm/(:any)', 'Payment_callback::bitcoin_confirm/$1');
    

    
});
$routes->group('customer', ['namespace' => 'App\Modules\Gourl\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    $subroutes->add('payment_callback/gourl_callback', 'Payment_callback::gourl_callback');
    
});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Gourl\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('payment_gateway/gourl_setting', 'Payment_gateway::form');
    

});