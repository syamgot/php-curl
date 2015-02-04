<?php

namespace syamgot\Curl;

/**
 * 
 * 
 */
class CurlCookie {

	/**
	 * 
	 */
	public function __construct($str) {
		$this->convert($str);
	}

	/**
	 *
	 */
	private function convert($str) {
		$vals = explode('; ',$str);	
		foreach ($vals as $val) {
			$val = explode('=', $val);	
			if (strtolower($val[0]) === 'expires') {
				$this->expires = $val[1];	
			}
			else if (strtolower($val[0]) === 'path') {
				$this->path = $val[1];	
			}
			else if (strtolower($val[0]) === 'domain') {
				$this->domain = $val[1];	
			}
			else if (count($val) === 1 && trim($val[0]) === 'secure') {
				$this->secure = true;
			}
			else {
				$this->key = $val[0];
				$this->value = $val[1];
			}
		}
	}

	/**
	 * 
	 * @return string
	 */
	public function toString() {
		$str = '';
		if ($this->key !== '' && $this->value !== '') {
			$str.= $this->key.'='.$this->value.'; ';
			if ($this->expires !== '') {
				$str.= 'expires='.$this->expires.'; ';
			}
			if ($this->path !== '') {
				$str.= 'path='.$this->path.'; ';
			}
			if ($this->domain !== '') {
				$str.= 'domain='.$this->domain.'; ';
			}
			if ($this->secure) {
				$str.= 'secure';
			}
			$str = trim($str);
		}
		return $str;
	}
	
	/**
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param string 
	 */
	private $key="";

	/**
	 * @param string 
	 */
	private $value="";

	/**
	 * @param string 
	 */
	private $expires = "";

	/**
	 * @param string 
	 */
	private $domain = "";

	/**
	 * @param string 
	 */
	private $path = "/";

	/**
	 * @param boolean
	 */
	private $secure = false;

}





