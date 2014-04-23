<?php

/**
 * Page
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class System_Db_Page extends System_Db_Table_Abstract
{
    public $form;
    
    public $formSchema;
    
    /**
     * The default table name
     */
    protected $_name = 'pages';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    /**
     * Classname for row
     *
     * @var string
     */
    protected $_rowClass = 'System_Db_NestedSet_Node';
    
    /**
     * Classname for rowset
     *
     * @var string
     */
    protected $_rowsetClass = 'System_Db_NestedSet_Branch';
    
    //     protected $_dependentTables = array(
    //         'System_Db_PageCategories'
    //     );
    
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
     * 
     * 
     * // CategoryPages
     * 
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
    
    public $log;
    
    public function init()
    {
        $this->log = Zend_Registry::get('log');
        //$this->collections = new Page_Model_Collections();
        //$this->collectionMapping = new Page_Model_CollectionMapping();
    }
    public function map(array $data)
    {
        try {
            $row = $this->collectionMapping->fetchNew();
            $row->setFromArray($data);
            $row->save();
        } catch (Exception $e) {
            $this->log->crit($e);
        }
    }
    public function fetchTotalPageCount()
    {
        return count($this->fetchAll());
    }
    
    public function getPagesForOrder()
    {
        $query = $this->select()
        ->from($this->_name, array(
            'id',
            'label',
            'pageOrder'
        ))
        ->order('pageOrder ASC');
        return $this->fetchAll($query);
    }
    
    public function fetchById($id)
    {
        $query = $this->select()->where('id = ?', $id);
        return $this->fetchRow($query);
    }
    
    public function fetchParentDropDown()
    {
        $noParent = array();
    
        $query = $this->select()->from($this->_name, array(
            'key' => 'id',
            'value' => 'label'
        ));
        $result = $this->fetchAll($query)->toArray();
        // Zend_Debug::dump($result);
        array_unshift($result, array(
        'key' => 0,
        'value' => 'No Parent'
            ));
    
        return $result;
    }
    
    public function fetchPageFileByFileName($fileName)
    {
        $files = new Page_Model_Files();
        return $files->fetchFileName($fileName);
    }
    
    public function fetchForEditByUri($uri)
    {
        $query = $this->select()->from($this->_name)->where('uri = ?', $uri);
        return $this->fetchRow($query);
    }
    
    public function fetchMainMenu($options = null, $keys = null)
    {
        if ($options == null) {
            $options['visibility'] = 'Public';
        }
        if ($keys == null) {
            $keys = array(
                'id',
                'role',
                'label',
                'uri',
                'visibility',
                'createdDate',
                'modifiedDate',
                'archivedDate',
                'pageOrder',
                'content'
            );
        }
        $query = $this->select()->from($this->_name, $keys);
        return $this->fetchAll($query);
    }
    
    public function fetchByName($name)
    {
        $query = $this->select()
        ->from($this->_name, array(
            'id',
            'role',
            'label',
            'uri',
            'visibility',
            'createdDate',
            'modifiedDate',
            'archivedDate',
            'pageOrder',
            'content',
            'keyWords'
        ))
        ->where('label = ?', $name);
        return $this->fetchRow($query);
    }
    
    public function fetchByUri($uri)
    {
        $query = $this->select()->from($this->_name)->where('uri = ?', $uri);
        return $this->fetchRow($query);
    }
    
    public function fetchIdByName($name)
    {
        $query = $this->select()->from($this->_name, array('id'))->where('label = ?', $name);
        return $this->fetchRow($query);
    }
    
    public function fetchPageNames()
    {
        $query = $this->select()->from($this->_name, array(
            'label'
        ));
        return $this->fetchAll($query);
    }
    
    public function fetchSearchData()
    {
        // rewrite this into a join to support searching by author
        try {
            $select = $this->select()->from($this->_name, array(
                'id',
                'role',
                'label',
                'uri',
                'visibility',
                'createdDate',
                'content'
            ));
            return $this->fetchAll($select);
        } catch (Exception $e) {
            $this->log->alert($e->getMessage() . ' ::Error Location:: File:: ' . $e->getFile() . ' :: Line:: ' . $e->getLine());
        }
    }
    /**
     * @see System_Db_Table_Form_Interface::getForm()
     */
    public function getForm(Array $columns = null)
    {
        $columnTypes = array();
        $columns = array(
            'id',
            'label'
        );
        $this->form = new Zend_Dojo_Form($this->_name);
        $this->formSchema = $this->getAdapter()->describeTable($this->_name);
        // Zend_Debug::dump(self::VAR_CHAR);
        if ($columns !== null) {}
        return $this->form;
    }
    
    public function getFormSchema()
    {
        return $this->formSchema;
    }
}
