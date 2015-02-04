<?php

namespace syamgot\Curl\Tests;

use syamgot\Curl\Curl;
use syamgot\Curl\CurlHandler;
use syamgot\Curl\CurlMultiHandler;


/**
 * 
 * 
 */
class CurlTest extends \PHPUnit_Framework_TestCase {


	/**
	 * 
	 * @test 
	 * @covers syamgot\Curl\Curl::multieFecth
	 * @covers syamgot\Curl\CurlMultiHandler::__construct
	 * @covers syamgot\Curl\CurlMultiHandler::add
	 */
	public function multieFecth() {

		//	
		$mch = new CurlMultiHandler();
		$mch->add(new CurlHandler('http://localhost:8000/'));
		$mch->add(new CurlHandler('http://localhost:8000/'));
		$cReses = Curl::multieFecth($mch);
		$this->assertEquals(count($cReses), 2);
		foreach ($cReses as $cRes) {
			$this->assertEquals($cRes->getHttpCode(), 200);
			$this->assertEquals($cRes->getBody(), 'hello');
		}
	}

	/**
	 * 
	 * @test 
	 * @covers syamgot\Curl\Curl::fetch
	 * @covers syamgot\Curl\CurlHandler::__construct
	 * @covers syamgot\Curl\CurlHandler::getHandle
	 * @covers syamgot\Curl\CurlResponse::__construct
	 * @covers syamgot\Curl\CurlResponse::getHttpCode
	 * @covers syamgot\Curl\CurlResponse::getBody
	 * @covers syamgot\Curl\CurlResponse::convert
	 * @covers syamgot\Curl\CurlResponse::getResponseHeader
	 * @covers syamgot\Curl\CurlResponseHeader::__construct
	 * @covers syamgot\Curl\CurlResponseHeader::parse
	 * @covers syamgot\Curl\CurlResponseHeader::getMimeType
	 * @covers syamgot\Curl\CurlResponseHeader::getCookies
	 * @covers syamgot\Curl\CurlResponseHeader::getCookie
	 * @covers syamgot\Curl\CurlCookie::__construct
	 * @covers syamgot\Curl\CurlCookie::getKey
	 * @covers syamgot\Curl\CurlCookie::getValue
	 */
	public function fecth() {

		//
		$ch = new CurlHandler('http://localhost:8000/');
		$cRes = Curl::fetch($ch);
		$this->assertEquals($cRes->getHttpCode(), 200);
		$this->assertEquals($cRes->getBody(), 'hello');

		//
		$cResHdr = $cRes->getResponseHeader();
		$this->assertEquals($cResHdr->getMimeType(), 'text/html');
		$this->assertEquals($cResHdr->get('arienaikeyname'), '');

		//
		$cCookies = $cResHdr->getCookies();
		$this->assertEquals(count($cCookies), 3);
		$this->assertEquals($cResHdr->getCookie('arienaikeyname'), null);

		//
		$cCookie = $cResHdr->getCookie('hoge_key');
		$this->assertEquals($cCookie->getKey(), 'hoge_key');
		$this->assertEquals($cCookie->getValue(), 'hoge_value');

	}

		
	/**
	 * 
	 * @test 
	 * @expectedException syamgot\Curl\Exception\CurlFetchException
	 * @expectedExceptionMessage Failed to connect to 
	 */
	public function fecthException() {
		$ch = new CurlHandler('http://localhost:9999/');
		$cRes = Curl::fetch($ch);
	}

}
