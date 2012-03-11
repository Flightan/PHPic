<?php

/**
 * class User
 * @author Joseph El Khoury
 *
 */
class User {
	
 	private $username;
 	private $albums;

	public function __construct($xml) 
	{
		readXML($xml);
	}
	
	public function getUsername() 
	{
		return $this->username;
	}
	
	public function getAlbumList()
	{
		
	}
	
	public function addAlbum($album)
	{
		
	}
	
	public function readXML($xml)
	{
		$count = 0;
		
		foreach ($xml->collection->album as $value)
		{
			$a = new Album();
			$a->setTitle($value->getAttribute("title"));
			$this->albums[$count] = $a;
			$count++;
		}
	}
}