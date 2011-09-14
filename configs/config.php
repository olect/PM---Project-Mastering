<?php

error_reporting(E_ALL|E_STRICT);
define("SYSTEM_THEME", "default"); // CHOOSEN THEME BASED ON DIRECTORY NAME

define("SYSTEM_TITLE", "PM System"); // PROJECT TITLE
define("SYSTEM_BASE", "/pm/"); // YOUR BASEHREF ROOT

global $dbSettings;
$dbSettings = array(
    "host" 	=> "YOUR MYSQL SERVER",
    "user" 	=> "MYSQL USERNAME",
    "pass" 	=> "MYSQL PASSWORD",
    "db" 	=> "MYSQL DATABASE NAME"
);

?>