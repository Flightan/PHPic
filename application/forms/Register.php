<?php

class Application_Form_Register extends Zend_Form
{
	public function init()
	{			
		$username = $this->createElement('text', 'username');
		$username	->addValidator('alnum')
					->addValidator('regex', false, array('/^[a-z]+/'))
					->addValidator('stringLength', false, array(1, 20))
					->setRequired(true)
					->addFilter('StringTrim')
					->addErrorMessage('Wrong username value, username must be 1-20 characters and only letters or numbers.')
					->setLabel('Username:');
		
		$email = $this->createElement('text', 'email');
		$email		->addValidator('EmailAddress')
					->addFilter('StringTrim')
					->setRequired(true)
					->addErrorMessage('Email is invalid')
					->setLabel('Email:');
		
		$password = $this->createElement('password', 'password');
		$password	->addValidator('StringLength', false, array(6))
					->addFilter('StringTrim')
					->setRequired(true)
					->addErrorMessage('Please enter a password, password must be at least 6 characters.')
					->setLabel('Password:');
		
		$this	->addElement($username)
				->addElement($password)
				->addElement($email)
				->addElement('submit', 'register', array(
		            'required' => false,
		            'ignore'   => true,
		            'label'    => 'Sign up',
		));
	}
}