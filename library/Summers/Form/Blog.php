<?php

class Summers_Form_Blog extends /*Zend_Dojo_Form */Summers_Form_Standart
{
    private $options_notes = array(
        'degrade' => true,
        'class' => 'form-itemcreate',
        'editActionInterval' => 2,
        'focusOnLoad'        => true,
        'height'             => '300px',
        //'min-height'             => '100px',
        'inheritWidth'       => true,
        'plugins'=>
        array(/*'undo','redo', 'selectAll', 'subscript','superscript', '|',*/
            'foreColor', 'hiliteColor', '|',
            //'cut','copy','paste','|',
            'bold','italic','underline','strikethrough','|',
            'insertOrderedList', 'insertUnorderedList','|',
            'removeFormat','insertHorizontalRule', 'createLink', '|',

            'createLink', 'insertImage', '|',
            'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull', '|',
            'indent', 'outdent', '|',
            'viewSource',
            /*'fontName', 'fontSize', 'formatBlock', '|',*/
        ),);

    function __construct($action, $options = null) {
        $this->setAction($action);
        parent::__construct($options);
    }

    public function init()
    {
        $this->addElement('hidden', 'blogid', array('required' => false));
        //$this->addElement(new Zend_Form_Element_Hidden('blogid'));

        $title = (new Zend_Dojo_Form_Element_TextBox('title'))
            ->setLabel('Title')
            ->setRequired(true)
            ->setOptions(array('StringLength', false, array(4, 255)))
            ->addFilter('StringTrim');

        Zend_Dojo::enableForm($this);
        //Zend_Dojo_Form_Element_Textarea
        $body = (new Zend_Dojo_Form_Element_Editor('body'))
            ->setOptions($this->options_notes)
            ->setLabel('body')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Поле не може бути пустим.')));;
        //-----------------------------------------------

        $blogstatus = (new Zend_Form_Element_Checkbox('blogstatus'))
            ->setLabel('blog-status');

        $mask = (new Zend_Form_Element_Text('meta'))
            ->setLabel('meta')
            ->setOptions(array('StringLength', false, array(0, 500)))
            ->addFilter('StringTrim');

        // --- Groups ----------------------------------------------
        $this->addDisplayGroup(array($title, $body), 'display-body');
        $this->getDisplayGroup('display-body')->setLegend('display-body');

        $this->addDisplayGroup(array($blogstatus, $mask), 'display-mark');
        $this->getDisplayGroup('display-mark')->setLegend('display-mark');

        // --- fin -------------------------------------------------
        //$this->setMethod('POST');
//        $this->addElements(array($blogid,));

        parent::init();
    }
}