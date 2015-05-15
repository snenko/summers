<?php
class Summers_Validate_EqualInputs extends Zend_Validate_Abstract
{
    /**
     * Метка ошибки
     * @var const
     */
    const NOT_EQUAL = 'passwordNotEqual';

    /**
     * Текст ошибки
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_EQUAL => 'Password`s confirmation is not equal'
    );

    /**
     * Проверка пароля
     *
     * @param array $value значение которое поддается валидации
     */
    public function isValid($value)
    {
        // Благодаря этому методу значение будет автоматически подставлено в текст ошибки при необходимости
        //--$this->_setValue($value);

        // Перевірка поля паролю та підтвердження паролю
        if ($value[0]!=$value[1]) {
            // С помощью этого метода мы указываем какая именно ошибка произошла
            $this->_error(self::NOT_EQUAL);
            return false;
        }

        return true;
    }
}