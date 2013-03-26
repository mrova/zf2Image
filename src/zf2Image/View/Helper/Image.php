<?php
namespace zf2Image\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class Image extends AbstractHelper
{

    protected $sm;

    protected $imageService;

    public function __invoke($filename, $style_name, $refresh = false) {

        $config = $this->sm->get('config');
        $presets = $config['image_styles'][$style_name];

        unset($presets['name']);

        $basename = basename($filename);
        $directory = dirname($filename);

        $image_styles_dir = '/files/images/image_styles';

        $destination_dir = $image_styles_dir . '/' . $style_name;
        $destination = $this->file_create_filename($destination_dir, $basename, $destination_arr, true);
        $destination_dir = $destination_arr['directory'];

        $ext = false;
        foreach ($presets as $operation) {
            if($operation['operation'] == 'format'){
                $ext = $operation['options']['format'];
            }
        }

        //if (isset($presets['format'])) {
        if ($ext) {
            $image_path = $destination_arr['directory'] . '/' . $destination_arr['name'] . '.' . $ext;
            //unset($presets['format']);
        } else {
            $image_path = $destination_arr['directory'] . '/' . $destination_arr['name'] . $destination_arr['ext'];
        }


        //if this image processed before, return url processed image
        if (!file_exists($image_path) || $refresh) {
            if ($this->file_check_directory($destination_dir)) {

                $image = $this->getImageService();

                $filedata = array();
                $source = $this->file_create_filename($directory, $basename, $filedata, true);
                $image->createImage($source);

                //parse Image presets And run image processing
                foreach ($presets as $operation) {
                    if(!isset($operation['options'])){
                        $operation['options'] = array();
                    }
                    $image->$operation['operation']($operation['options']);
                }

                //Save image file
                $image_path = $image->output($destination_dir . '/' . $filedata['name'] . '.' . $image->getOutputFormat());
            } else {
                return 'Destination error';
            }
        }

        return '<img src="' . $this->file_public_dir($image_path) . '">';
    }

    public function setLocator($locator){
        $this->sm = $locator;
    }

    public function getServiceLocator(){
        return $this->sm;
    }

    public function getImageService(){
        if(!$this->imageService){
            $this->imageService = $this->sm->get('ImageService');
        }
        return $this->imageService;
    }

    protected function getViewHelper($helperName)
    {
        return $this->sm->get('viewhelpermanager')->get($helperName);
    }


    function file_check_directory($directory) {

        $directory = rtrim($directory, '/\\');

        // Check if directory exists.
        if (!is_dir($directory)) {
            //if (($mode & FILE_CREATE_DIRECTORY) && @mkdir($directory)) {
            if (@mkdir($directory)) {
                @chmod($directory, 0775); // Necessary for non-webserver users.
            } else {
                return FALSE;
            }
        }

        // Check to see if the directory is writable.
        if (!is_writable($directory)) {
            if (@chmod($directory, 0775)) {

            } else {
                return FALSE;
            }
        }

        return TRUE;
    }

    function file_public_dir($path){
        return str_replace('public', '', $path);
    }

    function file_create_filename($directory, $basename, &$filedata = array(), $replace = false) {

        $dest = 'public' . $directory . '/' . $basename;

        // Destination file already exists, generate an alternative.
        if ($pos = strrpos($basename, '.')) {
            $name = substr($basename, 0, $pos);
            $ext = substr($basename, $pos);
        } else {
            $name = $basename;
            $ext = '';
        }
        if (file_exists($dest)) {
            if (!$replace) {
                $counter = 0;
                do {
                    $dest = 'public' . $directory . '/' . $name . '_' . $counter++ . $ext;
                    $name = $name . '_' . $counter;
                } while (file_exists($dest));
            } else {
                $dest = 'public' . $directory . '/' . $name . $ext;
            }
        }
        $filedata = array(
            'directory' => 'public' . $directory,
            'basename' => $basename,
            'name' => $name,
            'ext' => $ext,
        );

        return $dest;
    }
}