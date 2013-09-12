<?php /* Smarty version 2.6.19, created on 2008-06-26 08:42:47
         compiled from logout.tpl */ ?>
<p><?php echo $this->_tpl_vars['lang']['adminuser']['LOGOUTSTORY']; ?>
</p>
<form method="post">
<fieldset><legend>Logout form</legend>
<ul>
	<li><input type="radio" name="mode" value="thissession" checked />
	<?php echo $this->_tpl_vars['lang']['adminuser']['LOGOUTTHISSESSION']; ?>
</li>
	<li><input type="radio" name="mode" value="allsessions" />
	<?php echo $this->_tpl_vars['lang']['adminuser']['LOGOUTALLSESSIONS']; ?>
</li>
</ul>
<p><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminuser']['LOGOUT']; ?>
" /><input
	type="hidden" name="action" value="logout" /></p>
</fieldset>
</form>