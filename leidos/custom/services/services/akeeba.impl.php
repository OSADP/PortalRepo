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
	
	function getRelease($releaseId) {
		// Print all codes in database
		$stmt = $this->db->query ( 
				'SELECT * FROM jos_ars_releases  
				WHERE id=' . $releaseId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
				
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
	}
	
	function getAllItems() {
		$stmt = $this->db->query ( 'SELECT * FROM jos_ars_items' );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
		
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
	}
	
	function getItem($itemId) {
		$stmt = $this->db->query ( 
				'SELECT id, release_id, title, alias, description, type, 
					filename, url, updatestream, md5, sha1, filesize, 
					groups, hits, created_by, checked_out, checked_out_time, 
					ordering, access, show_unauth_links, redirect_unauth, 
					published, language, environments  
				FROM jos_ars_items WHERE id=' . $itemId );
		while ( $row = $stmt->fetch_array ( MYSQL_ASSOC ) ) {
			$arrCat [] = $row;
		}
	
		header ( 'Content-type: application/json' );
		echo json_encode ( $arrCat );
		$stmt->close ();
	}
	
	function getItemDetail($itemId) {
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