<?php
/**
 * Command
 *
 * @package default
 */
class App_Command_SendEmail extends App_Command_Abstract{
    /**
     * Store the command name
     *
     * @var string
     */
    private $_commandName = 'sendEmail';
    
    /**
     * Convenience method to run the command
     *
     * @param string $name
     * @param mixed $args
     * @return boolean
     */
    public function onCommand($name, $args){
        if(strcasecmp($name, $this->_commandName) !== 0){
            return FALSE;
        }
        
        $bootstrap = Zend_Registry::get('Bootstrap');
        
        if(!Zend_Registry::isRegistered('Router')){
            $bootstrap->bootstrap(array('Router', 'ViewPaths'));
        }
        
        $router = new Zend_Controller_Router_Rewrite();
        $routes = new Zend_Config_Xml(APPLICATION_PATH . '/configs/cli_routes.xml');
        
        $router->addConfig($routes);
        
        $front = Zend_Controller_Front::getInstance();
        $front->setRouter($router);
        
        //Do the command
        $trackingId = sha1(uniqid(time(), TRUE));
        $args = $args + array(
            'trackingId' => $trackingId,
            'pixelUrl' => sprintf(
                '%s%s', 
                App_DI_Container::get('ConfigObject')->frontend->url, 
                Zend_Layout::getMvcInstance()->getView()->url(
                    array(
                        'id' => $trackingId
                    ),
                    'analytics-email-opened'
                )
            )
        );
        
        $mailObject = sprintf('App_Mail_%s', $args['type']);
        $mail = new $mailObject();
        
        $mail->recipients = $args['recipients'];
        $mail->send($args);
        
        if(Zend_Registry::isRegistered('Router')){
            $front = Zend_Controller_Front::getInstance();
            $front->setRouter(Zend_Registry::get('Router'));
        }
        
        return TRUE;
    }

    /**
     * Store the email in the log
     *
     * @param string $msg 
     * @param string $level 
     * @return void
     */
    private function _log($msg, $level = Zend_Log::INFO){
        App_DI_Container::get('MailerLog')->log($msg, $level);
    }
}