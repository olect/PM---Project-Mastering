<?php

// Need only to define this path
define("ROOT_DIR", "/Applications/MAMP/htdocs/PM/");

define("SMARTY_DIR", ROOT_DIR."libs/");
define("CLASSES_ROOT", ROOT_DIR."classes/");

define("CONTAINER_ROOT", CLASSES_ROOT."containers/");
define("MODELS_ROOT", CLASSES_ROOT."models/");
define("CONTROLLERS_ROOT", CLASSES_ROOT."controllers/");

define("SMARTY_TEMPLATE_ROOT", ROOT_DIR."themes/".SYSTEM_THEME."/templates/");
define("SMARTY_TEMPLATE_COMPILE_ROOT", ROOT_DIR."templates_c/");
define("SMARTY_CACHE_ROOT", ROOT_DIR."cache/");
define("CONFIG_ROOT", ROOT_DIR."configs/");

define("INTERNAL_ROOT", ROOT_DIR."internal/");

?>