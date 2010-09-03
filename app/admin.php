<?php

include 'gally.php';

session_start();
if($_POST["username"] && $_POST["password"] && !$_SESSION["user"])
{
	if($_POST["username"] == ADMIN_USER && $_POST["password"] == ADMIN_PASSWORD) {
		$_SESSION["user"] = "admin";
		header( 'Location: admin.php' ) ;
	}
}

if($_GET["action"] == "logout")
{
	session_destroy();
	header( 'Location: admin.php' ) ;
}

if($_SESSION["user"])
{
	$url = __baseurl() . IMAGE_FOLDER;
	$admin = new Gally_Admin($url, new Gally_File(__BASE__ . IMAGE_FOLDER), $types, $sizes);
	
	if($_POST["__method"] == "delete")
	{
		$name = str_replace("/", "", $_POST["name"]);
		$admin->delete($name);
	}
	
	if (!empty($_FILES))
	{
		$tempFile = new Gally_File($_FILES['upload']['tmp_name']);
		$filename = $_FILES['upload']['name'];
		$admin->upload($tempFile, $filename);
		$tempFile->delete();
		header( 'Location: admin.php' ) ;
	}
	
	$view = new Gally_File("views/admin.mustache");
}
else
{
	$view = new Gally_File("views/login.mustache"); 
}

$mustache = new Mustache();
echo $mustache->render($view->read(), $admin);