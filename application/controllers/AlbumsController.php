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
    	$i = 0;
	    if ($xml != false)
	    {
	    	foreach($xml->children() as $k=>$item)
	    	{	
	    		if($k == "album")
	    		{
	    			$albums[$i]["title"] = $item['title'][0];
	    			$albums[$i]["scope"] = $item['scope'][0];
	    		}
	    		$i++;
	    	}
	    }
	   // print_r($albums);
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
    	return "<li><a href='/albums/index/user/" . $this->view->user . "/title/$album' title='$album'><img src='/$imgSrc' alt='$album' /></a></li>";

    }
	
    function drawImage($image) {
    	return "<li><a class='fancybox' rel='group' href='/users/".$this->view->user."/".$this->view->album."/full/".$image."' title='$image'><img src='/users/".$this->view->user."/".$this->view->album."/thumbnails/".$image."' alt='$image' /></a></li>\n";
    }

    public function indexAction() {
    	//User loggé
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
			$xml = simplexml_load_file($path . "/" . $user.'/album.xml');
	    	$this->albums = $this->parseXML($xml);
	    	
	        // action body
	        //ICI faudra gerer leur affichage
	        $this->view->html = "<div class='page-header'>
									<h2><a href='/' title='index'>home</a> / <a href='/albums/index/user/$user' title='$user'>$user</a></h2>
									</div>
									<div class='content'>";
	    	$this->view->html .= "<ul class='polaroids'>";
	    /*	echo "<pre>";
	    	print_r($this->albums);
	    	echo "</pre>";
	    	echo $user;*/
	    	foreach ($this->albums as $id=>$elt)
	    	{
	    		if ($elt['scope'] != 'protected' OR $identity == $user)
	    			$this->view->html .= $this->drawAlbum($elt['title']);
	    	}
	    	$this->view->html .= "</ul><br class='clear'/>";
    	}
    	else 
    	{
    		$this->view->album = $album;
    		$this->view->html = "<div class='page-header'>
									<h2><a href='/' title='index'>home</a> / <a href='/albums/index/user/$user' title='$user'> $user </a> / <a href='/albums/index/user/$user/title/$album' title='$album'>$album</a></h2>
									</div>
									<div class='content'>";
    		$this->view->html .= "<ul class='polaroids_albums'>";
			//parcourir le repertoire
			$path .= "/$user/$album/";
    		$files = glob($path . "*.{[jJ][pP][gG],[jJ][pP][eE][gG],[gG][iI][fF],[pP][nN][gG]}", GLOB_BRACE);
 
    		foreach ($files as $photo)
    		{
    			$image = explode("/", $photo);
    			$last = sizeof($image)-1;
    			$this->view->html .= $this->drawImage($image[$last]);
    		}
    		$this->view->html .= "</ul><br class='clear'/>
    								</div>";
    	}
    }
}
