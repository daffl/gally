<?php

include 'gally.php';

$url = __baseurl() . IMAGE_FOLDER;
$gallery = new Gally_Gallery($url, new Gally_File(__BASE__ . IMAGE_FOLDER), $types);
$mustache = new Mustache();
$view = new Gally_File("views/gallery.mustache");
echo $mustache->render($view->read(), $gallery);