<?php

/**
 * A class containing the configuration of our database
 */
class DBConfig {
	// define our database configuration
	private $host = 'localhost';
	private $schema = 'osadp';
	private $username = 'root';
	private $password = 'Password*2';
	
	// define a database variable for subclasses
	protected $db;
	
	// Constructor - open database connection
	function __construct() {
		$this->db = $this->database_connect ();
	}
	
	// Destructor - close database connection
	function __destruct() {
		$this->db->close ();
	}
	protected function database_connect() {
		$config = new mysqli ( $this->host, $this->username, $this->password, $this->schema );
		$config->autocommit ( FALSE );
		return $config;
	}
}

?>