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

        $titleProducts = (new Zend_Form_Element_MultiCheckbox('titleProducts'));
        foreach ((new Summers_Model_Product())->getProducts() as $v) {
            $titleProducts->addMultiOption($v['productid'], $v['name']);}

        // guest
        $this->addDisplayGroup(array($guestEmailAddress, $langDefault,), 'display-guest');
        $this->getDisplayGroup('display-guest')->setLegend('settings of guest');

        // admin
        $this->addDisplayGroup(array($adminEmailAddress), 'display-admin');
        $this->getDisplayGroup('display-admin')->setLegend('settings of admin');

        // titleProducts
        $this->addDisplayGroup(array($titleProducts,), 'display-titleProducts');
        $this->getDisplayGroup('display-titleProducts')->setLegend('Title products');

        parent::init();
    }
}