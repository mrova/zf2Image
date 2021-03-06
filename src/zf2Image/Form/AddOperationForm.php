<?php
// $
namespace zf2Image\Form;

use Zend\Form\Element;
use Zend\Form\Form;



class AddOperationForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('image_style');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'operation',
            'options' => array(
                'label' => 'Operation',
                'value_options' => array(),
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
                'value' => 'Add',
            ),
        ));
    }
}