<?php
require (dirname ( __FILE__ ) . "/services/akeebacustom.impl.php");
// instantiate our implementation
$ars = new AkeebaCustomImpl();
// simulate the RESTful format
$params = array();
// get our URI
$parts = explode ( '/', $_SERVER ['REQUEST_URI'] );
// parse it
for($i = 0; $i < count ( $parts ); $i ++) {
	// first segment is the param name, second is the value
	$params [$parts [$i]] = $parts [$i];
}

if( isset($params['keywords']) ) {
	if ( isset($_POST['itemId']) && isset($_POST['keywords']) ) {
		$itemId = $_POST['itemId'];
		$keywords = $_POST['keywords'];
		echo $ars->updateKeywordsById( $itemId, $keywords );
	} else {
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		if ( isset($request->itemId) && isset($request->keywords) ) {
			$itemId = $request->itemId;
			$keywords = $request->keywords;
			echo $ars->updateKeywordsById( $itemId, $keywords );
		}
	}
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
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		if( isset($request->categoryId) && isset($request->iconUrl) ) {
			$categoryId = $request->categoryId;
			$iconUrl = $request->iconUrl;
			$category = $ars->getCustomById( $categoryId );
			if( isset( $category['icon_url'] )) {
				echo $ars->updateCustomById( $categoryId, $iconUrl );	
			} else {
				echo $ars->insertCustomById( $categoryId, $iconUrl );	
			}
		} else {
			die( false );
		}
	}
}

if ( isset($params['item']) ) {
	if ( isset($_POST['itemId']) && isset($_POST['iconUrl']) && isset($_POST['shortDescription']) && isset($_POST['mainDiscussion']) && isset($_POST['issuesDiscussion']) ) {
		$itemId = $_POST['itemId'];
		$iconUrl = $_POST['iconUrl'];
		$shortDescription = $_POST['shortDescription'];
		$mainDiscussion = $_POST['mainDiscussion'];
		$issuesDiscussion = $_POST['issuesDiscussion'];
		$keywords = $_POST['keywords'];
		$keywords = ( is_array( $keywords ) ) ? $keywords : [ $keywords ];

		$item = $ars->getItemCustomsById( $itemId );
		if( isset( $item['icon_url'] )) {
			echo $ars->updateItemCustomsById( $itemId, $iconUrl, $shortDescription, $mainDiscussion, $issuesDiscussion, $keywords );
		} else {
			echo $ars->insertItemCustomsById( $itemId, $iconUrl, $shortDescription, $mainDiscussion, $issuesDiscussion, $keywords );	
		}
	} else if ( $_POST['itemId'] ) {
		$itemId = $_POST['itemId'];
		echo json_encode($ars->getItemCustomsById( $itemId ));
	} else {
		echo false;
	}
}

if ( isset($params['documentation']) ) {
	if ( isset($_POST['itemId']) ) {
		$itemId = $_POST['itemId'];
		$documentation = $_POST['links']; // array
		$documentation = $documentation ? $documentation : [];

		$item = $ars->getDocumentationsById( $itemId );
		
		if( count( $item ) > 0 ) {
			$ars->deleteDocumentationByItemId( $itemId );
		}
		foreach ($documentation as $item) {
			if( $item['link'] != '' && $item['text'] !='' )
				$ars->insertItemDocumentationsById( $itemId, $item['link'], $item['text'] );	
		}
		echo $itemId;
	} else if ( isset($_POST['itemId']) ) {
		$itemId = $_POST['itemId'];
		die( json_encode($ars->getDocumentationsById( $itemId )));
	} else {
		$json = file_get_contents('php://input');
		$data = json_decode( $json );
		if( $data->itemId != null ) {
			echo json_encode($ars->getDocumentationsById( $data->itemId ));
		} else {
			echo false;
		}
	}
}

?>