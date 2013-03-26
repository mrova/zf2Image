<?php
// $
namespace zf2Image\Form;

use Zend\Form\Element;
use Zend\Form\Form;



class OperationScaleForm extends Form
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
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'upscale',
            'attributes' => array(
                //'type' => 'checkbox',
                'value' => '1', //set checked to '1'
            ),
            'options' => array(
                'label' => 'Upscale',
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