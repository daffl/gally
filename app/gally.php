<?php

require_once 'config.php';

function __baseurl()
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return substr($pageURL, 0, strrpos($pageURL, "/") + 1);
}

function __autoload($classname) {
	$path = implode('/', explode("_", $classname));
    require_once 'classes/' . $path . '.class.php';
}