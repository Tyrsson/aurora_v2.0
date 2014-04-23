<?php
class System_Navigation_Page_NestedSet extends Zend_Navigation_Page
{
    private $_categoryId; 
    private $_rootId; 
    private $_categoryName; 
    private $_name; 
    private $_url; 
    private $_parentId; 
    private $_lft; 
    private $_rgt; 
    private $_children;
    
    private $_tree;
    
	public function __construct($options = null) {
		// TODO: Auto-generated method stub
		$options['type'] = get_class($this);
		
		parent::__construct($options);
	}
	protected function _init() {
		// TODO: Auto-generated method stub
	    
	}
	/**
	 * Sets the given property
	 *
	 * If the given property is native (id, class, title, etc), the matching
	 * set method will be used. Otherwise, it will be set as a custom property.
	 *
	 * @param  string $property           property name
	 * @param  mixed  $value              value to set
	 * @return Zend_Navigation_Page       fluent interface, returns self
	 * @throws Zend_Navigation_Exception  if property name is invalid
	 */
	public function set($property, $value)
	{
	    if (!is_string($property) || empty($property)) {
	        require_once 'Zend/Navigation/Exception.php';
	        throw new Zend_Navigation_Exception(
	            'Invalid argument: $property must be a non-empty string');
	    }
	
	    $method = 'set' . self::_normalizePropertyName($property);
	
	    if ($method != 'setOptions' && $method != 'setConfig' &&
	    method_exists($this, $method)) {
	        $this->$method($value);
	    } else {
	        //$this->_properties[$property] = $value;
	    }
	
	    return $this;
	}
	/**
     * @see Zend_Navigation_Page::getHref()
     */
    public function getHref()
    {
        // TODO Auto-generated method stub
        return $this->_getUrl();
    }

	/**
     * @return the $_categoryId
     */
    public function getCategoryId()
    {
        return $this->_categoryId;
    }

	/**
     * @param field_type $_categoryId
     */
    public function setCategoryId($_categoryId)
    {
        $this->_categoryId = $_categoryId;
    }

	/**
     * @return the $_rootId
     */
    public function getRootId()
    {
        return $this->_rootId;
    }

	/**
     * @param field_type $_rootId
     */
    public function setRootId($_rootId)
    {
        $this->_rootId = $_rootId;
    }
    
	/**
     * @return the $_pageName
     */
    public function getName()
    {
        return $this->_name;
    }

	/**
     * @param field_type $_pageName
     */
    public function setName($_name)
    {
        $this->_name = $_name;
    }

	/**
     * @return the $_categoryName
     */
    public function getCategoryName()
    {
        return $this->_categoryName;
    }

	/**
     * @param field_type $_categoryName
     */
    public function setCategoryName($_categoryName)
    {
        if(!isset($this->_name) && !isset($this->_label)) {
            $this->setLabel($_categoryName);
        }
        $this->_categoryName = $_categoryName;
    }

	/**
     * @return the $_url
     */
    public function getUrl()
    {
        return $this->_url;
    }

	/**
     * @param field_type $_url
     */
    public function setUrl($_url)
    {
        $this->_url = $_url;
    }

	/**
     * @return the $_parentId
     */
    public function getParentId()
    {
        return $this->_parentId;
    }

	/**
     * @param field_type $_parentId
     */
    public function setParentId($_parentId)
    {
        $this->_parentId = $_parentId;
    }

	/**
     * @return the $_lft
     */
    public function getLft()
    {
        return $this->_lft;
    }

	/**
     * @param field_type $_lft
     */
    public function setLft($_lft)
    {
        $this->_lft = $_lft;
    }

	/**
     * @return the $_rgt
     */
    public function getRgt()
    {
        return $this->_rgt;
    }

	/**
     * @param field_type $_rgt
     */
    public function setRgt($_rgt)
    {
        $this->_rgt = $_rgt;
    }

	/**
     * @return the $_children
     */
    public function getChildren()
    {
        return $this->_children;
    }

	/**
     * @param field_type $_children
     */
    public function setChildren($_children)
    {
        $this->_children = $_children;
        $this->_pages = $this->_children;
    }

    
}