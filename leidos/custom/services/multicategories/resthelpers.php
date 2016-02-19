<?php 
/**
* A helper class to simulate RESTful Web Service functions
*/

class RestHelper
{
	// 
	private $args = [];
	// construct
	function __construct( $params, $parts )
	{
		$this->args['params'] = $params;
		$this->args['parts'] = $parts;
	}
	// check if parameter exist
	function isParam( $match ) {
		return ( $this->args['params'][$match] ) ? 1 : 0;
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