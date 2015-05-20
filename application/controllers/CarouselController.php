<?php

class CarouselController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $carousels = new Summers_Model_Collection_Carousel();
        $carousels->loadCarousels();

        $this->view->carousels = $carousels->getCarousels();
    }

    public function createAction()
    {
        // action body
        $form = new Summers_Form_Carousel('/carousel/create');
        $form->populate($_POST);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $adapter = $form->picture->getTransferAdapter();

                    $carousel= new Summers_Model_Carousel();
                    $carousel->fromArray($values);
                    $carousel->setAdapter($adapter);
                    $carousel->save();

                    if ($carousel->getErrorStack()->toArray()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('carousel');
                }
            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('carousel');
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $form = (new Summers_Form_Delete())->populate($_POST)->setAction('/carousel/delete');

        if ($this->getRequest()->isPost())
        {
            //видаляємо
            if ($form->submit->isChecked()) {
                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();
                    $carousel_id = $values['id'];

                    $carousel= Doctrine::getTable('Summers_Model_Carousel')->find($carousel_id);
                    $title =  $carousel->toArray()['title'];
                    $carousel->delete();

                    if ($carousel->getErrorStack()->toArray()) {
                        throw new Zend_Controller_Action_Exception('Can`t delete!');
                    }
                    //Успіх, переходимо на success
                    $this->_helper->getHelper('FlashMessenger')
                        ->addMessage('Product "'.$title.'" has deleted');
                    $this->_redirect('/carousel/success');
                }
            }

            //скасовуємо видалення
            elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('carousel');
            }

        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валідності url
            if ($input->isValid()) {

                if($carousel= Doctrine::getTable('Summers_Model_Carousel')->find($input->id)){
                    $title =  $carousel->toArray()['title'];
                    $form->populate(array('id' => $input->id));
                    $this->view->caption = 'carousel';
                    $this->view->message = $title;
                }else{
                    throw new Zend_Controller_Action_Exception('Invalid id');
                }
            } else {throw new Zend_Controller_Action_Exception('Invalid input');}
        }

        $this->view->form = $form;
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
        $form = (new Summers_Form_Carousel())->populate($_POST)->setAction('/carousel/update');
        //при редагуванні, зображення вводити не обовязково
        $form->picture->setRequired(false);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                if ($form->isValid($this->getRequest()->getPost())) {
                    $values = $form->getValues();

                    $item = Doctrine::getTable('Summers_Model_Carousel')->find($values['carousel_id']);

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
                    $this->_helper->snenko->gotoAfterAction('carousel');
                }

            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('carousel');
            }
        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валыдності url
            if ($input->isValid()) {
                if ($item = Doctrine::getTable('Summers_Model_Carousel')->find($input->id)) {
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

    public function displayAction()
    {
        // action body
    }


}











