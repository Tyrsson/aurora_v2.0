<?php
class System_Db_NestedSet_Node extends System_Db_Table_Row_Abstract
                             implements System_Db_TreeNodeInterface,
                                        RecursiveIterator,
                                        Countable
{

    const NODE_PATH_SEPARATOR = ':';
    
    /**
     * List of child nodes
     *
     * @var System_Db_Tree_NestedSet_NodeIterator
     */
	public $_children = null;

	/**
	 * The parent node
	 *
	 * @var System_Db_Tree_NodeInterface
	 */
	protected $_parent = null;
	
	/**
	 * Setup the node
	 *
	 * @todo Enable writing to the db from a node object under certain
	 *        conditions. We set nodes read only because we cannot have unique
	 *        left and right values, manually altering a node could possibly
	 *        corrupt a tree.
	 * @param array $config
	 */
	public function __construct(array $config = array())
	{
		parent::__construct($config);
		if(isset($config['children']) && is_array($config['children'])) {
            $this->addChildren($config['children']);
		} else {
		    $this->_children = array();
		}		
		$this->setReadOnly(true);
	}

	/**
	 * Set the parent node
	 *
	 * @param System_Db_TreeNodeInterface $node
	 */
	public function setParent(System_Db_TreeNodeInterface $node)
	{
	    $this->_parent = $node;
	}
	
	/**
	 * Get the parent node
	 *
	 * @return System_Db_Tree_NodeInterface
	 */
	public function getParent()
	{
	    return $this->_parent;
	}	

	/**
	 * Get's the table to which this node is associated with
	 *
	 * @return System_Db_Tree_NestedSet
	 * @see System_Db_Table_Row_Abstract#getTable()
	 */
	public function getTable()
	{
		return parent::getTable();
	}

	/**
	 * return whether or not this is a leaf node
	 *
	 * @return bool
	 */
    public function isLeaf()
    {
        $lft = $this->_table->getLeftKey();
        $rgt = $this->_table->getRightKey();
        return (($this->$rgt - $this->$lft) == 1) ? true : false;        
    }

    /**
     * Return whether or not this is a root node
     *
     * @return bool
     */
    public function isRoot()
    {
    	$lft = $this->_table->getLeftKey();
        return ($this->$lft == 1) ? true : false;
    }

    /**
     * Return whether or not this node has children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->count() > 0;
    }
    
    /**
     * Adds a child table row object
     * 
     * @param unknown_type $child
     */
    public function addChild($child)
    {
        if($child instanceof System_Db_TreeNodeInterface) {
            $child->setParent($this);
            $this->_children[] = $child;
         } else {
             throw new RuntimeException('Not instance of System_Db_Tree_NodeInterface');
         }
    }
    
    /**
     * Adds a set of table row objects as children
     * 
     * @param unknown_type $children
     */
    public function addChildren($children)
    {
        if(is_array($children)) {            
            // its an array, just attach each array member            
            foreach ($children as $child) {
                if($child instanceof System_Db_TreeNodeInterface) {
                    $this->addChild($child);
                    continue;
                } 
                if (is_array($child)) {
                    $child = $this->getTable()->createRow($child);
                    $this->addChild($child);
                } else {
                    throw new RuntimeException('Not array or not instance of System_Db_NodeInterface');
                }
            }
        } else {
            throw new RuntimeException('Nodes supplied as unsupported format.');
        }
    }   
    /**
     * Completes interface
     */
//     public function hasChildren()
//     {
//         return is_array($this->_children[$this->key()]);
//     }
    /**
     * Get the container of children
     *
     * @return mixed|System_Db_Tree_NestedSet_BranchIterator|null
     */
    public function getChildren()
    {
        if(isset($this->_children[$this->key()])) {
            $children = $this->_children[$this->key()];
            //Zend_Debug::dump($children, '$children from node row');
            //die(__FILE__ . ' :: ' . __LINE__);
            return $children;
        }
        return null;
    }
    
    /**
     * Completes interface
     */
    public function count()
    {
        $count =  count($this->_children);
        return $count;
    }

    /**
     * Completes interface
     */
    public function current()
    {
        return current($this->_children);
    }

    /**
     * Completes interface
     */
    public function key()
    {
        return key($this->_children);
    }

    /**
     * Completes interface
     */
    public function next()
    {
        next($this->_children);
    }

    /**
     * Completes interface
     */
    public function rewind()
    {
        reset($this->_children);
    }

    /**
     * Completes interface
     */
    public function valid()
    {
        $key = key($this->_children);
        $current = current($this->_children);
        $valid = current($this->_children) !== false;
        return $valid;
    }

    /**
     * Return the path to this node as an array of column values, the column
     * value to return cannot be primary key, left or right identifiers.
     * 
     * @param string $column
     * @return System_Db_TreeBranchInterface $path collection of path nodes
     */
    public function getPath($column = null)
    {        
        $select = $this->_table->select();
        $tableName = $this->_table->info(Zend_Db_Table::NAME);
        $lft = $this->_table->getLeftKey();
        $rgt = $this->_table->getRightKey();
        $primary = $this->_table->info(Zend_Db_Table::PRIMARY);
        
        if($column == null ||
           $column == $primary[1] ||
           $column == $lft ||
           $column == $rgt)
        {
            throw new System_Db_NestedSet_Exception(
                'Column cannot be null, primary, left or right.'
            );       
        }
        if (!in_array($column, $this->_table->info(Zend_Db_Table::COLS))) {
            throw new System_Db_NestedSet_Exception('Unknown column.');
        }
                       
        $select->from(array('p' => $tableName),
                      array($column))
               ->join(array('n' => $tableName),
                      "n.{$lft} BETWEEN p.{$lft} AND p.{$rgt} " .
                      "AND n.{$column} = {$this->_table->getAdapter()->quote($this->$column)}")
               ->order("p.{$lft}");               
               
        return $this->_table->fetchAll($select);                
    }

    /**
     * Reutrns whether the node has descendant nodes
     * 
     * @return bool
     */
    public function hasDescendants()
    {
        $lft = $this->_table->getLeftKey();
        $rgt = $this->_table->getRightKey();
        return (($this->$rgt - $this->$lft) > 1) ? true : false;        
    }
    
    /**
     * Return the immediate descendants for this node. As an example, this would
     * be useful for getting all items in the next level of a category or menu.
     * 
     * @todo get immediate descendants only or option to get all?
     * @param string $column used for display/label e.g. categoryName
     * @return System_Db_TreeBranchInterface
     */
    public function getDescendants($column = null)
    {
        $select = $this->_table->select();
        $tableName = $this->_table->info(Zend_Db_Table::NAME);
        $lft = $this->_table->getLeftKey();
        $rgt = $this->_table->getRightKey();
        $parent = $this->_table->getParentKey();
        $primary = $this->_table->info(Zend_Db_Table::PRIMARY);
        
        if($column == null ||
           $column == $primary[1] ||
           $column == $lft ||
           $column == $rgt)
        {
            throw new System_Db_NestedSet_Exception(
                'Column cannot be null, primary, left or right.'
            );       
        }
        if (!in_array($column, $this->_table->info(Zend_Db_Table::COLS))) {
            throw new System_Db_NestedSet_Exception('Unknown column.');
        }
                          
         $subStr="(SELECT n.{$column}, (COUNT(p.{$column}) - 1) AS depth
                   FROM {$tableName} AS n,
                   {$tableName} AS p
                   WHERE n.{$lft} BETWEEN p.{$lft} AND p.{$rgt}
                   AND n.{$column} = {$this->_table->getAdapter()->quote($this->$column)}
                   GROUP BY n.{$column}
                   ORDER BY n.{$lft})";
         $subSelect = new Zend_Db_Expr($subStr);
         
         $select->setIntegrityCheck(false);
         $select->from(array('n' => $tableName),
                       array(
                           "n.{$column}",
                           "n.{$primary[1]}",
                           "n.{$lft}",
                           "n.{$rgt}",
                           "n.{$parent}",
                           "(COUNT(p.{$column})-(st.depth+1)) as depth")
                       )
                ->from(array('p' => $tableName),
                       array())
                ->from(array('sp'=> $tableName),
                       array())
                ->from(array('st'=> $subSelect),
                       array())
                ->where("n.{$lft} BETWEEN p.{$lft} AND p.{$rgt}
                         AND n.{$lft} BETWEEN sp.{$lft} AND sp.{$rgt}
                         AND sp.{$column} = st.{$column}
                         AND depth = 1")
                ->group("n.{$column}")
                ->having('depth = 1')
                ->order("n.{$lft}");
                
         return $this->_table->fetchAll($select);
    }

    /**
     * Return all the siblings of this node.
     * 
     * @return System_Db_TreeBranchInterface 
     */
    public function getSiblings()
    {
        $select = $this->_table->select();
        $parent = $this->_table->getParentKey();
        $select->where($parent . '=?', $this->$parent);
        
        if ($this->_table->isMultiRoot()) {
            $root = $this->_table->getRootKey();
            $select->where($root . '=?', $this->$root);
        }
        
        $lft = $this->_table->getLeftKey();
        $select->where($lft . '!=?', $this->$lft)
               ->order($lft);
        
        return $this->_table->fetchAll($select);
    }
}