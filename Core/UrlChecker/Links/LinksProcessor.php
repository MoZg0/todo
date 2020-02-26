<?php


namespace Core\UrlChecker\Links;


use Core\cUrl\curl;
use Core\HtmlDom\simple_html_dom;
use Core\UrlChecker\UrlValidator\UrlValidator;

/**
 * Class LinksProcessor
 * @package Core\UrlChecker\Links
 */
class LinksProcessor
{
	/**
	 * @var string Url
	 */
	private $url = '';

	/**
	 * @var array Links
	 */
	private $links = array();

	/**
	 * LinksProcessor constructor.
	 * @param $url string Url
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}

	/**
	 * Find All <a href="#"> links
	 *
	 * @return array
	 */
	public function FindAllLinks() {
		try {
			$html = curl::URLDownloadToVar($this->url);
			if ($html === -1)
				return [];

			$html = new simple_html_dom($html);
			foreach ($html->find('a') as $foundATag) {
				var_dump($foundATag->href);

				if (empty($foundATag->href)) {
					continue;
				}

				$absoluteUrl = UrlValidator::GetAbsoluteUrl($foundATag->href, $this->url);
				array_push($this->links, $absoluteUrl);
			}

			return $this->links;
		} catch (\Exception $ex) {
			die($ex);
		}
	}

}