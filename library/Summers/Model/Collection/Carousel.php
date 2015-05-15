<?php
class Summers_Model_Collection_Carousel
{
    protected $_carousels=array();

    /**
     * @param array $carousels
     */
    public function loadCarousels($carousel_ids=array())
    {
        $q = Doctrine_Query::create()
            ->from('Summers_Model_Carousel c');

        if ($carousel_ids) {
            $q->whereIn('c.carousel_id = ?', $carousel_ids);
        }

        $carousels = $q->fetchArray();

        $this->setCarousels($carousels);
    }

    /**
     * @param array $carousels
     */
    public function setCarousel($carousel)
    {
        $this->_carousels[] = $carousel;
    }

    /**
     * @param array $carousels
     */
    public function setCarousels($carousels)
    {
        $this->_carousels = $carousels;
    }

    /**
     * @return array
     */
    public function getCarousels()
    {
        return $this->_carousels;
    }

//    public function getCarousel_byId($carousel_id)
//    {
//        $q = Doctrine_Query::create()
//            ->from('Summers_Model_Carousel c')
//            ->where('c.carousel_id = ?', $carousel_id);
//        $carousels = $q->fetchArray();
//
//        $carousel_id
//
//        return $this->_carousels;
//    }

}