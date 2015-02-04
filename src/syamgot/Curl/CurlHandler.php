<?php

namespace syamgot\Curl;

/**
 * cUrlセッションのラッパークラスです。
 * 
 * @author syamgot
 * @package com\syamgot\php\curl
 */
class CurlHandler {

	/**
	 * 新しい CurlResponse インスタンスを作成します.
	 * 
	 * @param string url
	 */
	public function __construct($url = '') {
		
		$this->handler = curl_init($url);
		$this->posts = array();
		
		// CURLOPT_RETURNTRANSFER, CURLOPT_HEADER, CURLINFO_HEADER_OUT は true で固定
		curl_setopt($this->handler, CURLOPT_HEADER, true);
		curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->handler, CURLINFO_HEADER_OUT, true);
		
	}
	
	/**
	 * 
	 * 
	 */
	public function __destruct() {
		$this->close();
	}

	/**
	 * セッションを閉じます.
	 * 
	 */
	public function close() {
		if ($this->handler) {
			curl_close($this->handler);
			$this->handler = null;
		}
	}
	
	/**
	 * 
	 * 
	 */
	public function setOptions(array $options) {

		//
		foreach ($options as $name => $value) {
			$this->setOption($name, $value);
		}

	}

	/**
	 * 
	 * 
	 */
	public function setOption($name, $value) {
		
		// CURLOPT_RETURNTRANSFER, CURLOPT_HEADER, CURLINFO_HEADER_OUT は true で固定
		if ($name === CURLOPT_HEADER 
		 || $name === CURLOPT_RETURNTRANSFER 
		 || $name === CURLINFO_HEADER_OUT ) {
			return;
		}
		
		curl_setopt($this->handler, $name, $value);
	}

	/**
	 * 複数のPOST送信するデータをセットします.
	 * 
	 * @param array $values
	 * @throws InvalidArgumentException 
	 * @return CurlHandler
	 */
	public function setPosts(array $values) {

		// 
		foreach ($values as $key => $value) { 
			$this->setPost($key, $value);
		}

		return $this;
	}
	
	/**
	 * POST送信するデータをセットします.
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return CurlHandler
	 */
	public function setPost($name, $value) {
		$this->posts[$name] = $value;
		curl_setopt($this->handler, CURLOPT_POSTFIELDS, http_build_query($this->posts, '&'));
		return $this;
	}
	
	/**
	 * @return cUrlセッション
	 */
	public function getHandle() {
		return $this->handler;
	}

	private $posts;
	private $handler;
	
}


