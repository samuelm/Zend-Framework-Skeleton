<?php
/**
 * Various string utilities
 *
 * @category App
 * @package Neo
 * @copyright Company
 */

class App_Inflector 
{
    /**
     * Single instance of the object
     * 
     * @static
     * @var App_Inflector
     * @access private
     */
    private static $_instance = NULL;
    
    /**
     * Default contructor - must not be called from "outside"
     * 
     * @access private
     * @return void
     */
    private function __construct(){
    }
    
    /**
     * Returns the singleton object
     * 
     * @static
     * @access public
     * @return void
     */
    public static function getInstance(){
        if (NULL === self::$_instance) {
            self::$_instance = new App_Inflector();
        }
        
        return self::$_instance;
    }
    
    /**
     * Implementation of the __clone() magic that prevents cloning of a 
     * singleton object
     * 
     * @access public
     * @return void
     */
    public function __clone(){
        throw new Zend_Exception('Cloning singleton objects is forbidden.');
    }
    
    /**
     * Converts a controller's name to a resource name
     * 
     * Ex: MyExampleController => my-example
     * 
     * @param string $string 
     * @access public
     * @return string
     */
    public function convertControllerName($string){
        $string = substr($string, 0, -10);
        return $this->camelCaseToDash($string);
    }
    
    /**
     * Converts an action's name to a privilege name
     * 
     * Ex: myExampleAction => my-example
     * 
     * @param string $string 
     * @access public
     * @return string
     */
    public function convertActionName($string){
        $string = substr($string, 0, -6);
        return $this->camelCaseToDash($string);
    }
    
    /**
     * Convers a camelCasedString to lower cased string with
     * words separated by dashes
     *
     * Ex: myCamelCasedString => my-camel-cased-string
     * 
     * @param string $string 
     * @access public
     * @return string
     */
    public function camelCaseToDash($string){
        $string = preg_replace('/([A-Z]+)([A-Z])/','$1-$2', $string);
        $string = preg_replace('/([a-z])([A-Z])/', '$1-$2', $string);
        
        return strtolower($string);
    }
    
    /**
     * Converts a dashed or underscored string to a humanly readable
     * one. Ex:
     * my-action-controller => My action controller
     * 
     * @param mixed $string 
     * @access public
     * @return void
     */
    public function humanize($string){
        return ucfirst(str_replace(array('_', '-'), ' ', $string));
    }
    
    /**
     * Computes a slug of the given string
     * 
     * @param mixed $string 
     * @access public
     * @return string
     */
    public function slug($string){
        $string = preg_replace('/([^a-z0-9]){1,}/', '-', strtolower($string));
        return $string;
    }
}