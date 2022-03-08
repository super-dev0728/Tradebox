<?php

$ADMINMENU['cms'] = array(
    'order'         => 8,
    'parent'        => display('cms'),
    'status'        => 1,
    'link'          => 'cms',
    'icon'          => '<i class="hvr-buzz-out far fa-comment-alt"></i>',
    'submenu'       => array(
                '0' => array(
                    'name'          => display('themes_setting'),
                    'icon'          => null,
                    'link'          => 'cms/themes-setting',
                    'segment'       => 3,
                    'segment_text'  => 'themes-setting',
                ),
                '1' => array(
                    'name'          => display('page_content_list'),
                    'icon'          => null,
                    'link'          => 'cms/page-content-list',
                    'segment'       => 3,
                    'segment_text'  => 'page-content-list',
                ),
                '2' => array(
                    'name'          => display('faq_list'),
                    'icon'          => null,
                    'link'          => 'cms/faq-list',
                    'segment'       => 3,
                    'segment_text'  => 'faq-list',
                ),
                '3' => array(
                    'name'          => display('notice_list'),
                    'icon'          => null,
                    'link'          => 'cms/notice-list',
                    'segment'       => 3,
                    'segment_text'  => 'notice-list',
                ),
                '4' => array(
                    'name'          => display('news_list'),
                    'icon'          => null,
                    'link'          => 'cms/news-list',
                    'segment'       => 3,
                    'segment_text'  => 'news-list',
                ),
                '5' => array(
                    'name'          => display('category_list'),
                    'icon'          => null,
                    'link'          => 'cms/category-list',
                    'segment'       => 3,
                    'segment_text'  => 'category-list',
                ),
                '6' => array(
                    'name'          => display('slider_list'),
                    'icon'          => null,
                    'link'          => 'cms/slider-list',
                    'segment'       => 3,
                    'segment_text'  => 'slider-list',
                ),
                '7' => array(
                    'name'          => display('social_link_list'),
                    'icon'          => null,
                    'link'          => 'cms/social-link-list',
                    'segment'       => 3,
                    'segment_text'  => 'social-link-list',
                ),
                '8' => array(
                    'name'          => display('advertisement_list'),
                    'icon'          => null,
                    'link'          => 'cms/advertisement-list',
                    'segment'       => 3,
                    'segment_text'  => 'advertisement-list',
                ),
                '9' => array(
                    'name'          => display('web_language_list'),
                    'icon'          => null,
                    'link'          => 'cms/web-language-list',
                    'segment'       => 3,
                    'segment_text'  => 'web-language-list',
                )

    ),
    'segment'       => 2,
    'segment_text'  => 'cms'
);