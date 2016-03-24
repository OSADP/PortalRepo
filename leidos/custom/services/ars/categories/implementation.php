<?php
	require (dirname ( __DIR__ ) . "../../configs/database.php");
	/**
	* 
	*/
	class ArsCategories extends DBConfig
	{
		// Get all the releases
		function all() {
			// prepare the statement
			$stmt = $this->db->query ( 
					'SELECT category.id, category.alias, category.title,
					category.description, category.created, category.modified,
					category.type, category.directory, custom.icon_url, category.published
					FROM jos_ars_categories AS category
					LEFT JOIN jos_akeeba_category_custom AS custom
					ON category.id = custom.category_id
					WHERE category.published = 1');
			$arrCat = [];
			// put the results in an array
			while ( $row = $stmt->fetch_assoc() ) {
				$arrCat [] = $row;
			}
			
			// close out the statement and return the array
			$stmt->close();
			return $arrCat;
		}
		
		// Get the release by release id
		function get( $categoryId ) {
			// prepare the statement
			$stmt = $this->db->query ( 
				'SELECT category.id, category.alias, category.title,
				category.description, category.created, category.modified,
				category.type, category.directory, custom.icon_url
				FROM jos_ars_categories AS category
				LEFT JOIN jos_akeeba_category_custom AS custom
				ON category.id = custom.category_id
				WHERE category.id=' . $categoryId .
				'AND category.published = 1');
					
			// should only return one result.  put that row in a variable
			while ( $row = $stmt->fetch_assoc() ) {
				$cat = $row;
			}

			// close out the statement and return the one category
			$stmt->close ();
			return $cat;
		}
	}
?>