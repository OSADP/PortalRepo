<?php
	require( dirname ( __DIR__ ) . '../../../../configuration.php');
	/**
	 * A class containing the configuration of our database
	 */
	class DBConfig extends JConfig {
		// Constructor - open database connection
		function __construct() {
			$this->db = $this->database_connect ();
		}
		// Destructor - close database connection
		function __destruct() {
			$this->db->close ();
		}
		// Create a new MySQL connection
		protected function database_connect() {
			$config = new mysqli ( $this->host, $this->user, $this->password, $this->db );
			$config->autocommit ( FALSE );
			return $config;
		}
	}
?>

