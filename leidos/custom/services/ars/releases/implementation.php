<?php
	require (dirname ( __DIR__ ) . "../../configs/database.php");
	/**
	* 
	*/
	class ArsRelease extends DBConfig
	{
		// Get all the releases
		function all() {
			// prepare the statement
			$stmt = $this->db->query ('SELECT * FROM jos_ars_releases WHERE published = 1');
			
			// put the results in an array
			$arrRel = [];
			while ( $row = $stmt->fetch_assoc() ) {
				$arrRel [] = $row;
			}
			
			// close out the statement and return the array
			$stmt->close ();
			return $arrRel;
		}
		
		// Get the release by release id
		function get( $releaseId ) {
			// prepare the statement
			$stmt = $this->db->query ( 
				'SELECT * FROM jos_ars_releases 
				WHERE id=' . $releaseId . 'AND published = 1');

			// should only return one result.  put that row in a variable
			$rel = NULL;
			while ( $row = $stmt->fetch_assoc() ) {
				$rel = $row;
			}

			// close out the statement and return the one release
			$stmt->close ();
			return $rel;
		}
	}
?>