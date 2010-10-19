<?php
/**
 * Default parent controller for all the frontend controllers
 *
 * @package App_Controller
 * @copyright Company
 */

abstract class App_Frontend_Controller extends App_Controller
{
    /**
     * Overrides init() from Neo_Controller
     * 
     * @access public
     * @return void
     */
    public function init(){
        parent::init();
    }
    
    /**
     * Overrides preDispatch() from Neo_Controller
     * Fetch and prepare the cart system in the namespace
     * 
     * @access public
     * @return void
     */
    public function preDispatch(){
        parent::preDispatch();
        
        $controllerName = $this->getRequest()->getControllerName();
        $actionName = $this->getRequest()->getActionName();
        
        Zend_Registry::set('controllerName', $controllerName);
        Zend_Registry::set('actionName', $actionName);
        // check the Flag and Flipper
        $this->_checkFlagFlippers();
    }
    
    /**
     * Queries the Flag and Flippers and redirects the user to a different
     * page if he/her doesn't have the required permissions for
     * accessing the current page
     * 
     * @access protected
     * @return void
     */
    protected function _checkFlagFlippers(){
        $controllerName = Zend_Registry::get('controllerName');
        $actionName = Zend_Registry::get('actionName');
        
        $auth = Zend_Auth::getInstance();
        
        // load the identity
        if(!$auth->hasIdentity()){
            $user = new stdClass();
            $user->username = 'guests';
            $auth->getStorage()->write($user);
        }
        
        $user = $auth->getIdentity();
        
        if(Zend_Registry::get('IS_DEVELOPMENT') && $controllerName != 'error'){
            $flagModel = new Flag();
            
            $flag = strtolower(CURRENT_MODULE) . '-' . $controllerName;
            
            if (!$flagModel->checkRegistered($flag, $actionName)) {
                $params = array(
                    'originalController' => $controllerName,
                    'originalAction' => $actionName
                );
                
                $this->_forward('flagflipper', 'error', NULL, $params);
                return;
            }
        }
        
        if(!App_FlagFlippers_Manager::isAllowed($user->username, $controllerName, $actionName)){
            if ($user->username == 'guests') {
                // the user is a guest, save the request and redirect him to
                // the login page
                $session = new Zend_Session_Namespace('App.Backoffice.Controller');
                $session->request = serialize($this->getRequest());
                $this->_redirect('/profile/login/');
            } else {
                $this->_redirect('/error/forbidden/');
            }
        }
    }
}

