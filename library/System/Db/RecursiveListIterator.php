<?php
class System_Db_RecursiveListIterator extends RecursiveIteratorIterator
{
    public $tab = "\t";
    
    public $view;
    
    
    
    /* (non-PHPdoc)
     * @see RecursiveIteratorIterator::__construct()
     */
//     public function __construct(Traversable $iterator, $mode, $flags)
//     {
//         // TODO Auto-generated method stub
//         $this->getView();
//         Zend_Debug::dump($this->view);
//         parent::__construct($iterator, $mode, $flags);
//     }
    

	public function beginChildren() {
        if (count($this->getInnerIterator()) == 0) { return; }
        echo str_repeat($this->tab, $this->getDepth()), "<ul>\n";
    }
     
    public function endChildren() {
        if (count($this->getInnerIterator()) == 0) { return; }
        echo str_repeat($this->tab, $this->getDepth()), "</ul>\n";
        echo str_repeat($this->tab, $this->getDepth()), "</li>\n";
    }
     
    public function nextElement() {
        // Display leaf node
        if ( ! $this->callHasChildren()) {
            
            // get a copy of the current array as we are iterating it
            $current = $this->getArrayCopy();
            
            if($this->key() === 'categoryName') {
                $edit = $this->view->button(null, '/admin/page/edit/category/' . $current['uri'], array('label' => 'Edit'), array('class' => 'pageManagerButton'));
                //$edit = '<a href="/admin/page/edit/category/' . $current['uri'] . '">Edit</a>';
                if(Zend_Registry::get('appSettings')->lockCategories == true) {
                    if ($current['isLocked'] == false) {
                        $delete = $this->view->button(null, '/admin/page/delete/category/' . $current['uri'], array('label' => 'Delete'), array('class' => 'pageManagerButton'));
                    }
                } else if (Zend_Registry::get('appSettings')->lockCategories == false) {
                    $delete = $this->view->button(null, '/admin/page/delete/category/' . $current['uri'], array('label' => 'Delete'), array('class' => 'pageManagerButton'));
                }
                //$delete = '<a href="">Delete</a>';
                echo str_repeat($this->tab, $this->getDepth() +1 ) . '<li>' . $this->current() . '&nbsp;' . $edit . '&nbsp;' . $delete . '</li>' . "\n";
            }
            
            if(!isset($current['categoryName']) && $this->key() === 'label') {
                // we know these will be "pages" because they do not have a categoryName key
                // $this->button('createCategory', '/admin/page/create/category', /* params */array('label' => 'Create New Category'), /* attribs */array('class' => 'pageManagerButton'));
                $edit = $this->view->button(null, '/admin/page/edit/' . $current['uri'], array('label' => 'Edit'), array('class' => 'pageManagerButton'));
                
                $delete = $this->view->button(null, '/admin/page/delete/' . $current['uri'], array('label' => 'Delete'), array('class' => 'pageManagerButton'));
                //$edit = '<a href="/admin/page/edit/' . $current['uri'] . '">Edit</a>';
                //$delete = '<a href="">Delete</a>';
                echo str_repeat($this->tab, $this->getDepth() +1 ) . '<li>' . $this->current() . '&nbsp;' . $edit . '&nbsp;' . $delete . '</li>' . "\n";
            }
   
            return;
        }
         
        // Display branch with label
         //echo str_repeat( $this->tab, $this->getDepth() +1 ), '<li>', $this->key();
        
         //echo (count($this->callGetChildren()) == 0) ? "</li>\n" : "\n";
    }
	public function getView()
	{
	    return $this->view;
	}
	public function setView($view) {
		$this->view = $view;
	}
	public function useDojo($flag = true)
	{
	
	}

    
}