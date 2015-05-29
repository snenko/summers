<?php

class Zend_Controller_Action_Helper_Snenko extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * go to controller's action page after controller's action
     * @param string $path
     * @param        $id
     */
                    //'product', 'success', 'Product has deleted'
//    function gotoPage($controller, $action, $message)
//    {
//        $obj = $this->_actionController;
//        if ($id) {
//            $obj->redirect('/'.$controller.$action.$id);
//        } else {
//            $obj->redirect('/'.$controller);
//        }
//    }

    /**
     * @param string $controller
     * @param string $id
     */
    function gotoAfterAction($controller = 'index', $id='', $action ='')
    {
        $obj = $this->_actionController;

//        if(!$action && $id) $action = 'display';

        $action = (!$action && $id)?'/display':'/'.$action;
        if ($id) $id = '/'.$id;

        $obj->redirect('/'.$controller.$action.$id);
    }


}

