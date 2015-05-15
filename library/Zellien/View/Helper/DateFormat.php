<?php
/**
 * Помощник вида для форматирования даты при выводе в шаблонах
 *
 * @author zellien
 */
require_once 'Zend/View/Helper/Abstract.php';
class Zellien_View_Helper_DateFormat extends Zend_View_Helper_Abstract {
    public function dateFormat($value, $format = 'dd.MM.YYYY HH:mm:ss', $locale = null) {
        if (null == $locale) {
            $locale = new Zend_Locale();
        }
        $date = new Zend_Date($value, false, $locale);
        return $date->toString($format);
    }
}
// В таком формате выводится из MySQL дата
//$value = '2012-06-22 12:30:45';
//echo $this->dateFormat($value, 'dd MMM YYYY');
// На выходе получится 22 июня 2012