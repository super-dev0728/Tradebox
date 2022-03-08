<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\User\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('user/user-list', 'UserController::index');
	$subroutes->add('user/ajax-list', 'UserController::ajax_list');
	$subroutes->add('user/add-user', 'UserController::form');
	$subroutes->add('user/edit-user', 'UserController::form');
	$subroutes->add('user/edit-user/(:any)', 'UserController::form/$1');
	$subroutes->add('user/user-details', 'UserController::user_details');
	$subroutes->add('user/user-details/(:any)', 'UserController::user_details/$1');
	$subroutes->add('user/ajax-tradelist/(:any)/(:any)', 'UserController::ajax_tradelist/$1/$2');
	$subroutes->add('user/verify-user', 'UserController::pending_user_verification_list');
	$subroutes->add('user/pending-user-verification/(:any)', 'UserController::pending_user_verification/$1');
	$subroutes->add('user/subscriber-list', 'UserController::subscriber_list');

});