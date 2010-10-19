<?php

/**
 * Bootstraps the Backoffice module
 *
 * @category  backoffice
 * @package   backoffice_bootstrap
 * @copyright Company
 */
class Backoffice_Bootstrap extends App_Bootstrap_Abstract {

    /**
     * Inits the backoffice user actions logger (BigBrother)
     * 
     * @access protected
     * @return void     
     */
    protected function _initBigBrother(){
    }
    
    /**
     * Inits the session for the backoffice
     * 
     * @access protected
     * @return void     
     */
    protected function _initSession(){
        Zend_Session::start();
    }
    
    /**
     * Inits the Zend Paginator component
     *
     * @access protected
     * @return void
     */
    protected function _initPaginator(){
        Zend_Paginator::setDefaultScrollingStyle(Zend_Registry::get('config')->paginator->scrolling_style);
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            'default.phtml'
        );
    }
}