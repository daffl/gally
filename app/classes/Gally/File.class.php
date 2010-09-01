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
		return is_dir($this->getAbsoluteName());
	}
	
	/**
	 * Lists all files if this file is a directory
	 * @return array of Gally_File
	 */
	public function listFiles()
	{
		if($this->isDirectory())
		{
			$files = array();
			$dir = dir($this->getAbsoluteName());
			while($filename = $dir->read())
			{
				if($filename !== "." && $filename !== "..")
				{
					$tmpfile = new Gally_File($this->getAbsoluteName() . "/" . $filename);
					if(!$tmpfile->isDirectory()) // Only add files
						$files[] = $tmpfile;
				}
			}
			$dir->close();
			return $files;	
		}
		throw new Exception('Can not list files on non directory ' . $this->getFilename());
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
			return realpath($this->getFilename());
		else
			return $this->getFilename();
	}
	
	/**
	 * Returns the file extension of this file as in the filename
	 * @return string The files extension
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
}