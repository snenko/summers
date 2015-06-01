<?php

class Summers_Form_Translator extends Summers_Form_Standart
{

    public function init()
    {
        $this->addElements(
            array (
                'label' => array('textarea', array('label'=>'mark label',   'attribs' => array('rows'=>3,   'readonly' => true)) ),
                'ru'    => array('textarea', array('label'=>'russian',      'attribs' => array('rows' => 3),'filters' =>array('StringTrim'))),
                'uk'    => array('textarea', array('label'=>'ukrainian',    'attribs' => array('rows'=>3),  'filters' =>array('StringTrim'))),
                'en'    => array('textarea', array('label'=>'english',      'attribs' => array('rows'=>3),  'filters' =>array('StringTrim'))),
            )
        );

        parent::init();
    }
}