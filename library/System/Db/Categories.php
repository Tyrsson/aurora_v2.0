<?php 

class System_Db_Categories extends System_Db_NestedSet 
{
    const RETURN_OBJECT = 'object'; 
    const RETURN_ARRAY  = 'array'; 
    
    protected $_name = 'categories'; 
    protected $_sequence = true; 
    protected $_primary = 'categoryId';
    
    protected $_dependentTables = array('System_Db_Page');
    
    protected $_mode = 'object'; 
    
    
	public function __construct(array $config = null) {
		parent::__construct($config);
		
	}
	public function fetch($categoryId) {
	    $sql = $this->select()->from($this->_name)->where('categoryId = ?', $categoryId);
	    return $this->fetchRow($sql);
	}
	public function fetchNodeByUri($categoryUri)
	{
	    return $this->fetchNode( 
	                   $this->select()->where('uri = ?', $categoryUri) 
	           );
	}
	//public function get
	public function getLandingContent($categoryUri) {
	    
	    $row = $this->fetchNode(
	                       $this->select()->where('uri = ?', $categoryUri)
	           );
	    $table = new $this->_dependentTables[0]();
	    $content = $row->findDependentRowset('System_Db_Page', 'CategoryPages', $table->select()->from('pages')->where('isLanding = ?', 1));
	    if($content !== null && $content->count() > 0) {
	        if($this->getMode() === self::RETURN_ARRAY)
	        {  
	            return $content[0]->toArray();
	        }
	        else {
	            return $content[0];
	        }
	    }
	    
	}
	public function getHomeContent()
	{
	    $row = $this->fetchNode(
	        $this->select()->where('categoryId = ?', '1')
	    );
	    $content = $row->findDependentRowset('System_Db_Page', 'CategoryPages');
	    if($content->count() > 0) {
	        
	        if($this->getMode() === self::RETURN_ARRAY)
	        {
	            return $content[0]->toArray();
	        }
	        else {
	            return $content[0];
	        }
	        
	    }
	    else {
	        return null;
	    }
	}
	public function fetchContentManagerNavigation()
	{
	    $sql = $this->select()->setIntegrityCheck(false)
	    ->from($this->_name, array('categoryName', 'uri'))
	    ->join('pages', 'pages.categoryId = categories.categoryId', array('label', 'uri'))
	    ->where('categories.categoryId >= ?', 2);
	    return $this->fetchAll($sql);
	}
	public function fetchPagesByCategoryUri($categoryUri)
	{
	    $row = $this->fetchNode(
	            $this->select()->where('uri = ?', $categoryUri)
	    );
	    $table = new $this->_dependentTables[0]();
	    $content = $row->findDependentRowset('System_Db_Page', 'CategoryPages', $table->select()->from('pages', array('id', 'categoryId', 'userId', 'role', 'label', 'isLanding', 'featured', 'uri', 'visibility')));
	    if($content !== null && $content->count() > 0) {
	        if($this->getMode() === self::RETURN_ARRAY)
	        {
	            return $content->toArray();
	        }
	        else {
	            return $content;
	        }
	    }
	}
	public function fetchPageByUri($pageUri)
	{
	    try {
	        if(!is_string($pageUri))
	        {
	            throw new System_Db_NestedSet_Exception('$pageUri must be a string in: ' . __FILE__ . ' on line: ' . __LINE__);
	        }
	        else {
	            $gateway = new $this->_dependentTables[0];
	            //Zend_Debug::dump($gateway);
	            if($gateway instanceof System_Db_Page) {
	                switch($this->getMode()) {
	                	case self::RETURN_OBJECT :
	                	    //Zend_Debug::dump($gateway->fetchByUri($pageUri));
	                	    return $gateway->fetchByUri($pageUri);
	                	    break;
	                	case self::RETURN_ARRAY :
	                	    return $gateway->fetchByUri($pageUri)->toArray();
	                	    break;
	                }
	            }
	            else {
	                throw new System_Db_NestedSet_Exception('$gateway must be an instance of System_Db_Page in: ' . __FILE__ . ' on line: ' . __LINE__);
	            }
	        }
	    } catch (Zend_Exception $e) {
	        $this->log->crit($e);
	        echo $e->getMessage();
	    }
	}
	/**
	 * Check whether tree has a root node
	 *
	 * @return bool
	 */
	public function hasRootByUrl($url = null)
	{
	    $row = $this->fetchNodeByUrl($url);
	    if ($this->_multiRoot && ($row->rootId == null)) {
	        throw new System_Db_NestedSet_Exception('Ambiguous rootId');
	    }
	
	    $select = $this->select();
	    $select->where($this->_lftKey . '=1');
	    if($this->_multiRoot && !($row->rootId == null)) {
	        $select->where($this->getRootkey() . '=?', $row->rootId);
	    }
	    $root = $this->fetchRow($select);
	    if ($root === null) {
	        return false;
	    }
	    return true;
	}
	public function fetchParentDropDown()
	{
	    $noParent = array();
	
	    $query = $this->select()->from($this->_name, array('key' => 'categoryId', 'value' => 'categoryName'));
	    $result = $this->fetchAll($query)->toArray();
	    // Zend_Debug::dump($result);
	    array_unshift($result, array(
	    'key' => 0,
	    'value' => 'No Parent'
	        ));
	
	    return $result;
	}
	public function fetchPagecategoryDropDown($startNode = 'Page')
	{
	    $noParent = array();
	
	    $query = $this->select()->from($this->_name, array('key' => 'categoryId', 'value' => 'categoryName'))->where('categoryId > ?', 1)->where('isContent = ?', 1);
	    $result = $this->fetchAll($query)->toArray();
	    // Zend_Debug::dump($result);
// 	    array_unshift($result, array(
// 	    'key' => 0,
// 	    'value' => 'No Parent'
// 	        ));
	
	    return $result;
	}

	/**
	 * @return the unknown_type
	 */
	public function getMode() {
		return $this->_mode;
	}
	
	/**
	 * @param unknown_type $_mode
	 */
	public function setMode($_mode) {
		$this->_mode = $_mode;
		return $this;
	}
	
	
}