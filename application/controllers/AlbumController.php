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
	    /*if ($dir = opendir($path))
		{
			$images = array();
			while (false !== ($file = readdir($dir)))
			{
				if ($file != "." && $file != "..")
				{
					$type = mime_content_type($file);
					$first_token  = strtok('/something', '/');
					$second_token = strtok('/');
					if (mime_content_type($file))
					{
						$images[] = $file;
					}
				}
			}
		}*/
	    
	    return $images;
    }
    
	function drawImage($image) {
    	return "<li><a class='fancybox' rel='group' href='/users/".$this->view->user."/".$this->view->album."/".$image."' title='$image'><img src='/users/".$this->view->user."/".$this->view->album."/thumbnails/".$image."' alt='$image' /></a></li>";
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
    	$this->view->html = "<ul class='polaroids_albums'>";
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
