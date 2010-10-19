<?php
/**
 * Model for managing the Flippers in the application.
 *
 * It operates according to the following rules:
 * - each controller is considered a resource
 * - each controller action is considered a privilege
 * - each user group is considered to be a role
 *
 * For details, see http://framework.zend.com/manual/en/zend.acl.introduction.html
 *
 * @package backoffice_models
 * @copyright Company
 */

class Flipper extends App_Model
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
    protected $_name = 'flippers';
    
    /**
     * Finds all the Flippers associated with a certain group
     * 
     * @param int $groupId 
     * @access public
     * @return void
     */
    public function findByGroupId($groupId){
        $select = new Zend_Db_Select($this->_db);
        $select->from($this->_name);
        $select->where('group_id = ?', $groupId);
        
        return $this->_db->fetchAll($select);
    }
    
    /**
     * Returns the full Flippers data
     * 
     * @access public
     * @return void
     */
    public function fetchFullData(){
        $select = new Zend_Db_Select($this->_db);
        $select->from(array('a' => $this->_name));
        $select->join(array('p' => 'privileges'), 'a.privilege_id = p.id');
        $select->join(array('f' => 'flags'), 'a.flag_id = f.id');
        $select->join(array('g' => 'groups'), 'a.group_id = g.id');
        $select->reset(Zend_Db_Table::COLUMNS);
        $select->columns(
            array(
                'a.*', 
                'p.name AS privilege_name', 
                'f.name AS flag_name', 
                'g.name AS group_name',
            )
        );
        
        return $this->_db->fetchAll($select);
    }
    
    /**
     * Saves the permissions for a group
     * 
     * @param array $data 
     * @access public
     * @return void
     */
    public function savePermissions($data){
        foreach ($data['flipper'] as $resourceId => $privileges) {
            foreach($privileges as $privilegeId => $allow) {
                if ($allow) {
                    try {
                        $this->insert(array(
                            'group_id' => $data['group_id'],
                            'flag_id' => $resourceId,
                            'privilege_id' => $privilegeId,
                            'allow' => 1
                        ));
                    }catch(Zend_Exception $ze){
                        // nothing special, just a duplicate key
                    }
                } else {
                    $this->delete(array(
                        'group_id' => $data['group_id'],
                        'flag_id' => $resourceId,
                        'privilege_id' => $privilegeId,
                    ));
                }
            }
        }
    }
    
    /**
     * Deletes all associations with the given privilege id
     * 
     * @param int $privilegeId
     * @access public
     * @return void
     */
    public function deleteByPrivilegeId($privilegeId){
        $this->delete($this->_db->quoteInto('privilege_id = ?', $privilegeId));
    }
}