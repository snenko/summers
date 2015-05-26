<?php

class Summers_Form_Carousel extends Summers_Form_Standart
{
    function __construct($action=null, $options = null) {
        parent::__construct($action, $options);
    }

    function init()
    {
        $this->addElement('hidden', 'carousel_id', array('required' => false));

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('title')
            ->setRequired(true)
            ->setOptions(array('StringLength', false, array(0, 255)))
            ->addFilter('StringTrim');

        $productid = new Zend_Form_Element_Select('productid');
        $productid->setLabel('product')
            ->addValidator('Int')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim')
            ->addFilter('StringToUpper');
        foreach ((new Summers_Model_Product())->getProducts() as $v) {
            $productid->addMultiOption($v['productid'], $v['name']);
        }
        $productid->addMultiOption('', '-');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('description')
            ->setOptions(array('rows' => '5'))
            ->addFilter('StringTrim');

        $picture = new Zend_Form_Element_File('picture');
        $picture->setLabel('picture')
            ->setDestination(Zend_Registry::get('config')->uploads->galleryPhotoDir)
            ->setValueDisabled(true)
            ->setRequired(true)
            ->addValidator('Size', false, '2048000')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->addValidator(
                'ImageSize', false,
                array(
                     'minwidth'  => 340,
                     'minheight' => 170,
                )
            );

        $url = new Zend_Form_Element_Text('url');
        $url->setLabel('url')
            ->setOptions(array('StringLength', false, array(0, 500)))
            ->addFilter('StringTrim');

        $sort_order = new Zend_Form_Element_Text('sort_order');
        $sort_order->setLabel('sort_order')
            ->setOptions(array('StringLength', false, array(0, 3)))
            ->addValidator('Int')
            ->addFilter('StringTrim');


        $this->addElements(
            array(
                 $title,
                 $productid,
                 $description,
                 $picture,
                 $url,
                 $sort_order
            ));

        parent::init();
    }
}