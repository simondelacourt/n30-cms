<?php /* Smarty version Smarty-3.1.14, created on 2013-10-01 17:19:19
         compiled from "/Library/WebServer/Documents/php-projects/n30-cms/non_html/modules/content/templates/l.default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:39001085524ae7f7f05446-96042973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ba0916ced871f8dce561808be942c34e93da2ba' => 
    array (
      0 => '/Library/WebServer/Documents/php-projects/n30-cms/non_html/modules/content/templates/l.default.tpl',
      1 => 1378971750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39001085524ae7f7f05446-96042973',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_524ae7f8056ed4_58008188',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524ae7f8056ed4_58008188')) {function content_524ae7f8056ed4_58008188($_smarty_tpl) {?><ul>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ln']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['name'] = 'ln';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ln']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['link'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ln']['index']]['full_title']);?>
</a></li>
	<?php endfor; endif; ?>
</ul><?php }} ?>