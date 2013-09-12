<?php /* Smarty version 2.6.19, created on 2008-08-19 11:41:45
         compiled from delete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'delete.tpl', 1, false),)), $this); ?>
<h2 class="ttitle"><?php echo $this->_tpl_vars['mlang']['delete']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['full_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "breadcrumbs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="post">
<p><?php echo $this->_tpl_vars['mlang']['deleteexpl']; ?>
</p>
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['mlang']['delete']; ?>
" />
<input type="hidden" name="action" value="delete" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" />
</form>