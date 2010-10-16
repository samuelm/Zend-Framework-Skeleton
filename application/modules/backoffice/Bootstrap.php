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
     * Inits the Access Control Lists
     * 
     * @access protected
     * @return void     
     */
    protected function _initAcl() {
        // init the acls - not used in the frontend
    }
    
    /**
     * Inits the backoffice user actions logger (BigBrother)
     * 
     * @access protected
     * @return void     
     */
    protected function _initBigBrother() {
    }
    
    /**
     * Inits the session for the backoffice
     * 
     * @access protected
     * @return void     
     */
    protected function _initSession() {
        Zend_Session::start();
    }
}