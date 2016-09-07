<?php
	require (dirname ( __DIR__ ) . "/items/implementation.php");
	require (dirname ( __DIR__ ) . "/../services/utf8parser.php");
	require (dirname ( __DIR__ ) . "/../services/rest.php");
	// implementation class
	$implementation = new ArsItems();
	// utf8 parser class
	$utf8parser = new UTF8parser();
	// REST class
	$rest = new RouteConfig();


	// get all release or release by id
	if ( $rest->on('items') ) {
		header ( 'Content-type: application/json' );
		// get release by id if available, else get all items
		if ( $child = $rest->child('items') ) {
			if( $child !== 'category' && $child !== 'keywords' ) {
				$rel = $implementation->get( $child );
				echo json_encode ( $utf8parser->convert( $rel ) );
			} else if( $child === 'category' ) {
				$categoryId = $rest->child($child);
				$allItems = $implementation->all();
				$allItems = $utf8parser->convert( $allItems );
				$items = array();
				foreach ($allItems as $key => $item) {
					$categoryIds = array($item["category_ids"]);
					foreach ($categoryIds as $key => $value) {
						foreach ($value as $key => $value2) {
							if($value2 === $categoryId) {
								array_push($items, $item);
							}
						}
					}
				}
				echo json_encode($items);
			}
		} else {
			$arrRel = $implementation->all();
			echo json_encode ( $utf8parser->convert( $arrRel ) );
		}
	}
?>