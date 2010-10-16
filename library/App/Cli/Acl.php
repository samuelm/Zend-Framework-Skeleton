<?php
/**
 * Creates automatic inserts for the ACL tool
 *
 * @category App
 * @package App_Cli
 * @subpackage App_Cli_Acl
 * @copyright Company
 */

class App_Cli_Acl 
{
    /**
     * Singleton instance
     * 
     * @static
     * @var App_Cli_Acl
     * @access protected
     */
    protected static $_instance;
    
    /**
     * Database adapter
     * 
     * @var Zend_Db_Adapter_Abstract
     * @access protected
     */
    protected $_db;
    
    /**
     * Inits the object with the default db adapter
     * 
     * @access protected
     * @return void
     */
    protected function __construct(){
        $this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }
    
    /**
     * Returns a singleton instance
     * 
     * @static
     * @access public
     * @return void
     */
    public static function getInstance(){
        if (NULL === self::$_instance) {
            self::$_instance = new App_Cli_Acl();
        }
        
        return self::$_instance;
    }
    
    /**
     * Overrides the __clone() magic method in order
     * to prevent cloning of this object
     * 
     * @access public
     * @return void
     */
    public function __clone(){
        throw new Zend_Exception('Cloning singleton objects is forbidden');
    }
    
    /**
     * Generates an array of SQL insert statements that 
     * will save the current 
     * 
     * @param array $resources 
     * @access public
     * @return string
     */
    public function generateInserts(array $resources){
        $quotedName = $this->_db->quoteIdentifier('name');
        $quotedDescription = $this->_db->quoteIdentifier('description');
        $quotedResourceTable = $this->_db->quoteIdentifier('backoffice_resources');
        
        $insertResourceTemplate = sprintf(
            'INSERT IGNORE INTO %s (%s, %s) VALUES (?, ?);',
            $quotedResourceTable,
            $quotedName,
            $quotedDescription
        );
        
        $selectResourceTemplate = sprintf(
            'SET @resource_id := (SELECT id FROM %s WHERE %s = ?);',
            $quotedResourceTable,
            $quotedName
        );
        
        $insertPrivilegeTemplate = '(@resource_id, %s, %s)';
        
        $inserts = array();
        foreach ($resources as $resource) {
            // ready the insert resource query
            $insertResourceSql = $this->_db->quoteInto($insertResourceTemplate, $resource['name'], NULL, 1);
            $insertResourceSql = $this->_db->quoteInto($insertResourceSql, $resource['description'], NULL, 1);
            
            // ready the select resource query
            $selectResourceSql = $this->_db->quoteInto($selectResourceTemplate, $resource['name']);
            
            // ready the insert privilege query
            $insertPrivilegeSql = sprintf(
                'INSERT IGNORE INTO %s (%s, %s, %s) VALUES ',
                $this->_db->quoteIdentifier('backoffice_privileges'),
                $this->_db->quoteIdentifier('resource_id'),
                $quotedName,
                $quotedDescription
            );
            
            $insertPrivilegeSqlParts = array();
            
            foreach ($resource['methods'] as $method) {
                $insertPrivilegeSqlParts[] = sprintf(
                    $insertPrivilegeTemplate,
                    $this->_db->quote($method['name']),
                    $this->_db->quote($method['description'])
                );
            }
            $inserts[] = $insertResourceSql . PHP_EOL .
                         $selectResourceSql . PHP_EOL .
                         $insertPrivilegeSql . PHP_EOL . 
                         "\t" . implode(',' . PHP_EOL . "\t", $insertPrivilegeSqlParts) . ';' . PHP_EOL;
        }
        
        return $inserts;
    }
}