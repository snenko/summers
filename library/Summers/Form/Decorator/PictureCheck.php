<?php

/**
 * Class Summers_Form_Decorator_PictureCheck
 */
class Summers_Form_Decorator_PictureCheck extends Zend_Form_Decorator_Abstract
{
    /**
     * Decorator rendering
     *
     * @param string $content
     *
     * @return string
     */
    public function render($content)
    {
        // Получаем объект элемента к которому применяется декоратор
        $element = $this->getElement();
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }
        // Проверяем объект вида зарегистрированного для формы
        if (null === $element->getView()) {
            return $content;
        }
        $s = $element->options;

        //$dir = Zend_Registry::get('config')->uploads->galleryPhotoDir;
        $dir = Zend_Registry::get('config')->thumbnails->dir;
        //$md = Zend_Registry::get('config')->md->dir;
        //$dir = '/photos';

        if (!$s) return $content;

        $r=array();
        foreach ($s as $key => $value) {
            $r[$key]= "<img src=\"{$dir}/{$value}\"/>";
        }

        // s = array('image1.jpg', 'image2.jpg')
        // r = array('<img src="image1.jpg" />', '<img src="image2.jpg" />')
        //шукаємо в '$content' елементи масиву 's' і замінюємо їх елементами масиву 'r'
        $content = str_replace($s, $r, $content);

        return $content;
    }
}

?>