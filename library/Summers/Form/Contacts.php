<?php
class Summers_Form_Contacts extends Zend_Form
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
            ->addFilter('HTMLEntities')
            ->addFilter('StringToLower')
            ->addFilter('StringTrim');


        $message = (new Zend_Form_Element_Textarea('message'))
            ->setLabel('your message')
            ->setOptions(array('rows' => '3'))
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addFilter('HTMLEntities')
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

        $this->addDisplayGroup(
            array(
                 $name,
                 $email,
                 $message,
                 $captcha),
            'display-note');
        $this->getDisplayGroup('display-note')->setLegend('send email to Helena');



        $submit = (new Zend_Form_Element_Submit('submit'))
            ->setLabel('send message')
            ->setOptions(array('class' => 'submit'))
                ->setOrder(3);

        $this->addElements(
            array($submit)
        );

        parent::init();
    }


}