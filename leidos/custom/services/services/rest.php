<?php
	/**
	* Simulate a RESTful URI format
	*/
	class RouteConfig
	{
		function __construct()
		{
			$parameters = array();
			// get our URI
			$parts = explode ( '/', $_SERVER ['REQUEST_URI'] );
			// parse it
			for($i = 0; $i < count ( $parts ); $i ++) {
				// first segment is the param name, second is the value
				$parameters [$parts [$i]] = $parts [$i];
			}
			$this->parts = $parts;
			$this->parameters = $parameters;
		}

		function on( $route )
		{
			return ( isset( $this->parameters[$route] ) );
		}

		function child( $route ) {
			$count = count($this->parameters) - 2;
			$key = array_search($route, array_values($this->parameters));
			if( $key == $count ) {
				return $this->parts[ $key + 1 ];
			} else {
				return 0;
			}
		}
	}
?>