<?php

namespace syamgot\Curl;

/**
 *
 *
 */	
Class CurlMultiHandler {

	public function __construct() {
		$this->_mh = curl_multi_init();
		$this->_handlers = array();
	}

	public function add(CurlHandler $h){
		curl_multi_add_handle($this->_mh, $h->getHandle());		
		array_push($this->_handlers, $h);
	}

	public function remove(CurlHandler $h) {
		curl_multi_remove_handle($this->_mh, $h->getHandle());
	}

	/**
	 * 
	 * Enter description here ...
	 * @return curl_multi_init で作成したハンドル
	 */
	public function getHandle() {
		return $this->_mh;	
	}

	/**
	 * 
	 * @return array<CurlHandler>
	 */	
	public function getHandlers() {
		return $this->_handlers;
	}

	/**
	 * 
	 * Enter description here ...
	 */
	public function close() {
		curl_multi_close($this->mh);
	}
	
	private $_handlers;
	private $_mh;
}


