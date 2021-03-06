<?php

/**
 * Summers_Model_Carousel
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Summers_Model_Carousel extends Summers_Model_BaseCarousel
{
    protected  $_adapter;

    protected $_files_for_delete=array();

    /**
     * Добавляємо файл для видалення
     *
     * @param array $file_for_delete
     */
    public function setFilesForDelete($files_for_delete)
    {
        if(!$files_for_delete) return;

        if(!is_array($files_for_delete))
            $files_for_delete = array($files_for_delete);

        $this->_files_for_delete = $files_for_delete;
    }

    /**
     * @return array
     */
    public function getFilesForDelete()
    {
        return $this->_files_for_delete;
    }

    /**
     * @param mixed $adapter
     */
    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;
    }

    /**
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function save(Doctrine_Connection $conn = null)
    {
        //зберігаємо зображення
//        if($this->picture)
//        {
//            //якщо редагуємо зображення/добавляємо нове, то видаляємо старе
//            $new_fn = Summers_Snenko::SavePicture($this->getAdapter(), $this->picture);
//
//            if ($new_fn)
//                $this->picture = $new_fn;
//        }
//--------------------------------------------------------
        if($this->getAdapter()) {
//            $new_fn = Summers_Snenko::SaveFileWithRandomName(
//                $this->getAdapter(),
//                Summers_Snenko::getNewFileName().".".pathinfo($this->picture, PATHINFO_EXTENSION),
//                $this->picture);
            //якщо редагуємо зображення/добавляємо нове, то видаляємо старе
            $new_fn = Summers_Snenko::SavePicture($this->getAdapter(), $this->picture);

            if (!$new_fn) {
                $this->getErrorStack()->add('picture', 'general');
                return;
                //throw new Zend_Controller_Action_Exception("Picture is not be saved.");
            }
            $this->picture = $new_fn;
        }
//--------------------------------------------------------

        parent::save($conn);

        // якщо немає помилок при збереженні: видаляємо зображення, що було до оновлення
        if($files_for_delete = $this->getFilesForDelete()) {
            if (!$this->getErrorStack()->toArray()) {
                foreach($files_for_delete as $file)
                    Summers_Snenko::deletePictures($file);
            }
        }
    }

    public function delete(Doctrine_Connection $conn = null)
    {
        if($this->picture)
        {
            //видалити фотки
            if ($this->picture) {

                //ProductPictures::deletePictures_in_Product($this->picture, $dirs);
                Summers_Snenko::deletePictures($this->picture);
            }
        }

        parent::delete($conn);
    }

}