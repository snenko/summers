<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function successAction()
    {
        if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
            $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        } else {
            $this->redirect('/');
        }
    }

    public function indexAction()
    {
        //повний список товарів
        //$this->view->products = (new Summers_Model_Product())->getListProducts();
        $this->view->products = (new Summers_Model_Product())->getProducts();
    }

    public function createAction()
    {
        $input = (new Zend_Filter_Input(
            array('gallery' => array('HtmlEntities', 'StripTags', 'StringTrim')),
            array('gallery' => array( /*'NotEmpty', */
                'Int'))
        ))->setData($this->getRequest()->getParams());

        $form = (new Summers_Form_Product())->populate($_POST)
            ->setAction('/product/create');
        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();

                if ($form->isValid($postData)) {

                    $values = $form->getValues();
                    $adapter = $form->pictures->getTransferAdapter();

                    //збереження продукту в бд
                    $galleryDir = Zend_Registry::get('config')->uploads->galleryPhotoDir;//'/../public/photos'
                    $res_id = Summers_Model_Product::setProduct($values, $adapter, $galleryDir);
                    //$res_id = (new Summers_Model_Product())->setProductAdapterForm($values, $adapter);
                    if (!$res_id) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    //перехід на сторінку(після збереження)
                    $this->_helper->snenko->gotoAfterAction('product', $res_id);

                }
            }
            if ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('gallery', $input->gallery);
            }
        } else {
            if ($input->gallery) {
                $form->galleries->setValue(array($input->gallery));
            }
        }

        $this->view->title = 'Create product';
        $this->view->form = $form;
    }

    public function updateAction()
    {
        $form = (new Summers_Form_Product())->populate($_POST)->setAction('/product/update');

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    //зберігаємо все
                    $values = $form->getValues();
                    $adapter = $form->pictures->getTransferAdapter();

                    $galleryDir = Zend_Registry::get('config')->uploads->galleryPhotoDir;//'/../public/photos'
                    $res_id = Summers_Model_Product::setProduct($values, $adapter, $galleryDir);

                    if (!$res_id) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('product', $res_id);
                }
                //$form->populate($prod[0]);
            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('gallery');
            }
        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валыдності url
            if ($input->isValid()) {
                if (count($prod = (new Summers_Model_Product)->getProduct($product_id = $input->id)) == 1) {
                    //задаємо початкові значення в формі
                    $form->galleries->setValue(Summers_Model_Gallery::getGalleriesByProductToArray($product_id));

                    //Добавити елемент Check
                    if ($pictures1 = Summers_Model_Product::getPictures($product_id)) {
                        $form->checkpictures->setOptions(array('multiOptions' => $pictures1,));
                    }
                    $form->populate($prod[0]);

                } else {
                    throw new Zend_Controller_Action_Exception('Page not found', 404);
                }
            } else {
                throw new Zend_Controller_Action_Exception('Invalid input');
            }
        }

        $this->view->title = 'Update product';
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $form = (new Summers_Form_Delete())->populate($_POST)->setAction('/product/delete');

        if ($this->getRequest()->isPost())
        {
            //видаляємо
            if ($form->submit->isChecked()) {
                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $p = (new Summers_Model_Product)->deleteProduct($values['id']);
                    $gall = (new Summers_Model_Gallery)->getGallery($values['id']);

                    if(!$p){
                        throw new Zend_Controller_Action_Exception('Can`t delete!');
                    }
                    //Успіх, переходимо на success
                    $this->_helper->getHelper('FlashMessenger')
                        ->addMessage('Product "'.$gall[0]['name'].'" has deleted');
                    $this->_redirect('/product/success');
                }
            }

            //скасовуємо видалення
            elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('product');
            }

        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валідності url
            if ($input->isValid()) {

                //Визначаэмо назву товара, що видаляється
                $prod = (new Summers_Model_Product)->getProduct($input->id);
                if($prod){
                    //тут треба передати id але воно обриваэться
                    $form->populate(array('id' => $input->id));
                    $this->view->caption = 'product';
                    $this->view->message = $prod[0]['name'];

                }else{
                    throw new Zend_Controller_Action_Exception('Invalid id');
                }
            } else {throw new Zend_Controller_Action_Exception('Invalid input');}
        }

        $this->view->form = $form;
    }

    public function displayAction()
    {
        $input = new Zend_Filter_Input(
            array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
            array('id' => array('NotEmpty', 'Int')));

        $input->setData($this->getRequest()->getParams());

        if ($input->isValid()) {

//            $product = (new Summers_Model_Product)->getProduct($input->id);
            $product = (new Summers_Model_Product)->getProducts(array('products'=>$input->id));// ->getProduct($input->id);
            if (count($product) != 1) {
                throw new Zend_Controller_Action_Exception('Page not found', 404);
            }

            $this->view->headTitle($product[0]['name']);
            $this->view->product = $product[0];

        } else {
            throw new Zend_Controller_Action_Exception('Invalid input');
        }

    }

}









