<?php
class Summers_Form_Contacts extends Twitter_Bootstrap_Form_Vertical
{

    function init()
    {
        $this->setMethod('POST');

        $name = (new Zend_Form_Element_Text('name'))
            ->setLabel('your name')
            ->setRequired(true)
            ->setOptions(array('size' => '50','StringLength', false, array(4, 255)))
            ->addFilter('StringTrim');

        $email = (new Zend_Form_Element_Text('email'))
            ->setLabel('your email')
            ->setOptions(array('size' => '50'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('EmailAddress', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');


        $message = (new Zend_Form_Element_Textarea('message'))
            ->setLabel('your message')
            ->setOptions(array('rows' => '3'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addFilter('HtmlEntities')
            ->addFilter('StringTrim');

        $captcha = new Zend_Form_Element_Captcha('captcha',
            array(
                 'label'=>'contact-verification',
                 'captcha' => array(
                     'captcha' => 'Image',
                     'wordLen' => 6,
                     'timeout' => 300,
                     'width'   => 300,
                     'height'  => 100,
                     'imgUrl'  => '/captcha',
                     'imgDir'  => APPLICATION_PATH . '/../public/captcha',
                     'font'    => APPLICATION_PATH . '/../public/fonts/LiberationSansRegular.ttf',
                 )
            ));
        $captcha->addDecorators(Summers_Form_Standart::$decorators_captcha);

        $this->addDisplayGroup(
            array(
                 $name,
                 $email,
                 $message,
                 $captcha),
            'display-note');
        $this->getDisplayGroup('display-note')->setLegend('send email to Helena');



//        $submit = (new Zend_Form_Element_Submit('submit'))
//            ->setLabel('send message')
//            ->setOptions(array('class' => 'submit'))
//                ->setOrder(3);

        $this->addElement(
            'button', 'reset',
            array(
                 'decorators' => Summers_Form_Standart::$decorators_submit,
                 'label'        => 'reset',
                 'buttonType'   => Twitter_Bootstrap_Form_Element_Button::BUTTON_WARNING,
                 'type'         => 'reset'
                 ,'escape'        => true
            )
        );

        $this->addElement(
            'button', 'submit',
            array(
                 'decorators' => Summers_Form_Standart::$decorators_submit,
                 'label'      => 'send message',
                 'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS,
                 'type'       => 'submit'
                 ,'escape'        => true
            )
        );

        $this->addDisplayGroup(
            array('submit', 'reset'),
            'actions',
            array(
                 'disableLoadDefaultDecorators' => true,
                 'decorators'                   => array('Actions')
            )
        );

        parent::init();
    }


}