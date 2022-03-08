<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Common\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin cms***/
    $subroutes->add('autoupdate/cancel_notification', 'Autoupdate::cancel_notification');
    $subroutes->add('auto_update', 'Autoupdate::index');
    $subroutes->add('auto_update/update', 'Autoupdate::update');
    $subroutes->add('download_database', 'Autoupdate::Download');
});

$routes->group('backend', ['namespace' => 'App\Modules\Common\Controllers\Admin'], function ($subroutes) {
    
    $subroutes->add('auto_update/updatenow', 'Autoupdate::updatenow');

});