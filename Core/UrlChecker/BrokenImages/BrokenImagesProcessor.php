<?php

namespace Core\UrlChecker\BrokenImages;

use Core\cUrl\curl;
use Core\HtmlDom\simple_html_dom;
use Core\UrlChecker\UrlValidator\UrlValidator;

/**
 * Class BrokenImagesProcessor
 * @package Core\UrlChecker\BrokenImages
 */
class BrokenImagesProcessor
{
	/**
	 * @var string Url
	 */
	private $url = '';

	/**
	 * @var array Broken Images Links
	 */
	private $brokenImagesLinks = array();

	/**
	 * BrokenImagesProcessor constructor.
	 * @param $url string Url
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}

	/**
	 * Find All Broken Images on the site
	 *
	 * @return array
	 */
	public function FindBrokenImages()
	{
		try {
			$html = curl::URLDownloadToVar($this->url);
			if ($html === -1)
				return [];

			$html = new simple_html_dom($html);
			foreach ($html->find('img') as $foundImgTag) {
				var_dump($foundImgTag->src);

				if (empty($foundImgTag->src)) {
					continue;
				}

				$absoluteUrl = UrlValidator::GetAbsoluteUrl($foundImgTag->src, $this->url);
				if (!UrlValidator::UrlExists($absoluteUrl)) {
					array_push($this->brokenImagesLinks, $foundImgTag->src);
				}
			}

			return $this->brokenImagesLinks;
		} catch (\Exception $ex) {
			die($ex);
		}
	}
}