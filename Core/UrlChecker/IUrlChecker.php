<?php

namespace Core\UrlChecker;

/**
 * Interface IUrlChecker
 * @package Core\UrlChecker
 */
interface IUrlChecker {
	public function getBrokenImages($links): array;
	public function getAllLinks($links): array;
}