<?php
	require (dirname ( __DIR__ ) . "/releases/implementation.php");
	require (dirname ( __DIR__ ) . "/../services/utf8parser.php");
	require (dirname ( __DIR__ ) . "/../services/rest.php");
	// implementation class
	$releaseImpl = new ArsRelease();
	// utf8 parser class
	$utf8parser = new UTF8parser();
	// REST class
	$router = new RouteConfig();


	// get all release or release by id
	if ( $router->on('releases') ) {
		header ( 'Content-type: application/json' );
		// get release by id if available, else get all releases
		if ( $releaseId = $router->child('releases') ) {
			$rel = $releaseImpl->get($releaseId);
			echo json_encode ( $utf8parser->convert( $rel ) );
		} else {
			$arrRel = $releaseImpl->all();
			echo json_encode ( $utf8parser->convert( $arrRel ) );
		}
	}
?>