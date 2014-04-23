<?php
class System_Db_NestedSet_Branch extends Zend_Db_Table_Rowset_Abstract
                               implements System_Db_TreeBranchInterface
{

    /**
     * System_Db_Tree_NestedSet_NodeIterator
     *
     * @var RecursiveIteratorIterator
     */
    protected $_iterator = null;

	/* 
	 * 
	 */
	protected $_pages; 
	
	protected $navContainer; 
	
    /**
     * Constructor, passes config to parent constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }
    public function getNavigationContainer()
    {
        
    }
    public function setNavigationContainer($container) 
    {
        
    }
    public function getPages(array $node, $asArray = true)
    {
        $row = new $this->_rowClass(
            array(
                'table'    => $this->_table,
                'data'     => $node,
                'stored'   => $this->_stored,
                'readOnly' => $this->_readOnly
            )
        );
        $table = $this->getTable();
        if($asArray) {
            return $row->findDependentRowSet('System_Db_Page', 'CategoryPages', $table->select()->where('isLanding != ?', 1))->toArray();
        } else {
            return $row->findDependentRowSet('System_Db_Page', 'CategoryPages', $table->select()->where('isLanding != ?', 1));
        }
        
    }
    public function setPages($node = null, $pages)
    {
        
    }
    public function toNavigation($startNode = 'Site', $children = true)
    {
        $container = Zend_Registry::get('Zend_Navigation');
        // temp container to allow targeting a particular node
        $nested = new Zend_Navigation();
        $nested->addPages($this->toZendArray());
        // find the start node by its label
        $target = $nested->findOneBy('label', $startNode);
        // add the target to the main navigation container
        if(!$children) {
            foreach ($target->pages as $page) {
                foreach($page as $hidden) {
                    $hidden->visible = false;
                    continue;
                }
                continue;
            }
            $container->addPages($target->pages);
        }
        else {
            $container->addPages($target->pages);
        }
        
    }
    public function toPageManagerNavigation()
    {
        
        $container = new Zend_Navigation();

        $container->addPages($this->toZendArray());

        return $container;
    }
    public function toSubNavigation($uri, $children = true)
    {
        // temp container to allow targeting a particular node
        $nested = new Zend_Navigation();
        $nested->addPages($this->toZendArray());
        // find the start node by its label
        $target = $nested->findOneBy('uri', $uri);
        return $target;
//         // add the target to the main navigation container
//         if(!$children) {
//             foreach ($target->pages as $page) {
//                 foreach($page as $hidden) {
//                     $hidden->visible = false;
//                     continue;
//                 }
//                 continue;
//             }
//             $container->addPages($target->pages);
//         }
//         else {
//             $container->addPages($target->pages);
//         }
    }
    public function toZendArray()
    {
        $tree = array();
        $ref = array();
        $tableInfo = $this->getTable()->info();
        $primary = $tableInfo['primary'][1];
        $parent = $this->getTable()->getParentKey();
    
        // TODO fallback to recursion to build the array if no parent column
        if(!in_array($parent, $tableInfo['cols'])) {
            throw new RuntimeException(
                'Cannot build multi-dimensional array. Table has no parent column.'
            );
        }
        
        foreach ($this->_data as $node) {

            $node['pages'] = array();
            if (isset($ref[$node[$parent]])) {
                
                
                if(isset($ref[$node[$parent]]['categoryName'])) {
                    $ref[$node[$parent]]['label'] = $ref[$node[$parent]]['categoryName'];
                }
                
                
                $ref[$node[$parent]]['pages'][$node[$primary]] = $node;
    
                
                $row = new $this->_rowClass(
                            array(
                                'table'    => $this->_table,
                                'data'     => $ref[$node[$parent]]['pages'][$node[$primary]],
                                'stored'   => $this->_stored,
                                'readOnly' => $this->_readOnly
                            )
                        );
                
                $contentPages = $row->findDependentRowSet('System_Db_Page', 'CategoryPages')->toArray();
               // Zend_Debug::dump($contentPages);
                $ref[$node[$parent]]['pages'][$node[$primary]]['label'] = $ref[$node[$parent]]['pages'][$node[$primary]]['categoryName'];
                
                if(count($contentPages) > 0) {
                    //Zend_Debug::dump($contentPages);
                    $index = count($contentPages);
                    for ($offset = 0; $offset < $index; $offset++) {
                        
                        $ref[$node[$parent]]['pages'][$node[$primary]]['pages'][$offset] = $contentPages[$offset];
                        
//                         if( !$contentPages[$offset]['isLanding']) {
//                             $ref[$node[$parent]]['pages'][$node[$primary]]['pages'][$offset] = $contentPages[$offset];
//                             //Zend_Debug::dump($ref[$node[$parent]]['pages'][$node[$primary]]['pages'][$offset]);
//                         }
                        continue;
                    }
                }
                
                $ref[$node[$primary]] = & $ref[$node[$parent]]['pages'][$node[$primary]];
                
            } else {
                $tree[$node[$primary]] = $node;
                
                $ref[$node[$primary]] = & $tree[$node[$primary]];
                
                if(isset($ref[$node[$primary]]['categoryName'])) {
                    $ref[$node[$primary]]['label'] = $ref[$node[$primary]]['categoryName'];
                }
                
            }
            continue;
        }
        //return array_reverse($tree, false);
        //Zend_Debug::dump($tree);
        return $tree;
    }
    public function toDojoStore()
    {
        $tree = array();
        $ref = array();
        $tableInfo = $this->getTable()->info();
        $primary = $tableInfo['primary'][1];
        $parent = $this->getTable()->getParentKey();
        
        // TODO fallback to recursion to build the array if no parent column
        if(!in_array($parent, $tableInfo['cols'])) {
            throw new RuntimeException(
                'Cannot build multi-dimensional array. Table has no parent column.'
            );
        }
        foreach ($this->_data as $node) {
            $node['pages'] = array();
            if (isset($ref[$node[$parent]])) {
        
                $ref[$node[$parent]]['pages'][$node[$primary]] = $node;
        
                if(isset($ref[$node[$parent]]['categoryName'])) {
                    $ref[$node[$parent]]['label'] = $ref[$node[$parent]]['categoryName'];
                }
                $row = new $this->_rowClass(
                    array(
                        'table'    => $this->_table,
                        'data'     => $ref[$node[$parent]]['pages'][$node[$primary]],
                        'stored'   => $this->_stored,
                        'readOnly' => $this->_readOnly
                    )
                );
                $contentPages = @$row->findDependentRowSet('System_Db_Page', 'CategoryPages')->toArray();
                $ref[$node[$parent]]['pages'][$node[$primary]]['label'] = $ref[$node[$parent]]['pages'][$node[$primary]]['categoryName'];
                $ref[$node[$parent]]['pages'][$node[$primary]]['parent'] = $ref[$node[$parent]]['pages'][$node[$primary]]['categoryName'];
                
                if(count($contentPages) > 0) {
                    foreach($contentPages as $cp) {
                        
                        $cp['parent'] = $ref[$node[$parent]]['pages'][$node[$primary]]['categoryName'];
                        $ref[$node[$parent]]['pages'][$node[$primary]]['pages'][] = $cp;
                        continue;
                    }
                    
                }
                $ref[$node[$primary]] = & $ref[$node[$parent]]['pages'][$node[$primary]];
            } else {
                $tree[$node[$primary]] = $node;
                if(isset($ref[$node[$primary]]['categoryName'])) {
                    $ref[$node[$primary]]['label'] = $ref[$node[$primary]]['categoryName'];
                }
                $ref[$node[$primary]] = & $tree[$node[$primary]];
            }
        }
        return $tree;
    }
    /**
     * Return the rowset data as a multi-dimensional array
     *
     * @todo fallback to recursion to build the array if no parent column
     * @return array $tree
     */
    public function toMultiArray()
    {
        $tree = array();
        $ref = array();
        $tableInfo = $this->getTable()->info();
        $primary = $tableInfo['primary'][1];
        $parent = $this->getTable()->getParentKey();

        // TODO fallback to recursion to build the array if no parent column
        if(!in_array($parent, $tableInfo['cols'])) {
            throw new RuntimeException(
                'Cannot build multi-dimensional array. Table has no parent column.'
            );
        }
        foreach ($this->_data as $node) {
                $node['children'] = array();
            if (isset($ref[$node[$parent]])) {
                $ref[$node[$parent]]['children'][$node[$primary]] = $node;
                $ref[$node[$primary]] = & $ref[$node[$parent]]['children'][$node[$primary]];
            } else {
                $tree[$node[$primary]] = $node;
                $ref[$node[$primary]] = & $tree[$node[$primary]];
            }
        }
        return $tree;
    }

    /**
     * Return the rowset as recursive iterator tree
     *
     * @todo Fallback to recursion to build iterator if no parent column
     * @return RecursiveIteratorIterator
     */
    public function toIterator()
    {
        $tree = null;
        $ref = array();

        $tableInfo = $this->getTable()->info();
        $primary = $tableInfo['primary'][1];
        $parent = $this->getTable()->getParentKey();

        // TODO fallback to recursion to build the array at this point
        if(!in_array($parent, $tableInfo['cols'])) {
            throw new RuntimeException(
                'Cannot build mutli-dimensional array. Table has no parent column.'
            );
        }
        foreach ($this->_data as $value) {
        	if ( isset($ref[$value[$parent]]) ) { 
        	    $node = new $this->_rowClass(
                            array(
                                'table'    => $this->_table,
                                'data'     => $value,
                                'stored'   => $this->_stored,
                                'readOnly' => $this->_readOnly
                            )
                        );
                $ref[$value[$parent]]->addChild($node);
                $ref[$value[$primary]] = $node;
        	} else {
                $node = new $this->_rowClass(
                            array(
                                'table'    => $this->_table,
                                'data'     => $value,
                                'stored'   => $this->_stored,
                                'readOnly' => $this->_readOnly
                            )
                        );
               $tree = $node;
               $ref[$value[$primary]] = $node;
        	}
        }
        $this->_iterator = new RecursiveIteratorIterator(
                               $tree, RecursiveIteratorIterator::SELF_FIRST
                           );
        return $this->_iterator;
    }
}