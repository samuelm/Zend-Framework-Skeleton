<?php
/**
 * Default parent controller for all the frontend controllers
 *
 * @package App_Controller
 * @copyright Company
 */

abstract class App_Frontend_Controller extends App_Controller
{
    /**
     * Store the shopping system
     */
    protected $shoppingSystem = NULL;
    
    /**
     * Overrides init() from Neo_Controller
     * 
     * @access public
     * @return void
     */
    public function init(){
        parent::init();
    }
    
    /**
     * Overrides preDispatch() from Neo_Controller
     * Fetch and prepare the cart system in the namespace
     * 
     * @access public
     * @return void
     */
    public function preDispatch(){
        parent::preDispatch();
    }
}

