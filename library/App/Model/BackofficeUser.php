<?php
/**
 * Model that manages the users within the application
 *
 * @category App
 * @package App_Model
 * @copyright Company
 */

class BackofficeUser extends App_Model
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
    protected $_name = 'backoffice_users';
    
    /**
     * Holds the associated model class
     * 
     * @var string
     * @access protected
     */
    protected $_rowClass = 'App_Table_BackofficeUser';
    
    /**
     * Logs an user in the application based on his
     * username and email
     * 
     * @param string $username
     * @param string $password 
     * @access public
     * @return void
     */
    public function login($username, $password){
        // adapter cfg
        $adapter = new Zend_Auth_Adapter_DbTable($this->_db);
        $adapter->setTableName($this->_name);
        $adapter->setIdentityColumn('username');
        $adapter->setCredentialColumn('password');
        
        // checking credentials
        $adapter->setIdentity($username);
        $adapter->setCredential(BackofficeUser::hashPassword($password));
        $result = $adapter->authenticate();
        
        if($result->isValid()) {
            // clear the existing data
            $auth = Zend_Auth::getInstance();
            $auth->clearIdentity();
            
            // get the user row
            $user = $adapter->getResultRowObject(NULL, 'password');
            
            // check if the password has expired
            $auth->getStorage()->write($user);
            
            $this->update(
                array(
                    'last_login' => new Zend_Db_Expr('NOW()')
                ), 
                $this->_db->quoteInto('id = ?', $user->id)
            );
            
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * Changes the current user's password
     * 
     * @param string $password 
     * @access public
     * @return void
     */
    public function changePassword($password){
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Zend_Exception('You must have one authenticated user in the application in order to be able to call this method');
        }
        
        $user = Zend_Auth::getInstance()->getIdentity();
        
        $password = BackofficeUser::hashPassword($password);
        
        $passwordLogModel = new PasswordLog();
        $passwordLogModel->savePassword($password);
        
        $this->update(
            array(
                'password' => $password,
                'last_password_update' => new Zend_Db_Expr('NOW()'),
                'password_valid' => 1
            ),
            $this->_db->quoteInto('id = ?', $user->id)
        );
    }
    
    /**
     * Updates the user's profile. 
     * 
     * @param array $data 
     * @access public
     * @return void
     */
    public function updateProfile(array $data){
        $user = Zend_Auth::getInstance()->getIdentity();
        $data['id'] = $user->id;
        
        $this->save($data);
    }
    
    /**
     * Overrides save() in App_Model
     * 
     * @param array $data 
     * @access public
     * @return int
     */
    public function save($data){
        $id = parent::save($data);
        if (isset($data['groups']) && is_array($data['groups']) && !empty($data['groups'])) {
            $groups = $data['groups'];
        } else {
            $groups = array();
        }
        
        $userGroupModel = new BackofficeUserGroup();
        $userGroupModel->saveForUser($groups, $id);
        
        return $id;
    }
    
    /**
     * Overrides insert() in App_Model
     * 
     * @param array $data 
     * @access public
     * @return int
     */
    public function insert($data){
        $data['last_password_update'] = new Zend_Db_Expr('NOW()');
        $data['password'] = BackofficeUser::hashPassword($data['password']);
        $data['password_valid'] = 0;
        
        return parent::insert($data);
    }
    
    /**
     * Hashes a password using the salt in the app.ini
     *
     * @param string $password 
     * @static
     * @access public
     * @return string
     */
    public static function hashPassword($password){
        $config = Zend_Registry::get('config');
        return sha1($config->backoffice->security->passwordsalt . $password);
    }
    
    /**
     * Overrides getAll() in App_Model
     * 
     * @param int $page 
     * @access public
     * @return Zend_Paginator
     */
    public function findAll($page = 1){
        $paginator = parent::findAll($page);
        $items = array();
        
        $userGroupModel = new BackofficeUserGroup();
        
        foreach ($paginator as $item) {
            $item['groups'] = array();
            
            foreach($userGroupModel->findByUserId($item['id'], TRUE) as $group) {
                $item['groups'][$group['id']] = $group['name'];
            }
            
            $items[] = $item;
        }
        
        return Zend_Paginator::factory($items);
    }
    
    /**
     * Overrides findById() in App_Model
     * 
     * @param int $userId 
     * @access public
     * @return array
     */
    public function findById($userId){
        $row = parent::findById($userId);
        if(!empty($row)){
            $row['groups'] = array();
            
            $userGroupModel = new BackofficeUserGroup();
            
            foreach($userGroupModel->findByUserId($userId, TRUE) as $group){
                $row['groups'][$group['id']] = $group['name'];
            }
        }
        
        return $row;
    }
    
    /**
     * Overrides delete() in App_Model.
     *
     * When an user is deleted, all associated objects are also
     * deleted
     * 
     * @param mixed $where 
     * @access public
     * @return int
     */
    public function delete($where){
        if (is_numeric($where)) {
            $where = $this->_primary . ' = ' . $where;
        }
        
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        $select->where($where);
        
        $rows = $this->_db->fetchAll($select);
        $userGroupModel = new BackofficeUserGroup();
        
        foreach ($rows as $row) {
            $userGroupModel->deleteByUserId($row['id']);
        }
        
        return parent::delete($where);
    }
}