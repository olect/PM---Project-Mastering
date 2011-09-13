<?php /* Smarty version Smarty-3.0.8, created on 2011-07-25 14:33:10
         compiled from "/Applications/MAMP/htdocs/PM/themes/default/templates/main/steptwo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15530049334e2d62864cb807-03088835%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '459b5eeb1567aafb31f23ea2fd057e1e0405ce02' => 
    array (
      0 => '/Applications/MAMP/htdocs/PM/themes/default/templates/main/steptwo.tpl',
      1 => 1311597055,
      2 => 'file',
    ),
    'e4bd734da867ee4c0d00f873f997e1d75ba8fa5e' => 
    array (
      0 => '/Applications/MAMP/htdocs/PM/themes/default/templates/index.tpl',
      1 => 1308650897,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15530049334e2d62864cb807-03088835',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <head>
       <title><?php echo $_smarty_tpl->getVariable('SystemTitle')->value;?>
</title>
       <link rel="stylesheet" href="themes/default/css/main.css" type="text/css" />
    </head>
    <body>
        <div id="wrapper">

<p><?php echo $_smarty_tpl->getVariable('message')->value;?>
</p>
<a href="<?php echo $_smarty_tpl->getVariable('link')->value;?>
" title="<?php echo $_smarty_tpl->getVariable('title')->value;?>
"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</a>
    
</div>
    </body>
</html>