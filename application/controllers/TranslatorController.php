<?php

class TranslatorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->translations = (new Summers_Model_Translator())->getTranslates();
    }

    public function updateAction()
    {
        // action body
        $form = (new Summers_Form_Translator())->populate($_POST)->setAction('/translator/update');

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                if ($form->isValid($this->getRequest()->getPost())) {
                    $values = $form->getValues();

                    $item = Doctrine::getTable('Summers_Model_Carousel')->find($values['carousel_id']);

                    $item = new Summers_Model_Translator();
                    $item->fromArray($values);
                    $item->save();

                    if ($item->getErrors()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('translator');
                }

            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('translator');
            }

        } else {
            $input = (new Zend_Filter_Input(
                array('label' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('label' => array('NotEmpty'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валыдності url
            if ($input->isValid()) {

                if ($item = ( new Summers_Model_Translator())->find($input->label)) {
                    $item['label'] = $input->label;
                    $form->populate($item);
                } else {
                    throw new Zend_Controller_Action_Exception('Page not found', 404);
                }
            } else {
                throw new Zend_Controller_Action_Exception('Invalid input');
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        // action body
    }

    public function createAction()
    {
        $form = (new Summers_Form_Translator())->setAction('/translator/create')->populate($_POST);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $page = new Summers_Model_Translator();
                    $page->fromArray($values);
                    $page->save();

                    if ($page->getErrors()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('translator');
                }
            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('translator');
            }
        }
        $form->label->setAttrib('readonly', null);
        $this->view->title = 'Create translate';
        $this->view->form = $form;
    }

    /*вивести весь список фраз для перекладу*/
    public function listAction()
    {

    }


}









