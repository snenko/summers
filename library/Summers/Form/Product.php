<?php

class Summers_Form_Product extends Summers_Form_Standart
{
//    protected $_id = '';
//
//    function __construct($productid = null, $options = null)
//    {
//        $this->_id = $productid;
//        parent::__construct($options);
//    }

    public function init()
    {
        $this->addPrefixPath('Summers_Form', 'Summers/Form');

        $this->addElement(
            (new Zend_Form_Element_Hidden('productid'))
            ->addValidator('Int')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim')
        );

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('name')
            ->setRequired(true)
            ->setOptions(array('StringLength', false, array(4, 255)))
            ->addFilter('StringTrim')
            ->addDecorators(Summers_Form_Standart::$decorators_element)
            ->addValidator('NotEmpty');
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('description')
            ->setOptions(array('rows' => '4'))
            ->addFilter('StringTrim');
        $url = new Zend_Form_Element_Text('url');
        $url->setLabel('url')
            ->addFilter('StringTrim');
        $meta = new Zend_Form_Element_Text('meta');
        $meta->setLabel('meta')
            ->setOptions(array('StringLength', false, array(4, 255)))
            ->addFilter('StringTrim');

        $galleries = (new Summers_Form_Element_Galleries('galleries'));
        $pictures = (new Summers_Form_Element_Picture('pictures'))->setMultiFile(5);

        $checkpictures
            = (new Zend_Form_Element_MultiCheckbox('checkpictures'))
            ->setLabel('check pictures for delete:')
            ->setDecorators(
                array(
                     'ViewHelper',
                     new Summers_Form_Decorator_PictureCheck(),//'PictureCheck',
                     'Errors',
                     'HtmlTag',
                     'Label',
                )
            );
        $checkpictures->setRegisterInArrayValidator(false);
        //--Передача опции 'tag' и 'class' во время конструкции  декоратора

        //--$element->addDecorator('HtmlTag',  array('tag' => 'div', 'class' => 'caption'));

//        $dir = Zend_Registry::get('config')->uploads->galleryPhotoDir_short;

        // Groups

        $this->addDisplayGroup(array($name, $description, $url, $meta,), 'display-note');
        $this->getDisplayGroup('display-note')
            ->setLegend('display-note');

        $this->addDisplayGroup(array($galleries), 'display-galleries');
        $this->getDisplayGroup('display-galleries')
            ->setLegend('display-galleries');

        $this->addDisplayGroup(array($pictures, $checkpictures), 'display-pictures');
        $this->getDisplayGroup('display-pictures')
            ->setLegend('pictures');

        //-----------------------------------------------------------------------

        parent::init();
    }

}
