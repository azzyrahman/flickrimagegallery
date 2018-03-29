<?php
namespace ImageGallery\Form;

use Zend\Form\Form;

class SearchForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('search');

        $this->add([
            'name' => 'query',
            'type' => 'text',
            'options' => [
                'label' => 'Search',
                'label_attributes' => array(
                   'class'  => 'lcol-sm-2 col-form-labels pull-left'
                 ),
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}


?>