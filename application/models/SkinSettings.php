<?php

/**
 * SkinSettings
 *
 * @author Joey Smith
 * @version 2.0.0
 */
require_once 'Zend/Db/Table/Abstract.php';

class Aurora_Model_SkinSettings extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'skin_settings';

	protected $_referenceMap = array(
	                           'SkinSettings' => array(
                                    'columns' 			=> array('skinId'),
                                    'refTableClass'		=> 'Aurora_Model_Skins',
                                    'refColumns' 		=> array('skinId'),
                                    'onDelete'          => self::CASCADE
								)
			 );

	public function fetchCurrent() {
	    $q = $this->select()->from($this->_name, array('*'))->where('spec = ?', "isCurrentSkin")->where('value = ?', 1);
	    $result = $this->fetchRow($q);
	    return $result->findParentRow('Aurora_Model_Skins');
	}
}
