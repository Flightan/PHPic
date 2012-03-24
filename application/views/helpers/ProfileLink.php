<?php

class Zend_View_Helper_ProfileLink extends Zend_View_Helper_Abstract
{
	public function profileLink()
	{
		$auth = Zend_Auth::getInstance();
		
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			return 'Welcome, ' . $identity["username"] . '<a href="login/logout">Logout</a>';
		}

		return '<a href="login">Login</a><a href="register">Sign up</a>';
	}
}