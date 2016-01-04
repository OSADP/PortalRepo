<?php

require (dirname ( __DIR__ ) . "/configs/database.php");

class ArsService extends DBConfig {
	
	// Get all the categories
	function getAllCategories() {
		// prepare the statement
		$stmt = $this->db->query ( 
				'SELECT category.id, category.alias, category.title,
				category.description, category.created, category.modified,
				category.type, category.directory, custom.icon_url
				FROM jos_ars_categories AS category
				LEFT JOIN jos_akeeba_category_custom AS custom
				ON category.id = custom.category_id');
		
		// put the results in an array
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
		
		// close out the statement and return the array
		$stmt->close ();
		return $arrCat;
	}
	
	// Get a category by a category id
	function getCategory($categoryId) {
		// prepare the statement
		$stmt = $this->db->query ( 
				'SELECT category.id, category.alias, category.title,
				category.description, category.created, category.modified,
				category.type, category.directory, custom.icon_url
				FROM jos_ars_categories AS category
				LEFT JOIN jos_akeeba_category_custom AS custom
				WHERE id=' . $categoryId );
				
		// should only return one result.  put that row in a variable
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$cat = $row;
		}

		// close out the statement and return the one category
		$stmt->close ();
		return $cat;
	}
	
	// Get all the releases
	function getAllReleases() {
		// prepare the statement
		$stmt = $this->db->query ( 'SELECT * FROM jos_ars_releases' );

		// put the results in an array
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrRel [] = $row;
		}
		
		// close out the statement and return the array
		$stmt->close ();
		return $arrRel;
	}
	
	// Get the release by release id
	function getRelease($releaseId) {
		// prepare the statement
		$stmt = $this->db->query ( 
				'SELECT * FROM jos_ars_releases  
				WHERE id=' . $releaseId );

		// should only return one result.  put that row in a variable
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$rel = $row;
		}
				
		// close out the statement and return the one category
		$stmt->close ();
		return $rel;
	}
	
/*
	// Get all the items
	function getAllItems() {
		// prepare the statement
		$stmt = $this->db->query ( 'SELECT * FROM jos_ars_items' );

		// put the results in an array
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrItems[] = $row;
		}
		
		// close out the statement and return the array
		$stmt->close ();
		return $arrItems;
	}
	
	function getItem($itemId) {
		// prepare the statement
		$stmt = $this->db->query ( 
				'SELECT id, release_id, title, alias, description, type, 
					filename, url, updatestream, md5, sha1, filesize, 
					groups, hits, created_by, checked_out, checked_out_time, 
					ordering, access, show_unauth_links, redirect_unauth, 
					published, language, environments  
				FROM jos_ars_items WHERE id=' . $itemId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$item = $row;
		}
	
		header ( 'Content-type: application/json' );
		echo json_encode ( $item );
		$stmt->close ();
	}
	
	function getItemDetail($itemId) {
		// prepare the statement
		$stmt = $this->db->query (
				'SELECT 
				i.id, i.release_id, i.title, i.alias, i.description, i.type,
				i.filename, i.url, i.updatestream, i.md5, i.sha1, i.filesize,
				i.groups, i.hits, i.created_by, i.checked_out, i.checked_out_time,
				i.ordering, i.access, i.show_unauth_links, i.redirect_unauth,
				i.published, i.language, i.environments,
				r.id, r.category_id, r.version, r.alias, r.maturity, r.description, 
				r.notes, r.groups, r.hits, r.created, r.created_by, r.modified, 
				r.modified_by, r.checked_out, r.checked_out_time, r.ordering, 
				r.access, r.show_unauth_links, r.redirect_unauth, r.published, 
				r.language,
				c.id, c.title, c.alias, c.description, c.type, c.groups, c.directory, 
				c.vgroup_id, c.created, c.created_by, c.modified, c.modified_by,
				c.checked_out, c.checked_out_time, c.ordering, c.access, c.show_unauth_links,
				c.redirect_unauth, c.published, c.language
			FROM 
				jos_ars_items i
			INNER JOIN
				jos_ars_releases r on i.release_id = r.id
			INNER JOIN
				jos_ars_categories c on r.category_id = c.id
			WHERE 
				i.id=' . $itemId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$item = $row;
		}
	
		header ( 'Content-type: application/json' );
		echo json_encode ( $item );
		$stmt->close ();
	}
*/	

	// Get all the items and their subcomponents
	function getAllItemsRest() {
		// prepare the items statement
		$stmt = $this->db->query (
				'SELECT
					i.id, i.release_id, i.title, i.alias, i.description, i.type,
					i.filename, i.url, i.updatestream, i.md5, i.sha1, i.filesize,
					i.groups, i.hits, i.created_by, i.checked_out, i.checked_out_time,
					i.ordering, i.access, i.show_unauth_links, i.redirect_unauth,
					i.published, i.language, i.environments,
					c.icon_url, c.short_description, c.discussion_url, c.issues_url
				FROM  
					jos_ars_items i 
				LEFT JOIN
					jos_akeeba_item_custom c ON i.id = c.item_id
				INNER JOIN
					jos_ars_releases r ON i.release_id = r.id
				ORDER BY i.title');
		$counter = 0;

		// put the results in an array
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
 			$arrItems[] = $row;
 			$releaseId = $row['release_id'];
			
			// prepare the RELEASE statement
 			$stmt2 = $this->db->query (
 					'SELECT * FROM jos_ars_releases WHERE id=' . $releaseId );

			// should only return one result.  put that row in a variable
			while ( $row2 = $stmt2->fetch_array ( MYSQL_ASSOC ) ) {
 				$rel = $row2;
 				$categoryId = $rel['category_id'];

				// prepare the CATEGORY statement
				$stmt3 = $this->db->query (
						'SELECT *FROM jos_ars_categories WHERE id=' . $categoryId );
 			
				// should only return one result.  put that row in a variable
				while ( $row3 = $stmt3->fetch_array ( MYSQL_ASSOC ) ) {
 					$cat = $row3;

	 				// add the category to the release
	 				$rel['category'] = $cat;
 				}

	 			// add the release to the item
	 			$arrItems[$counter]["release"] = $rel;
 			}

 			$counter++;
		}
		
		// close out the statements and return the array
		$stmt->close ();
 		$stmt2->close();
 		$stmt3->close();
		return $arrItems;
	}
	
	// Get the item and it's subcomponents by item id
	function getItemRest($itemId) {
		// prepare the statement for the item
		$stmt = $this->db->query (
			'SELECT 
				i.id, i.release_id, i.title, i.alias, i.description, i.type,
				i.filename, i.url, i.updatestream, i.md5, i.sha1, i.filesize,
				i.groups, i.hits, i.created_by, i.checked_out, i.checked_out_time,
				i.ordering, i.access, i.show_unauth_links, i.redirect_unauth,
				i.published, i.language, i.environments,
				c.icon_url, c.short_description, c.discussion_url, c.issues_url,
		    d.documentation_link, d.documentation_text
				FROM jos_ars_items i 
				LEFT JOIN
				jos_akeeba_item_custom c ON i.id = c.item_id
				LEFT JOIN
				jos_akeeba_item_documentation d ON i.id = d.item_id
			WHERE i.id=' . $itemId );
		
		// should only return one result.  put that row in a variable
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$item = $row;
		}
		$releaseId = $item['release_id'];
		
		// prepare the statement for the RELEASE
		$stmt2 = $this->db->query (
				'SELECT * FROM jos_ars_releases
				WHERE id=' . $releaseId );

		// should only return one result.  put that row in a variable
		while ( $row2 = $stmt2->fetch_array ( MYSQL_ASSOC ) ) {
			$rel = $row2;
		}
		$categoryId = $rel['category_id'];
		
		// prepare the statement for the CATEGORY
		$stmt3 = $this->db->query (
				'SELECT id, alias, title, description, created, modified, type, directory 
				FROM jos_ars_categories 
				WHERE id=' . $categoryId );

		// should only return one result.  put that row in a variable
		while ( $row3 = $stmt3->fetch_array ( MYSQL_ASSOC ) ) {
			$cat = $row3;
		}
		
		// add the category to the release
		$rel['category'] = $cat;
		// add the release to the item
		$item["release"] = $rel;
		
		$stmt->close ();
		$stmt2->close();
		$stmt3->close();
		return $item;
	}
	
	// Get all the items and their subcomponents by the category id
	function getAllItemsByCategory($catId) {
	
		$isItemFound = false;

		// prepare the statement for items
		$stmt = $this->db->query (
				'SELECT 
					i.id, i.release_id, i.title, i.alias, i.description, i.type,
					i.filename, i.url, i.updatestream, i.md5, i.sha1, i.filesize,
					i.groups, i.hits, i.created_by, i.checked_out, i.checked_out_time,
					i.ordering, i.access, i.show_unauth_links, i.redirect_unauth,
					i.published, i.language, i.environments
				FROM 
					jos_ars_items i
				INNER JOIN
					jos_ars_releases r on i.release_id = r.id
				WHERE 
					r.category_id=' . $catId  );
		$counter = 0;
		
		// put the results in an array
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$isItemFound = true;
			$arrItems[] = $row;
			$releaseId = $row['release_id'];
				
			// prepare the statement for RELEASE
			$stmt2 = $this->db->query (
					'SELECT * FROM jos_ars_releases WHERE id=' . $releaseId );
			
			// should only return one result.  put that row in a variable
			while ( $row2 = $stmt2->fetch_array ( MYSQL_ASSOC ) ) {
				$rel = $row2;
				$categoryId = $rel['category_id'];

				// prepare the statement for CATEGORY
				$stmt3 = $this->db->query (
						'SELECT *FROM jos_ars_categories WHERE id=' . $categoryId );

				// should only return one result.  put that row in a variable
				while ( $row3 = $stmt3->fetch_array ( MYSQL_ASSOC ) ) {
					$cat = $row3;
	
					// add the category to the release
					$rel['category'] = $cat;
				}
	
				// add the release to the item
				$arrItems[$counter]["release"] = $rel;
			}
	
			$counter++;
		}
	
		// close out the statements and return the array
		$stmt->close ();
		if ($isItemFound) {
			$stmt2->close();
			$stmt3->close();
			return $arrItems;
		} else {
			return null;
		}
	}
	
	// Get all the items and their subcomponents by the category id
	function getAllItemsByRelease($relId) {
	
		$isItemFound = false;

		// prepare the statement for items
		$stmt = $this->db->query (
				'SELECT
					i.id, i.release_id, i.title, i.alias, i.description, i.type,
					i.filename, i.url, i.updatestream, i.md5, i.sha1, i.filesize,
					i.groups, i.hits, i.created_by, i.checked_out, i.checked_out_time,
					i.ordering, i.access, i.show_unauth_links, i.redirect_unauth,
					i.published, i.language, i.environments
				FROM
					jos_ars_items i
				WHERE
					i.release_id=' . $relId  );
		$counter = 0;
		
		// put the results in an array
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$isItemFound = true;
			$arrItems[] = $row;
			$releaseId = $row['release_id'];
	
			// prepare the statement for RELEASE
			$stmt2 = $this->db->query (
					'SELECT * FROM jos_ars_releases WHERE id=' . $releaseId );
			
			// should only return one result.  put that row in a variable
			while ( $row2 = $stmt2->fetch_array ( MYSQL_ASSOC ) ) {
				$rel = $row2;
				$categoryId = $rel['category_id'];

				// prepare the statement for CATEGORY
				$stmt3 = $this->db->query (
						'SELECT *FROM jos_ars_categories WHERE id=' . $categoryId );

				// should only return one result.  put that row in a variable
				while ( $row3 = $stmt3->fetch_array ( MYSQL_ASSOC ) ) {
					$cat = $row3;
	
					// add the category to the release
					$rel['category'] = $cat;
				}
	
				// add the release to the item
				$arrItems[$counter]["release"] = $rel;
			}
	
			$counter++;
		}
	
		// close out the statements and return the array
		$stmt->close ();
		if ($isItemFound) {
			$stmt2->close();
			$stmt3->close();
			return $arrItems;
		} else {
			return null;
		}
	}
	
	// this is mostly just for reference use getAllCategories always
	function getAllCategoriesArray() {
		$stmt = $this->db->prepare ( 'SELECT id, title FROM jos_ars_categories' );
		$stmt->execute ();
		$stmt->bind_result ( $id, $title );
		while ( $stmt->fetch () ) {
			$arrCat [] = array (
					$id,
					$title 
			);
		}
		
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
	}
	
	function getFileNameAndDirectory($itemId) {
		$stmt = $this->db->query (
			'select 
			i.id as \'item_id\', i.release_id, i.filename, 
			r.id as \'rel_id\', r.category_id, 
			c.id as \'cat_id\', c.directory
			from jos_ars_items i
			inner join jos_ars_releases r
			on i.release_id = r.id
			inner join jos_ars_categories c
			on  r.category_id = c.id
			where i.id = ' . $itemId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrItem = $row;
		}

		$stmt->close();
		return $arrItem;
	}
	
	function getItemFileName($itemId) {
		// prepare the statement
		$stmt = $this->db->query ( 
			'SELECT i.filename FROM jos_ars_items i WHERE i.id = ' . $itemId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrItem = $row;
		}

		$stmt->close();
//		incrementItemHitCount($itemId);
		
		return $arrItem;
	}

	function incrementItemHitCount($itemId) {
		// prepare the statement
		$stmt = $this->db->prepare ( 
			'UPDATE jos_ars_items SET hits = hits + 1 WHERE id = ' . $itemId );
		$stmt->execute ();
		$stmt->close ();
	}

}

?>