<?php

namespace Core\cUrl;

class curl
{
	public static $ch = null;

	private static $postHeaders = array(
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
		"Accept-Language: en-GB,en;q=0.5",
		"Accept-Encoding: gzip, deflate, br",
		"Content-Type: application/x-www-form-urlencoded",
		"Connection: keep-alive",
		"Upgrade-Insecure-Requests: 1",
	);

	private static $userAgents = array(
		"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2",
		"Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A"
	);

	private static $cookieFile = "Cookie.txt";

	public static function Login($postUrl, $referer, $postData)
	{
		static::CheckCurlHandle();

		$options = static::GenerateLoginPostOptions($postUrl, $referer, $postData);

		return static::DoCurl($options);
	}

	public static function URLDownloadToVar($url)
	{
		static::CheckCurlHandle();

		$options = static::GenerateUrlOptions($url);
		return static::DoCurl($options);
	}

	public static function GetHeaders($url) {
		return get_headers($url);
	}

	private static function DoCurl($options)
	{
		try {
			curl_setopt_array(static::$ch, $options);
			$result = curl_exec(static::$ch);
			if (curl_error(static::$ch)) {
				throw new \Exception(curl_error(static::$ch), curl_errno(static::$ch));
			}
			return $result;
		} catch (\Exception $ex) {
			die($ex);
		}
	}

	private static function GenerateUrlOptions($url)
	{
		return array(
			CURLOPT_USERAGENT => static::GenerateRandomUserAgent(),
			CURLOPT_COOKIEJAR => static::$cookieFile,
			CURLOPT_COOKIEFILE => static::$cookieFile,
			CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 30,
			//CURLOPT_PROXYUSERPWD => $proxyauth,
			//CURLOPT_ENCODING => 'UTF-8',
			//CURLOPT_POST => true, // DO NOT USE
			CURLOPT_AUTOREFERER => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_SSL_VERIFYPEER => false,
		);
	}

	private static function GenerateLoginPostOptions($postUrl, $referer, $postData)
	{
		return array(
			CURLOPT_USERAGENT => static::GenerateRandomUserAgent(),
			CURLOPT_HTTPHEADER => static::PostHeaderWithReferer($referer),
			CURLOPT_COOKIEJAR => static::$cookieFile,
			CURLOPT_COOKIEFILE => static::$cookieFile,
			CURLOPT_POSTFIELDS => $postData,
			CURLOPT_AUTOREFERER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_URL => $postUrl,
			CURLOPT_TIMEOUT => 30,
		);
	}

	private static function GenerateRandomUserAgent()
	{
		return static::$userAgents[rand(0, count(static::$userAgents) - 1)];
	}

	private static function PostHeaderWithReferer($referer)
	{
		$newPost = static::$postHeaders;
		$newPost[] = "Referer: $referer";
		return $newPost;
	}

	private static function CheckCurlHandle() {
		if (!static::isCurlInit())
			static::$ch = static::InitCurlHandle();
	}

	private static function isCurlInit()
	{
		if (empty(static::$ch)) {
			return false;
		}
		return true;
	}

	private static function InitCurlHandle()
	{
		return curl_init();
	}
}