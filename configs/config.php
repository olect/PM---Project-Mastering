<?php

error_reporting(E_ALL|E_STRICT);
define("SYSTEM_THEME", "default");

define("SYSTEM_TITLE", "PM System");
define("SYSTEM_BASE", "/pm/");

global $dbSettings;
$dbSettings = array(
    "host" 	=> "localhost",
    "user" 	=> "pm",
    "pass" 	=> "laplink",
    "db" 	=> "pm"
);

?>