<?php
/**
 * DB table for managing the billing schedules
 *
 *
 * @category App
 * @package App_Table
 * @copyright Company
 */

class App_Table_Examples extends App_Table
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
    protected $_name = 'examples';
    
    /**
     * Holds the associated model class
     * 
     * @var string
     * @access protected
     */
    protected $_rowClass = 'App_Model_Example';
    
    protected $_referenceMap    = array(
        'Lorem' => array(
            'columns'           => 'lorem_id',
            'refTableClass'     => 'App_Table_Lorems',
            'refColumns'        => 'id'
        ),
    );
}