<?php
/**
 * User: Adolis
 * Date: 28.04.15
 * Time: 15:58
 * To change this template use File | Settings | File Templates.
 */

class Acl extends Zend_Acl
{
    const ROLE_GUEST = 'guest';
    const ROLE_USER = 'user';
//    const ROLE_PUBLISHER = 'publisher';
//    const ROLE_EDITOR = 'editor';
    const ROLE_ADMIN = 'admin';
//    const ROLE_GOD = 'god';

    protected static $_instance;

    /* Singleton pattern */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function resetInstance()
    {
        self::$_instance = null;
        self::getInstance();
    }

    protected function __construct()
    {
        $this->addRole(self::ROLE_GUEST);
        $this->addRole(self::ROLE_USER, self::ROLE_GUEST);
        $this->addRole(self::ROLE_ADMIN, self::ROLE_USER);

        //$this->deny();
        $this->deny(
            array(
                 self::ROLE_GUEST,
                 self::ROLE_USER,
                 self::ROLE_ADMIN
            )
        );
        //$this->allow(self::ROLE_ADMIN);

        //чи можна в application.ini одразу задавати рівень доступу?
        // parent resoures
        $this->addResource('guest_allow');
        $this->addResource('user_allow', 'guest_allow');
        $this->addResource('admin_allow', 'user_allow');

        // guest
        $this->addResource('index/index', 'guest_allow');
        $this->addResource('gallery/index', 'guest_allow');
        $this->addResource('gallery/display', 'guest_allow');
        $this->addResource('product/index', 'guest_allow');
        $this->addResource('product/display', 'guest_allow');
        $this->addResource('product/login', 'guest_allow');

        // admin

        $this->addResource('carousel/index', 'admin_allow');
        $this->addResource('carousel/create', 'admin_allow');
        $this->addResource('carousel/update', 'admin_allow');
        $this->addResource('carousel/delete', 'admin_allow');

        $this->addResource('gallery/create', 'admin_allow');
        $this->addResource('gallery/update', 'admin_allow');
        $this->addResource('gallery/delete', 'admin_allow');

        $this->addResource('product/create', 'admin_allow');
        $this->addResource('product/update', 'admin_allow');
        $this->addResource('product/delete', 'admin_allow');
        /*****************************************************/

        // permissions
        $this->allow(self::ROLE_GUEST, array('guest_allow'));
        $this->allow('user',  array('guest_allow', 'user_allow'));
        $this->allow('admin', array('guest_allow', 'user_allow', 'admin_allow'));

        return $this;
    }

    /**
     * Перевірка доступності ресурсу
     *
     * @param string $privilege
     *
     * @return bool
     */
    public function can($privilege = 'show')
    {
        $resource = $this->getResource();
        if (!$this->has($resource)) {
            return true;
        }

        $role = $this->getRole(); //Acl::ROLE_GUEST;//

        return $this->isAllowed($role, $resource, $privilege);
    }

    public function getRole($role='')
    {
        $auth = Zend_Auth::getInstance();
        $role = ($auth->hasIdentity() && !empty($auth->getIdentity()->role))
            ? $auth->getIdentity()->role
            : Acl::ROLE_GUEST;

//        $storage_data = Zend_Auth::getInstance()->getStorage()->read();
//        $role = array_key_exists('role', $storage_data)
//            ? $storage_data->role
//            : Acl::ROLE_GUEST;

        return $role;
    }

    public function getResource()
    {
        $request = Zend_Controller_Front::getInstance();
        $controller = $request->getRequest()->getParams()['controller'];
        $action = $request->getRequest()->getParams()['action'];

        return "{$controller}/{$action}";
    }

}
