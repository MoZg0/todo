<?php

namespace Core\UrlChecker;

use BrokenImages\BrokenImagesProcessor;

class UrlChecker implements iUrlChecker
{
	public function getBrokenImages($links): array
	{
		$result = array();

		foreach ($this->GetLink($links) as $key => $url) {
			var_dump([$key, $url]);
			$ImagesProcessor = new BrokenImagesProcessor($url);
			foreach ($ImagesProcessor->FindBrokenImages() as $imageUrl) {
				array_push($result, $imageUrl);
			}
		}

		return $result;
	}

	public function getAllLinks($links): array
	{
		$result = array();

		return $result;
	}

	private function GetLink($links) {
		foreach ($links as $link) {
			yield $link;
		}
	}
}