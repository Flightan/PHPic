<?php

class RegisterController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$this->view->form = $this->getForm();
    }
    
    public function getForm()
    {
    	return new Application_Form_Register(array(
				'action' => '/register/process',
				'method' => 'post',
    	));
    }
    
    public function processAction()
    { 	
    	$request = $this->getRequest();
    	
    	// Check if we have a POST request
    	if (!$request->isPost()) {
    		return $this->_helper->redirector('index');
    	}
    	
    	// Get our form and validate it
    	$form = $this->getForm();
    	if (!$form->isValid($request->getPost())) {
    		// Invalid entries
    		$this->view->form = $form;
    		return $this->render('index'); // re-render the register form
    	}

    	$params = $form->getValues();
    	$filename = APPLICATION_PATH . "/logins";
    	$username = $params["username"];
    	$realm = "phpic";
    	$password = $params["password"];
    	$md5 = md5("$username:$realm:$password");
    	
    	$fileHandle = fopen($filename, 'w');
    	
    	$data = "$username:$realm:$md5\n";
    	fwrite($fileHandle, $data);
    	
    	fclose($fileHandle);
    	
    	$this->_auth_adapter = new Zend_Auth_Adapter_Digest($filename, $realm, $username, $password);
    	
    	$result = Zend_Auth::getInstance()->authenticate($this->_auth_adapter);    	
    	
    	// We're authenticated! Redirect to the home page
    	$this->_helper->redirector('index', 'index');
    }

    /**
     * Encrypts a value by md5 + static token
     *
     * @param string $value
     *
     * @return string $value
     */
   	protected function _encryptPassword($value)
   	{
    	return md5($value);
    }
}

