<?php

require_once 'PHPUnit/Framework.php';
require_once 'app/classes/Gally/Image.class.php';
require_once 'app/classes/Gally/File.class.php';

class ImageTest extends PHPUnit_Framework_TestCase
{
	public function testResizeAndSave()
	{
		$file = new Gally_File("test/data/vertical.jpg");
		$img = new Gally_Image($file);
		$img->resize(200, 400);
		$savefile = new Gally_File("test/data/resized.jpg");
		$img->save($savefile);
		$this->assertTrue($savefile->exists());
	}
	
	public function testRectangularize()
	{
		$vertimg = new Gally_File("test/data/vertical.jpg");
		$img = new Gally_Image($vertimg);
		$img->rectangularize(600, array(255, 255, 255));
		$img->save(new Gally_File("test/data/rectangled_vertical.jpg"));
		
		$horimg = new Gally_File("test/data/horizontal.jpg");
		$img = new Gally_Image($horimg);
		$img->rectangularize(200);
		$img->save(new Gally_File("test/data/rectangled_horizontal.jpg"));
	}
}