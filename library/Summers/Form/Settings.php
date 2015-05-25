<?php
class Summers_Form_Settings extends Summers_Form_Standart
{

    function init()
    {
        $this->setMethod('POST');

        // guest
        $guestEmailAddress = (new Zend_Form_Element_Text('guestEmailAddress'))
            ->setLabel('email for guest seller')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            ->addFilter('HTMLEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');

        $langDefault = (new Zend_Form_Element_Select('langDefault'))
            ->setLabel('language defaul')
            ->addMultiOptions(Summers_Snenko::getLanguages());
//            ->setRequired(true)
//            ->addValidator('Int')
//            ->addFilter('HtmlEntities')
//            ->addFilter('StringTrim')
//            ->addFilter('StringToUpper')


//        foreach ($this->getLang() as $lang=>$name) {
//            $langDefault->addMultiOption($lang, $name);
//        }

//        $logExceptionsToFile = (new Zend_Form_Element_Checkbox('logExceptionsToFile'))
//            ->setLabel('your message');

        // admin
        $adminEmailAddress = (new Zend_Form_Element_Text('adminEmailAddress'))
            ->setLabel('email for site robot seller')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            ->addFilter('HTMLEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');

        // guest
        $this->addDisplayGroup(array($guestEmailAddress, $langDefault,), 'display-guest');
        $this->getDisplayGroup('display-guest')->setLegend('settings of guest');

        // admin
        $this->addDisplayGroup(array($adminEmailAddress,), 'display-admin');
        $this->getDisplayGroup('display-guest')->setLegend('settings of admin');

        parent::init();
    }
}