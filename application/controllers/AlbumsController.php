<?php

class AlbumsController extends Zend_Controller_Action
{
	var $albums;
	
    public function init()
    {
        $this->html = "TEST";
    }
    
	protected function parseXML($xml)
    {
    	$albums = Array();
	    if ($xml != false)
	    {
	    	foreach($xml->children() as $k=>$item)
	    	{
	    		if($k == "album")
	    		{
	    			$albums[] = $item['title'][0];
	    		}
	    	}
	    }
	    
	    return $albums;
    }
    
    function random_pic($dir)
    {
    	$files = glob($dir . "*.{[jJ][pP][gG],[gG][iI][fF],[pP][nN][gG]}", GLOB_BRACE);
    	if (empty($files))
    	{
    		return "img/user.png";
    	}

    	$file = array_rand($files);
    	return $files[$file];
    }
    
    function drawAlbum($album) {
    	$imgSrc = $this->random_pic('users/' . $this->view->user . "/$album/thumbnails/");
    	return "<li><a href='/album/index/user/" . $this->view->user . "/title/$album' title='$album'><img src='/$imgSrc' alt='$album' /></a></li>";
    }

    public function indexAction()
    {
    	//ICI faut lire le parametre pour savoir quel utilisateur on veut
    	$user = $this->getRequest()->getParam('user');
		//L'url doit etre de la forme: http://phpic.localhost.local/albums/index/user/joseph
    	
		//A enlever plus tard et gerer le cas ou pas de parametre dans l'url
		if($user == '')
			$user = 'joseph';
		
		$this->view->user = $user;
    	//On ouvre le fichier XML correspondant et on le parse pour avoir la liste des albums
    	//exemple
		$path = realpath(APPLICATION_PATH . '/../public/users');
    	$xml = simplexml_load_file($path . "/" . $user.'/album.xml');
    	$this->albums = $this->parseXML($xml);
    	
        // action body
        //ICI faudra gerer leur affichage
    	$this->view->html = "<ul class='polaroids'>";
    	foreach ($this->albums as $album)
    	{
    		$this->view->html .= $this->drawAlbum($album);
    	}
    	$this->view->html .= "</ul><br class='clear'/>";
    }



}
