<?php
/**
 * Default application wide controller parent class
 *
 * @category App
 * @package App_Controller
 * @copyright Company
 */

abstract class App_Controller extends Zend_Controller_Action
{
    
    /**
     * Queries the Flag and Flipper and redirects the user to a different
     * page if he/her doesn't have the required permissions for
     * accessing the current page
     * 
     * @access protected
     * @return void
     */
    protected function _checkFlagFlippers(){
        $controllerName = Zend_Registry::get('controllerName');
        $actionName = Zend_Registry::get('actionName');
        
        $user = BaseUser::getSession();
        
        if(Zend_Registry::get('IS_DEVELOPMENT') && $controllerName != 'error'){
            $flagModel = new Flag();
            
            $flag = strtolower(CURRENT_MODULE) . '-' . $controllerName;
            
            if(!$flagModel->checkRegistered($flag, App_Inflector::camelCaseToDash($actionName))){
                $params = array(
                    'originalController' => $controllerName,
                    'originalAction' => $actionName
                );
                
                $this->_forward('flagflippers', 'error', NULL, $params);
                return;
            }
        }
        
        //Check the flag and flippers for ZFDebug
        if(!App_FlagFlippers_Manager::isAllowed($user->group->name, 'testing', 'zfdebug')){
            Zend_Controller_Front::getInstance()->unregisterPlugin('ZFDebug_Controller_Plugin_Debug');
        }
        
        if(!App_FlagFlippers_Manager::isAllowed($user->group->name, $controllerName, $actionName)){
            if(empty($user->id)){
                // the user is a guest, save the request and redirect him to
                // the login page
                $session = new Zend_Session_Namespace('App.' . CURRENT_MODULE . '.Controller');
                $session->request = serialize($this->getRequest());
                $this->_redirect('/profile/login/');
            }else{
                $this->_redirect('/error/forbidden/');
            }
        }
    }
}
