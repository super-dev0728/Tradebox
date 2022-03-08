<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Trade\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('trade/open-order', 'TradeController::open_order');
    $subroutes->add('trade/trade-history', 'TradeController::trade_history');

});