<?php
// turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header ( 'Content-type: application/json' );
// require our implementation class
require (dirname ( __FILE__ ) . "/multicategories.impl.php");
require (dirname ( __FILE__ ) . "/resthelpers.php");

// create a new instance of our implementation
$multi = new MulticategoriesImpl();
// simulate the RESTful format
$params = [];
// get our URI
$parts = explode ( '/', $_SERVER ['REQUEST_URI'] );
// parse it
for($i = 0; $i < count ( $parts ); $i ++) {
	// first segment is the param name, second is the value
	$params [$parts [$i]] = $parts [$i];
}
// create a rest helper instance
$rest = new RestHelper( $params, $parts );
// POST for inserting categories to the given itemId
if ( isset( $params['save'] ) ) {
	header ( 'Content-type: application/json' );
	if ( isset( $_POST['itemId'] ) && isset( $_POST['categories'] ) ) {
		$itemId = $_POST['itemId'];
		$categories = $_POST['categories'];
		$categories = ( is_array( $categories ) ) ? $categories : [ $categories ];
		// check if item id exist in the db and use UPDATE
		// otherwise use INSERT
		if( $multi->getCategoriesByItem( $itemId ) ) {
			$response = $multi->updateCategories($itemId, $categories);
		} else {
			$response = $multi->insertCategories($itemId, $categories);
		}
		die( json_encode( $response ) );
	}

	die( FALSE );
}
// Categories Web Service
// GET all categories for all items
// GET all categories for an item by item id
if( isset( $params['categories'] ) ) {
	$itemId = $rest->nextParam('categories');
	// get all categories if no item id is found
	if( ! $itemId ) {
		die( json_encode($multi->getAllCategories()) );
	} else {
		die( json_encode($multi->getCategoriesByItem( $itemId )) );
	}

	die( FALSE );
}
// TODO: GET all categories by item id
?>