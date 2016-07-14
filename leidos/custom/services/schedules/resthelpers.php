<?php 
/**
* A helper class to simulate RESTful Web Service functions
*/

class RestHelper
{
	// 
	private $args = [];
	// construct
	function __construct( $requestURI )
	{
		$params = [];
		// get our URI
		$parts = explode ( '/', $requestURI );
		// parse it
		for($i = 0; $i < count ( $parts ); $i ++) {
			// first segment is the param name, second is the value
			$params[ $parts[$i] ] = $parts[$i];
		}

		$this->args['params'] = $params;
		$this->args['parts'] = $parts;
	}
	public function request($match, $impl, $callback) {
		if( $this->isParam($match) ) {
			/**
			 * Call our callback function passing in $this(RestHelper),
			 * the Implementation being used, and $match(string to match).
			 */
			call_user_func($callback, $this, $impl, $match);
		}
	}
	// check if parameter exist
	function isParam( $match ) {
		if( isset($this->args['params'][$match]) )
			return ( $this->args['params'][$match] ) ? 1 : 0;
		else
			return 0;
	}
	// check if parts exist
	function isPart( $match ) {
		return ( $this->args['parts'][$match] ) ? 1 : 0;
	}
	// get next parameter
	function nextParam( $match ) {
		foreach ($this->args['parts'] as $key => $value) {
			if( $this->isParam( $match ) ) {
				if( $value == $this->args['params'][$match] ) {
					// return next paramater
					if( isset($this->args['parts'][ $key + 1 ]))
						return $this->args['parts'][ $key + 1 ];
					else return false;
				}
			} else {
				return false;
			}
		}
	}
	// get argument
	function get( $item = null ) {
		if( ! isset( $item ) ) return json_encode( $this->args );
		$query = $this->args[ $item ];
		if( is_array( $query ) ) {
			return json_encode( $query );
		} else {
			return $query;
		}
	}

}

?>