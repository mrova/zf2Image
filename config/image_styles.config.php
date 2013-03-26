<?php

return array(
    'image_styles' => array(
        'thumb' => array(
            0 => array(
                'operation' => 'scaleandcrop',
                'options' => array(
                    'width' => 150,
                    'height' => 150,
                    'upscale' => false,
                ),
            ),
        ),
        'medium' => array(
            0 => array(
                'operation' => 'scaleandcrop',
                'options' => array(
                    'width' => 400,
                    'height' => 400,
                    'upscale' => false,
                ),
            ),
        ),
        'medscale' => array(
            0 => array(
                'operation' => 'scale',
                'options' => array(
                    'width' => 400,
                    'height' => 400,
                    'upscale' => false,
                ),
            ),
        ),
        'medupscale' => array(
            0 => array(
                'operation' => 'scale',
                'options' => array(
                    'width' => 400,
                    'height' => 400,
                    'upscale' => true,
                ),
            ),
        ),
        'croped' => array(
            0 => array(
                'operation' => 'crop',
                'options' => array(
                    'width' => 150,
                    'height' => 150,
                    'x' => 600,
                    'y' => 400,
                ),
            ),
            1 => array(
                'operation' => 'desturate',
                'options' => array(),
            )
        ),
        'rounded' => array(
            0 => array(
                'operation' => 'format',
                'options' => array(
                    'format' => 'png'
                )
            ),
            1 => array(
                'operation' => 'scaleandcrop',
                'options' => array(
                    'width' => 160,
                    'height' => 160,
                    'upscale' => false,
                ),
            ),
            2 => array(
                'operation' => 'roundedcorners',
                'options' => array(
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
        ),
        'difrounded' => array(
            0 => array(
                'operation' => 'format',
                'options' => array(
                    'format' => 'png'
                )
            ),
            1 => array(
                'operation' => 'scaleandcrop',
                'options' => array(
                    'width' => 400,
                    'height' => 400,
                    'upscale' => false,
                ),
            ),
            2 => array(
                'operation' => 'roundedcorners',
                'options' => array(
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
    ),
);