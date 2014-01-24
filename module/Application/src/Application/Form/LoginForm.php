<?php

namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');

        $this->setAttributes(array(
            'method' => 'post',
            'class'  => 'form-horizontal'
        ));
        /*
                $this->add(array(
            'name' => 'usr_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
                */
        $this->add(array(
            'name' => 'username', // 'usr_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'password', // 'usr_password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Password',
                'label_attributes' => array(
                    'class'  => 'label-control'
                ),
            ),
        ));

        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',
//            'attributes' => array(
//                'type'  => '\Zend\Form\Element\Checkbox',
//            ),
            'options' => array(
                'label' => 'Remember Me?',
                'label_attributes' => array(
                    'class'  => 'label-control'
                ),
//                                'checked_value' => 'true', without value here will be 1
//                                'unchecked_value' => 'false', // witll be 1
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}