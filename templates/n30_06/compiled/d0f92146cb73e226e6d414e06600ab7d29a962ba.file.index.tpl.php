<?php /* Smarty version Smarty-3.1.14, created on 2013-10-01 17:19:20
         compiled from "/Library/WebServer/Documents/php-projects/n30-cms/templates/n30_06/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1797227195524ae7f80d7f51-37946162%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0f92146cb73e226e6d414e06600ab7d29a962ba' => 
    array (
      0 => '/Library/WebServer/Documents/php-projects/n30-cms/templates/n30_06/index.tpl',
      1 => 1378971751,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1797227195524ae7f80d7f51-37946162',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'version' => 0,
    'pagetitle' => 0,
    'baseurl' => 0,
    'mainmenu' => 0,
    'submenu' => 0,
    'contextmenu' => 0,
    'context' => 0,
    'mod' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_524ae7f81c1b74_50552463',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524ae7f81c1b74_50552463')) {function content_524ae7f81c1b74_50552463($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms - <?php echo $_smarty_tpl->tpl_vars['version']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/templates/n30_06/style/default.css"
	rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<h1>n30 cms - <?php echo $_smarty_tpl->tpl_vars['version']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</h1>
<ul id="mainmenu">
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['name'] = 'ln';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['mainmenu']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
	<li <?php if ($_smarty_tpl->tpl_vars['mainmenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['active']=='true'){?> class="opened"<?php }?>><a
		href="<?php echo $_smarty_tpl->tpl_vars['mainmenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['link'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['mainmenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['full_title'];?>
</span></a></li>
	<?php endfor; endif; ?>
</ul>
<?php if (isset($_smarty_tpl->tpl_vars['submenu']->value[0])){?>
<ul id="submenu">
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['name'] = 'ln';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['submenu']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
	<li <?php if ($_smarty_tpl->tpl_vars['submenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['active']=='true'){?> class="opened"<?php }?>><a
		href="<?php echo $_smarty_tpl->tpl_vars['submenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['link'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['submenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['full_title'];?>
</span></a></li>
	<?php endfor; endif; ?>
</ul>
<?php }?>
<div id="content">
<h2><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</h2>
<?php if (isset($_smarty_tpl->tpl_vars['contextmenu']->value[0])){?>
<ul id="contentmenu">
	<li class="head">menu</li>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['name'] = 'ln';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['contextmenu']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
	<li <?php if ($_smarty_tpl->tpl_vars['context']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['active']=='true'){?> class="opened"<?php }?>><a
		href="<?php echo $_smarty_tpl->tpl_vars['contextmenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['link'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['contextmenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['full_title'];?>
</span></a></li>
	<?php endfor; endif; ?>
</ul>
<?php }?> <?php echo $_smarty_tpl->tpl_vars['mod']->value;?>
 <span style="clear: both;" /></div>
</div>
</body>
</html><?php }} ?>