<?php

class Zend_View_Helper_ProfileLink extends Zend_View_Helper_Abstract
{
	public function profileLink()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$username = $auth->getIdentity()->username;
			return '<a href=\"/profile' . $username . '\">Welcome, ' . $username .  '</a>';
		}

		return '<a href="login">Login</a>';
	}
}