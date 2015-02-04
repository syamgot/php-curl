<?php

namespace syamgot\Curl;

/**
 * 
 * 
 */
class CurlResponseHeader {

	/**
	 * 
	 */
	public function __construct($str = null) {
		$this->parse($str);
	}

	/**
	 * 
	 * @return string 
	 */
	private function parse($str) {
		$this->headers = array();
		if ($str !== '') {

			//
			foreach (explode("\n", $str) as $val) {
				$val = trim($val);
				$pos = strpos($val, ':');	
				$key = ($pos > 0) ? substr($val,0,$pos) : '';
				$val = ($pos > 0) ? trim(substr($val,$pos+1)) : $val;
				if ($key !== '' ) {
					if (isset($this->headers[$key])) {
						if (is_array($this->headers[$key]) === false) {
							$this->headers[$key] = array($this->headers[$key]);
						}
						array_push($this->headers[$key], $val);
					}
					else {
						$this->headers[$key] = $val;
					}
				}
				else if ($val !== '') {
					$r = explode(' ', $val);
					$this->protocol 	= $r[0];
					$this->status 		= $r[1];
					$this->message 	= $r[2];
				}
			} 

			//
			$this->cookies = array();
			$cookies = $this->get('Set-Cookie');
			if (is_array($cookies) === false) {
				$cookies = array($cookies);
			}
			foreach ($cookies as $cookie) {
				$c = new CurlCookie($cookie);
				$this->cookies[$c->getKey()] = $c;
			}

		}

	}

	/**
	 * 
	 * @return string 
	 */
	public function get($key = '') {
		return isset($this->headers[$key]) ? $this->headers[$key] : '';
	}

	/**
	 * @return string 
	 */
	public function getMimeType() {
		$cont = $this->get('Content-type');
		$type = '';
		if ($cont !== '' && strpos($cont,'/') > 0) {
			$s = explode(';',$cont);
			$type = $s[0];
		}
		return $type;
	}

	/**
	 * @return array 
	 */
	public function getCookies() {
		return $this->cookies;
	}

	/**
	 * @return CurlCookie 
	 */
	public function getCookie($key) {
		return isset($this->cookies[$key]) ? $this->cookies[$key] : null;
	}

	/**
	 * 
	 * @return string
	 */
	public function toString() {
		$str = '';
		$str .= $this->protocol.' ';
		$str .= $this->status.' ';
		$str .= $this->message.' ';
		$str .= "\n";
		foreach ($this->headers as $key => $val) {
			if (is_array($val)) {
				foreach ($val as $v) {
					$str .= "$key: $v\n";
				}
			}
			else {
				$str .= "$key: $val\n";
			}
		}
		return $str;
	}

	private $header;

	/**
	 * @param array
	 */
	private $headers;

	/**
	 * @param CurlCookies
	 */
	private $cookies;

	private $protocol 	= '';
	private $status 	= '';
	private $message 	= '';

}


