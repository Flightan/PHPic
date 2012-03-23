<?php

class AlbumsController extends Zend_Controller_Action
{
	var $albums;
	
    public function init()
    {
        /* Initialize action controller here */
    	
    	//ICI faut lire le parametre pour savoir quel utilisateur on veut
    	//$this->_request->getParams();
    	
    	//On ouvre le fichier XML correspondant et on le parse pour avoir la liste des albums
    	//exemple
    	$xml = simplexml_load_file('joseph/albums.xml');
    	$this->parseXML($xml);
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
