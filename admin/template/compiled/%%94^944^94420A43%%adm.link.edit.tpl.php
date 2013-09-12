<?php /* Smarty version 2.6.19, created on 2008-08-15 20:49:42
         compiled from adm.link.edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'adm.link.edit.tpl', 3, false),array('modifier', 'stripslashes', 'adm.link.edit.tpl', 3, false),)), $this); ?>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['link']; ?>
</label></dt>
	<dd><input type="text" name="pdata[link]" size="60" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['link'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
" /></dd>
</dl>