<?php
/**
 * Default application wide controller parent class
 *
 * @category App
 * @package App_FlagFlippers
 * @copyright Company
 */

/**
 * Handle different operations with the ACL and the functionality deploy
 */
class App_FlagFlippers_Manager
{
    public static $indexKey = 'FlagFlippers';
    private static $_membersAllowedResources = array(
        'index',
    );
    
    /**
     * Load the ACL to the Registry if is not there
     * 
     * This function takes care about generating the acl from the db
     * if the info is not in the registry and/or memcache.
     * 
     * If the acl is inside memcache we load it from there.
     * 
     * @return void
     */
    public static function load(){
        if(!App_FlagFlippers_Manager::_checkIfExist()){
            if(!$acl = App_FlagFlippers_Manager::_getFromMemcache()){
                $acl = App_FlagFlippers_Manager::_generateFromDb();
                App_FlagFlippers_Manager::_storeInMemcache($acl);
            }
            
            App_FlagFlippers_Manager::_storeInRegistry($acl);
        }
    }
    
    /**
     * Regenerate the Acl from the DB and update memcache and Zend_Registry
     *
     * @return boolean
     */
    public static function save(){
        $acl = App_FlagFlippers_Manager::_generateFromDb();
        App_FlagFlippers_Manager::_storeInMemcache($acl);
        App_FlagFlippers_Manager::_storeInRegistry($acl);
    }
    
    /**
     * Check if a role is allowed for a certain resource
     *
     * @param string $role 
     * @param string $resource 
     * @return boolean
     */
    public function isAllowed($role, $resource = NULL, $action = NULL){
        return App_FlagFlippers_Manager::_getFromRegistry()->isAllowed($role, $resource, $action);
    }
    
    /**
     * Check if the acl exists in Zend_Registry
     *
     * @return boolean
     */
    private function _checkIfExist(){
        return Zend_Registry::isRegistered(App_FlagFlippers_Manager::$indexKey);
    }
    
    /**
     * Get Acl from Registry
     *
     * @return void
     */
    private static function _getFromRegistry(){
        if(App_FlagFlippers_Manager::_checkIfExist()){
            return Zend_Registry::get(App_FlagFlippers_Manager::$indexKey);
        }
        
        return FALSE;
    }
    
    /**
     * Retrieve the acl from memcache
     *
     * @return Zend_Acl | boolean
     */
    private static function _getFromMemcache(){
        $cacheHandler = Zend_Registry::get('Zend_Cache_Manager')->getCache('memcache');
        
        if($acl = $cacheHandler->load(App_FlagFlippers_Manager::$indexKey)){
            return $acl;
        }
        
        return FALSE;
    }
    
    /**
     * Generate the Acl object from the permission file
     *
     * @return Zend_Acl
     */
    private static function _generateFromDb(){
        $aclObject = new Zend_Acl();
        $aclObject->deny();
        
        //Add all groups
        $groupModel = new Group();
        $groups = $groupModel->fetchAllThreaded();
        
        foreach($groups as $group){
            if($group['parent_name']){
                $aclObject->addRole(new Zend_Acl_Role($group['name']), $group['parent_name']);
            }else{
                $aclObject->addRole(new Zend_Acl_Role($group['name']));
            }
        }
        
        //Add all users
        $userModel = new User();
        $users = $userModel->findAll();
        
        foreach($users as $user){
            $aclObject->addRole(new Zend_Acl_Role($user['username']), $user['groups']);
        }
        
        //Add all resources
        $resourceModel = new Resource();
        $resources = $resourceModel->fetchAll();
        
        foreach($resources as $resource){
            $aclObject->addResource(new Zend_Acl_Resource($resource['name']));
        }
        
        $aclObject->addResource('error');
        
        //Populate the ACLs
        $aclModel = new Acl();
        $acls = $aclModel->fetchFullData();
        
        foreach($acls as $acl){
            if($acl['allow']){
                $aclObject->allow($acl['group_name'], $acl['resource_name'], $acl['privilege_name']);
            } else {
                $aclObject->deny($acl['group_name'], $acl['resource_name'], $acl['privilege_name']);
            }
        }
        
        //Hardcode basic paths for members
        foreach(App_FlagFlippers_Manager::$_membersAllowedResources as $resource){
            $aclObject->allow('members', $resource);
        }
        
        //Everbody can see the errors
        $aclObject->allow(null, 'error');
        
        //Admins are allowed everywhere
        $aclObject->allow('administrators');
        
        return $aclObject;
    }
    
    /**
     * Store the Acl in memcache
     *
     * @return void
     */
    private static function _storeInMemcache($acl = NULL){
        if(is_null($acl) && App_FlagFlippers_Manager::_checkIfExist()){
            $acl = App_FlagFlippers_Manager::_getFromRegistry();
        }
        
        if(empty($acl)){
            throw new Exception('You must provide a valid Acl in order to store it');
        }
        
        $cacheHandler = Zend_Registry::get('Zend_Cache_Manager')->getCache('memcache');
        
        $cacheHandler->save($acl, App_FlagFlippers_Manager::$indexKey);
    }
    
    /**
     * Store the Acl in the Registry
     *
     * @return void
     */
    private static function _storeInRegistry($acl){
        Zend_Registry::set(App_FlagFlippers_Manager::$indexKey, $acl);
    }
}