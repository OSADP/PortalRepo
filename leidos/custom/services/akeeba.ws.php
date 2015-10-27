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

/*
echo count($parts);
echo $_GET['categories'];
for ($j=0; $j < count($parts); $j++) {
	echo $parts[$j];
	echo "<br>";
}
*/

if (isset ( $_GET ['categories'] )) {
	$count = count($params) - 2;
//	echo 'count -> ' . $count;
//	echo "<br>";

	$key = array_search('categories', array_values($params));
//	echo "key -> " . $key;
//	echo "<br>";
	
	if ($key == $count) { // this can only happen if there is an id after the categories in the url
		$categoryId = $parts[$key+1]; // the category id
//		echo "$categoryId -> " . $categoryId;
//		echo "<br>";
		
		$ars->getCategory($categoryId);
	} else {
		$ars->getAllCategories();
	}
}

if (isset ( $_GET ['category'] )) {
		$ars->getCategory ();
}

if (isset ( $_GET ['releases'] )) {
	$ars->getAllReleases ();
}

if (isset ( $_GET ['array'] )) {
	$ars->getAllCategoriesArray ();
}

?>