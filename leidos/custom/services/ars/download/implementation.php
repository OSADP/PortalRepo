<?php
	require (dirname ( __DIR__ ) . "../../configs/database.php");
	/**
	* Implementation Class for our Download Service
	*/
	class ArsDownload extends DBConfig
	{
		// Get the release by release id
		function get() {
			// make sure the request is valid
			if( isset($_GET['userId']) && isset($_GET['itemId']) ) {
				// values we get from the request
				$userId = mysqli_escape_string($this->db, $_GET['userId']);
				$itemId = mysqli_escape_string($this->db, $_GET['itemId']);
				// decode our userId by simply turning it into a decimal
				// and subtract 618, basically reversing the encode process
				$userId = (int) hexdec($userId) - 618;
				if( $this->verifyUser($userId) ) {
					// get filename and directory among other information
			    $arrItem = $this->getFileInfo( $itemId );
			    // make sure item is published in akeeba
			    if( $arrItem['published'] == 1 ) {
				    // increment download hit
				    $this->incrementItemHitCount($itemId);
				    // get root directory
				    $baseDir = $_SERVER["DOCUMENT_ROOT"];
				    $trimmedDir = ltrim($arrItem["directory"], ".");
				    $filename = $arrItem["filename"];
				    $file = new ZipArchive();
				    $file = $baseDir . $trimmedDir . "/" . $filename;
				    $dirs = explode("/", $filename);

				    if ( file_exists($file) ) {
				    	// insert download log
				    	$this->insertDownloadLogs($userId, $itemId);
				    	// initiate download of file
							header("Content-Type: application/zip");
						  header("Content-Disposition: attachment; filename=" . basename($file));
							header('Content-Transfer-Encoding: binary');
							ob_clean();
							flush();
				    	// insert a log entry
				    	//$this->insertDownloadLogs( $userId, $itemId );
				      return readfile($file);
				    } else {
				      die("Error: File not found.");
				    }
				  } else {
				  	die('Error: File is not published.');
				  }
				}
			}
		}

		// get filename and directory among other information
		function getFileInfo($itemId) {
			$stmt = $this->db->query (
				'SELECT 
					i.id as \'item_id\', i.release_id, i.filename, i.published,
					r.id as \'rel_id\', r.category_id, 
					c.id as \'cat_id\', c.directory
				FROM 
					jos_ars_items i
				INNER JOIN 
					jos_ars_releases r ON i.release_id = r.id
				INNER JOIN 
					jos_ars_categories c ON r.category_id = c.id
				WHERE 
					i.id = ' . $itemId );
			if( $stmt ) {
				while ( $row = $stmt->fetch_assoc() ) {
					$arrItem = $row;
				}

				$stmt->close();
				return $arrItem;
			} else {
				die('Error: Invalid Item.');
			}
		}

		// increment download hit on successful application download
		function incrementItemHitCount($itemId) {
			// prepare the statement
			$stmt = $this->db->prepare('UPDATE jos_ars_items SET hits = hits + 1 WHERE id = ' . $itemId);
			if( $stmt ) {
				$stmt->execute ();
				$stmt->close ();
			} else {
				die('Error: Item doesn\'t exist.');
			}
		}

		// verify that a registered user is using the application
		// to download items
		function verifyUser( $userId ) {
			$stmt = $this->db->query('SELECT username FROM jos_users WHERE id='. $userId);
			$user = NULL;
			while ( $row = $stmt->fetch_assoc() ) {
				$user = $row;
			}
			
			return ( $user != NULL );
		}

		// increment download hit on successful application download
		function insertDownloadLogs( $userId, $itemId ) {
			// get current date and time
			$accessedOn = date('Y-m-d H:m:s');
			// the URL where the request was initiated
			$referer = $_SERVER['HTTP_REFERER'];
			// the IP address of the machine that initiated the request
			$ipAddress = $_SERVER['REMOTE_ADDR'];
			// using an API to get Country code based off of the IP Address
			$geocode = file_get_contents("http://www.geoplugin.net/json.gp?ip={$ipAddress}");
			// convert result to array
			$geocode = json_decode(( $geocode ), true);
			// get the country code value
			$country = $geocode['geoplugin_countryCode'];
			// TODO: this seems to be static, need more info on this
			$authorized = 1;
			// prepare the statement
			$stmt = $this->db->prepare(
				"INSERT INTO jos_ars_log (user_id, item_id, accessed_on, referer, ip, country, authorized)
				 VALUES ($userId, $itemId, '$accessedOn', '$referer', '$ipAddress', '$country', $authorized)"
			 );
			if( $stmt->execute() ) {
				$stmt->close();
				return 1;
			} else {
				$stmt->close();
				return 0;
			}
		}
	}
?>