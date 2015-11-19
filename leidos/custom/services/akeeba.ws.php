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
	header ( 'Content-type: application/json' );
	
	if ($key == $count) { // this can only happen if there is an id after the categories in the url
		$categoryId = $parts[$key+1]; // the category id
		$cat = $ars->getCategory($categoryId);
		echo json_encode ( $cat );
	} else {
		$arrCat = $ars->getAllCategories();
		echo json_encode ( $arrCat );
	}
}

if (isset ( $_GET ['releases'] )) {
	$count = count($params) - 2;
	$key = array_search('releases', array_values($params));
	header ( 'Content-type: application/json' );
	
	if ($key == $count) { // this can only happen if there is an id after the releases in the url
		$releaseId = $parts[$key+1]; // the release id
		$rel = $ars->getRelease($releaseId);
		echo json_encode ( $rel );
	} else {
		$arrRel = $ars->getAllReleases();
		echo json_encode ( $arrRel );
	}
}

if (isset ( $_GET ['items'] )) {
	$count = count($params);
	$key = array_search('items', array_values($params));
	header ( 'Content-type: application/json' );

	// nothing is after the key, get all the items
	if ($key == ($count-1)) { 
		$arrItems = $ars->getAllItemsRest();
		echo json_encode (  $arrItems );
		
	// additional url parameters have been provided
	} else {
		
		// if the next url path isn't category or release, it must be the id
		if ($parts[$key+1] != 'category' && $parts[$key+1] != 'release') {
			$itemId = $parts[$key+1]; // the item id
			$arrItem = $ars->getItemRest($itemId);
			echo json_encode ( $arrItem );

		// gotta be category or release
		} else {
			// its categery
			if ($parts[$key+1] == 'category') {
				// look up items by category id
				// count should be 3 greater than the key index
				if ($count == $key+3) {
//					echo $parts[$key+2];
					$arrItemsCat = $ars->getAllItemsByCategory($parts[$key+2]);
					echo json_encode($arrItemsCat);
				} else {
					// no category id provided
					echo "no category id provided";
				}
				
			// its release
			} else if ($parts[$key+1] == 'release') {
				// look up items by release id
				// count should be 3 greater than the key index
				if ($count == $key+3) {
//					echo $parts[$key+2];
					$arrItemsRel = $ars->getAllItemsByRelease($parts[$key+2]);
					echo json_encode($arrItemsRel);
				} else {
					// no category id provided
					echo "no release id provided";
				}
			
			// no idea what it is
			} else {
				// do nothing.  the url path is unrecognized.
				// possibly return a 404 error
				echo "possibly return a 404 error";
			}
		} 
	}
}

if (isset ( $_POST ['item'] )) {
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

if (isset($_POST['download'])) {
	$data = json_decode(file_get_contents('php://input'), true);
	if ($data == null) {
		$data = array("id" => "20");
	}
// 	print_r($data);
// 	echo $data["id"];
	$arrItem = $ars->doMeBaby($data["id"]);
	
	header ( 'Content-type: application/json' );
	echo json_encode ( $arrItem );
}


?>