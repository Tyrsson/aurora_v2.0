<?php
class Aurora_Model_Rowset_ContentNodes extends Zend_Db_Table_Rowset_Abstract
{
	protected $_rowClass = 'Aurora_Model_Row_ContentNode';
	protected $_tableClass = 'Aurora_Model_ContentNodes';
	
	public function __construct($config)
	{
		parent::__construct($config);
		Zend_Debug::dump(__METHOD__);
	}
}