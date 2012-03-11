<?php

/**
 * class Picture
 * @author Joseph El Khoury
 *
 */
class Picture {
	
 	private $path;
 	private $path_thumbnail;

	public function __construct() 
	{
	}
	
	public function getPath() 
	{
		return $this->path;
	}
	
	public function setPath($path)
	{
		$this->path = $path;
	}
	
	public function getThumbnail() 
	{
		return $this->path_thumbnail;
	}
	
	public function setThumbnail($path_thumbnail)
	{
		$this->path_thumbnail = $path_thumbnail;
	}
	
	public function getSize()
	{
		
	}
}