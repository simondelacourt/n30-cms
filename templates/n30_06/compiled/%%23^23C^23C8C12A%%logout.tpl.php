<?php /* Smarty version 2.6.19, created on 2008-06-26 09:52:17
         compiled from logout.tpl */ ?>
<p><?php echo $this->_tpl_vars['clang']['LOGOUTSTORY']; ?>
</p>
<form method="post">
<fieldset><legend>Logout form</legend>
<ul>
	<li><input type="radio" name="mode" value="thissession" checked />
	<?php echo $this->_tpl_vars['clang']['LOGOUTTHISSESSION']; ?>
</li>
	<li><input type="radio" name="mode" value="allsessions" />
	<?php echo $this->_tpl_vars['clang']['LOGOUTALLSESSIONS']; ?>
</li>
</ul>
<p><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['clang']['LOGOUT']; ?>
" /><input
	type="hidden" name="action" value="logout" /></p>
</fieldset>
</form>