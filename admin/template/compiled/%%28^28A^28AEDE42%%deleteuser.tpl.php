<?php /* Smarty version 2.6.19, created on 2008-04-29 16:20:07
         compiled from deleteuser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'deleteuser.tpl', 1, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['deleteuser']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
<p><?php echo $this->_tpl_vars['lang']['adminusers']['deleteuserexplain']; ?>
</p>
<form method="post" action="">
<input type="hidden" name="action" value="deleteuser" /> 
<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
" /> 
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['deleteuser']; ?>
" />
</form>