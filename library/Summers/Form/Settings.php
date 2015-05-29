<?php
class Summers_Form_Settings extends Summers_Form_Standart
{

    function init()
    {
        // guest
        $guestEmailAddress = (new Zend_Form_Element_Text('guestEmailAddress'))
            ->setLabel('email for guest seller')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');

        $langDefault = (new Zend_Form_Element_Select('langDefault'))
            ->setLabel('language defaul')
            ->addMultiOptions(Summers_Snenko::getLanguages());

        // admin
        $adminEmailAddress = (new Zend_Form_Element_Text('adminEmailAddress'))
            ->setLabel('email for site robot seller')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');

        $titleProducts = (new Zend_Form_Element_MultiCheckbox('titleProducts'));
        $titleProducts->setLabel('Title products');
        foreach ((new Summers_Model_Product())->getProducts() as $v) {
            $titleProducts->addMultiOption($v['productid'], $v['name']);}

        // guest
        $this->addDisplayGroup(array($guestEmailAddress, $langDefault,), 'display-guest',array('legend' => 'settings of guest'));

        // admin
        $this->addDisplayGroup(array($adminEmailAddress, $titleProducts),'display-admin',array('legend' => 'settings of admin'));

        parent::init();
    }
}