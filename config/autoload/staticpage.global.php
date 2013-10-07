<?php

return array(
    'router' => array(
        'routes' => array(
            'about' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/about',
                    'defaults' => array(
                        'controller' => 'PhlySimplePage\Controller\Page',
                        'template' => 'application/pages/about',
                    ),
                ),
            ),
        ),
    ),
    'phly-simple-page' => array(
        'cache' => array(
            'adapter' => array(
                'name' => 'filesystem',
                'options' => array(
                    'namespace' => 'pages',
                    'cache_dir' => getcwd() . '/data/cache',
                    'dir_permission' => 0777,
                    'file_permission' => '0666',
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'PhlySimplePage\PageCache' => 'PhlySimplePage\PageCacheService',
        ),
    ),
);

