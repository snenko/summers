<?php

class CarouselController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
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
                    $this->_helper->snenko->gotoAfterAction('carousel', $carousel->carousel_id);
                }
            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('carousel');
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        // action body
    }

    public function successAction()
    {
        // action body
    }

    public function updateAction()
    {
        // action body
    }

    public function displayAction()
    {
        // action body
    }


}











