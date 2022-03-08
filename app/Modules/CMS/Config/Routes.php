<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\CMS\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin cms***/
    $subroutes->add('cms/themes-setting', 'CmsController::index');
    $subroutes->add('cms/page-content-list', 'CmsController::page_content_list');
    $subroutes->add('cms/add-page-content', 'CmsController::add_page_content');
    $subroutes->add('cms/add-page-content/(:any)', 'CmsController::add_page_content/$1');
    $subroutes->add('cms/edit-page-content/(:any)', 'CmsController::add_page_content/$1');
    $subroutes->add('cms/delete-page-content/(:any)', 'CmsController::delete_page_content/$1');

    $subroutes->add('cms/faq-list', 'CmsController::faq_list');
    $subroutes->add('cms/add-faq', 'CmsController::add_faq');
    $subroutes->add('cms/add-faq/(:any)', 'CmsController::add_faq/$1');
    $subroutes->add('cms/edit-faq/(:any)', 'CmsController::add_faq/$1');
    $subroutes->add('cms/delete-faq/(:any)', 'CmsController::delete_faq/$1');

    $subroutes->add('cms/notice-list', 'CmsController::notice_list');
    $subroutes->add('cms/add-notice', 'CmsController::add_notice');
    $subroutes->add('cms/add-notice/(:any)', 'CmsController::add_notice/$1');
    $subroutes->add('cms/edit-notice/(:any)', 'CmsController::add_notice/$1');
    $subroutes->add('cms/delete-notice/(:any)', 'CmsController::delete_notice/$1');

    $subroutes->add('cms/contact', 'CmsController::contact');

    $subroutes->add('cms/news-list', 'CmsController::news_list');
    $subroutes->add('cms/add-news', 'CmsController::add_news');
    $subroutes->add('cms/add-news/(:any)', 'CmsController::add_news/$1');
    $subroutes->add('cms/edit-news/(:any)', 'CmsController::add_news/$1');
    $subroutes->add('cms/delete-news/(:any)', 'CmsController::delete_news/$1');

    $subroutes->add('cms/category-list', 'CmsController::category_list');
    $subroutes->add('cms/add-category', 'CmsController::add_category');
    $subroutes->add('cms/add-category/(:any)', 'CmsController::add_category/$1');
    $subroutes->add('cms/edit-category/(:any)', 'CmsController::add_category/$1');
    $subroutes->add('cms/delete-category/(:any)', 'CmsController::delete_category/$1');

    $subroutes->add('cms/slider-list', 'CmsController::slider_list');
    $subroutes->add('cms/add-slider', 'CmsController::add_slider');
    $subroutes->add('cms/add-slider/(:any)', 'CmsController::add_slider/$1');
    $subroutes->add('cms/edit-slider/(:any)', 'CmsController::add_slider/$1');
    $subroutes->add('cms/delete-slider/(:any)', 'CmsController::delete_slider/$1');

    $subroutes->add('cms/social-link-list', 'CmsController::social_link_list');
    $subroutes->add('cms/add-social-link', 'CmsController::add_social_link');
    $subroutes->add('cms/add-social-link/(:any)', 'CmsController::add_social_link/$1');
    $subroutes->add('cms/edit-social-link/(:any)', 'CmsController::add_social_link/$1');
    $subroutes->add('cms/delete-social-link/(:any)', 'CmsController::delete_social_link/$1');

    $subroutes->add('cms/advertisement-list', 'CmsController::advertisement_list');
    $subroutes->add('cms/add-advertisement', 'CmsController::add_advertisement');
    $subroutes->add('cms/add-advertisement/(:any)', 'CmsController::add_advertisement/$1');
    $subroutes->add('cms/edit-advertisement/(:any)', 'CmsController::add_advertisement/$1');
    $subroutes->add('cms/delete-advertisement/(:any)', 'CmsController::delete_advertisement/$1');
    $subroutes->add('cms/getAdvertisementinfo/(:any)', 'CmsController::getAdvertisementinfo/$1');

    $subroutes->add('cms/web-language-list', 'CmsController::weblanguage_list');
    $subroutes->add('cms/add-weblanguage', 'CmsController::add_weblanguage');
    $subroutes->add('cms/add-weblanguage/(:any)', 'CmsController::add_weblanguage/$1');
    $subroutes->add('cms/edit-weblanguage/(:any)', 'CmsController::add_weblanguage/$1');
    $subroutes->add('cms/delete-weblanguage/(:any)', 'CmsController::delete_weblanguage/$1');
});