<?php
// import our database class
require (dirname ( __DIR__ ) . "/configs/database.php");
// implementation class for multiple categories
class SchedulesImpl extends DBConfig {
	// get all release schedules
	function getAllSchedules() {
		$statement = $this->db->query('SELECT * FROM jos_osadp_release_schedule WHERE published = 1 ORDER BY date DESC');
		$arrCat = [];
		// put the results in an array
		while ( $row = $statement->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
		$statement->close();
		die( json_encode( $arrCat ) );
	}
	// get all categories for all items
	function getAllCategories() {
		$statement = $this->db->query('SELECT * FROM jos_akeeba_multicategories');
		$arrCat = [];
		// put the results in an array
		while ( $row = $statement->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
		$statement->close();
		die( json_encode( $arrCat ) );
	}
	// get all categories for an item by item id
	function getCategoriesByItem( $itemId ) {
		$statement = $this->db->query(
			"SELECT * 
			 FROM jos_akeeba_multicategories
			 WHERE item_id = $itemId");
		// get our row, we expect only 1 row
		$row = $statement->fetch_assoc();
		// close out the statement and return the array
		$statement->close ();
		if( ! empty( $row ) ) {
			return $row;
		} else {
			return false;
		}
	}
	
	// inserting categories by item id
	function insertCategories($itemId, $categories) {
		// convert array into savable data to our db
		$categories = implode(",", $categories );
		// create our query
		$statement = $this->db->prepare(
			"INSERT INTO jos_akeeba_multicategories (item_id, category_ids)
			 VALUES ($itemId, '$categories')"
		 );
		// execute statement and return the appropriate response
		if ( $statement->execute() ) {
			// commit changes to the database
			$this->db->commit();
			$statement->close();
			return TRUE;
		} else {
			$statement->close();
			return FALSE;
		}
	}
	// update categories for an item by itemId
	function updateCategories($itemId, $categories) {
		$categories = implode(',', $categories );
		$statement = $this->db->prepare ( 
			"UPDATE jos_akeeba_multicategories
			 SET category_ids = '$categories'
			 WHERE item_id = $itemId"
		 );
		// should only return one result.  put that row in a variable
		if ( $statement->execute() ) {
			// commit changes to the database
			$this->db->commit();
			$statement->close();
			return true;
		} else {
			$statement->close();
			return false;
		}
		$this->db->autocommit( FALSE );
		$statement->close();
	}

}

?>