<?php

class GalleryController extends Zend_Controller_Action
{
    public function preDispatch()
    {

//        if(Zend_Auth::getInstance()->hasIdentity()){
//            //$url = $this->getRequest()->getRequestUri();
//            //$this->_helper->layout->setLayout('admin');
//            $this->view->isadmin = true;
//
//        }
    }

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->records = (new Summers_Model_Gallery)->getGallerys();
    }

    public function createAction()
    {
        $form = new Summers_Form_Gallery();
        $form->setAction('/gallery/create');

        $form->populate($_POST);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();

                if ($form->isValid($postData)) {

                    $res_id = (new Summers_Model_Gallery)
                        ->setGalleryAdapterForm($form);
                    if (!$res_id) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('gallery', $res_id);
                }
            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('gallery');
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $form = (new Summers_Form_Delete())->populate($_POST)->setAction('/gallery/delete');

        if ($this->getRequest()->isPost())
        {
            //видаляємо
            if ($form->submit->isChecked()) {
                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $gall = (new Summers_Model_Gallery)->getGallery($values['id']);
                    $p = (new Summers_Model_Gallery)->deleteGallery($values['id']);

                    if(!$p){
                        throw new Zend_Controller_Action_Exception('Can`t delete!');
                    }
                    //Успіх, переходимо на success
                    $this->_helper->getHelper('FlashMessenger')
                        ->addMessage('Gallery "'.$gall[0]['galleryname'].'" has deleted');
                    $this->_redirect('/gallery/success');
                }
            }

            //скасовуємо видалення
            elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('gallery');
            }

        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валідності url
            if ($input->isValid()) {

                //Визначаэмо назву товара, що видаляється
                $gall = (new Summers_Model_Gallery)->getGallery($input->id);
                if($gall){
                    //тут треба передати id але воно обриваэться
                    $form->populate(array('id' => $input->id));
                    $this->view->caption = 'gallery';
                    $this->view->message = $gall[0]['galleryname'];

                }else{
                    throw new Zend_Controller_Action_Exception('Invalid id');
                }
            } else {throw new Zend_Controller_Action_Exception('Invalid input');}
        }

        $this->view->form = $form;

//        $input = new Zend_Filter_Input(
//            array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
//            array('id' => array('NotEmpty', 'Int')));
//        $input->setData($this->getRequest()->getParams());
//
//        $form = new Summers_Form_GalleryCreate();
//        $this->view->form = $form;
//
//
//
//
//        if ($input->isValid()&& $form->submit->isChecked()) {
//            $id = (new Summers_Model_Gallery())->deleteGallery($input->id);
//
//            $this->_helper->getHelper('FlashMessenger')->addMessage('The records were successfully deleted.');
//            $this->redirect('/gallery/success');
//        } else {
//            throw new Zend_Controller_Action_Exception('Invalid input');
//        }
    }

    public function displayAction()
    {
        $input = new Zend_Filter_Input(
            array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
            array('id' => array('NotEmpty', 'Int')));

        $input->setData($this->getRequest()->getParams());

        if ($input->isValid()) {

            //$products = (new Summers_Model_Product)->getProducts($input->id);
            $products = Summers_Model_Product::getProducts_ByGalleries($input->id);
            $gallery = (new Summers_Model_Gallery)->getGallery($input->id);
            $this->view->headTitle($gallery[0]['galleryname']);

            if (count($gallery) == 1) {
                $this->view->products = $products;
                $this->view->gallery  = $gallery[0];

            } else {
                throw new Zend_Controller_Action_Exception('Page not found', 404);
            }
        } else {
            throw new Zend_Controller_Action_Exception('Invalid input');
        }
    }

    public function successAction()
    {
        if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
            $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        } else {
            $this->_redirect('/');
        }
    }

    public function updateAction()
    {
        $form = new Summers_Form_Gallery();
        $form->populate($_POST);

        if ($this->getRequest()->isPost()) {

            if ($form->submit->isChecked()) {
                $postData = $this->getRequest()->getPost();

                if ($form->isValid($postData)) {
                    $res_id = (new Summers_Model_Gallery)->setGalleryAdapterForm($form);

                    if (!$res_id) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('gallery', $res_id);
                }

            } elseif ($form->cancel->isChecked()) {
                $galleryid = $form->getValues()['galleryid'];
                $this->_helper->snenko->gotoAfterAction('gallery', $galleryid);
            }

        } else {

            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //gallery/update/1 форму загружає данними
            if ($input->isValid()) {
                if (count($gal = (new Summers_Model_Gallery)->getGallery($input->id)) == 1) {
                    $form->populate($gal[0]);
                } else {
                    throw new Zend_Controller_Action_Exception('Page not found', 404);
                }
            } else {
                throw new Zend_Controller_Action_Exception('Invalid input');
            }
        }
        $form->setAction('/gallery/update');
        $this->view->form = $form;
    }

    /**
     * get new filename of photo
     *
     * @param $orig_full_fn
     * @param $new_fn
     *
     * @return string
     */
    public function getNewGalleryPhotoName($orig_full_fn, $new_fn)
    {
        $ext = pathinfo($orig_full_fn, PATHINFO_EXTENSION);
        return $new_fn . $ext;
    }


}









