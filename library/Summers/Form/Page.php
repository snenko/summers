<?php

class Summers_Form_Page extends Summers_Form_Standart
{
    function init()
    {
//        $status = (new Zend_Form_Element_Checkbox('status'))->setLabel('blog-status')->addDecorators(Summers_Form_Standart::$decorators_checkbox);

        $elements = array(
              'page_id'     => array('hidden')
            , 'name'        => array('text',   array('label' => 'Name',         'options' => array('StringLength' => array(false, array(1, 50)),), 'filters' => array('StringTrim'), 'required' => true))
            , 'title'       => array('text',  array('label' => 'Title',         'options' => array('StringLength' => array(false, array(4, 255)),),'filters' => array('StringTrim'), 'required' => true))
            , 'meta'        => array('text',   array('label' => 'meta',         'options' => array('StringLength' => array(false, array(4, 255))), 'filters' => array('StringTrim'),))
            , 'description' => array('textarea',array('label' => 'description', 'attribs' => array('rows' => 2), 'filters' => array('StringTrim'), 'required' => true))
            , 'body'        => array('textarea',array('label' => 'body',        'attribs' => array('rows' => 7), 'filters' => array('StringTrim'), 'required' => true))
        );
        $this->addElements($elements);

        // --- Groups ----------------------------------------------
        $this->addDisplayGroup(array('name','title', 'meta'), 'display-head', array('legend'=>'display-head'));
        $this->addDisplayGroup(array('description', 'body'), 'display-body', array('legend'=>'display-body'));
        parent::init();
    }
}