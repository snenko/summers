<?php

class My_Element_Text extends Zend_Form_Element
{
    public function init()
    {
        $this->addPrefixPath('My_Decorator', 'My/Decorator/', 'decorator')
            ->addFilters('StringTrim')
            ->addValidator('Regex', false, array('/^[a-z0-9]{6,}$/i'))
            ->addDecorator('TextItem')
            ->setAttrib('size', 30)
            ->setAttrib('maxLength', 45)
            ->setAttrib('class', 'text');
    }


}