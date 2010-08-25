<?php

require_once 'config.php';

function __autoload($class_name) {
    require_once 'classes/' . $class_name . '.class.php';
}

$admin = new GallyAdmin();
$gallery = new GallyGallery(IMAGE_FOLDER);