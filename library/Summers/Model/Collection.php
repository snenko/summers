<?php
abstract class Summers_Model_Collection
{

    protected  $_collection = array();

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->_collection;
    }

}