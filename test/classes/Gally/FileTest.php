<?php

require_once 'PHPUnit/Framework.php';
require_once 'app/classes/Gally/File.class.php';

class FileTest extends PHPUnit_Framework_TestCase
{
	public function testGetAbsoluteName()
	{
		$dummy = new Gally_File("blubb");
		$this->assertEquals("blubb", $dummy->getAbsoluteName(), 
			"File doesn't exist. Should be the same as initialized name");
		$base = realpath('.') . '/';
		$file = new Gally_File("test");
		$this->assertTrue($file->exists());
		$this->assertEquals($base . "test/", $file->getAbsoluteName());
	}
	
	public function testIsWriteable()
	{
		$testfolder = new Gally_File('test/data');
		$this->assertTrue($testfolder->isDirectory(), "Testfolder is not a directory");
		$this->assertTrue($testfolder->isWriteable(), "Testfolder is not writeable");
	}
	
	public function testGetExtensionAndSimpleName()
	{
		$testfile = new Gally_File('test/data/horizontal.jpg');
		$this->assertEquals("jpg", $testfile->getExtension(), "File extension should be jpg");
		$this->assertEquals("horizontal.jpg", $testfile->getSimpleName());
	}
	
	public function testListFiles()
	{
		$testfile = new Gally_File('test/data');
		$files = $testfile->listFiles();
		$this->assertGreaterThan(0, sizeof($files), "File list should not be empty");
		foreach($files as $file)
		{
			$this->assertTrue($file instanceof Gally_File);
			$this->assertTrue($file->exists(), "Listed file should exist");
		}
	}
	
	public function testGetParent()
	{
		$subfolder = new Gally_File('test/data/horizontal.jpg');
		$testfile2 = new Gally_File('test');
		$this->assertTrue($subfolder->getParent()->isDirectory(), "File parent should always be a directory");
		$this->assertEquals($testfile2->getAbsoluteName(), $subfolder->getParent()->getParent()->getAbsoluteName());
	}
	
	public function testTouchAndDelete()
	{
		$newfile = new Gally_File("test/data/testfile.txt");
		$this->assertFalse($newfile->exists(), "File should not exist yet");
		$newfile->touch();
		$this->assertTrue($newfile->exists(), "File should exist now");
		$newfile->delete();
		$this->assertFalse($newfile->exists(), "File should be deleted");
	}
}
?>