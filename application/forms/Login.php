<?php

class Application_Form_Login extends Zend_Form
{
	public function init()
	{		
		$username = $this->createElement('text', 'username');
		$username	->addValidator('alnum')
					->addValidator('regex', false, array('/^[a-z]+/'))
					->addValidator('stringLength', false, array(1, 20))
					->setRequired(true)
					->addFilter('StringTrim')
					->addErrorMessage('Please enter a username value')
					->setLabel('Username:');
		
		$password = $this->createElement('password', 'password');
		$password	->addValidator('StringLength', false, array(6))
					->setRequired(true)
					->addFilter('StringTrim')
					->addErrorMessage('Please enter a password')
					->setLabel('Password:');
		
		$this	->addElement($username)
				->addElement($password)
				->addElement('submit', 'login', array('label' => 'Login'));


		// We want to display a 'failed authentication' message if necessary;
		// we'll do that with the form 'description', so we need to add that
		// decorator.
		$this->setDecorators(array(
		'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
		));
	}
}

