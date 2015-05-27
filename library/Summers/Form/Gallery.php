<?php

class Summers_Form_Gallery extends Summers_Form_Standart
{
    public function init()
    {
       $this->addPrefixPath('Summers_Form', 'Summers/Form');

        $galleryid = (new Zend_Form_Element_Hidden('galleryid'))
            ->addValidator('Int')
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

        $galleryname = new Zend_Form_Element_Text('galleryname');
        $galleryname->setLabel('galleryname')
            ->setRequired(true)
            ->setOptions(array('StringLength', false, array(4, 255)))
            ->addFilter('StringTrim')
            /*->addValidator('NotEmpty')*/;

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('description')
            ->setOptions(array('rows' => '4'))
            ->addFilter('StringTrim');

        $picture = new Zend_Form_Element_File('picture');
        $picture->setLabel('picture')
            ->setDestination(Zend_Registry::get('config')->uploads->galleryPhotoDir)
            ->setValueDisabled(true)
            ->setRequired(true)
            ->addValidator('Size', false, '2048000')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->addValidator(
                'ImageSize', false, Summers_Snenko::getImageSize()
            );
        $picture->addDecorator('showPicture');

        $meta = new Zend_Form_Element_Text('meta');
        $meta->setLabel('meta')
            ->setOptions(array('StringLength', false, array(4, 255)))
            ->addFilter('StringTrim');

        $this->addElements(
            array($galleryid,
                  $galleryname,
                  $picture,
                  $description,
                  $meta,
//                  $submit,
//                  $cancel
            )
        );
        parent::init();
    }
}