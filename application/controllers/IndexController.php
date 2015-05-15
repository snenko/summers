<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //$products = (new Summers_Model_Product)->getProducts(null, 3);

        $carousel = new Summers_Model_Collection_Carousel();
        $carousel->loadCarousels();

        $this->view->carousel = array(
            //'products'  => $products,
            'carousel' => $carousel->getCarousels(),
        );

    }

    public function contactsAction()
    {
        // action body
    }


}



