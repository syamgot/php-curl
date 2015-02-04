<?php

namespace syamgot\Curl;

/**
 * 
 * cUrl 実行結果を扱うクラスです.
 *
 */
class CurlResponse {

	/**
	 * 新しい CurlResponse インスタンスを作成します.
	 * 
	 * @param String $response CURLOPT_RETURNTRANSFER オプションが設定された curl_exec もしくは curl_multi_getcontent の返り値.
	 * @param curl_init で作成したセッション
	 */
	public function __construct($response, $ch) {
		$this->response = $response;	
		$this->ch = $ch;
		$this->convert();
	}

	/**
	 * Body を返します.
	 * 
	 * @return mixed
	 */
	public function getBody() {
		return  $this->body;	
	}
	
	/**
	 * Header を返します.
	 * 
	 * @return string
	 */
	public function getHeader() {
		return $this->header;
	}
	
	/**
	 * CurlResponseHeader インスタンスを返します.
	 * 
	 * @return CurlResponseHeader
	 */
	public function getResponseHeader() {
		return $this->responseHeader;	
	}
	
	/**
	 * HTTP コードを返します.
	 * 
	 * @return int
	 */
	public function getHttpCode() {
		return $this->httpCode;	
	}
	
	/**
	 * @return string
	 */
	public function getHeaderOut() {
		return $this->headerOut;
	}
	
	private function convert() {
		
		$header_size 		= (int) curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$this->header 		= (string) substr($this->response, 0, $header_size);
		$this->body 		= (string) substr($this->response, $header_size);
		$this->httpCode 	= (int) curl_getinfo($this->ch,CURLINFO_HTTP_CODE);
		$this->lastUrl 		= (string) curl_getinfo($this->ch,CURLINFO_EFFECTIVE_URL);
		$this->headerOut 	= (string) curl_getinfo($this->ch, CURLINFO_HEADER_OUT);
		$this->curlError 	= curl_errno($this->ch);

		$this->responseHeader 	= new CurlResponseHeader($this->header);
		
	}

	private $ch;
	private $response;
	private $header;
	private $body;
	private $httpCode;
	private $lastUrl;
	private $headerOut;
	private $curlError;
	private $responseHeader;
	
}


