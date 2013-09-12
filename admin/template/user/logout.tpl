<p>{$lang.adminuser.LOGOUTSTORY}</p>
<form method="post">
<fieldset><legend>Logout form</legend>
<ul>
	<li><input type="radio" name="mode" value="thissession" checked />
	{$lang.adminuser.LOGOUTTHISSESSION}</li>
	<li><input type="radio" name="mode" value="allsessions" />
	{$lang.adminuser.LOGOUTALLSESSIONS}</li>
</ul>
<p><input type="submit" name="submit" value="{$lang.adminuser.LOGOUT}" /><input
	type="hidden" name="action" value="logout" /></p>
</fieldset>
</form>