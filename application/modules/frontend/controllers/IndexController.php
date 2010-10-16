<?php
/**
 * Default entry point in the application
 *
 * @package frontend_controllers
 * @copyright Company
 */

class IndexController extends App_Frontend_Controller
{
    /**
     * Overrides Zend_Controller_Action::init()
     *
     * @access public
     * @return void
     */
    public function init(){
        // init the parent
        parent::init();
    }
    
    /**
     * Controller's entry point
     *
     * @access public
     * @return void
     */
    public function indexAction(){
    }
}