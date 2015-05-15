<?php

class Summers_Form_Element_Galleries extends
    Zend_Form_Element_MultiCheckbox
{
    public function init()
    {
        $this->setLabel('galleries');
        $galleries = Summers_Model_Gallery::getGalleriesToMultiOptions();

        $this->setOptions(
            array('multiOptions' => $galleries,));

        //$this->setOptions(array('class' => 'col-lg-2'));

        //$this->setValue(array('bar', 'bat'));
    }

}
