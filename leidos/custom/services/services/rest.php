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
			$this->post = $_POST;
		}

		function on( $route )
		{
			return ( isset( $this->parameters[$route] ) );
		}

		function child( $route ) {
			$routeValue = array_search($route, array_values($this->parameters));
			if( $routeValue !== null ) {
				$difference = count($this->parameters) - $routeValue;
				$key = count($this->parameters) - $difference + 1;
				return $this->parts[$key];
			}
			$count = count($this->parameters) - 2;
			if( $key == $count ) {
				return $this->parts[ $key + 1 ];
			} else {
				return 0;
			}
		}
	}
?>