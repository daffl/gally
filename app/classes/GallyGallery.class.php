<?php

class GallyGallery
{
	private $_files;
	private $_view;
	private $_thumb;
	private $_base;
	
	public function __construct($base, $viewfolder = "view/", $thumbfolder = "thumb/")
	{
		$this->_view = $viewfolder;
		$this->_thumb = $thumbfolder;
		$this->_base = $base;
		$this->_files = $this->scanImages();
	}
	
	private function scanImages()
	{
		$thumbfiles = $this->listFiles($this->_base . $this->_thumb);
		$viewfiles = $this->listFiles($this->_base . $this->_view);
		// Only return the files that are in both folders
		return array_intersect($thumbfiles, $viewfiles);
	}
	
	private function listFiles($folder)
	{
		$files = array();
		if(is_dir($folder))
		{
			$dir = dir($folder);
			while($filename=$dir->read())
			{
				if($filename !== "." && $filename !== "..")
					$files[] = $filename;
			}
			$dir->close();
		}
		return $files;	
	}
	
	private function view($file)
	{
		return $this->_base . $this->_view . $file;
	}
	
	private function thumb($file)
	{
		return $this->_base . $this->_thumb . $file;
	}
	
	public function getFiles()
	{
		return $this->_files;
	}
}
