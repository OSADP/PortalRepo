<?php
	require (dirname ( __DIR__ ) . "/download/implementation.php");
	require (dirname ( __DIR__ ) . "/../services/rest.php");
	
	// implementation class
	$implementation = new ArsDownload();
	// REST class
	$router = new RouteConfig();
	
	// get all release or release by id
	if ( $router->on('download') ) {
		// download application by item id else err
  	$implementation->get();
	}
?>