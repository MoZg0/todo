<?php
/**
 * Front controller
 *
 * PHP version 7.3
 */

/**
 * Composer
 */
require 'vendor\autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
date_default_timezone_set('Europe/Helsinki');
//setlocale(LC_TIME, "ru_RU.utf-8");	// Locale
ini_set('max_execution_time', 40000); // 11.11 hours
//set_error_handler('Core\Error::errorHandler');
//set_exception_handler('Core\Error::exceptionHandler');

ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", "PHPErrors.log");

ignore_user_abort(false);


//$val = \Core\UrlChecker\UrlValidator\UrlValidator::ValidateUrl('../../img.png');
//var_dump($val);
//exit;


$linksArray = array(
	'https://wcm.ecentria.tools/PLC_P/CreateFiles_PL/create-new.php',
	'',
	'localhost',
	'127.0.0.1',
);

$check = new Core\UrlChecker\UrlChecker();
var_dump($check->getBrokenImages($linksArray));
var_dump($check->getAllLinks($linksArray));
