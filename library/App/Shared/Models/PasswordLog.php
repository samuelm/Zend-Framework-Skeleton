<?php
/**
 * Model that holds the password's log
 *
 * Whenever an user changes his/her password, the new password must 
 * not be in the log. Each new password must be different from the previous
 * 4 passwords stored in the log.
 *
 * @package backoffice_models
 * @copyright Company
 */

class PasswordLog extends App_Model
{
    /**
     * Column for the primary key
     *
     * @var string
     * @access protected
     */
    protected $_primary = 'id';
    
    /**
     * Holds the table's name
     *
     * @var string
     * @access protected
     */
    protected $_name = 'password_log';
    
    /**
     * Saves a password in the log under the current user_id. If there are
     * more that 4 password, the oldest is deleted.
     *
     * By this point, the password should already be hashed
     * using User::hashPassword()
     * 
     * @param string $password 
     * @access public
     * @return void
     */
    public function savePassword($password){
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Zend_Exception('You must have one authenticated user in the application in order to be able to call this method');
        }
        
        $user = Zend_Auth::getInstance()->getIdentity();
        
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        $select->where('user_id = ?', $user->id);
        $select->order('created_at ASC');
        
        $rows = $this->_db->fetchAll($select);
        
        if (count($rows) == 4) {
            $this->deleteById($rows[0]['id']);
        }
        
        $this->insert(array(
            'user_id' => $user->id,
            'password' => $password,
            'created_at' => new Zend_Db_Expr('NOW()'),
        ));
    }
}