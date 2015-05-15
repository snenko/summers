<?php
class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->doctype('XHTML1_STRICT');
        //$this->_helper->layout->setLayout('admin');
    }

    public function loginAction()
    {
        $form = new Summers_Form_Login;

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $auth = Zend_Auth::getInstance();
                $values = $form->getValues();

                $adapter = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable(
                    $adapter,
                    'user', 'username','password','PASSWORD(?)'
                );

                $authAdapter->setIdentity($values['username']);
                $authAdapter->setCredential($values['password']);

                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {
                    $storage = $auth->getStorage();
                    $storege_data = $authAdapter->getResultRowObject(
                        null,
                        array('activate', 'password', 'enabled')
                    );
//                  $user = new Summers_Model_DbTable_User();
                    //$storege_data->status = Acl::ROLE_GUEST;
                    $storege_data->role = Acl::ROLE_GUEST;
                    $storage->write($storege_data);

                    $this->_helper->getHelper('FlashMessenger')->addMessage('You were successfully logged in.');
                    $this->_redirect('/login/success');
                }
            }
        }

        $this->view->form = $form;
    }

    public function successAction()
    {
        if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
            $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        } else {
            $this->_redirect('/home');
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();
        $this->_redirect('/home');
    }

}







