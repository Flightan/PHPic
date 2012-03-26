<?php

class AlbumsController extends Zend_Controller_Action
{
	var $albums;
	
    public function init()
    {
    }
    
	protected function parseXML($xml)
    {
    	$albums = Array();
    	$i = 0;
	    if ($xml != false)
	    {
	    	foreach($xml as $album)
	    	{	
	    		//print_r($album);
    			$i++;
    			$albums[$i]["title"] = $album['title'];
    			$albums[$i]["scope"] = $album['scope'];
    		
    			if ($album['scope'] == "private")
    			{
    				foreach ($album->user as $user)
    					$albums[$i]['user'][] = "".$user['name'];
    			}
	    	}
	    }
	    return $albums;
    }
    
    function random_pic($dir)
    {
    	$files = glob($dir . "*.{[jJ][pP][gG],[jJ][pP][eE][gG],[gG][iI][fF],[pP][nN][gG]}", GLOB_BRACE);
    	if (empty($files))
    	{
    		return "img/user.png";
    	}

    	$file = array_rand($files);
    	return $files[$file];
    }
    
    function drawAlbum($album) {
		$imgSrc = $this->random_pic('users/' . $this->view->user . "/$album/thumbnails/");
    	return "\t\t\t\t<li><a href='/albums/index/user/" . $this->view->user . "/title/$album' title='$album'><img src='/$imgSrc' alt='$album' /></a></li>\n";

    }
	
    function drawImage($image) {
    	return "\t\t\t\t<li><a class='fancybox' rel='group' href='/users/" . $this->view->user
    		. "/" . $this->view->album . "/full/" . $image . "' title='$image'><img src='/users/".$this->view->user."/".$this->view->album."/thumbnails/".$image."' alt='$image' /></a></li>\n";
    }

    public function indexAction() {
    	//User loggé
    	$identity = "";
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
			$ident = $auth->getIdentity();
			$identity = $ident["username"];
    	}
    	//ICI faut lire le parametre pour savoir quel utilisateur on veut
    	$user = $this->getRequest()->getParam('user');
    	
    	if($user == '')
				$this->_helper->redirector('index', 'index');
		$this->view->user = $user;
		//XML correspondant au user
		$path = realpath(APPLICATION_PATH . '/../public/users');	    	
		$album = $this->getRequest()->getParam('title');
    	if (empty($album))
    	{
			//L'url doit etre de la forme: http://phpic.localhost.local/albums/index/user/joseph
	    		
	    	//On ouvre le fichier XML correspondant et on le parse pour avoir la liste des albums
	    	//exemple
			//$xml = simplexml_load_file($path . "/" . $user.'/album.xml');
			$xmlpath = realpath(APPLICATION_PATH . '/../users');
			$xml = simplexml_load_file($xmlpath . '/album_'.$user.'.xml');
	    	$this->albums = $this->parseXML($xml);
	    	
	        // action body
	        //ICI faudra gerer leur affichage
	        $this->view->html = "<div class='page-header'>\n"
									. "\t\t\t<h2><a href='/' title='index'>Home</a> / <a href='/albums/index/user/$user' title='$user'>$user</a></h2>\n"
									. "\t\t</div>\n"
									. "\t\t<div class='content'>\n";
	    	$this->view->html .= "\t\t\t<ul class='polaroids'>\n";
	    	
	    	foreach ($this->albums as $id=>$elt)
	    	{
	    		if ($elt['scope'] == 'public' OR $identity == $user OR (isset($elt['user']) AND in_array($identity, $elt['user'])))
	    			$this->view->html .= $this->drawAlbum($elt['title']);
	    		
	    	}
    	}
    	else 
    	{
    		$this->view->album = $album;
    		$this->view->html = "<div class='page-header'>\n"
									. "\t\t\t<h2><a href='/' title='index'>Home</a> / <a href='/albums/index/user/$user' title='$user'> $user </a> / <a href='/albums/index/user/$user/title/$album' title='$album'>$album</a></h2>\n"
									. "\t\t</div>\n"
									. "\t\t<div class='content'>\n";
    		$this->view->html .= "\t\t\t<ul class='polaroids_albums'>";
			//parcourir le repertoire
			$path .= "/$user/$album/";
    		$files = glob($path . "*.{[jJ][pP][gG],[jJ][pP][eE][gG],[gG][iI][fF],[pP][nN][gG]}", GLOB_BRACE);
 
    		foreach ($files as $photo)
    		{
    			$image = explode("/", $photo);
    			$last = sizeof($image)-1;
    			$this->view->html .= $this->drawImage($image[$last]);
    		}
    	}
    	$this->view->html .= "\t\t\t</ul></div></div>";
    }
}
