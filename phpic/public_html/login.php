<?php

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

require_once(TEMPLATES_PATH . "/header.php");

echo "\n<div class=\"container\">\n";

require_once(TEMPLATES_PATH . "/loginform.php");

require_once(TEMPLATES_PATH . "/footer.php");

echo "\n</div>\n";