<?php

namespace zf2Image\Service;


class Image {

    protected $image;

    protected $width;
    protected $height;

    protected $imageinfo;

    protected $outputFormat = 'jpg';


    public function createImage($filename){
        $this->outputFormat = 'jpg';
        $this->imageinfo = getimagesize($filename);
        list($this->width, $this->height) = getimagesize($filename);


         switch ($this->imageinfo['mime']) {
            case 'image/jpeg': $this->image = imagecreatefromjpeg($filename);
                break;
            case 'image/gif': $this->image = imagecreatefromgif($filename);
                break;
            case 'image/png': $this->image = imagecreatefrompng($filename);
                break;
            default:
                $this->image = false;
        }
    }

    public function getOutputFormat(){
        return $this->outputFormat;
    }

    public function output($destination){

        switch($this->outputFormat){
            case 'jpg':
                $this->_saveFileJpg($destination);
                break;
            case 'png':
                $this->_saveFilePng($destination);
                break;
            case 'gif':
                $this->_saveFileGif($destination);
                break;
        }
        return $destination;

    }


    protected function _saveFileJpg($destination){
        return imagejpeg($this->image, $destination);
    }

    protected function _saveFilePng($destination){
        return imagepng($this->image, $destination);
    }

    protected function _saveFileGif($destination){
        return imagegif($this->image, $destination);
    }



    //public function resize($width, $height){
    public function resize($params){
        $width = (int) round($params['width']);
        $height = (int) round($params['height']);
        $image = imagecreatetruecolor($width, $height);
        if(!imagecopyresampled($image, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height)){
            return FALSE;
        }
        imagedestroy($this->image);
        $this->image = $image;
        $this->width = $width;
        $this->height = $height;
        return TRUE;
    }

    //public function scale($image, $width, $height, $upscale){
    public function scale($params){
        $dimensions = array(
            'width' => $this->width,
            'height' => $this->height,
        );
        // Scale the dimensions - if they don't change then just return success.
        if (!$this->dimensionsScale($dimensions, $params['width'], $params['height'], $params['upscale'])) {
            return TRUE;
        }
        //return $this->resize($this->image, $dimensions['width'], $dimensions['height']);
        return $this->resize($dimensions);
    }

    public function crop($params){

        $aspect = $this->height / $this->width;

        if (empty($params['height']))
            $params['height'] = $params['width'] / $aspect;

        if (empty($params['width']))
            $params['width'] = $params['height'] * $aspect;

        $width = (int) round($params['width']);
        $height = (int) round($params['height']);


        $image = imagecreatetruecolor($width, $height);
        if(!imagecopyresampled($image, $this->image, 0, 0, $params['x'], $params['y'], $width, $height, $width, $height)){
            return FALSE;
        }

        imagedestroy($this->image);
        $this->image = $image;
        $this->width = $width;
        $this->height = $height;
        return TRUE;
    }

    //public function scaleAndCrop($image, $width, $height){
    public function scaleAndCrop($params){
        $scale = max($params['width'] / $this->width, $params['height'] / $this->height);
        $x = ($this->width * $scale - $params['width']) / 2;
        $y = ($this->height * $scale - $params['height']) / 2;

        $dimensions = array(
            'width' => $this->width * $scale,
            'height' => $this->height * $scale,
        );

        if ($this->resize($dimensions)) {
            $cropparams = array(
                'x' => $x,
                'y' => $y,
                'width' => $params['width'],
                'height' => $params['height'],
            );

            //print_r($cropparams);

            return $this->crop($cropparams);
        }
        return FALSE;
    }

//    function _scaleAndCrop($filename, $output, $new_width, $new_height) {
//        list($width, $height) = getimagesize($filename);
//
//        $image_p = imagecreatetruecolor($new_width, $new_height);
//        $image = imagecreatefromjpeg($filename);
//        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
//
//
//        return imagejpeg($image_p, $output);
//    }

    public function rotate(){

    }

    public function desturate(){
        imagefilter($this->image, IMG_FILTER_GRAYSCALE);
    }

    public function watermark(){

    }




    public function dimensionsScale(array &$dimensions, $width = NULL, $height = NULL, $upscale = FALSE) {
        $aspect = $dimensions['height'] / $dimensions['width'];

        // Calculate one of the dimensions from the other target dimension,
        // ensuring the same aspect ratio as the source dimensions. If one of the
        // target dimensions is missing, that is the one that is calculated. If both
        // are specified then the dimension calculated is the one that would not be
        // calculated to be bigger than its target.
        if (($width && !$height) || ($width && $height && $aspect < $height / $width)) {
            $height = (int) round($width * $aspect);
        } else {
            $width = (int) round($height / $aspect);
        }

        // Don't upscale if the option isn't enabled.
        if (!$upscale && ($width >= $dimensions['width'] || $height >= $dimensions['height'])) {
            return FALSE;
        }

        $dimensions['width'] = $width;
        $dimensions['height'] = $height;
        return TRUE;
    }

    //function roundedcorners($image, $action = array()) {
    function roundedcorners($params) {

        $this->outputFormat = 'png';

        // Read settings.
        $width = $this->width;
        $height = $this->height;

        $radius = $params['radius'];
        $independent_corners = !empty($params['independent_corners_set']['independent_corners']);
        $corners = array('tl', 'tr', 'bl', 'br');

        //$im = &$image->resource;
        // Prepare drawing on the alpha channel.
        imagesavealpha($this->image, TRUE);
        imagealphablending($this->image, FALSE);

        foreach ($corners as $key) {
            if ($independent_corners && isset($params['independent_corners_set']['radii'][$key])) {
                $r = $params['independent_corners_set']['radii'][$key];
            } else {
                // Use the all-the-same radius setting.
                $r = $radius;
            }

            // key can be 'tl', 'tr', 'bl', 'br'.
            $is_bottom = ($key{0} == 'b');
            $is_right = ($key{1} == 'r');

            // dx and dy are in "continuous coordinates",
            // and mark the distance of the pixel middle to the image border.
            for ($dx = .5; $dx < $r; ++$dx) {
                for ($dy = .5; $dy < $r; ++$dy) {

                    // ix and iy are in discrete pixel indices,
                    // counting from the top left
                    $ix = floor($is_right ? $width - $dx : $dx);
                    $iy = floor($is_bottom ? $height - $dy : $dy);

                    // Color lookup at ($ix, $iy).
                    $color_ix = imagecolorat($this->image, $ix, $iy);
                    $color = imagecolorsforindex($this->image, $color_ix);


                    // Do not process opacity if transparency is 100%. Just jump...
                    // Opacity is always 0 on a transparent source pixel.
                    if ($color['alpha'] != 127) {
                        $opacity = $this->roundedcorners_pixel_opacity($dx, $dy, $r);
                        if ($opacity >= 1) {
                            // we can finish this row,
                            // all following pixels will be fully opaque.
                            break;
                        }


                        if (isset($color['alpha'])) {
                            $color['alpha'] = 127 - round($opacity * (127 - $color['alpha']));
                        } else {
                            $color['alpha'] = 127 - round($opacity * 127);
                        }
                        // Value should not be more than 127, and not less than 0.
                        $color['alpha'] = ($color['alpha'] > 127) ? 127 : (($color['alpha'] < 0) ? 0 : $color['alpha']);
                    }

                    $color_ix = imagecolorallocatealpha($this->image, $color['red'], $color['green'], $color['blue'], $color['alpha']);
                    imagesetpixel($this->image, $ix, $iy, $color_ix);
                }
            }
        }
        return TRUE;
    }

    function roundedcorners_pixel_opacity($x, $y, $r) {
        if ($x < 0 || $y < 0) {
            return 0;
        } else if ($x > $r || $y > $r) {
            return 1;
        }
        $dist_2 = ($r - $x) * ($r - $x) + ($r - $y) * ($r - $y);
        $r_2 = $r * $r;
        if ($dist_2 > ($r + 0.8) * ($r + 0.8)) {
            return 0;
        } else if ($dist_2 < ($r - 0.8) * ($r - 0.8)) {
            return 1;
        } else {
            // this pixel needs special analysis.
            // thanks to a quite efficient algorithm, we can afford 10x antialiasing :)
            $opacity = 0.5;
            if ($x > $y) {
                // cut the pixel into 10 vertical "stripes"
                for ($dx = -0.45; $dx < 0.5; $dx += 0.1) {
                    // find out where the rounded corner edge intersects with the stripe
                    // this is plain triangle geometry.
                    $dy = $r - $y - sqrt($r_2 - ($r - $x - $dx) * ($r - $x - $dx));
                    $dy = ($dy > 0.5) ? 0.5 : (($dy < -0.5) ? -0.5 : $dy);
                    // count the opaque part of the stripe.
                    $opacity -= 0.1 * $dy;
                }
            } else {
                // cut the pixel into 10 horizontal "stripes"
                for ($dy = -0.45; $dy < 0.5; $dy += 0.1) {
                    // this is the math:
                    //   ($r-$x-$dx)^2 + ($r-$y-$dy)^2 = $r^2
                    //   $dx = $r - $x - sqrt($r^2 - ($r-$y-$dy)^2)
                    $dx = $r - $x - sqrt($r_2 - ($r - $y - $dy) * ($r - $y - $dy));
                    $dx = ($dx > 0.5) ? 0.5 : (($dx < -0.5) ? -0.5 : $dx);
                    $opacity -= 0.1 * $dx;
                }
            }
            return ($opacity < 0) ? 0 : (($opacity > 1) ? 1 : $opacity);
        }
    }

}
