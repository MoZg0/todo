<?php

namespace Core\UrlChecker;

use Core\UrlChecker\BrokenImages\BrokenImagesProcessor;

/**
 * Class UrlChecker
 * @package Core\UrlChecker
 */
class UrlChecker implements iUrlChecker
{
	/**
	 * Get all Broken Images from links
	 *
	 * @param $links array Array of URLs
	 * @return array Found Broken Images
	 */
	public function getBrokenImages($links): array
	{
		$result = array();

		foreach ($this->GetLink($links) as $key => $url) {
			var_dump('Key : ' . $key . ' | Url : ' . $url);
			$ImagesProcessor = new BrokenImagesProcessor($url);
			foreach ($ImagesProcessor->FindBrokenImages() as $imageUrl) {
				array_push($result, $imageUrl);
			}
		}

		return $result;
	}

	/**
	 * Get All Links from <a>
	 *
	 * @param $links array Array of URLs
	 * @return array Found Links
	 */
	public function getAllLinks($links): array
	{
		$result = array();

		foreach ($this->GetLink($links) as $key => $url) {
			var_dump('Key : ' . $key . ' | Url : ' . $url);
			$LinkProcessor = new Links\LinksProcessor($url);
			foreach ($LinkProcessor->FindAllLinks() as $href) {
				array_push($result, $href);
			}
		}

		return $result;
	}

	/**
	 * Generator for URLs
	 *
	 * @param $links array Array of URLs
	 * @return \Generator
	 */
	private function GetLink($links) {
		foreach ($links as $link) {
			yield $link;
		}
	}
}