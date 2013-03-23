<?php
// module/User/conﬁg/module.conﬁg.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'zf2Image\Controller\Image' => 'zf2Image\Controller\zf2ImageController',
        ),
    ),
//     'controller_plugins' => array(
//        'invokables' => array(
//            'getUser' => 'User\Plugin\GetUser',
//        ),
//    ),

    // The following section is new and should be added to your file
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
    ),

    'image_styles' => array(
        '48x48' => array(
            'scaleAndCrop' => array(
                'width' => 48,
                'height' => 48,
            ),
        ),
        'thumb' => array(
            'scaleAndCrop' => array(
                'width' => 150,
                'height' => 150,
            ),
        ),
        'medium' => array(
            'scaleAndCrop' => array(
                'width' => 400,
                'height' => 400,
            ),
        ),
        'medscale' => array(
            'scale' => array(
                'width' => 400,
                'height' => 400,
                'upscale' => false,
            ),
        ),
        'medupscale' => array(
            'scale' => array(
                'width' => 400,
                'height' => 400,
                'upscale' => true,
            ),
        ),
        'croped' => array(
            'crop' => array(
                'width' => 150,
                'height' => 150,
                'x' => 600,
                'y' => 400,
            ),
            'desturate' => array(),
        ),
        'rounded' => array(
            'format' => 'png',
            'scaleAndCrop' => array(
                'width' => 160,
                'height' => 160,
                'upscale' => false,
            ),
            'roundedcorners' => array(
                'radius' => 80,
                'independent_corners_set' => array(
                    'independent_corners' => false,
                    'radii' => array(
                        'tl' => 20,
                        'tr' => 10,
                        'bl' => 50,
                        'br' => 100,
                    ),
                ),
            ),
        ),
        'difrounded' => array(
            'format' => 'png',
            'scaleAndCrop' => array(
                'width' => 400,
                'height' => 400,
                'upscale' => false,
            ),
            'roundedcorners' => array(
                'radius' => 80,
                'independent_corners_set' => array(
                    'independent_corners' => true,
                    'radii' => array(
                        'tl' => 20,
                        'tr' => 10,
                        'bl' => 50,
                        'br' => 100,
                    ),
                ),
            ),
        ),

    ),

);

