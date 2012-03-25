<?php

class AlbumController extends Zend_Controller_Action
{
	var $images;
	
    public function init()
    {
        /* Initialize action controller here */
    }
    
	protected function parseXML($xml)
    {
    	$images = Array();
	    if ($xml != false)
	    {
	    	foreach($xml->children() as $k=>$item)
	    	{
	    		if($k == "picture")
	    		{
	    			$images[] = $item['url'][0];
	    		}
	    	}
	    }
	    
	    return $images;
    }
    
	function drawImage($image) {
    	return "<li><a href='' title='$image'><img src='/".$this->view->user."/".$this->view->album."/".$image."' alt='$image' /></a></li>";
    }

    public function indexAction()
    {
        //ICI faut lire le parametre pour savoir quel utilisateur on veut
    	$user = $this->getRequest()->getParam('user');
    	$album = $this->getRequest()->getParam('title');
		//L'url doit etre de la forme: http://phpic.localhost.local/albums/index/user/joseph
    	
		//A enlever plus tard et gerer le cas ou pas de parametre dans l'url
		if($user == '')
			$user = 'joseph';
			
		$this->view->user = $user;
		$this->view->album = $album;
    	//On ouvre le fichier XML correspondant et on le parse pour avoir la liste des albums
    	//exemple
    	$path = realpath(APPLICATION_PATH . '/../public/users');
    	$xml = simplexml_load_file($path . "/" . $user.'/'.$album.'/photo.xml');
    	$this->images = $this->parseXML($xml);
    	
        // action body
        //ICI faudra gerer leur affichage
    	$this->view->html = "<ul class='polaroids'>";
    	foreach ($this->images as $image)
    	{
    		$this->view->html .= $this->drawImage($image);
    	}
    	$this->view->html .= "</ul><br class='clear'/>";
    }

    public function loginAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // action body
    }


}
