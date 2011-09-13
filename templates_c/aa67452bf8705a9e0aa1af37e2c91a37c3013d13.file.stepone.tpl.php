<?php /* Smarty version Smarty-3.0.8, created on 2011-08-30 00:36:03
         compiled from "/Applications/MAMP/htdocs/PM/themes/default/templates/main/stepone.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16757582914e5be35bdafc61-60474069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa67452bf8705a9e0aa1af37e2c91a37c3013d13' => 
    array (
      0 => '/Applications/MAMP/htdocs/PM/themes/default/templates/main/stepone.tpl',
      1 => 1314644669,
      2 => 'file',
    ),
    'e4bd734da867ee4c0d00f873f997e1d75ba8fa5e' => 
    array (
      0 => '/Applications/MAMP/htdocs/PM/themes/default/templates/index.tpl',
      1 => 1314657356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16757582914e5be35bdafc61-60474069',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
       <title><?php echo $_smarty_tpl->getVariable('SystemTitle')->value;?>
</title>
       <link rel="stylesheet" href="themes/default/css/reset.css" type="text/css" />
       <link rel="stylesheet" href="themes/default/css/main.css" type="text/css" />
    </head>
    <body>
        <div id="wrapper">

<div id="form">
    <?php echo $_smarty_tpl->getVariable('form')->value;?>

</div>
<p><?php echo $_smarty_tpl->getVariable('message')->value;?>
</p>
<a href="<?php echo $_smarty_tpl->getVariable('link')->value;?>
" title="<?php echo $_smarty_tpl->getVariable('title')->value;?>
"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</a>
    
</div>
    </body>
</html>