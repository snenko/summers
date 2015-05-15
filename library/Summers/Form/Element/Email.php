<?php
class Summers_Form_Element_Email extends Zend_Form_Element_Text
{
    public function init()
    {
        $this->setLabel('Электронная почта:');
        $this->setAttrib('maxlength', 80);
        $this->addValidator('EmailAddress', true);
        $this->addValidator('NoDbRecordExists', true, array('users', 'email'));
        $this->addFilter('StringTrim');
    }
}