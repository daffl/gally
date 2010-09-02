<?php
class Gally_File
{
	private $_filename;
	
	/**
	 * Creates a new file with given filename
	 * @param $filename The filename to use
	 */
	public function __construct($filename)
	{
		$this->_filename = $filename;
	}
	
	/**
	 * Returns whether this file physically exists or not
	 * @return boolen If this file exists or not
	 */
	public function exists()
	{
		return file_exists($this->getFilename());
	}
	
	/* TODO implement these
	
	 public function copy() {}
	 
	public function move(Gally_File $newfile)
	{
		rename($this->getFilename(), $newfile->getFilename());
	}
	 */
	
	/**
	 * Returns whether this file is writeable or not
	 * @return boolean If this file or directory is writeable
	 */
	public function isWriteable()
	{
		return is_writeable($this->getAbsoluteName());
	}
	
	/**
	 * Delete this file
	 * @return If unlink was successful or not 
	 */
	public function delete()
	{
		if($this->exists())
			return unlink($this->getAbsoluteName());
	}
	
	/**
	 * Returns the actual filename this file has been created with
	 * @return string The actual filename (might be absolute or relative)
	 * @see getAbsoluteName for the absolute filename
	 */
	public function getFilename()
	{
		return $this->_filename;
	}
	
	/**
	 * Returns if this file is a directory
	 * @return boolean If this file is a directory
	 */
	public function isDirectory()
	{
		return is_dir($this->getFilename());
	}
	
	private function listItems($files, $directories)
	{
		if($this->isDirectory())
		{
			$files = array();
			$dir = dir($this->getAbsoluteName());
			while($filename = $dir->read())
			{
				if($filename !== "." && $filename !== "..")
				{
					$tmpfile = new Gally_File($this->getAbsoluteName() . $filename);
					if($directories && $tmpfile->isDirectory()) {
						$files[] = $tmpfile;
					}
					if($files && !$tmpfile->isDirectory()) {
						$files[] = $tmpfile;
					}
				}
			}
			$dir->close();
			return $files;	
		}
		return false;
	}
	
	/**
	 * Lists all files if this directory
	 * @return array of Gally_File
	 */
	public function listFiles()
	{
		return $this->listItems(true, false);
	}
	
	public function listAll()
	{
		return $this->listItems(true, true);
	}
	
	/**
	 * Returns the parent directory of this file
	 * @return Gally_File The parent directory
	 */
	public function getParent()
	{
		return new Gally_File(dirname($this->getFilename()));
	}
	
	/**
	 * Returns the files absolute name or the filename if this file doesn't exist
	 * @return string the absolute name. Is equals getFilename if file doesn't exist
	 */
	public function getAbsoluteName()
	{
		if($this->exists())
			return realpath($this->getFilename()) . ($this->isDirectory() ? "/" : "");
		else
			return $this->getFilename();
	}
	
	/**
	 * Returns the simple name of the file without any directories,
	 * if this file is not a directory
	 * @return string The simple name of the file or false
	 * if the simple name can't be determined
	 */
	public function getSimpleName()
	{
		if($this->exists() && !$this->isDirectory())
		{
			$fname = $this->getAbsoluteName();
			return substr($fname, strrpos($fname, '/') + 1, strlen($fname));
		}
		return false;
	}
	
	/**
	 * Returns the file extension of this file as in the filename
	 * @return string The file extension
	 */
	public function getExtension()
	{
		return strtolower(substr($this->getFilename(), strrpos($this->getFilename(), '.') + 1, strlen($this->getFilename())));
	}
	
	/**
	 * Opens this file and returns the file handle
	 * @param $mode The mode to open this file in (@see fopen)
	 * @return filehandle The handle of the open file
	 */
	public function open($mode)
	{
		return fopen($this->getAbsoluteName(), $mode);
	}
	
	/**
	 * Creates an empty file at this files location if it doesn't exist yet
	 * @return void
	 */
	public function touch()
	{
		if(!$this->exists())
		{
			$handle = $this->open("w");
			fclose($handle);
		}
	}
	
	/**
	 * Merge this directory with a given filename
	 * @param $name The name of the file to append to this directory
	 * @return The joined file instance or false it the
	 * 		current file is not a directory 
	 */
	public function join($name)
	{
		if($this->isDirectory()) {
			return new Gally_File($this->getAbsoluteName() . $name);
		}
		return false;
	}
}