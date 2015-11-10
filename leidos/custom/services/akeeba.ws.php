<?php
// set response as json
// header('Content-type: application/json');
require (dirname ( __FILE__ ) . "/services/akeeba.impl.php");

$ars = new ArsService ();

// simulate the RESTful format
$params = array ();
// get our URI
$parts = explode ( '/', $_SERVER ['REQUEST_URI'] );
// parse it
for($i = 0; $i < count ( $parts ); $i ++) {
	// first segment is the param name, second is the value
	$params [$parts [$i]] = $parts [$i];
}

// and make it work with your exsisting code
$_GET = $params;

if (isset ( $_GET ['categories'] )) {
	$count = count($params) - 2;
	$key = array_search('categories', array_values($params));
	
	if ($key == $count) { // this can only happen if there is an id after the categories in the url
		$categoryId = $parts[$key+1]; // the category id
		$ars->getCategory($categoryId);
	} else {
		$ars->getAllCategories();
	}
}

if (isset ( $_GET ['releases'] )) {
	$count = count($params) - 2;
	$key = array_search('releases', array_values($params));
	
	if ($key == $count) { // this can only happen if there is an id after the releases in the url
		$releaseId = $parts[$key+1]; // the release id
		$ars->getRelease($releaseId);
	} else {
		$ars->getAllReleases ();
	}
}

if (isset ( $_GET ['items'] )) {
	$count = count($params) - 2;
	$key = array_search('items', array_values($params));

	if ($key == $count) { // this can only happen if there is an id after the items in the url
		$itemId = $parts[$key+1]; // the item id
		$ars->getItemRest($itemId);
	} else {
		$ars->getAllItemsRest();
	}
}

?>