<?php
class Gally_Admin extends Gally_Gallery
{
	protected $sizes;
	
	public function __construct($baseurl, Gally_File $basefolder, 
		$types = array("view", "thumb"), 
		$sizes = array("view" => 600, "thumb" => 100))
	{
		parent::__construct($baseurl, $basefolder, $types);
		if(!$this->basefolder->isWriteable())
			throw new Exception("Folder '$basefolder' is not writeable! Cannot upload images.");
		$this->sizes = $sizes;
	}
	
	public function upload(Gally_File $tempfile, $name)
	{
		if(!$tempfile->exists()) {
			throw new Exception("File '$tempfile' does not exist!");
		}
		foreach($this->types as $type)
		{
			$image = new Gally_Image($tempfile);
			$destfile = $this->basefolder->join($type)->join($name);
			$image->rectangularize($this->sizes[$type]);
			$image->save($destfile);
		}
	}
	
	public function delete($name)
	{
		foreach($this->types as $type)
		{
			$file = $this->basefolder->join($type)->join($name);
			$file->delete();
		}
	}
}