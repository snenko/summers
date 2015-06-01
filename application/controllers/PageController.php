<?php

class PageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->pages = (new Summers_Model_Page())->getPages();
    }

    public function createAction()
    {
        $form = (new Summers_Form_Page())->setAction('/page/create')->populate($_POST);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $page = new Summers_Model_Page();
                    $page->fromArray($values);
                    $page->save();

                    if ($page->getErrorStack()->toArray()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('page', $page->page_id);
                }
            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('page');
            }
        }

        $this->view->title = 'Create page';
        $this->view->form = $form;
    }

    public function updateAction()
    {
        $form = (new Summers_Form_Page())->setAction('/page/update')->populate($_POST);

        if ($this->getRequest()->isPost()) {
            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();

                    $page = Doctrine::getTable('Summers_Model_Page')->find($values['page_id']);
                    $page->fromArray($values);
                    $page->save();

                    if ($page->getErrorStack()->toArray()) {
                        throw new Zend_Controller_Action_Exception('Invalid saved');
                    }
                    $this->_helper->snenko->gotoAfterAction('page', $page->page_id);
                }

            } elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('page');
            }
        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валыдності url
            if ($input->isValid()) {
                $page = Doctrine::getTable('Summers_Model_Page')->find($input->id);

                if ($page->getErrorStack()->toArray()) {
                    throw new Zend_Controller_Action_Exception('Page not found', 404);
                }
                //задаємо початкові значення в формі
                $form->populate($page->getData());
            } else {
                throw new Zend_Controller_Action_Exception('Invalid input');
            }
        }

        $this->view->title = 'Update page';
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $form = new Summers_Form_Delete('/page/delete');

        if ($this->getRequest()->isPost())
        {
            $form->populate($_POST);
            //видаляємо
            if ($form->submit->isChecked()) {
                if ($form->isValid($this->getRequest()->getPost())) {
                    $values = $form->getValues();

                    $page = Doctrine::getTable('Summers_Model_Page')->find($values['id']);
                    $page_name = $page->name;
                    $page->delete();

                    if($page->getErrorStack()->toArray()){
                        throw new Zend_Controller_Action_Exception('Can`t delete!');
                    }
                    //Успіх, переходимо на success
                    $this->_helper->getHelper('FlashMessenger')
                        ->addMessage("Page \"{$page_name}\" has deleted");
                    $this->_redirect('/page/success');
                }
            }

            //скасовуємо видалення
            elseif ($form->cancel->isChecked()) {
                $this->_helper->snenko->gotoAfterAction('page');
            }

        } else {
            $input = (new Zend_Filter_Input(
                array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
                array('id' => array('NotEmpty', 'Int'))
            ))->setData($this->getRequest()->getParams());

            //перевырка валідності url
            if ($input->isValid()) {

                //Визначаэмо назву товара, що видаляється
                $page = Doctrine::getTable('Summers_Model_Page')->find($input->id);
                if($page->page_id){
                    $form->populate(array('id' => $input->id));
                    $this->view->caption = 'page';
                    $this->view->message = $page->name;

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

    public function displayAction()
    {
        $input = new Zend_Filter_Input(
            array('id' => array('HtmlEntities', 'StripTags', 'StringTrim')),
            array('id' => array('NotEmpty', 'Int')));

        $input->setData($this->getRequest()->getParams());

        if ($input->isValid()) {

            $page = Doctrine::getTable('Summers_Model_Page')->find($input->id);

            if ($page->getErrorStack()->toArray()) {
                throw new Zend_Controller_Action_Exception('Page not found', 404);
            }

            $this->view->headTitle('display page: '.$page->title);
            $p = $page->getData();
            $this->view->page = $p;

        } else {
            throw new Zend_Controller_Action_Exception('Invalid input');
        }
    }


}











