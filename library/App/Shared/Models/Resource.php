<?php
/**
 * Model that manages the resources (controller names) for defining
 * the ACLs in the application
 *
 * @package backoffice_models
 * @copyright Company
 */

class Resource extends App_Model
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
    protected $_name = 'backoffice_resources';
    
    /**
     * Paths that are hardcoded in the application and should not
     * be displayed to the users for editing. These resources manage
     * very critical areas of the app
     * 
     * @var array
     * @access protected
     */
    protected $_hardcodedResources = array(
        'error',
        'index',
    );
    
    public function init(){
        $this->_db = Zend_Registry::get('dbAdapter');
    }
    
    /**
     * Finds a resource based on its name
     * 
     * @param string $name 
     * @access public
     * @return void
     */
    public function findByName($name){
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        $select->where('name = ?', $name);
        
        return $this->_db->fetchRow($select);
    }
    
    /**
     * Returns an array with all resources and their associated
     * privileges
     * 
     * @access public
     * @return array
     */
    public function getAllResourcesAndPrivileges(){
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        
        $rows = $this->_db->fetchAll($select);
        
        $privilegeModel = new Privilege();
        
        foreach ($rows as $key => $row) {
            if (in_array($row['name'], $this->_hardcodedResources)) {
                unset($rows[$key]);
            } else {
                $rows[$key]['privileges'] = $privilegeModel->findByResourceId($row['id']);
            }
        }
        
        return $rows;
    }
    
    /**
     * Checks if a resource is registered. This is used only for
     * debugging purposes
     * 
     * @param string $resource 
     * @param string $privilege 
     * @access public
     * @return void
     */
    public function checkRegistered($resource, $privilege){
        $select = new Zend_Db_Select($this->_db);
        $select->from(array('r' => $this->_name));
        $select->join(array('p' => 'backoffice_privileges'), 'r.id = p.resource_id');
        $select->where('r.name = ?', $resource);
        $select->where('p.name = ?', $privilege);
        $select->reset(Zend_Db_Table::COLUMNS);
        $select->columns(array('COUNT(r.id)'));
        
        $count = $this->_db->fetchOne($select);
        
        return $count != 0;
    }
}