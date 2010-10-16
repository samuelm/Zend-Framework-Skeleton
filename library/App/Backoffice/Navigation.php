<?php
/**
 * Holds the backoffice's navigation system
 *
 *
 * @category App
 * @package App_Backoffice
 * @subpackage Navigation
 * @copyright Company
 */

class App_Backoffice_Navigation 
{
    /**
     * Singleton object for this class
     *
     * @var App_Backoffice_Navigation
     * @access protected
     */
    protected static $_instance;
    
    /**
     * Holds the navigation array
     * 
     * @var array
     * @access protected
     */
    protected $_navigation;
    
    /**
     * Constructs the Navigation object. Must not be called directly
     * 
     * @access public
     * @return void
     */
    protected function __construct(){
        $this->_navigation = $this->_markActive($this->_filter($this->_getPages()));
    }
    
    /**
     * Returns a singleton instance of the class
     * 
     * @access public
     * @return void
     */
    public function getInstance(){
        if (NULL === self::$_instance) {
            self::$_instance = new App_Backoffice_Navigation();
        }
        
        return self::$_instance;
    }
    
    /**
     * Implements the __clone() magic method, forbidding the cloning
     * of this object
     * 
     * @access public
     * @return void
     */
    public function __clone(){
        throw new Zend_Exception('Cloning singleton objects is forbidden');
    }
    
    /**
     * Returns an array of pages
     * 
     * @access protected
     * @return void
     */
    protected function _getPages(){
        $pages = array(
            array(
                'label' => 'Groups',
                'pages' => array(
                    array(
                        'label' => 'List groups',
                        'controller' => 'groups',
                        'action' => 'index',
                    ),
                ),
            ),
            array(
                'label' => 'Users',
                'pages' => array(
                    array(
                        'label' => 'List users',
                        'controller' => 'users',
                        'action' => 'index',
                    ),
                ),
            ),
            array(
                'label' => 'Profile',
                'controller' => 'profile',
                'action' => 'index'
            ),
        );
        
        return $pages;
    }
    
    /**
     * Returns an array with all the pages that will be available for
     * the current user
     * 
     * @param array $data
     * @access protected
     * @return array
     */
    protected function _filter($data){
        $user = Zend_Auth::getInstance()->getIdentity();
        
        $filtered = array();
        
        foreach($data as $tab){
            $filteredPages = array();
            if(isset($tab['pages'])){
                foreach($tab['pages'] as $page){
                    try{
                        if(App_FlagFlippers_Manager::isAllowed($user->username, $page['controller'], $page['action'])){
                            $filteredPages[] = $page;
                        }
                    }catch(Zend_Exception $e){
                        // resource not yet registered, will be picked up by the App_Backoffice_Controller
                        // when the user tries to access it. Add it for now for testing purposes
                        
                        $filteredPages[] = $page;
                    }
                }
            }
            
            if(!empty($filteredPages)){
                $filteredTab = array(
                    'label' => $tab['label'],
                    'pages' => $filteredPages,
                );
                
                $filtered[] = $filteredTab;
            }
        }
        
        return $filtered;
    }
    
    /**
     * Marks the current tab as active
     * 
     * @param arrat $pages 
     * @access protected
     * @return array
     */
    protected function _markActive($menu){
        $controllerName = Zend_Registry::get('controllerName');
        
        foreach($menu as $tabkey => $tab){
            if(isset($tab['pages'])){
                foreach($tab['pages'] as $pagekey => $page) {
                    if ($controllerName === $page['controller']) {
                        $menu[$tabkey]['pages'][$pagekey]['active'] = true;
                        $menu[$tabkey]['active'] = true;
                        break;
                    }
                }
            }else{
                if ($controllerName === $tab['controller']){
                    $menu[$tabkey]['active'] = true;
                }
            }
        }
        
        return $menu;
    }
    
    /**
     * Returns the navigation array
     * 
     * @access public
     * @return array
     */
    public function getNavigation(){
        return $this->_navigation;
    }
}