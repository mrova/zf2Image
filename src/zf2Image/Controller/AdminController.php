<?php

namespace zf2Image\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use zf2Image\Form\ImageStyleForm;
use zf2Image\Model\ImageStyle;
use zf2Image\Form\AddOperationForm;
use zf2Image\Form\OperationScaleAndCropForm;
use zf2Image\Form\OperationScaleForm;
use zf2Image\Form\OperationCropForm;
use zf2Image\Form\OperationFormatForm;
use zf2Image\Form\OperationDesturateForm;
use zf2Image\Form\OperationRoundedCornersForm;

class AdminController extends AbstractActionController {

    public function indexAction() {

        $config = $this->getServiceLocator()->get('config');
        $image_styles = array();

        //print_r($config['image_styles']);

        foreach ($config['image_styles'] as $key => $style) {
            $style['name'] = $key;
            $image_styles[] = $style;
        }

        //print_r($image_styles);

        return array(
            'image_styles' => $image_styles,
        );
    }

    public function addoperationAction() {
        $style_name = $this->params()->fromRoute('style_name', 0);
        $operation = $this->params()->fromRoute('operation', 0);

        //echo $style_name;
        //echo $operation;




        if (!$style_name || !$operation) {
            return $this->redirect()->toRoute('adminzf2image');
        }

        switch ($operation) {
            case 'scaleandcrop':
                $form = new OperationScaleAndCropForm();
                break;
            case 'scale':
                $form = new OperationScaleForm();
                break;
            case 'crop':
                $form = new OperationCropForm();
                break;
            case 'format':
                $form = new OperationFormatForm();
                break;
            case 'desturate':
                $form = new OperationDesturateForm();
                break;
            case 'roundedcorners':
                $form = new OperationRoundedCornersForm();
                break;
        }


        $request = $this->getRequest();
        if ($request->isPost()) {

            $config = $this->getServiceLocator()->get('config');

            $config = new \Zend\Config\Config(array('image_styles' => $config['image_styles']), true);
            //$config->image_styles = array();


            unset($config->image_styles->$style_name->name);


            $newop = array(
                'operation' => $operation,
                'options' => array(),
            );

            switch ($operation) {
                case 'scaleandcrop':
                    $newop['options'] = array(
                        'width' => $request->getPost('width'),
                        'height' => $request->getPost('height'),
                        'upscale' => $request->getPost('upscale'),
                    );
                    break;
                case 'scale':
                    $newop['options'] = array(
                        'width' => $request->getPost('width'),
                        'height' => $request->getPost('height'),
                        'upscale' => $request->getPost('upscale'),
                    );
                    break;
                case 'crop':
                    $newop['options'] = array(
                        'width' => $request->getPost('width'),
                        'height' => $request->getPost('height'),
                        'x' => $request->getPost('x'),
                        'y' => $request->getPost('y'),
                    );
                    break;
                case 'format':
                    $newop['options'] = array(
                        'format' => $request->getPost('format'),
                    );
                    break;
                case 'desturate':

                    break;
                case 'roundedcorners':
                    $newop['options'] = array(
                        'radius' => $request->getPost('radius'),
                        'independent_corners_set' => array(
                            'independent_corners' => $request->getPost('independent_corners'),
                            'radii' => array(
                                'tl' => $request->getPost('tl'),
                                'tr' => $request->getPost('tr'),
                                'bl' => $request->getPost('bl'),
                                'br' => $request->getPost('br'),
                            ),
                        ),
                    );
                    break;
            }

            $count = count($config->image_styles->$style_name);

            $config->image_styles->$style_name->$count = $newop;

            $writer = new \Zend\Config\Writer\Ini();
            $writer->toFile('data/zf2imagestyles.ini', $config);


            return $this->redirect()->toRoute('adminzf2image',
                    array('action' => 'edit', 'style_name' => $style_name));
        }


        return array(
            'form' => $form,
            'operation' => $operation,
            'style_name' => $style_name,
        );
    }

    public function editoperationAction() {
        $style_name = $this->params()->fromRoute('style_name', 0);
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$style_name || !$id) {
            return $this->redirect()->toRoute('adminzf2image');
        }

        return array();
    }

    public function editAction() {

        $style_name = $this->params()->fromRoute('style_name', 0);
        if (!$style_name) {
            return $this->redirect()->toRoute('adminzf2image');
        }

        $form = new AddOperationForm();

        $config = $this->getServiceLocator()->get('config');

        $form->get('operation')->setOptions(array('value_options' => $config['zf2image_operations']));


        $request = $this->getRequest();
        if ($request->isPost()) {
            $operation = $request->getPost('operation');
            return $this->redirect()->toRoute('adminzf2imageaddoperation', array('style_name' => $style_name, 'operation' => $operation));
        }


        //print_r($config['image_styles'][$style_name]);

        return array(
            'form' => $form,
            'style_name' => $style_name,
            'operations' => $config['image_styles'][$style_name],
        );
    }

    public function addAction() {
        $form = new ImageStyleForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $fund = new ImageStyle();
            $form->setInputFilter($fund->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $config = $this->getServiceLocator()->get('config');

                $new_image_style = $request->getPost('name');

                if (isset($config['image_styles'][$new_image_style])) {
                    throw new \Exception("Image style $new_image_style already exists.");
                } else {

                    $config = new \Zend\Config\Config(array('image_styles' => $config['image_styles']), true);
                    //$config->image_styles = array();

                    $config->image_styles->$new_image_style = array();
                    $config->image_styles->$new_image_style->name = $new_image_style;

//                    $config->billings->lr->sci_acc = 'U123456';
//                    $config->billings->lr->sci_sw = 'qweqweqweqwe';
//                    $config->billings->lr->sci_api_name = 'Merchant';
//                    $config->billings->lr->sci_api_sw = 'ffasdfasfasdf';
//
//                    $config->billings->lr->api_acc = 'U567890';
//                    $config->billings->lr->api_name = 'Peyment';
//                    $config->billings->lr->api_sw = 'qweqeqweqwe';


                    $writer = new \Zend\Config\Writer\Ini();
                    $writer->toFile('data/zf2imagestyles.ini', $config);

                    return $this->redirect()->toRoute('adminzf2image');
                }
            }
        }
        return array('form' => $form);
    }

}