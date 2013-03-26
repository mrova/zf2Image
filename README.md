zf2Image
========

Allows you to use presets (image styles) for image processing. Update: added UI.

##Use

1. Enable module in application.config.php
2. Put same two images to '/public/files/images/image.jpg' and '/public/files/images/image2.jpg'. 
3. Open test page http://yoursite/zf2image - here you see same examples
4. Open http://yoursite/admin/zf2image and create new image_style (for example: new_style), and add operations.
Available operations: Scale and crop, Scale, Crop, Format, Grayscale, Rounded corners.

And then use it using style name in view script:

```php

<?php echo $this->zf2Image('/files/images/noavatar.gif', 'new_style'); ?>

```

More examples in view/zf2image/zf2image/index.phtml file.


