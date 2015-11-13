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
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$_GET = $params;
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_POST = $params;
}


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
	$count = count($params);
	$key = array_search('items', array_values($params));

	// nothing is after the key, get all the items
	if ($key == ($count-1)) { 
		$ars->getAllItemsRest();

	// additional url parameters have been provided
	} else {
		
		// if the next url path isn't category or release, it must be the id
		if ($parts[$key+1] != 'category' && $parts[$key+1] != 'release') {
			$itemId = $parts[$key+1]; // the item id
			$ars->hitMeBaby($itemId);
			$ars->getItemRest($itemId);

		
		} else {
			if ($parts[$key+1] == 'category') {
				// look up items by category id
				
				// count should be 3 greater than the key index
				if ($count == $key+3) {
//					echo $parts[$key+2];
					$ars->getAllItemsByCategory($parts[$key+2]);
				} else {
					// no category id provided
					echo "no category id provided";
				}
				
			} else if ($parts[$key+1] == 'release') {
				// count should be 3 greater than the key index
//				echo "look up items by release id\r\n";
				
				if ($count == $key+3) {
//					echo $parts[$key+2];
					$ars->getAllItemsByRelease($parts[$key+2]);
				} else {
					// no category id provided
					echo "no release id provided";
				}
			} else {
				// do nothing.  the url path is unrecognized.
				// possibly return a 404 error
				echo "possibly return a 404 error";
			}
		} 
	}
}

if (isset ( $_POST ['items'] )) {
	$data = json_decode(file_get_contents('php://input'), true);
//	print_r($data);
//	echo $data["id"];
	$ars->hitMeBaby($data["id"]);
}

if (isset ( $_GET ['session'] )) {
	if (isset($_SESSION['userlogin'])) {
		echo $_SESSION['userlogin'];
	} else {
		echo "No session set";
	}
}


?>