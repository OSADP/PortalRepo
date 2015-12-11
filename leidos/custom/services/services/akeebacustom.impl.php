<?php

require (dirname ( __DIR__ ) . "/configs/database.php");

class AkeebaCustomImpl extends DBConfig {

	// get custom values by category id
	function getCustomById( $categoryId ) {
		// prepare the statement
		$stmt = $this->db->query ( 
				'SELECT *
				FROM jos_akeeba_category_custom 
				WHERE category_id=' . $categoryId );
		// should only return one result.  put that row in a variable
		$cat = null;
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$cat = $row;
		}
		// close out the statement and return the one category
		$stmt->close ();
		return $cat;
	}

	// get custom values by category id
	function setCustomById() {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$stmt = $this->db->prepare ( 
				"INSERT INTO jos_akeeba_category_custom (id, category_id, icon_url)
				VALUES (3, 32, 'lmao rofl')");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	// get custom values by category id
	function insertCustomById( $categoryId, $icon_url ) {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$icon_url = mysqli_escape_string( $this->db, $icon_url );
		$categoryId = mysqli_escape_string( $this->db, $categoryId );
		$stmt = $this->db->prepare ( 
				"INSERT INTO jos_akeeba_category_custom (category_id, icon_url, created)
				VALUES ('$categoryId', '$icon_url', now())");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	// get custom values by category id
	function updateCustomById( $categoryId, $icon_url ) {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$icon_url = mysqli_escape_string( $this->db, $icon_url );
		$categoryId = mysqli_escape_string( $this->db, $categoryId );
		$stmt = $this->db->prepare ( 
				"UPDATE jos_akeeba_category_custom
				SET icon_url = '$icon_url', modified= now() WHERE category_id = '$categoryId'");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	// get all custom values by category id
	function getCategoriesCustoms() {
		// prepare the statement
		$stmt = $this->db->query('SELECT * FROM jos_akeeba_category_custom');
		$cat = null;
		// should only return one result.  put that row in a variable
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$cat [] = $row;
		}
		// close out the statement and return the one category
		$stmt->close ();
		return $cat;
	}

	// get custom values by category id
	function insertItemCustomsById( $itemId, $iconUrl, $shortDescription ) {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$iconUrl = mysqli_escape_string( $this->db, $iconUrl );
		$shortDescription = mysqli_escape_string( $this->db, $shortDescription );
		$itemId = mysqli_escape_string( $this->db, $itemId );
		$stmt = $this->db->prepare ( 
				"INSERT INTO jos_akeeba_item_custom (item_id, icon_url, short_description, created)
				VALUES ('$itemId', '$iconUrl', '$shortDescription', now())");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	// get custom values by category id
	function updateItemCustomsById( $itemId, $iconUrl, $shortDescription ) {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$iconUrl = mysqli_escape_string( $this->db, $iconUrl );
		$itemId = mysqli_escape_string( $this->db, $itemId );
		$stmt = $this->db->prepare ( 
				"UPDATE jos_akeeba_item_custom
				SET icon_url = '$iconUrl', short_description = '$shortDescription', modified= now() WHERE item_id = '$itemId'");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}
	// get custom values by category id
	function getItemCustomsById( $item ) {
		// prepare the statement
		$stmt = $this->db->query ( 
				'SELECT *
				FROM jos_akeeba_item_custom 
				WHERE item_id=' . $item );
		// should only return one result.  put that row in a variable
		$cat = null;
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$cat = $row;
		}
		// close out the statement and return the one category
		$stmt->close ();
		return $cat;
	}

	// get custom values by category id
	function insertItemDocumentationsById( $itemId, $link, $text ) {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$link = mysqli_escape_string( $this->db, $link );
		$text = mysqli_escape_string( $this->db, $text );
		$itemId = mysqli_escape_string( $this->db, $itemId );
		$stmt = $this->db->prepare ( 
				"INSERT INTO jos_akeeba_item_documentation (item_id, documentation_link, documentation_text, created)
				VALUES ('$itemId', '$link', '$text', now())");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	// get custom values by category id
	function updateItemDocumentationsById( $itemId, $iconUrl, $shortDescription ) {
		// prepare the statement
		$this->db->autocommit( TRUE );
		$iconUrl = mysqli_escape_string( $this->db, $iconUrl );
		$itemId = mysqli_escape_string( $this->db, $itemId );
		$stmt = $this->db->prepare ( 
				"UPDATE jos_akeeba_item_documentation
				SET icon_url = '$iconUrl', short_description = '$shortDescription', modified= now() WHERE item_id = '$itemId'");
		// should only return one result.  put that row in a variable
		if ( $stmt->execute() ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	function deleteDocumentationByItemId( $itemId ) {
		$this->db->autocommit( TRUE );
		$stmt = $this->db->query("DELETE FROM jos_akeeba_item_documentation WHERE item_id = '$itemId'");
		if( $stmt ) {
			return 'Success!';
		} else {
			return 'Error!';
		}
		$this->db->autocommit( FALSE );
		$stmt->close();
	}

	// get custom values by category id
	function getDocumentationsById( $itemId ) {
		// prepare the statement
		$stmt = $this->db->query ( 
				"SELECT *
				FROM jos_akeeba_item_documentation 
				WHERE item_id='$itemId'");
		// should only return one result. put that row in a variable
		$cat = [];
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			array_push($cat, $row);
		}
		// close out the statement and return the one category
		$stmt->close ();
		return $cat;
	}
	
}

?>