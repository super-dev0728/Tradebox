<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Exchange\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('exchange/cryptocoin', 'ExchangeController::index');
	$subroutes->add('exchange/cryptocoin-ajax-list', 'ExchangeController::ajax_list');
	$subroutes->add('exchange/cryptocoin-edit/(:any)', 'ExchangeController::form/$1');
	$subroutes->add('exchange/cryptocoin-add', 'ExchangeController::form');
	$subroutes->add('exchange/cryptocoin-edit', 'ExchangeController::form');

	$subroutes->add('exchange/market', 'ExchangeController::market');
	$subroutes->add('exchange/add-market', 'ExchangeController::market_form');
	$subroutes->add('exchange/add-market/(:any)', 'ExchangeController::market_form/$1');
	$subroutes->add('exchange/edit-market', 'ExchangeController::market_form');
	$subroutes->add('exchange/edit-market/(:any)', 'ExchangeController::market_form/$1');

	$subroutes->add('exchange/coin-pair', 'ExchangeController::coin_pair');
	$subroutes->add('exchange/add-coin-pair', 'ExchangeController::add_coin_pair_form');
	$subroutes->add('exchange/add-coin-pair/(:any)', 'ExchangeController::add_coin_pair_form/$1');
	$subroutes->add('exchange/edit-coin-pair/(:any)', 'ExchangeController::add_coin_pair_form/$1');
	$subroutes->add('exchange/market_streamer', 'ExchangeController::market_streamer');

});