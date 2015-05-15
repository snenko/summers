<?php
return array(
    'label'      => 'Home',
    'module'     => 'default',
    'controller' => 'index',
    'action'     => 'index',
    'pages'      => array(
        array(
            'label'      => 'gallery',
            'module'     => 'default',
            'controller' => 'gallery',
            'action'     => 'index'
        ),
        array(
            'label'      => 'product',
            'module'     => 'default',
            'controller' => 'product',
            'action'     => 'index',
//            'pages'      => array(
//                array(
//                    'label'      => 'View Order',
//                    'module'     => 'default',
//                    'controller' => 'order',
//                    'action'     => 'vieworder'
//                )
//            )
        ),
        array(
            'label'      => 'blog',
            'module'     => 'default',
            'controller' => 'blog',
            'action'     => 'index',
//            'pages'      =>
//            array(
//                array(
//                    'label'      => 'News and Announcements',
//                    'module'     => 'default',
//                    'controller' => 'admin',
//                    'action'     => 'addnews',
//                )
//            )
        ),
        array(
            'label'      => 'contacts',
            'module'     => 'default',
            'controller' => 'index',
            'action'     => 'contacts',
        )
    )
);