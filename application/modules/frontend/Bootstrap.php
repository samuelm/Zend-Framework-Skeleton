<?php
/**
 * Frontend bootstrap
 *
 * @package Frontend
 * @copyright Company
 */

class Frontend_Bootstrap extends App_Bootstrap_Abstract
{
    /**
     * Inits the session for the frontend
     * 
     * @access protected
     * @return void
     */
    protected function _initSession(){
        Zend_Session::start();
    }
    
    /**
     * Initialize the routes
     *
     * @return void
     */
    protected function _initRouter(){
        $routes = new Zend_Config_Xml(APPLICATION_PATH . '/configs/frontend_routes.xml');
        $router = new Zend_Controller_Router_Rewrite();
        $router->addConfig($routes);
        
        $front = Zend_Controller_Front::getInstance();
        $front->setRouter($router);
    }
    
    /**
     * Initialize the translation system
     *
     * @return void
     */
    protected function _initTranslator(){
        //Extract some info from the request
        $lang = Zend_Registry::get('Zend_Locale')->getLanguage();
        
        //Create a zend_log for missing translations
        $pathLog = ROOT_PATH . '/logs/' . CURRENT_MODULE . '/missing_translations/' . date('Ymd') . '_' . $lang . '.log';
        $writer = new Zend_Log_Writer_Stream($pathLog);
        $logger = new Zend_Log($writer);
        $translationFile = APPLICATION_PATH . '/modules/' . CURRENT_MODULE . '/translations/' . $lang . '.mo';
        
        //Check if the translations file is available, if not fallback default to english
        if(!file_exists($translationFile)){
            $translationFile = APPLICATION_PATH . '/modules/' . CURRENT_MODULE . '/translations/en.mo';
        }
        
        $translate = new Zend_Translate(
            array(
                'adapter' => 'gettext',
                'content' => $translationFile,
                'locale'  => $lang,
                'disableNotices' => Zend_Registry::get('config')->translations->disable_notices,
                'log' => $logger,
                'logMessage' => "Missing translation: %message%",
                'logUntranslated' => Zend_Registry::get('config')->translations->log_missing_translations
            )
        );
        
        Zend_Registry::set('Zend_Translate', $translate);
    }
}