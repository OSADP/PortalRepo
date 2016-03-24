<?php
	require (dirname ( __DIR__ ) . "../../configs/database.php");
	/**
	* 
	*/
	class ArsItems extends DBConfig
	{
		// Get all the releases
		function all() {
			// get the items joining custom values and
			// releases to get the category id value
			$stmt = $this->db->query(
				'SELECT
					i.id, i.release_id, i.title, i.alias, i.description, i.type,
					i.filename, i.url, i.updatestream, i.md5, i.sha1,
					ROUND(i.filesize/1048576, 2) AS "filesize",
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
				WHERE i.published = 1
				AND r.published = 1
				ORDER BY i.title');

			// parse it to a better JSON format with child objects
			// release and category with their values in them
			$counter = 0;
			$arrItems = [];
			// put the results in an array
			while ( $row = $stmt->fetch_assoc() ) {
	 			$arrItems[] = $row;
	 			$releaseId = $row['release_id'];
				
				// prepare the RELEASE statement
	 			$stmt2 = $this->db->query (
					'SELECT * FROM jos_ars_releases 
					WHERE id=' . $releaseId);

				// should only return one result.  put that row in a variable
				while ( $row2 = $stmt2->fetch_assoc() ) {
	 				$rel = $row2;
	 				$categoryId = $rel['category_id'];

					// prepare the CATEGORY statement
					$stmt3 = $this->db->query (
						'SELECT * FROM jos_ars_categories 
						WHERE id=' . $categoryId );
	 			
					// should only return one result.  put that row in a variable
					while ( $row3 = $stmt3->fetch_assoc() ) {
	 					$cat = $row3;
		 				// add the category to the release
		 				$rel['category'] = $cat;
	 				}

		 			// add the release to the item
		 			$arrItems[$counter]["release"] = $rel;
					// @author Robert Roth
					// @desc get all category ids from our database by item id
					$statement4 = $this->db->query('SELECT * FROM jos_akeeba_multicategories WHERE item_id='. $arrItems[$counter]['id']);
					$item['category_ids'] = [];
					if( $statement4 ){
						$category_ids = $statement4->fetch_assoc();
						$parsedCategories = explode(',', $category_ids['category_ids']);
						$arrItems[$counter]['category_ids'] = $parsedCategories;
					}
					$statement4->close();
					//--
	 			}

	 			$counter++;
			}
			
			// close out the statements and return the array
			$stmt->close();
	 		$stmt2->close();
	 		$stmt3->close();
			return $arrItems;
		}
		
		// Get the release by release id
		function get( $itemId ) {
			// prepare the statement for the item
			$stmt = $this->db->query (
				'SELECT 
					i.id, i.release_id, i.title, i.alias, i.description, i.type,
					i.filename, i.url, i.updatestream, i.md5, i.sha1,
					ROUND(i.filesize/1048576, 2) AS "filesize",
					i.groups, i.hits, i.created_by, i.checked_out, i.checked_out_time,
					i.ordering, i.access, i.show_unauth_links, i.redirect_unauth,
					i.published, i.language, i.environments,
					c.icon_url, c.short_description, c.discussion_url, c.issues_url,
			    d.documentation_link, d.documentation_text
				FROM 
					jos_ars_items i 
				LEFT JOIN
					jos_akeeba_item_custom c ON i.id = c.item_id
					LEFT JOIN
					jos_akeeba_item_documentation d ON i.id = d.item_id
				WHERE i.published = 1
				AND i.id=' . $itemId);
			
			// should only return one result.  put that row in a variable
			while ( $row = $stmt->fetch_assoc() ) {
				$item = $row;
			}
			$releaseId = $item['release_id'];
			
			// prepare the statement for the RELEASE
			$stmt2 = $this->db->query (
				'SELECT * FROM jos_ars_releases
				WHERE id=' . $releaseId );

			// should only return one result.  put that row in a variable
			while ( $row2 = $stmt2->fetch_assoc() ) {
				$rel = $row2;
			}
			$categoryId = $rel['category_id'];
			
			// prepare the statement for the CATEGORY
			$stmt3 = $this->db->query (
					'SELECT id, alias, title, description, created, modified, type, directory, published
					FROM jos_ars_categories 
					WHERE id=' . $categoryId);

			// should only return one result.  put that row in a variable
			while ( $row3 = $stmt3->fetch_assoc() ) {
				$cat = $row3;
			}
			// @author Robert Roth
			// @desc get all category ids from our database by item id
			$statement4 = $this->db->query('SELECT * FROM jos_akeeba_multicategories WHERE item_id='. $itemId);
			$item['category_ids'] = [];
			if( $statement4 ){
				$category_ids = $statement4->fetch_assoc();
				$parsedCategories = explode(',', $category_ids['category_ids']);
				$item['category_ids'] = $parsedCategories;
			}
			$statement4->close();
			//--
			
			// add the category to the release
			$rel['category'] = $cat;
			// add the release to the item
			$item["release"] = $rel;
			
			$stmt->close ();
			$stmt2->close();
			$stmt3->close();
			return $item;
		}
	}
?>