<?php
	require (dirname ( __DIR__ ) . "/items/implementation.php");
	require (dirname ( __DIR__ ) . "/../services/rest.php");
	// implementation class
	$implementation = new ArsItems();
	// REST class
	$router = new RouteConfig();


	// get all release or release by id
	if ( $router->on('items') ) {
		header ( 'Content-type: application/json' );
		// get release by id if available, else get all items
		if ( $child = $router->child('items') ) {
			$rel = $implementation->get( $child );
			echo json_encode ( $rel );
		} else {
			$arrRel = $implementation->all();
			echo json_encode ( $arrRel );
		}
	}
?>