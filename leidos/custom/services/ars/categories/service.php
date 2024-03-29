<?php
	require (dirname ( __DIR__ ) . "/categories/implementation.php");
	require (dirname ( __DIR__ ) . "/../services/utf8parser.php");
	require (dirname ( __DIR__ ) . "/../services/rest.php");

	// implementation class
	$implementation = new ArsCategories();
	// utf8 parser class
	$utf8parser = new UTF8parser();
	// REST class
	$router = new RouteConfig();


	// get all release or release by id
	if ( $router->on('categories') ) {
		header ( 'Content-type: application/json' );
		// get release by id if available, else get all categories
		if ( $releaseId = $router->child('categories') ) {
			$rel = $implementation->get($releaseId);
			echo json_encode ( $utf8parser->convert( $rel ) );
		} else {
			$array = $implementation->all();
			echo json_encode ( $utf8parser->convert( $array ) );
		}
	}
?>