<?php /* Smarty version 2.6.19, created on 2008-08-16 15:56:06
         compiled from uninstalltemplate.tpl */ ?>
<form method="post">
<p><?php echo $this->_tpl_vars['lang']['admincms']['uninstalltemplatemessage']; ?>
</p>
<input type="hidden" name="action" value="uninstalltemplate" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['admincms']['proceeduninstall']; ?>
" />
</form>