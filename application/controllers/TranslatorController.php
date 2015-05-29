<?php

class TranslatorController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
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

                    $item = (new Summers_Model_Translator);
                    $item->fromArray($values);
                    $item->saveToFiles();

                    if ($item->getErrors()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('translator',null, 'list');
                }

            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('translator/list');
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
        // action body
    }

    /*вивести весь список фраз для перекладу*/
    public function listAction()
    {
        $this->view->translations = (new Summers_Model_Translator())->getTranslates();
    }


}









