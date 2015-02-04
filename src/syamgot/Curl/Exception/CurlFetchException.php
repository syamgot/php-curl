<?php

namespace syamgot\Curl\Exception;

use \RuntimeException;

/**
 * 
 * 
 */
class CurlFetchException extends RuntimeException {

	/**
	 * 
	 */
    public function __construct($no, $msg) {
        parent::__construct($msg);
    }
	
}



