<?php

class Summers_Form_Delete extends Summers_Form_Standart
{
    function __construct($action=null, $options = null) {
        if ($action) {
            $this->setAction($action);
        }
        parent::__construct($options);
    }

    public function init()
    {
        $this->addElements(
            array(
                 ((new Zend_Form_Element_Hidden('id'))
                     ->addValidator('Int')
                     ->addFilter('HtmlEntities')
                     ->addFilter('StringTrim')),
            )
        );
        parent::init();
    }
}