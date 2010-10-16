<?php
/**
 * Form for editing groups per user
 *
 * @category backoffice
 * @package backoffice_forms
 * @copyright Company
 */

class GroupPermissionsForm extends App_Backoffice_Form
{
    /**
     * Overrides init() in Zend_Form
     * 
     * @access public
     * @return void
     */
    public function init() {
        // init the parent
        parent::init();
        
        // set the form's method
        $this->setMethod('post');
        
        $resourceModel = new Resource();
        $resources = $resourceModel->getAllResourcesAndPrivileges();
        
        foreach ($resources as $resource) {
            $displayGroup = array();
            foreach ($resource['privileges'] as $privilege) {
                $checkbox = new Zend_Form_Element_Checkbox('acl_' . $resource['id'] . '_' . $privilege['id']);
                $checkbox->setOptions(
                    array(
                        'label' => '/' . $resource['name'] . '/' . $privilege['name'] . '/ (' . $privilege['description'] . ' )',
                    )
                );
                $this->addElement($checkbox);
                $displayGroup []= $checkbox->getName();
            }
            
            $displayGroupTitle = ucfirst($resource['name']) . ' ( ' . $resource['description'] . ' )';
            $this->addDisplayGroup($displayGroup, $resource['name'])
                 ->getDisplayGroup($resource['name'])
                 ->setLegend($displayGroupTitle);
        }
        
        $groupId = new Zend_Form_Element_Hidden('group_id');
        $groupId->setOptions(
            array(
                'validators' => array(
                    // either empty or numeric
                    new Zend_Validate_Regex('/^\d*$/'),
                ),
            )
        );
        $this->addElement($groupId);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setOptions(
            array(
                'label'      => 'Save permissions',
                'required'   => true,
            )
        );
        $this->addElement($submit);
    }
    
    /**
     * Overrides populate() in Zend_Form
     * 
     * @param array $data 
     * @access public
     * @return void
     */
    public function populate(array $data){
        $parsed = array('group_id' => $data['group_id']);
        unset($data['group_id']);
        
        foreach ($data as $acl) {
            if ($acl['allow']) {
                $parsed['acl_' . $acl['resource_id'] . '_' . $acl['privilege_id']] = 1;
            }
        }
        
        parent::populate($parsed);
    }
    
    /**
     * Overrides getValues() in Zend_Form
     * 
     * @access public
     * @return array
     */
    public function getValues(){
        $raw = parent::getValues();
        $values = array(
            'group_id' => $raw['group_id'],
            'acl' => array(
            ),
        );
        
        foreach ($raw as $key => $value) {
            if (preg_match('/^acl_([0-9]{1,})_([0-9]{1,})$/', $key)) {
                $parts = explode('_', $key);
                if (!isset($values['acl'][$parts[1]])) {
                    $values['acl'][$parts[1]] = array();
                }
                $values['acl'][$parts[1]][$parts[2]] = $value;
            }
        }
        
        return $values;
    }
}