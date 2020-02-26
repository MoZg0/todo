<?php

namespace Core\UrlChecker\UrlValidator;

use Core\cUrl\curl;

/**
 * Class UrlValidator
 * @package Core\UrlChecker\UrlValidator
 */
class UrlValidator
{
	/**
	 * Validation of url link
	 *
	 * @param $url string Url Link
	 * @return bool Valid Url
	 */
	public static function ValidateUrl($url) {
		$path = parse_url($url, PHP_URL_PATH);
		$encoded_path = array_map('urlencode', explode('/', $path));
		$url = str_replace($path, implode('/', $encoded_path), $url);

		return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
	}

	/**
	 * Get Absolute Url
	 *
	 * @param $rel string Relative link
	 * @param $base string Base link
	 * @return string
	 */
	public static function GetAbsoluteUrl($rel, $base)
	{
		/* return if already absolute URL */
		if (parse_url($rel, PHP_URL_SCHEME) != '')
			return ($rel);

		/* queries and anchors */
		if ($rel[0] == '#' || $rel[0] == '?')
			return ($base . $rel);

		/* parse base URL and convert to local variables: $scheme, $host, $path, $query, $port, $user, $pass */
		extract(parse_url($base));

		/* remove non-directory element from path */
		$path = preg_replace('#/[^/]*$#', '', $path);

		/* destroy path if relative url points to root */
		if ($rel[0] == '/')
			$path = '';

		/* dirty absolute URL */
		$abs = '';

		/* do we have a user in our URL? */
		if (isset($user)) {
			$abs .= $user;

			/* password too? */
			if (isset($pass))
				$abs .= ':' . $pass;

			$abs .= '@';
		}

		$abs .= $host;

		/* did somebody sneak in a port? */
		if (isset($port))
			$abs .= ':' . $port;

		$abs .= $path . '/' . $rel . (isset($query) ? '?' . $query : '');

		/* replace '//' or '/./' or '/foo/../' with '/' */
		$re = ['#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#'];
		for ($n = 1; $n > 0; $abs = preg_replace($re, '/', $abs, -1, $n)) {
		}

		/* absolute URL is ready! */

		return ($scheme . '://' . $abs);
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

		$headers = curl::CurlGetHeaders($url);
		var_dump($headers);
		return (bool)preg_match('#^HTTP/.*\s+(200|301|302)+\s#i', $headers);
	}
}