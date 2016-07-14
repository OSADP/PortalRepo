<?php
// turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// set our response header
header ( 'Content-type: application/json' );
// require our implementation class
require (dirname ( __FILE__ ) . "/schedules.impl.php");
require (dirname ( __FILE__ ) . "/resthelpers.php");

// create a new instance of our implementation
$impl = new SchedulesImpl();
// simulate the RESTful format
// create a rest helper instance
$rest = new RestHelper( $_SERVER ['REQUEST_URI'] );
// POST for inserting categories to the given itemId
if ( isset( $params['save'] ) ) {
	header ( 'Content-type: application/json' );
	if ( isset( $_POST['itemId'] ) && isset( $_POST['categories'] ) ) {
		$itemId = $_POST['itemId'];
		$categories = $_POST['categories'];
		$categories = ( is_array( $categories ) ) ? $categories : [ $categories ];
		// check if item id exist in the db and use UPDATE
		// otherwise use INSERT
		if( $impl->getCategoriesByItem( $itemId ) ) {
			$response = $impl->updateCategories($itemId, $categories);
		} else {
			$response = $impl->insertCategories($itemId, $categories);
		}
		die( json_encode( $response ) );
	}

	die( FALSE );
}
// Categories Web Service
// GET all categories for all items
// GET all categories for an item by item id
$rest->request('all', $impl, 'allSchedules');

$rest->request('get', $impl, 'getSchedule');


// return categories by id or all categories
function allSchedules( $restHelper, $impl ) {
	die( json_encode($impl->getAllSchedules()) );
}

// return categories by id or all categories
function getSchedule( $restHelper, $impl ) {
	$itemId = $restHelper->nextParam('get');
	// get all categories if no item id is found
	if( $itemId ) {
		die( json_encode($impl->getCategoriesByItem( $itemId )) );
	}

	die( FALSE );
}

// TODO: GET all categories by item id
?>