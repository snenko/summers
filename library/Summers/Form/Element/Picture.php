<?php
class Summers_Form_Element_Picture extends Zend_Form_Element_File
{
    public function init()
    {
        $this->setLabel('add pictures:');

        $this->setDestination(Zend_Registry::get('config')->uploads->galleryPhotoDir);
        $this->setValueDisabled(true);

        //$this->setRequired(true)

        $this->addValidator('IsImage');
        $this->addValidator('Size', false, '2048000');
        $this->addValidator('Extension', false, 'jpg,png,gif');
        $this->addValidator(
            'ImageSize', false, Summers_Snenko::getImageSize()
        );

        //$this->addPrefixPath('Summers_Form', 'Summers/Form');
        $this->addPrefixPath('Summers_Filter', 'Summers/Filter');

//        $this->addFilter(
//            new Summers_Filter_ImageSize(
//                array(
//                     'width'    => 300,
//                     'height'   => 300,
//                     'strategy' => 'fit')
//            )
//
//        );

    }
}