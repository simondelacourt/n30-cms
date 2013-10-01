<?php /* Smarty version Smarty-3.1.14, created on 2013-10-01 17:20:38
         compiled from "/Library/WebServer/Documents/php-projects/n30-cms/admin/template/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:156730874524ae846447a85-74403808%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c674f1935704f6a381d41cce8b1ec510c7bca9e8' => 
    array (
      0 => '/Library/WebServer/Documents/php-projects/n30-cms/admin/template/login.tpl',
      1 => 1378971750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156730874524ae846447a85-74403808',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pagetitle' => 0,
    'baseurl' => 0,
    'javascriptloads' => 0,
    'error' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_524ae8464c2fb1_54805266',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524ae8464c2fb1_54805266')) {function content_524ae8464c2fb1_54805266($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/Library/WebServer/Documents/php-projects/n30-cms/non_html/Smarty/plugins/modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms admin - <?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/style/default.css" rel="stylesheet"
	type="text/css" />
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['name'] = 'ln';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['javascriptloads']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['total']);
?><script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['javascriptloads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']];?>
"></script> <?php endfor; endif; ?>
</head>
<body>
<div id="wrapper">
<div id="top">&nbsp;</div>
<div id="head"><h1><span>N30-CMS</span></h1></div>
<div id="main">
	<?php if (!empty($_smarty_tpl->tpl_vars['pagetitle']->value)){?><h2><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</h2><?php }?>
	<?php if ($_smarty_tpl->tpl_vars['error']->value){?><p><?php echo $_smarty_tpl->tpl_vars['lang']->value['adminuser']['LOGINERROR'];?>
</p><?php }?>
	<form method="post">
<fieldset><legend>Login form</legend>
<dl>
	<dt><label for="nickname"><?php echo $_smarty_tpl->tpl_vars['lang']->value['adminuser']['USERNAME'];?>
</label></dt>
	<dd><input type="text" name="nickname" size="24" /></dd>
	<dt><label for="password"><?php echo $_smarty_tpl->tpl_vars['lang']->value['adminuser']['PASSWORD'];?>
</label></dt>
	<dd><input type="password" name="password" size="30" /></dd>
	<dd><input type="submit" name="submit"
		value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['adminuser']['LOGINBUTTON'];?>
" /><input type="hidden" name="action"
		value="login" /></dd>
</dl>
</fieldset>
</form>
	
	
</div>
	<div class="copyright">&copy; <?php echo smarty_modifier_date_format(time(),"%Y");?>
 <a href="http://ctstudios.nl">CT.Studios</a></div>
		
<div id="footer">&nbsp;</div>
</div>
</body>
</html><?php }} ?>