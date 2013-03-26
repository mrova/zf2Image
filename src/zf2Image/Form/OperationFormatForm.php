<?php
// $
namespace zf2Image\Form;

use Zend\Form\Element;
use Zend\Form\Form;



class OperationFormatForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('image_style');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'format',
            'options' => array(
                'label' => 'Format',
                'value_options' => array(
                    'png' => 'PNG',
                    'jpg' => 'JPG',
                    'gif' => 'GIF',
                ),
            ),
            'attributes' => array(
                'value' => 0,
                'class' => 'select required'
            )
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