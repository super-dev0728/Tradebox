<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}
$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\System_user\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('admin-list', 'AdminController::index');
	$subroutes->add('add-admin', 'AdminController::form');
	$subroutes->add('add-admin/(:any)', 'AdminController::form/$1');
	$subroutes->add('edit-admin/(:any)', 'AdminController::form/$1');
	$subroutes->add('admin-delete/(:any)', 'AdminController::delete/$1');

});

