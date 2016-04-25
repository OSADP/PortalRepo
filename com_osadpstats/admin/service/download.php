<?php

/**
 * Accept POST request of sanitized strings and convert it
 * into a text file.
 */
if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if( isset($_POST['text']) )
		$string = $_POST['text'];
	else $string = '';

	header('Content-Disposition: attachment; filename="sample.txt"');
	header('Content-Type: text/plain');
	header('Content-Length: ' . strlen($string));
	header('Connection: close');
} else {
	header("HTTP/1.0 405 Method Not Allowed");
	exit();
}

?>