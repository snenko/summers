<?php
//class Summers_Form_Standart extends Zend_Form
class Summers_Form_Standart extends Twitter_Bootstrap_Form_Vertical
{

    public static $decorators_dojo = array (
        // Dijit elements
        'Zend_Dojo_Form_Element_FilteringSelect' => array (
            'DijitElement',
            array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'element')),
            'Label',
            array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
        ));

    public static $decorators_submit = array (
        // plain ole Zend_Form elements
        'Zend_Form_Element_Submit' => array (
            'ViewHelper',
            array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'button')),
            array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
        ),
    );
    public static $decorators_captcha = array (
        'Zend_Form_Element_Captcha' => array (
            'Label',
            array (array ('row' => 'HtmlTag'), array ('tag' => 'li'))
        ),
    );
    public static $decorators_checkbox = array (
        'Zend_Form_Element_Checkbox' => array (
            'Label',
            'ViewHelper',
            array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'checkbox')),
            array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
        ),
    );
//        'Zend_Form_Element_Radio' => array (
//            'Label',
//            'ViewHelper',
//            array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'radio')),
//            array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
//        ),
    public static $decorators_element = array (
        'Zend_Form_Element' => array (
            'ViewHelper',
            array (array ('data' => 'HtmlTag'), array ('tag' => 'div', 'class' => 'element')),
            'Label',
            array (array ('row' => 'HtmlTag'), array ('tag' => 'li')),
        ),
    );
    public static $decorators_form = array (
        'Zend_Form' => array (
            'FormErrors',
            'FormElements',
            array ('HtmlTag', array ('tag' => 'ol')),
            'Form'
        ),
    );

    function __construct($action = null, $options = null)
    {
        if ($action) {
            $this->setAction($action);
        }
        parent::__construct($options);
    }

    function init()
    {
        $this->setMethod('POST');
        //$this->addPrefixPath()

        $this->addElement('submit', 'reset',  array('label' => 'reset', 'type' => 'reset',  'escape' => true,
                                                    'decorators'=> Summers_Form_Standart::$decorators_submit, 'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_WARNING,));
        $this->addElement('submit', 'submit', array('label' => 'submit','type' => 'submit', 'escape' => true,
                                                    'decorators'=> Summers_Form_Standart::$decorators_submit, 'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS,));
        $this->addElement('submit', 'cancel', array('label' => 'cancel','type' => 'submit', 'escape' => true,
                                                    'decorators'=> Summers_Form_Standart::$decorators_submit));


        $this->addDisplayGroup(array('submit', 'reset',  'cancel'), 'actions',array('disableLoadDefaultDecorators' => true,'decorators' => array('Actions')));

//        parent::init();
    }
}