<?php

$config = array(
	"urls" => array(
		"baseUrl" => "http://phpic.lcl"
),
	"paths" => array(
		"resources" => "/phpic/resources",
		"images" => "/img"
)
);

defined("LIBRARY_PATH")
or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

/*
 Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>