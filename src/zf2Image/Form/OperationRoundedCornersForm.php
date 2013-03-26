<?php
// $
namespace zf2Image\Form;

use Zend\Form\Element;
use Zend\Form\Form;



class OperationRoundedCornersForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('image_style');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'radius',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Radius',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'independent_corners',
            'attributes' => array(
                //'type' => 'checkbox',
                'value' => '1', //set checked to '1'
            ),
            'options' => array(
                'label' => 'Independent corners',
            ),
        ));

        $this->add(array(
            'name' => 'tl',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Radius top left',
            ),
        ));

        $this->add(array(
            'name' => 'tr',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Radius top right',
            ),
        ));

        $this->add(array(
            'name' => 'bl',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Radius bottom left',
            ),
        ));

        $this->add(array(
            'name' => 'br',
            'attributes' => array(
                'type'  => 'text',
                //'id' => 'title-edit',
            ),
            'options' => array(
                'label' => 'Radius bottom right',
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