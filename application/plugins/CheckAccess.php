<?php
/**
 * User: Adolis
 * Date: 28.04.15
 * Time: 17:58
 * To change this template use File | Settings | File Templates.
 */

class CheckAccess extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // перевірка доступа до цього ресурса
        $acl = Acl::getInstance();

        if (!$acl->can()) {

            $request
                ->setControllerName('error')
                ->setActionName('denied')
                ->setParam('message', 'You don`t have access to this page')
                ->setParam('role', $acl->getCurrentRole())
                ->setParam('resource', $acl->getParams());
        }
    }
}