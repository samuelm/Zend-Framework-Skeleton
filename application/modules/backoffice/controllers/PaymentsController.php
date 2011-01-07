<?php
/**
 * Controller to handle reports and info related with payments
 *
 * @category backoffice
 * @package backoffice_controllers
 * @copyright Company
 */

class PaymentsController extends App_Backoffice_Controller
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
        $this->title = '';
        
        $transactionModel = new Transaction();
        $this->view->paginator = $transactionModel->findAll($this->_getPage());
    }
}