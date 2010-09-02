<?php

class Gally_Image
{
	private $_image;
	private $_type;
	
	/**
	 * Create a new image from a given Gally_File or an option array.
	 * @param $data Can be either an instance of Gally_File of the image to load
	 * or an array containing array("width" => width of the image, "height"
	 * => height of the image, "backround" => 
	 * the background color as array(red, green, blue) (optional)
	 * @return void
	 */
	public function __construct($data)
	{
		if($data instanceof Gally_File)
		{
			$fname = $data->getAbsoluteName();
			$imgdata = getimagesize($fname);
			$this->_type = $imgdata[2];
			if($this->_type == IMAGETYPE_JPEG) {
				$this->_image = imagecreatefromjpeg($fname);
			}
			elseif($this->_type == IMAGETYPE_GIF) {
				$this->_image = imagecreatefromgif($fname);
			}
			elseif($this->_type == IMAGETYPE_PNG) {
				$this->_image = imagecreatefrompng($fname);
			}
			if(!$this->_image)
				throw new Exception($data->getAbsoluteName() . " is not a valid image resource!");
		}
		elseif(is_array($data))
		{
			$this->_image = imagecreatetruecolor($data["width"], $data["height"]);
			if($data["background"]) {
				$white = imagecolorallocate($this->_image, $data["background"][0], $data["background"][1], $data["background"][2]);
				imagefill($this->_image, 0, 0, $white);
			}
		}
		else
			throw new Exception("$data is not a valid parameter for the image class");
	}

	/**
	 * Save this image to a file
	 * @param Gally_File $file The file to save to
	 * @param $compression The JPEG compression rate (if necessary, default: 95)
	 * @param $permissions The permissions to set
	 * @return Gally_File The file this image has been saved to
	 */
	public function save(Gally_File $file, $compression = 95, $permissions = false)
	{
		$image_type = IMAGETYPE_JPEG;
		if($file->getExtension() == "png") {
			$image_type = IMAGETYPE_PNG;
		}
		elseif($file->getExtension() == "gif") {
			$image_type = IMAGETYPE_GIF;
		}
		$fname = $file->getFilename();
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->_image, $fname, $compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->_image, $fname);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->_image, $fname);
		}
		if($permissions) {
			chmod($filename, $permissions);
		}
		return $file;
	}
	
	/**
	 * Returns the current image height
	 * @return int Image height in pixel
	 */
	public function height()
	{
		return imagesy($this->_image);
	}

	/**
	 * Returns the current image width
	 * @return int Image width in pixel
	 */
	public function width()
	{
		return imagesx($this->_image);
	}
	
	/**
	 * Scale down or up for a given percentage
	 * @param $scale The scale to use (in percent)
	 * @return void
	 */
	public function scale($scale)
	{
		$width = $this->width() * $scale/100;
		$height = $this->height() * $scale/100;
		$this->resize($width, $height);
	}
	
	/**
	 * Resize this image
	 * @param $width Width of the new image
	 * @param $height Height of the new image
	 * @return void
	 */
	public function resize($width, $height)
	{
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->_image, 0, 0, 0, 0, $width, $height, $this->width(), $this->height());
		$this->_image = $new_image;
	}
	
	
	/**
	 * Fit this image into a rectangle area with a given size in pixels.
	 * If no background is given, the image will be resized so that it fits into
	 * this rectangular area. If a background color is given as an array(red, green, blue)
	 * the current image will be inserted horizontally or vertically centered into
	 * a rectangular image with the given background color.
	 * @param $size Size of the rectangle area
	 * @param $background The background color to use
	 * @return void
	 */
	public function rectangularize($size, $background = false)
	{
		$ratio = $this->width() / $this->height();
		$xpos = $ypos = 0;
		$width = $height = $size;
		if($ratio > 1) {
			$height = round($size / $ratio);
		}
		else {
			$width = round($size * $ratio);
		}
		
		if(!$background) { // No background color given, just resize the image
			$this->resize($width, $height);
		}
		else // Resize and insert into rectangular image with background color
		{
			$newimg = new Gally_Image(array("width" => $size, "height" => $size, "background" => $background));
			if($ratio > 1) { // width > height so center image vertically
				$ypos = ($size / 2) - ($height / 2);
			}
			else { // width < height so center image horizontally
				$xpos = ($size / 2) - ($width / 2);
			}
			imagecopyresampled($newimg->_image, $this->_image, $xpos, $ypos, 0, 0, $width, $height, $this->width(), $this->height());
			$this->_image = $newimg->_image;	
		} 
	}
}