<?php

require_once 'PHPUnit/Framework.php';
require_once 'app/gally.php';

class GalleryAndAdminTest extends PHPUnit_Framework_TestCase
{
	public function testListNames()
	{
		$gallery = new Gally_Gallery("testurl/", new Gally_File("app/images"));
		$names = $gallery->listNames();
		$this->assertEquals("012.jpg", $names[0]);
	}
	
	public function testUploadAndDelete()
	{
		$name = "xytest.jpg";
		$testfile = new Gally_File("test/data/horizontal.jpg");
		$imagefolder = new Gally_File("app/images");
		$admin = new Gally_Admin("testurl/", $imagefolder);
		$admin->upload($testfile, $name);
		$this->assertTrue($imagefolder->join("view")->join($name)->exists(), 
			"File " . $imagefolder->getFilename() . " should exist");
		$admin->delete($name);
	}
}