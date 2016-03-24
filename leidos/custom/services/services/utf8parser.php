<?php

	/**
	* 
	*/
	class UTF8parser
	{
		function convert( $array ) {
	    if ( is_array( $array ) ) {
	        foreach ($array as $k => $v) {
	            $array[$k] = $this->convert($v);
	        }
	    } else if ( is_string ( $array ) ) {
	        return utf8_encode( $array );
	    }
	    return $array;
		}
	}
?>