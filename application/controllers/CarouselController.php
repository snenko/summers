<?php

class CarouselController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $carousel = new Summers_Model_Collection_Carousel();
        $carousel->loadCarousels();

        $this->view->carousel = array(
            //'products'  => $products,
            'carousel' => $carousel->getCarousels(),
        );
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
        //------------------------------------------------------------------------------
        // action body
        $form = new Summers_Form_Carousel('/carousel/update');
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
        //-----------------------------------------------------------------------------
        $form = (new Summers_Form_Carousel())->populate($_POST)->setAction('/carousel/update');

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $adapter = $form->picture->getTransferAdapter();
                    $carousel_id = $values['id'];

                    //$carousel= new Summers_Model_Carousel();
                    $carousel = Doctrine::getTable('Summers_Model_Carousel')->find($carousel_id);
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
        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валыдності url
            if ($input->isValid()) {
                $values = $form->getValues();
                $carousel_id = $values['id'];

                if (count($carousel = Doctrine::getTable('Summers_Model_Carousel')->find($carousel_id)) == 1) {
                    //задаємо початкові значення в формі
                    $form->populate($carousel[0]);
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











