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

        //карусель
        $carousel = new Summers_Model_Collection_Carousel();
        $carousel->loadCarousels();

        $this->view->carousel = array(
            //'products'  => $products,
            'carousel' => $carousel->getCarousels(),
        );

        //товари
        $this->view->products = (new Summers_Model_Product())->getListProducts(10);

        //статті
        $articles = (new Summers_Model_Blog())->getLastArticles(5);
        $this->view->articles = $articles;
    }

    public function contactsAction()
    {
        // action body
    }


}



