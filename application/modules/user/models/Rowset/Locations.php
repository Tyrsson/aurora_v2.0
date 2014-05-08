<?php
class User_Model_Rowset_Locations extends Zend_Db_Table_Rowset_Abstract
{
	protected $_tableClass = 'User_Model_Locations';
	
	public function getPrimary()
	{
		$node = null;
		
		foreach($this->_data as $data) {
			
			if( (bool) $data['primary'] === true )
			{
				//Zend_Debug::dump($data['primary']);
				$node = new $this->_rowClass(
						array(
								'table'    => $this->_table,
								'data'     => $data
						)
				);
			}
			
		}
		return $node;
	}
}