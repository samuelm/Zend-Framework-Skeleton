<?php
/**
 * Default parent controller for all the backoffice controllers
 *
 * @category App
 * @package App_Backoffice
 * @copyright Company
 */

abstract class App_Backoffice_Controller extends App_Controller
{
    /**
     * Holds the title for this controller
     * 
     * @var string
     * @access public
     */
    public $title = '';
    
    /**
     * Overrides init() from App_Controller
     * 
     * @access public
     * @return void
     */
    public function init(){
        parent::init();
    }
    
    /**
     * Overrides preDispatch() from App_Controller
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
        // check the ACL
        $this->_checkAcl();
    }
    
    /**
     * Overrides postDispatch() from App_Controller
     * 
     * @access public
     * @return void
     */
    public function postDispatch(){
        parent::postDispatch();
        
        $n = App_Backoffice_Navigation::getInstance();
        
        $this->_helper->layout()->getView()->headTitle($this->title);
    }
    
    /**
     * Gets the current page. Convenience method for using
     * paginators
     * 
     * @param int $default 
     * @access protected
     * @return int
     */
    protected function _getPage($default = 1){
        $page = $this->_getParam('page');
        if (!$page || !is_numeric($page)) {
            return $default;
        }
        
        return $page;
    }
    
    /**
     * Queries the ACL and redirects the user to a different
     * page if he/her doesn't have the required permissions for
     * accessing the current page
     * 
     * @access protected
     * @return void
     */
    protected function _checkAcl(){
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
            $resourceModel = new Resource();
            
            if (!$resourceModel->checkRegistered($controllerName, $actionName)) {
                $params = array(
                    'originalController' => $controllerName,
                    'originalAction' => $actionName
                );
                
                $this->_forward('acl', 'error', NULL, $params);
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