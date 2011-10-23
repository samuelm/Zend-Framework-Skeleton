<?php
/**
 * This class defines a few common methods to send emails
 *
 * @category App
 * @package App_Mail
 * @copyright company
 */
class App_Mail_Abstract
{
    /**
     * Store the template filename
     *
     * @var string
     */
    protected $_template;
    
    /**
     * Store the email subject
     *
     * @var string
     */
    protected $_subject;
    
    /**
     * Store the recipients of the email
     *
     * @var array
     */
    public $recipients;
    
    /**
     * Instantiate the translator object
     */
    public function __construct(){
        if(!Zend_Registry::isRegistered('Zend_Translate')){
            $bootstrap = Zend_Registry::get('Bootstrap');
            $bootstrap->bootstrap(array('Translator'));
        }
        
        $this->t = Zend_Registry::get('Zend_Translate');
    }
    
    /**
     * Send the email
     *
     * @param array $args
     * @return void
     */
    public function send(array $args){
        if(!Zend_Registry::get('IS_PRODUCTION') && !App_DI_Container::get('ConfigObject')->testing->mail){
            $this->_log(Zend_Layout::getMvcInstance()->getView()->partial($this->_template, $args));
        }else{
            App_DI_Container::get('GearmanClient')->doBackground('send_email', serialize(array(
                'to' => $this->recipients,
                'subject' => $this->_subject,
                'html' => Zend_Layout::getMvcInstance()->getView()->partial($this->_template, $args),
                'reply' => (array_key_exists('replyTo', $args)? $args['replyTo']->email : NULL),
                'attachment' => (array_key_exists('attachment', $args)? $args['attachment'] : NULL),
                'type' => $args['type'],
                'campaign' => (array_key_exists('campaign', $args)? $args['campaign'] : NULL)
            )));
        }
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