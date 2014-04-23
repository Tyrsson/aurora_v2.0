<?php
abstract class System_Model_Row_Searchable extends Zend_Db_Table_Row_Abstract
{
    protected $searchIndexer;
    protected $events;
    protected $baseUrl;
    protected $tagFilter;
    
    public function init(){
        $this->events();
        $this->setTagFilter(new Zend_Filter_StripTags(array('allowTags' => 'img')));
    }
    public function events() {
        if($this->events === null) {
            require_once(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'search' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR . 'SearchIndexer.php');
            $indexer = new Search_Service_SearchIndexer();
            $indexer->setIndexDirectory($this->getTable()->getIndexPath());
            $this->events = new Zend_EventManager_EventManager();
            $this->events->attach(array('_postInsert', '_postUpdate', '_postDelete'), array($indexer, '_addToIndex'), null);

        }
        return $this->events;
    }
    abstract public function getSearchIndexFields(Zend_Db_Table_Abstract $related = null);

    protected function _postInsert()
    {
       $this->events()->trigger('_postInsert', get_called_class(), $this->getSearchIndexFields());
    }
    protected function _postUpdate() 
    {
        $this->events()->trigger('_postUpdate', get_called_class(), $this->getSearchIndexFields());
    }
    protected function _postDelete()
    {
        $this->events()->trigger('_postDelete', get_called_class(), $this->getSearchIndexFields());
    }
	/**
	 * @return the $tagFilter
	 */
	protected function getTagFilter() {
		return $this->tagFilter;
	}

	/**
	 * @param Zend_Filter_StripTags $tagFilter
	 */
	public function setTagFilter($tagFilter) {
		$this->tagFilter = $tagFilter;
	}
}