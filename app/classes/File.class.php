<?php
class File
{
	private $_filename;
	
	public function __construct($filename)
	{
		$this->_filename = $filename;
	}
	
	public function exists()
	{
		return file_exists($this->_filename);
	}
	
	public function move(File $newfile)
	{
		rename($this->getFilename(), $newfile->getFilename());
	}
	
	public function isWriteable()
	{
		return is_writeable($this->getFilename());
	}
	
	public function delete()
	{
		if($this->exists())
			return unlink($this->getFilename());
		throw new Exception('Can not delete ' . $this->getFilename() . ' because it does not exist');
	}
	
	public function getFilename()
	{
		return $this->_filename;
	}
	
	public function isDirectory()
	{
		return is_dir($this->getFilename());
	}
	
	public function listFiles()
	{
		if($this->isDirectory())
		{
			$files = array();
			$dir = dir($this->_filename);
			while($filename = $dir->read())
			{
				if($filename !== "." && $filename !== "..")
					$files[] = $filename;
			}
			$dir->close();
			return $files;	
		}
		throw new Exception('Can not list files on non directory ' . $this->getFilename());
	}
	
	public function getParent()
	{
		return dirname($this->getFilename());
	}
	
	public function getAbsoluteFilename()
	{
		if($this->exists())
			return realpath($this->getFilename());
		throw new Exception('The file ' . $this->getFilename() . ' does not exist');
	}
	
	public function touch()
	{
		
	}
}