<?php /* Smarty version Smarty-3.1.14, created on 2013-10-01 17:20:38
         compiled from "/Library/WebServer/Documents/php-projects/n30-cms/admin/template/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:416552785524ae8464cade6-71242235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd96ac7d350eeaae731b55e46ac5f84a58d6c446d' => 
    array (
      0 => '/Library/WebServer/Documents/php-projects/n30-cms/admin/template/home.tpl',
      1 => 1378971750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '416552785524ae8464cade6-71242235',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseurl' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_524ae84655d984_83269157',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524ae84655d984_83269157')) {function content_524ae84655d984_83269157($_smarty_tpl) {?><!--[if lte IE 6]>
<p class="warning"><img src="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/style/icons/small/dialog-warning.png" alt="Warning!"/> <?php echo $_smarty_tpl->tpl_vars['lang']->value['adminlang']['iewarning'];?>
</p>
<![endif]-->
<p><?php echo $_smarty_tpl->tpl_vars['lang']->value['adminlang']['home'];?>
</p><?php }} ?>