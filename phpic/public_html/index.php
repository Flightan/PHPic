<?php
session_start();

function __autoload($class_name) {
	include '../resources/library/' . $class_name . '.php';
}

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

require_once(TEMPLATES_PATH . "/header.php");

echo "<div class=\"container\">\n";

require_once(TEMPLATES_PATH . "/home.php");

echo "</div>\n";

require_once(TEMPLATES_PATH . "/footer.php");

echo "</div>\n";