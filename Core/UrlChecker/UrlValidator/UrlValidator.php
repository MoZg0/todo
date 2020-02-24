<?php

namespace Core\UrlChecker\UrlValidator;

use Core\cUrl\curl;


class UrlValidator
{
	/**
	 * Validation of url link
	 *
	 * @param $url string Url Link
	 * @return bool Valid Url
	 */
	public static function ValidateUrl($url) {
		if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
			return false;
		}

		return true;
	}

	/**
	 * Check if url exists
	 *
	 * @param $url string Url Link
	 * @return bool Url Exist
	 */
	public static function UrlExists($url) {
		if (!static::ValidateUrl($url))
			return false;

		$headers = curl::GetHeaders($url);
		var_dump($headers);
		return (bool)preg_match('#^HTTP/.*\s+(200|301|302)+\s#i', $headers);
	}
}