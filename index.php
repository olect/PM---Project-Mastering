<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);
require_once('configs/config.php');
require_once('configs/defines.php');

require_once(SMARTY_DIR."Smarty.class.php");
require_once(INTERNAL_ROOT."Request.php");
require_once(INTERNAL_ROOT."Db.php");
require_once(INTERNAL_ROOT."Form.php");
require_once(INTERNAL_ROOT."Controller.php");
require_once(INTERNAL_ROOT."IndexController.php");
require_once(INTERNAL_ROOT."PMController.php");
require_once(INTERNAL_ROOT."PMModel.php");

$smarty = new Smarty();
$smarty->template_dir = SMARTY_TEMPLATE_ROOT;
$smarty->compile_dir  = SMARTY_TEMPLATE_COMPILE_ROOT;
$smarty->config_dir   = CONFIG_ROOT;
$smarty->cache_dir    = SMARTY_CACHE_ROOT;

$smarty->assign("SystemTitle", SYSTEM_TITLE);

$indexController = new IndexController($smarty, $_REQUEST);
//var_dump($indexController);

?>