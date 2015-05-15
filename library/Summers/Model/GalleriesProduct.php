<?php

/**
 * Class Summers_Model_GalleriesProduct
 *
 * Генерує роботу з обраними галереями
 */
class Summers_Model_GalleriesProduct
{
    private $productid = '';

    private $galleries_db = array();
    private $galleries_to_delete = array();
    private $galleries_to_insert = array();

    public $isError = '';
    public $galleries = '';

    //----- добавити ------------------------------------------------

    /**
     * //>1. видалити все, що лишнє в $galleries_db: $galleries_db - $galleries
     * @param string $galleries_to_delete
     */
    public function setGalleriesToDelete($galleries_to_delete = array())
    {
        if ($galleries_to_delete) {
            $this->galleries_to_delete = $galleries_to_delete;
        } else {
            $this->galleries_to_delete = array_diff($this->galleries_db, $this->galleries);
        }
    }

    /**
     * //>2. додати все, що лишнє в $galleries: $galleries - $galleries_db
     * @param string $galleries_to_insert
     */
    public function setGalleriesToInsert($galleries_to_insert = array())
    {
        if ($galleries_to_insert) {
            $this->galleries_to_insert = $galleries_to_insert;
        } else {
            $this->galleries_to_insert = array_diff($this->galleries, $this->galleries_db);
        }
    }

    /**
     * створити галереї бд
     * @param string $galleries_db
     */
    private function setGalleriesDb($galleries_db = '')
    {
        if ($galleries_db) {
            $this->galleries_db = $galleries_db;
        } else {
            $this->galleries_db = Summers_Model_SubProductGallery::getGalleries($this->productid);
        }
    }

    /**
     * @param string $isError
     */
    public function setIsError()
    {
        $this->isError = 1;
    }

    /**
     * @return string
     */
    public function getIsError()
    {
        return $this->isError;
    }

    /**
     * @param string $galleries
     */
    private function setGalleries($galleries)
    {
        $this->galleries = $galleries;
    }

    /**
     * @param string $productid
     */
    private function setProductid($productid)
    {
        $this->productid = $productid;
    }

    //----- процедура ------------------------------------------------

    public function __construct($productid, $galleries=array())
    {
        $this->setProductid($productid);
        $this->setGalleries($galleries);

        $this->process();
    }

    /**
     * Зберыгаємо галереї в продуктах в бд
     */
    public function pushToDB()
    {

    }

    /**
     * Видалення списку визначенийх галерей
     */
    public function deleteGalleries()
    {
        if ($this->galleries_to_delete) {
            Summers_Model_SubProductGallery::deleteGalleries($this->galleries_to_delete);
        }
    }

    /**
     * додати списку визначені галереї
     */
    public function addGalleries()
    {
        Summers_Model_SubProductGallery::addGalleries($this->productid, $this->galleries_to_insert);
    }

    /**
     * робочий процес
     */
    function process()
    {
        if (!$this->productid || !$this->galleries) {
            $this->setIsError();
            return;
        }

//        $galleries_db = array('1','2','3','4','5','6');
//        $galleries    = array('1'    ,'3','4'    ,'6','7','8');
//        1.                      '2',       ,'5'
//        2.                                         ,'7','8'
        $this->setGalleriesDb();

        //>1. видалити все, що лишнє в $galleries_db: $galleries_db - $galleries
        $this->setGalleriesToDelete();

        //>2. додати все, що лишнє в $galleries: $galleries - $galleries_db
        $this->setGalleriesToInsert();
    }
}
