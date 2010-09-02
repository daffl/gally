<?php

require_once 'config.php';

function __autoload($classname) {
	$path = implode('/', explode("_", $classname));
    require_once 'classes/' . $path . '.class.php';
}

$gallery = new Gally_Gallery(IMAGE_FOLDER);