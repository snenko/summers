<?php
class Summers_Form_Standart extends Zend_Form {
    public
        $formDecorators = array(
        array('FormElements'),
        array('Form'),
    );

    public
        $elementDecorators = array(
        array('FormElements'),
        //array('Form'),
    );

    public
        $buttonDecorators = array(
        array('ViewHelper'),
        array('HtmlTag', array('tag' => 'p'))
    );

    function __construct($action=null, $options = null) {
        if ($action) {
            $this->setAction($action);
        }
        parent::__construct($options);
    }

    function init(){
        $this->setMethod('POST');

        $this->addElements(
            array(
                 (new Zend_Form_Element_Submit('submit'))->setLabel('submit'),
                 (new Zend_Form_Element_Submit('cancel'))->setLabel('cancel'),
            )
        );
    }
}