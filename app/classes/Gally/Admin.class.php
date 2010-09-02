<?php
class Gally_Admin extends Gally_Gallery
{
	protected $sizes;
	
	public function __construct($baseurl, Gally_File $basefolder, $folders = array("original" => "original", 
		"view" => "view", "thumb" => "thumb"),
		$sizes = array("view" => 600, "thumb" => 100))
	{
		parent::__construct($baseurl, $basefolder, $folders);
	}
	
	public function upload($name)
	{
		// $thumb = new Gally_Image()
		// TODO upload functionality
	}
	
	public function delete($name)
	{
		$files = array();
		// Delete from all folders
		$files[] = $this->original->merge($name);
		$files[] = $this->view->merge($name);
		$files[] = $this->thumb->merge($name);
		foreach($files as $file) {
			$file->delete();
		}
	}
}