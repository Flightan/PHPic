<?php

/**
 * class Album
 * @author Joseph El Khoury
 *
 */
class Album {
	
 	private $author;
 	private $title;
 	private $theme;
 	private $display;
 	private $pictures;

	public function __construct($xml) 
	{
		$this->pictures = Array();
		readXML($xml);
	}
	
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function setAuthor($author)
	{
		$this->author = $author;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function getTheme()
	{
		return $this->theme;
	}
	
	public function setTheme($theme)
	{
		$this->theme = $theme;
	}
	
	public function getDisplay()
	{
		return $this->display;
	}
	
	public function setDisplay($display)
	{
		$this->display = $display;
	}
	
	public function addPicture($picture)
	{
		
	}
	
	public function removePicture($picture)
	{
		
	}
	
	public function getList()
	{
		
	}
	
	public function readXML($xml)
	{
		$count = 0;
		
		$theme = $xml->album->getAttribute("theme");
		$display = $xml->album->getAttribute("display");
		
		foreach ($xml->album->picture as $value)
		{
			$p = new Picture();
			$p->setPath($value->getAttribute("url"));
			$p->setThumbnail($value->getAttribute("thumbnail"));
			$this->pictures[$count] = $p;
			$count++;
		}
	}
}