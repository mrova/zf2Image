<?php
// module/User/conﬁg/module.conﬁg.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'zf2Image\Controller\Image' => 'zf2Image\Controller\zf2ImageController',
            'zf2Image\Controller\Admin' => 'zf2Image\Controller\AdminController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'zf2image' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/zf2image[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'zf2Image\Controller\Image',
                        'action'     => 'index',
                    ),
                ),
            ),
            'adminzf2image' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/zf2image[/:action][/:style_name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                        'style_name'     => '[a-zA-Z][a-zA-Z0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'zf2Image\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
            ),
            'adminzf2imageaddoperation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/zf2image/edit/:style_name/add/:operation',
                    'constraints' => array(
                        'operation'      => '[a-zA-Z][a-zA-Z0-9_]*',
                        'style_name'     => '[a-zA-Z0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'zf2Image\Controller\Admin',
                        'action'     => 'addoperation',
                    ),
                ),
            ),
            'adminzf2imageeditoperation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/zf2image/edit/:style_name/operation/:id',
                    'constraints' => array(
                        'id'             => '[0-9]*',
                        'style_name'     => '[a-zA-Z0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'zf2Image\Controller\Admin',
                        'action'     => 'editoperation',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'zf2image' => __DIR__ . '/../view',
        ),
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'zf2Image Test',
                'route' => 'zf2image',
            ),
        ),
        'admin' => array(
            array(
                'label' => 'zf2Image Settings',
                'route' => 'adminzf2image',
            ),
        ),
    ),

    'zf2image_operations' => array(
        'scaleandcrop' => 'Scale and crop',
        'scale' => 'Scale',
        'crop' => 'Crop',
        'format' => 'Format',
        'desturate' => 'Grayscale',
        'roundedcorners' => 'Rounded corners',
    ),

);

