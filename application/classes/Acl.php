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
    const ROLE_ADMIN = 'admin';

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

        //Ресурси
        $this->addResource('index');
        $this->addResource('gallery');
        $this->addResource('product');
        $this->addResource('blog');
        $this->addResource('login');
        $this->addResource('carousel');

        //Дозволи
        $this->allow(
            self::ROLE_GUEST,
            array('index', 'gallery', 'product', 'blog',),
            array('index', 'display')
        );
        $this->allow(self::ROLE_GUEST, 'index', array('contacts'));
        $this->allow(self::ROLE_GUEST, 'login', array('login'));
        // user

        $this->allow(self::ROLE_USER,
            array('blog'),
            array('comments')
        );
        $this->allow(self::ROLE_USER, 'login', array('logout', 'success'));

        //admin
        $this->allow(self::ROLE_ADMIN); // allow admin access to all resources
//        $this->allow(
//            self::ROLE_ADMIN,
//            array('gallery', 'product', 'blog', 'carousel'),
//            array('create', 'update', 'delete', 'success', 'index')
//        );

        return $this;
    }

    /**
     * Перевірка доступності ресурсу
     *
     * @param string $privilege
     *
     * @return bool
     */
    public function can($privilege='')
    {
        $params = $this->getParams();

        if (!$this->has($params['resource'])) {
            return true;
        }

        $role = $this->getCurrentRole(); //Acl::ROLE_GUEST;//

        if (!$privilege)
            $privilege = $params['privilege'];

        return $this->isAllowed($role, $params['resource'], $privilege);
    }

    public function getCurrentRole()
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

//    public function getRole($role){
//
//    }

    public function getParams()
    {
        $request = Zend_Controller_Front::getInstance();
        $_controller = $request->getRequest()->getParams();
        $_action = $request->getRequest()->getParams();

        $resource = $_controller['controller'];
        $privilege = $_action['action'];

        return array(
            'resource' => $resource,
            'privilege' => $privilege
        );
        //return "{$controller}/{$action}";
    }

}
