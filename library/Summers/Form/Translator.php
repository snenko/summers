<?php

class Summers_Form_Translator extends Summers_Form_Standart
{
    public function init()
    {
        $this->addElement('textarea', 'label',array('label'=>'mark label','attribs' => array('rows'=>3,'readonly' => 'true')) );

        $this->addElement('textarea', 'ru',array('label' => 'russian','attribs' => array('rows' => 3),'filters' =>array('StringTrim')));
        $this->addElement('textarea', 'uk',array('label'=>'ukrainian','attribs' => array('rows'=>3),'filters' =>array('StringTrim')));
        $this->addElement('textarea', 'en',array('label'=>'english','attribs' => array('rows'=>3),'filters' =>array('StringTrim')));

        parent::init();
    }
}