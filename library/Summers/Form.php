<?php

class Summers_Form extends Zend_Form
{
    public function init()
    {
        // Вызов родительского метода
        parent::init();

        // Создаем объект переводчика, он нам необходим для перевода сообщений об ошибках.
        // В качестве адаптера используется php массив
        //--$translator = new Zend_Translate('array', Zend_Registry::get('config')->path->languages . 'errors.php');

        // Задаем объект переводчика для формы
        //--$this->setTranslator($translator);

        /* Задаем префиксы для самописных элементов, валидаторов, фильтров и декораторов.
           Благодаря этому Zend_Form будет знать где искать наши самописные элементы */

        $this->addElementPrefixPath('Summers_Validate', 'Summers/Validate/', 'validate');
        $this->addElementPrefixPath('Summers_Filter', 'Summers/Filter/', 'filter');
        $this->addElementPrefixPath('Summers_Form_Decorator', 'Summers/Form/Decorator/', 'decorator');
    }
}