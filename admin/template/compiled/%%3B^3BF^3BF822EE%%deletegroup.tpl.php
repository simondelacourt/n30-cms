<?php /* Smarty version 2.6.19, created on 2008-04-30 17:38:19
         compiled from deletegroup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'deletegroup.tpl', 1, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['deletegroup']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['group']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
<p><?php echo $this->_tpl_vars['lang']['adminusers']['deletegroupinfo']; ?>
</p>
<form method="post" action="">
<input type="hidden" name="action" value="deletegroup" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['group']['id']; ?>
" />
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['deletegroup']; ?>
" />
</form>