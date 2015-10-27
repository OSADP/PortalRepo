<?php
require (dirname ( __DIR__ ) . "/configs/database.php");
class ArsService extends DBConfig {
	
	// Main method to redeem a code
	function getAllCategories() {
		// Print all codes in database
		$stmt = $this->db->query ( 'SELECT id, alias, title, description, created, modified, type, directory FROM jos_ars_categories' );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
		
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
	}
	
	// Main method to redeem a code
	function getCategory($categoryId) {
		// Print all codes in database
		$stmt = $this->db->query ( 
				'SELECT id, alias, title, description, created, modified, type, directory 
				FROM jos_ars_categories 
				WHERE id=' . $categoryId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
				
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
	}
	
	// Main method to redeem a code
	function getAllReleases() {
		// Print all codes in database
		$stmt = $this->db->query ( 'SELECT * FROM jos_ars_releases' );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
		
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
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
}

?>