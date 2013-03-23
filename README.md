zf2Image
========

zf2Image

Use

First you need setup some preset in config, and then use it using preset_name in view script:



```php

<?php echo $this->zf2Image('/files/images/noavatar.gif', 'thumb'); ?>

```

Or you can use exists presets:

```php
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

```


You can see presets examples in config of this module in config/congig.php.
Usage example see in view/zf2image/zf2image/index.phtml


