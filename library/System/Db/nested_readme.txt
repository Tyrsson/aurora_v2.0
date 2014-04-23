Get the full tree

<?php

$table = new Zend_Db_NestedSet('categories');

$tree = $table->getTree() 

// or getTree($rootId) for mutli tree table

#########################################################
Get the full tree as a multidimensional associative array
<?php

$table = new Zend_Db_NestedSet('categories');

$tree = $table->getTree()->toMultiArray() 

// or getTree($rootId) for mutli tree table

$navigation = new Zend_Navigation($tree);
#########################################################
Get the full tree as a recursive iterator

<?php

$table = new Zend_Db_NestedSet('categories');

$tree = $table->getTree()->toIterator() 

// or getTree($rootId) for mutli tree table    

foreach($tree as $node) {
    echo str_repeat('--',$tree->getDepth()) . $node->categoryName;
}


*/ Outputs the following

  Electronics
  --Televisions
  ----LCD
  ----Plasma
  --Audio Equipment
  ----MP3 Players
  ----Radios
  ----CD Players

*/
#########################################################
Get a branch starting at a specific node:

<?php
$table = new Zend_Db_NestedSet('categories');

$sql = $table->select()
             ->where('categoryName = ?', 'Audio Equipment');

$branch = $table->fetchBranch($sql);

#########################################################
Add a node
<?php

$table = new Zend_Db_NestedSet('categories');

$audio = $table->fetchNode(
    $table->select()->where('categoryName=?','Audio Equipment')
);

$newNode = $table->addNode($audio, array('categoryName' => 'iPods'));

#########################################################
Move a single node or a branch

$table = new Zend_Db_NestedSet('categories');

// Add new sub cateogry 'Apple' who's parent is the root 'Electronics'
$apple = $table->addNode(
    $table->getRoot(),
    array('categoryName' => 'Apple')
);

// Add ipods under audio equipment
$audio = $table->fetchNode(
    $table->select()->where('categoryName=?','Audio Equipment')
);        
$ipods = $table->addNode($audio, array('categoryName' => 'iPods'));

// Move ipods to 'Apple' category as the first child
$newLocation = $table->moveNode(
    $ipods, 
    $apple, 
    Zend_Db_NestedSet::FIRST_CHILD
);

