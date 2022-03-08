<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Addon\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/


});
$routes->group('customer', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Addon\Controllers'], function ($subroutes) {
    /*** Route for customer finance***/
    

});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Addon\Controllers'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('module/add_theme', 'Theme::index');
    $subroutes->add('module/add_module', 'Module::index');
    $subroutes->add('theme/upload_new_theme', 'Theme::upload_new_theme');
    $subroutes->add('theme/active_theme/(:any)', 'Theme::active_theme/$1');
    $subroutes->add('theme/delete/(:any)', 'Theme::theme_delete/$1');
    $subroutes->add('theme/download_theme', 'Theme::download_theme');
    $subroutes->add('module/verify_download_request', 'Module::verify_download_request');
    $subroutes->add('theme/verify_theme_download', 'Theme::verify_theme_download');
    $subroutes->add('module/upload', 'Module::upload');
    $subroutes->add('module/install', 'Module::install');
    $subroutes->add('module/uninstall/(:any)', 'Module::uninstall/$1');
    $subroutes->add('module/uninstall/(:any)/delete', 'Module::uninstall/$1');
    $subroutes->add('module/download_module', 'Module::download_module');

});