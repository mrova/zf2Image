<?php
// $
namespace zf2Image\Form;

use Zend\Form\Element;
use Zend\Form\Form;



class OperationCropForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('image_style');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'width',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Width',
            ),
        ));

        $this->add(array(
            'name' => 'height',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Height',
            ),
        ));


        $this->add(array(
            'name' => 'x',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Offset X',
            ),
        ));


        $this->add(array(
            'name' => 'y',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Offset Y',
            ),
        ));



        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
            ),
        ));
    }
}