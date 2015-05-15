<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initConfig()
    {
        // Action Helpers
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/controllers/helpers');

        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);
        return $config;
    }

    protected function _initDoctrine()
    {
        require_once 'Doctrine/Doctrine.php';
        $this->getApplication()
            ->getAutoloader()
            ->pushAutoloader(array('Doctrine', 'autoload'), 'Doctrine');

        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(
            Doctrine::ATTR_MODEL_LOADING,
            Doctrine::MODEL_LOADING_CONSERVATIVE
        );

        $config = $this->getOption('doctrine');
        $conn = Doctrine_Manager::connection($config['dsn'], 'doctrine')->setCharset('utf8');

        return $conn;
    }

    protected function _initLocale()
    {
        $locale = null;

        $session = new Zend_Session_Namespace('square.l10n');
        if ($session->locale) {
            $locale = new Zend_Locale($session->locale);
        }

        if ($locale === null) {
            try {
                $locale = new Zend_Locale('browser');
            } catch (Zend_Locale_Exception $e) {
                $locale = new Zend_Locale('uk_UA');
            }
        }

        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Locale', $locale);
    }

    protected function _initTranslate()
    {
        $translate = new Zend_Translate('array', APPLICATION_PATH . '/../languages/',
            null, array('scan' => Zend_Translate::LOCALE_FILENAME, 'disableNotices' => 1));
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Translate', $translate);
    }

    protected function _initDojo()
    {
        // get view resource
        $this->bootstrap('view');
        $view = $this->getResource('view');

        // add helper path to view
        Zend_Dojo::enableView($view);

        // configure Dojo view helper, disable
        $view->dojo()->setCdnBase(Zend_Dojo::CDN_BASE_AOL)
            //$view->dojo()->setCdnBase('/js/dojo/dojo.js')
            //    ->addStyleSheetModule('dijit.themes.tundra')
            ->disable();
    }

    protected function _initDatabase()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini');

        $database = Zend_Db::factory($config->database);
        Zend_Db_Table::setDefaultAdapter($database);
        //$database->getConnection();
        Zend_Registry::set("database", $database);
        return $database;
    }

    protected function _initAcl()
    {
        Zend_Loader::loadClass('Acl');
        Zend_Loader::loadClass('CheckAccess');

        Zend_Controller_Front::getInstance()
            ->registerPlugin(new CheckAccess());

        $acl = Acl::getInstance();

        // Чіпляємо ACL до Zend_Navigation
        Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
        Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($acl->getRole());

        return $acl;

    }

    protected function _initNavigation()
    {
        //read XML with navigation information and initializes it
        $db = Zend_Db_Table::getDefaultAdapter();
        $navigation_config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml');
        $conteiner = new Zend_Navigation($navigation_config);

        //registration navigation container
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Navigation', $conteiner);

        Zend_Controller_Action_HelperBroker::addHelper(
            new Summers_Controller_Action_Helper_Navigation()
        );
    }

    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();
        $data = $auth->getStorage()->read();
        if(!isset($data->role)) {
            //створюєсться новий, пустий обєкт storage_data і в нього засовуємо змінну status
            //Zend_Loader::loadClass('Acl');
            $storage_data = new stdClass();
            $storage_data->role = Acl::ROLE_GUEST;
            $auth->getStorage()->write($storage_data);
        }
    }
}

