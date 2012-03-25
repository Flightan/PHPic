<?php

class AlbumsController extends Zend_Controller_Action
{
	var $albums;
	
    public function init()
    {
        /* Initialize action controller here */
    }
    
	protected function parseXML($xml)
    {
    	$this->albums = Array();
    	$i = 0;
	    foreach ($xml->collection->album as $value)
		{
			//Faut les mettre dans un tableau
    		$this->albums[$i] = $value->attributes()->title;
    		$i++;
	    }
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
    	$xml = simplexml_load_file($user.'/albums.xml');
    	$this->parseXML($xml);
    	
        // action body
        //ICI faudra gerer leur affichage
    	$form = new Zend_Form;
    	$i = 0;
    	foreach ($this->albums as $album)
    	{
    		$form->addElement('image', 'username'.$i++, array(
    		'label'	=> $album,
    		));
    	}
    	$this->view->form = $form;
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
