<?php
/**
 *
 * @author jsmith
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * TitleFilter helper
 *
 * @uses viewHelper System_View_Helper
 */
class System_View_Helper_Title {
	
	/**
	 *
	 * @var Zend_View_Interface
	 */
	public $view;
	
	/**
	 */
	public function title($title) {
		$title = str_replace(array('-', '_'), ' ', $title);
		$title = ucwords($title);
		return $title;
	}
	
	/**
	 * Sets the view field
	 * 
	 * @param $view Zend_View_Interface        	
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
