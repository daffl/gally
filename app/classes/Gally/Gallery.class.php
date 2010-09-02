<?php

class Gally_Gallery
{
	protected $basefolder;
	protected $baseurl;
	protected $types;
	
	public function __construct($baseurl, Gally_File $basefolder, 
		$types = array("original", "view", "thumb"))
	{
		if(!$basefolder->isDirectory())
			throw new Exception($basefolder->getFilename() . " is not a valid directory!");
		$this->basefolder = $basefolder;
		$this->baseurl = $baseurl;
		$this->types = $types;
	}
	
	public function getFiles($name)
	{
		$result = array();
		foreach($this->types as $type)
		{
			$file = $this->basefolder->join($type)->join($name);
			if($file->exists())
				$result[$type] = $file;
		}
		return $result; 
	}
	
	public function getUrls($name)
	{
		$result = array();
		foreach($this->types as $type)
		{
			$result[$type] = $this->baseurl . $type . '/' . $name;
		}
		return $result; 
	}
	
	public function listNames()
	{
		// TODO array intersect from all types
		$names = array();
		$folder = $this->basefolder->join($this->types[0]);
		foreach($folder->listFiles() as $file)
		{
			$ext = $file->getExtension();
			if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
				$names[] = $file->getSimpleName();
			}
		}
		return $names;
	}
}
