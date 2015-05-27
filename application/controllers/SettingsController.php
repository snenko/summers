<?php

class SettingsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    }

    public function updateAction()
    {
        // generate input form
        $form = (new Summers_Form_Settings())->setAction('/settings/update')->populate($_POST);

        if ($this->getRequest()->isPost()) {

            if ($form->submit->isChecked()) {

                $postData = $this->getRequest()->getPost();
                if ($form->isValid($postData)) {
                    $values = $form->getValues();
                    $config = new Zend_Config(array(), true);
                    $config->guest = array();
                    $config->admin = array();

                    $config->guest->guestEmailAddress = $values['guestEmailAddress'];
                    $config->guest->langDefault = $values['langDefault'];
                    $config->admin->adminEmailAddress = $values['adminEmailAddress'];
                    $config->admin->titleProducts = $values['titleProducts'];

                    $writer = new Zend_Config_Writer_Ini();
                    $writer->write(Summers_Snenko::getSetting_path(), $config);

                    $this->_helper->getHelper('FlashMessenger')->addMessage('settings saved');
                    $this->redirect('/settings/success');
                }
            } elseif ($form->cancel->isChecked()) {
                $gallery = $form->getValues();
                $this->_helper->snenko->gotoAfterAction('gallery', $gallery['galleryid']);
            }

        } else {
            if ($config = Summers_Snenko::getSettings_config()) {
                // guest
                $data['guestEmailAddress'] = $config->guest->guestEmailAddress;
                $data['langDefault'] = $config->guest->langDefault;
                // admin
                $data['adminEmailAddress'] = $config->admin->adminEmailAddress;
                if($config->admin->titleProducts) {
                    $data['titleProducts'] = $config->admin->titleProducts->toArray();
                }


                $form->populate($data);
            }
        }

        $this->view->form = $form;
    }

    public function successAction()
    {
        if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
            $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        } else {
            $this->redirect('/');
        }
    }


}





