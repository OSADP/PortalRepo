<?php


require (dirname ( __FILE__ ) . "/services/akeebacustom.impl.php");

$ars = new AkeebaCustomImpl ();
// simulate the RESTful format
$params = array ();
// get our URI
$parts = explode ( '/', $_SERVER ['REQUEST_URI'] );
// parse it
for($i = 0; $i < count ( $parts ); $i ++) {
	// first segment is the param name, second is the value
	$params [$parts [$i]] = $parts [$i];
}

if ( isset($params['category']) ) {
	if ( isset( $_POST['categoryId'] ) && isset( $_POST['iconUrl'] ) ) {
		$categoryId = $_POST['categoryId'];
		$iconUrl = $_POST['iconUrl'];
		$category = $ars->getCustomById( $categoryId );
		if( isset( $category['icon_url'] )) {
			echo $ars->updateCustomById( $categoryId, $iconUrl );	
		} else {
			echo $ars->insertCustomById( $categoryId, $iconUrl );	
		}
	} else if ( isset( $_POST['categoryId'] ) ) {
		$categoryId = $_POST['categoryId'];
		die( json_encode($ars->getCustomById( $categoryId )) );
	} else {
		echo 'Error';
	}
}

if ( isset($params['item']) ) {
	if ( isset($_POST['itemId']) && isset($_POST['iconUrl']) && isset($_POST['shortDescription']) ) {
		$itemId = $_POST['itemId'];
		$iconUrl = $_POST['iconUrl'];
		$shortDescription = $_POST['shortDescription'];
		$item = $ars->getItemCustomsById( $itemId );
		if( isset( $item['icon_url'] )) {
			echo $ars->updateItemCustomsById( $itemId, $iconUrl, $shortDescription );	
		} else {
			echo $ars->insertItemCustomsById( $itemId, $iconUrl, $shortDescription );	
		}
	} else if ( $_POST['itemId'] ) {
		$itemId = $_POST['itemId'];
		die( json_encode($ars->getItemCustomsById( $itemId )));
	} else {
		echo 'Error';
	}
}

if ( isset($params['documentation']) ) {
	if ( isset($_POST['itemId']) && isset($_POST['links']) ) {
		$itemId = $_POST['itemId'];
		$documentation = $_POST['links']; // array
		$item = $ars->getDocumentationsById( $itemId );
		if( count( $item ) > 0 ) {
			echo $ars->deleteDocumentationByItemId( $itemId );
			foreach ($documentation as $item) {
				if( $item['link'] != '' && $item['text'] !='' )
					$ars->insertItemDocumentationsById( $itemId, $item['link'], $item['text'] );	
			}
		} else {
			foreach ($documentation as $item) {
				if( $item['link'] != '' && $item['text'] !='' )
					$ars->insertItemDocumentationsById( $itemId, $item['link'], $item['text'] );	
			}
			echo 'Success!';
		}
	} else if ( isset($_POST['itemId']) ) {
		$itemId = $_POST['itemId'];
		die( json_encode($ars->getDocumentationsById( $itemId )));
	} else {
		$json = file_get_contents('php://input');
		$data = json_decode( $json );
		if( $data->itemId != null ) {
			echo json_encode($ars->getDocumentationsById( $data->itemId ));
		} else {
			echo 'Error!';
		}
	}
}

?>