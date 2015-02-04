<?php

namespace syamgot\Curl;

use syamgot\Curl\Exception\CurlFetchException;

/**
 * 
 * 
 */
class Curl {

	/**
	 * 並列リクエストを実行します。
	 * 
	 * @param CurlMultiHandler $cmh
	 * @return array[CurlResponse]
	 */
	public static function multieFecth(CurlMultiHandler $cmh) {

		$mh = $cmh->getHandle();

		$active = null;
		do {
			$mrc = curl_multi_exec($mh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active and $mrc == CURLM_OK) {
			if (curl_multi_select($mh) != -1) {
				do {
					$mrc = curl_multi_exec($mh, $active);
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		$crs = array();
		foreach ($cmh->getHandlers() as $h) {
			$ch = $h->getHandle();

			$response = curl_multi_getcontent($ch);
			if ($response === false) {
				throw new CurlFetchException(curl_errno($ch), curl_error($ch));
			}
			array_push($crs, new CurlResponse($response, $ch));

			$cmh->remove($h);
			$h->close();
		}

		$cmh = null;

		return $crs;
	}

	/**
	 * リクエストを実行します。 
	 * 
	 * @param CurlHandler $h
	 * @return CurlResponse
	 */
	public static function fetch(CurlHandler $h) {

		$ch = $h->getHandle();

		$response = curl_exec($ch);
		if ($response === false) {
			throw new CurlFetchException(curl_errno($ch), curl_error($ch));
		}
		$cr = new CurlResponse($response, $ch);

		return $cr;
	}

}

