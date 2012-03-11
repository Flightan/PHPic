<?php
session_start();

function __autoload($class_name) {
	include LIBRARY_PATH . $class_name . '.php';
}

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

require_once(TEMPLATES_PATH . "/header.php");

echo "\n<div class=\"container\">\n";

require_once(TEMPLATES_PATH . "/home.php");

require_once(TEMPLATES_PATH . "/footer.php");

echo "\n</div>\n";