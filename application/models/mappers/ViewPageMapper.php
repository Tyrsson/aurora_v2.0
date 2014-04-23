<?php
class Com_Model_Mapper_ViewPageMapper
{
    protected $title;
    protected $uri;
    protected $data = array();
    
    public function __construct($title, $uri, Zend_Db_Table_Rowset_Abstract $data = null)
    {
        $this->setTitle($title);
        $this->setUri($uri);
        if($data !== null) {
            $this->setData($data);
        }
    }
	/**
     * @return the $title
     */
    public function getTitle ()
    {
        return $this->title;
    }

	/**
     * @param field_type $title
     */
    public function setTitle ($title)
    {
        $this->title = $title;
    }

	/**
     * @return the $uri
     */
    public function getUri ()
    {
        return $this->uri;
    }

	/**
     * @param field_type $uri
     */
    public function setUri ($uri)
    {
        $this->uri = $uri;
    }

	/**
     * @return the $data
     */
    public function getData ()
    {
        return $this->data;
    }

	/**
     * @param multitype: $data
     */
    public function setData ($data)
    {
        $this->data = $data;
    }

    
}