<?php
namespace zf2Image\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
//use Zend\Authentication\AuthenticationService;

//use User\Auth\Storage\Storage;


class Image extends AbstractHelper
{

    protected $sm;

    protected $imageService;

    public function __invoke($filename, $style_name) {

        $config = $this->sm->get('config');
        $presets = $config['image_styles'][$style_name];

        $basename = basename($filename);
        $directory = dirname($filename);

        $image_styles_dir = '/files/images/image_styles';

        $destination_dir = $image_styles_dir . '/' . $style_name;
        $destination = $this->file_create_filename($destination_dir, $basename, $destination_arr, true);
        $destination_dir = $destination_arr['directory'];
        if (isset($presets['format'])) {
            $image_path = $destination_arr['directory'] . '/' . $destination_arr['name'] . '.' . $presets['format'];
            unset($presets['format']);
        } else {
            $image_path = $destination_arr['directory'] . '/' . $destination_arr['name'] . $destination_arr['ext'];
        }


        // если картинка была уже обработана ранее, то не надо ее опять обрабатывать,
        // а просто выдать адрес уже обработанной картинки
        if (!file_exists($image_path)) {
            //echo 'IMAGE PROCESSED ';
            if ($this->file_check_directory($destination_dir)) {

                $image = $this->getImageService();

                $filedata = array();
                $source = $this->file_create_filename($directory, $basename, $filedata, true);
                $image->createImage($source);

                //parse Image presets And run image processing
                foreach ($presets as $operation => $params) {
                    $image->$operation($params);
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

//        if ((file_directory_path() == $directory || file_directory_temp() == $directory) && !is_file("$directory/.htaccess")) {
//            $htaccess_lines = "SetHandler Drupal_Security_Do_Not_Remove_See_SA_2006_006\nOptions None\nOptions +FollowSymLinks";
//            if (($fp = fopen("$directory/.htaccess", 'w')) && fputs($fp, $htaccess_lines)) {
//                fclose($fp);
//                chmod($directory . '/.htaccess', 0664);
//            } else {
//                $variables = array('%directory' => $directory, '!htaccess' => '<br />' . nl2br(check_plain($htaccess_lines)));
//                form_set_error($form_item, t("Security warning: Couldn't write .htaccess file. Please create a .htaccess file in your %directory directory which contains the following lines: <code>!htaccess</code>", $variables));
//                watchdog('security', "Security warning: Couldn't write .htaccess file. Please create a .htaccess file in your %directory directory which contains the following lines: <code>!htaccess</code>", $variables, WATCHDOG_ERROR);
//            }
//        }

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