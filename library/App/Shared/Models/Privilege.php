<?php
/**
 * Model that manages the privileges
 *
 * @package backoffice_models
 * @copyright Company
 */

class Privilege extends App_Model
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
    protected $_name = 'backoffice_privileges';
    
    /**
     * Finds a privilege based on its name and the id of the
     * resource it belongs to
     * 
     * @param string $name 
     * @param int $resourceId 
     * @access public
     * @return void
     */
    public function findByNameAndResourceId($name, $resourceId){
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        $select->where('name = ?', $name);
        $select->where('resource_id = ?', $resourceId);
        
        return $this->_db->fetchRow($select);
    }
    
    /**
     * Retrieves all the privileges attached to
     * the specified resource
     * 
     * @param mixed $resourceId 
     * @access public
     * @return void
     */
    public function findByResourceId($resourceId){
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        $select->where('resource_id = ?', $resourceId);
        
        return $this->_db->fetchAll($select);
    }
}