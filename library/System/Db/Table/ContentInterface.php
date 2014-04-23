<?php
/**
 * Interface to be implemented by all concrete System_Db_Table instances 
 * that should return content that will be served as a page
 *
 * @author Joey
 * @version 1.1.1
 * @package Aurora
 * @subpackage System_Db_Table
 */
interface System_Db_Table_ContentInterface
{
    /**
     * @param unknown $keyWords
     */
    public function setupKeyWords(&$keyWords);
}