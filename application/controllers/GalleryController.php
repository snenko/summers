<?php

class GalleryController extends Zend_Controller_Action
{
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

                    $pic_adapter = $form->picture->getTransferAdapter();

                    $item = new Summers_Model_Gallery();
                    $item->setAdapter($pic_adapter);
                    $item->fromArray($form->getValues());
                    $item->save();

                    if ($item->getErrorStack()->toArray()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('gallery', $item->galleryid);
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

                    //$gall = (new Summers_Model_Gallery)->getGallery($values['id']);
                    $gallery_name = Doctrine::getTable('Summers_Model_Gallery')->find($values['id'])->galleryname;

                    $p = (new Summers_Model_Gallery)->deleteGallery($values['id']);

                    if(!$p){
                        throw new Zend_Controller_Action_Exception('Can`t delete!');
                    }
                    $this->_helper->getHelper('FlashMessenger')->addMessage('Gallery "'.$gallery_name.'" has deleted');
                    $this->redirect('/gallery/success');
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
    }

    public function displayAction()
    {
        $input = new Zend_Filter_Input(
            array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
            array('id' => array('NotEmpty', 'Int')));

        $input->setData($this->getRequest()->getParams());

        if ($input->isValid()) {

            //$products = (new Summers_Model_Product)->getProducts($input->id);
            //$products = Summers_Model_Product::getProducts_ByGalleries($input->id);
            ///$this->view->products = (new Summers_Model_Product())->getListProducts(4);

            $products = (new Summers_Model_Product)->getProducts($input->id);// ::get get ::getProducts_ByGalleries($input->id);

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
            $this->redirect('/');
        }
    }

    public function updateAction()
    {
        $form = (new Summers_Form_Gallery())->populate($_POST)->setAction('/gallery/update');
        //при редагуванні, зображення вводити не обовязково
        $form->picture->setRequired(false);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                if ($form->isValid($this->getRequest()->getPost())) {
                    $values = $form->getValues();

                    $item = Doctrine::getTable('Summers_Model_Gallery')->find($values['galleryid']);

                    //якщо не редагується зображення, то
                    if (!$values['picture']) {
                        unset($values['picture']);
                    } else {
                        $item->setAdapter($form->picture->getTransferAdapter());
                        //задаємо сміття, для подальшого видалення
                        $item->setFilesForDelete($item->picture);
                    }

                    $item->fromArray($values);
                    $item->save();

                    if ($item->getErrorStack()->toArray()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('gallery', $item->galleryid);
                }

            } elseif ($form->cancel->isChecked()) {
                $gallery = $form->getValues();
                $this->_helper->snenko->gotoAfterAction('gallery', $gallery['galleryid']);
            }
        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //gallery/update/1 форму загружає данними
            if ($input->isValid()) {
                if ($item = Doctrine::getTable('Summers_Model_Gallery')->find($input->id)) {
                    $form->populate($item->toArray());
                } else {
                    throw new Zend_Controller_Action_Exception('Page not found', 404);
                }
            } else {
                throw new Zend_Controller_Action_Exception('Invalid input');
            }
        }
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










