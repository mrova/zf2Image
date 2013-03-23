<?php
// module/User/src/User/Controller/UserController.php:
namespace Image\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;




/**
 *
 * @author konstantin
 *
 */
class ImageController extends AbstractActionController
{

    public function indexAction()
    {

        $filepath = '/files/images/image.jpg';
        $filepath2 = '/files/images/image2.jpg';

        $this->getViewHelper('headScript')->prependFile('/js/test.js');

        $view = new ViewModel(array(
            'imagepath' => $filepath,
            'imagepath2' => $filepath2,
        ));

        return $view;
    }

    protected function getViewHelper($helperName)
    {
        return $this->getServiceLocator()->get('viewhelpermanager')->get($helperName);
    }
}
