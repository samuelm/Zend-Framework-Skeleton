<?php
/**
 * Logger Wrapper to integrate SNS on errors and info messages
 *
 * @category App
 * @package App_FlagFlippers
 * @copyright Company
 */
class App_Logger
{
    /**
     * Write messages to the log and send a notification to the SNS in case of error or info messages
     *
     * @param string $msg
     * @param int
     * @return void
     */
    public static function log($msg, $level = Zend_Log::INFO){
        Zend_Registry::get('Zend_Log')->log($msg, $level);
        
        if($level == Zend_Log::ERR){
            Zend_Registry::get('SNSFrontendErrors')->publish('Critical Error', $msg);
        }
        
        if($level == Zend_Log::INFO){
            Zend_Registry::get('SNSFrontendInfo')->publish('Info event', $msg);
        }
    }
}