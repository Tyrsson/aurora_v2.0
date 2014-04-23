<?php

/**
 * Abstract
 *
 * @author Joey
 * @version 1.1.1
 * @package Aurora
 * @subpackage System_Db_Table
 */

require_once ('Zend/Acl/Resource/Interface.php');
require_once ('Zend/Db/Table/Abstract.php');

abstract class System_Db_Table_Abstract extends Zend_Db_Table_Abstract implements Zend_Acl_Resource_Interface
{
	/**
	 * @see Zend_Acl_Resource_Interface::getResourceId();
	 * @var string
	 */
    protected $_resourceId;
    /**
     * @var object Zend_log
     */
    protected $log;

    /**
     *
     * @access public
     * @see Zend_Db_Table_Abstract
     */
    public function init()
    {
        $this->getLog();
    }

    /**
     * @uses Zend_Log
     * @see System_Log
     * @param object $log            
     * @return void
     */
    public function setLog(System_Log $log)
    {
        $this->log = $log;
    }

    /**
     * Lazy Load System_log instance if one has not been set
     * @throws Zend_Exception
     * @return System_Log
     */
    public function getLog()
    {
        try {
            switch (true) {
                case (! isset($this->log) && Zend_Registry::isRegistered('log')):
                    $this->log = Zend_Registry::get('log');
                    break;
                case (isset($this->log)):
                    return $this->log;
                    break;
            }
        } catch (Zend_Exception $e) {
            throw $e;
        }
    }
    /**
     * @see Zend_Acl_Resource_Interface::getResourceId()
     *
     * @return string
     */
    public function getResourceId()
    {
        $this->_resourceId = $this->_name;
        return $this->_resourceId;
    }

    public function __toString()
    {
        return $this->getResourceId();
    }
}