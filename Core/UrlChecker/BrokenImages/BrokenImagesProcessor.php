<?php

namespace BrokenImages;

use Core\cUrl\curl;
use Core\HtmlDom;

class BrokenImagesProcessor
{
	private $url = '';

	public function __construct($url)
	{
		$this->url = $url;
	}

	public function FindBrokenImages()
	{
		try {
			$brokenImagesLinks = array();

			$html = curl::URLDownloadToVar($this->url);
			$html = str_get_html($html);
			foreach ($html->find('img src') as $foundImgUrl) {
				var_dump($foundImgUrl);
				$isValid = \Core\UrlChecker\UrlValidator\UrlValidator::ValidateUrl($foundImgUrl);
				if ($isValid === false) {
					array_push($brokenImagesLinks, $foundImgUrl);
				}
//					$foundHtml = $sel->{$fieldInfo["attrVal" . $i]};
			}

			return $brokenImagesLinks;
		} catch (\Exception $ex) {
			die($ex);
		}
	}
}