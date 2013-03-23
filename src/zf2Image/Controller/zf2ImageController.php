<?php
// $
namespace zf2Image\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;






class zf2ImageController extends AbstractActionController
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
