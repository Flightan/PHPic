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
		$this->albums = Array();
		readXML($xml);
	}
	
	public function getUsername() 
	{
		return $this->username;
	}
	
	public function setUsername($username) 
	{
		$this->username = $username;
	}
	
	public function getAlbumList()
	{
		return $this->albums;
	}
	
	public function addAlbum($album)
	{
		
	}
	
	public function readXML($xml)
	{
		$count = 0;
		
		foreach ($xml->collection->album as $value)
		{
			$count2 = 0;
			$a = new Album();
			$a->setTitle($value->getAttribute("title"));
			$a->setAuthor($value->getAttribute("author"));
			foreach ($xml->collection->album->user as $user)
			{
				$a->users[$count2] = $user->getAttribute("login");
				$count2++;
			}
			$this->albums[$count] = $a;
			$count++;
		}
	}
}