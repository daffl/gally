<?php

require_once 'PHPUnit/Framework.php';
require_once 'app/classes/File.class.php';

class FileTest extends PHPUnit_Framework_TestCase
{
	public function folder()
	{
		return array(
			array(new File('test/data'))
		);
	}
	
	/**
	 * @dataProvider folder
	 */
	public function testExists($testfolder)
	{
		$this->assertTrue($testfolder->exists(), "Testfolder does not exist");
	}
	
	public function testIsWriteable()
	{
		$testfolder = new File('../data');
		$this->assertTrue($testfolder->isDirectory(), "Testfolder is not a directory");
		$this->assertTrue($testfolder->isWriteable(), "Testfolder is not writeable");
	}
}
?>