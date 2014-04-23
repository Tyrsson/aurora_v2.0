<?php

/**
 * CategoryPages
 *  
 * @author jsmith
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class System_Db_CategoryPage extends System_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'category_pages';
    protected $_sequence = true;
    protected $_primary = 'id'; 
    
    /**
     * Associative array map of declarative referential integrity rules.
     * This array has one entry per foreign key in the current table.
     * Each key is a mnemonic name for one reference rule.
     *
     * Each value is also an associative array, with the following keys:
     * - columns = array of names of column(s) in the child table.
     * - refTableClass = class name of the parent table.
     * - refColumns = array of names of column(s) in the parent table,
     * in the same order as those in the 'columns' entry.
     * - onDelete = "cascade" means that a delete in the parent table also
     * causes a delete of referencing rows in the child table.
     * - onUpdate = "cascade" means that an update of primary key values in
     * the parent table also causes an update of referencing
     * rows in the child table.
     *
     * @var array
     */
        protected $_referenceMap = array(
            'CategoryPages' => array(
                'columns' => array(
                    'categoryId'
                ),
                'refTableClass' => 'System_Db_Categories',
                'refColumns' => array(
                    'categoryId'
                ),
                'onDelete' => 'cascade',
                'onUpdate' => 'cascade'
             )
        );
    
}
