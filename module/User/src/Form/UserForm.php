<?php
namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
     {
         parent::__construct('user');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'email',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Email',
                 'label_attributes' => array(
                   'class'  => 'lcol-sm-2 col-form-labels pull-left'
                 ),
             ),
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
                 'label_attributes' => array(
                   'class'  => 'lcol-sm-2 col-form-labels pull-left'
                 ),
             ),
         ));
         $this->add(array(
             'name' => 'password',
             'type' => 'password',
             'options' => array(
                 'label' => 'Password',
                 'label_attributes' => array(
                   'class'  => 'lcol-sm-2 col-form-labels pull-left'
                 ),
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Sign up',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
?>