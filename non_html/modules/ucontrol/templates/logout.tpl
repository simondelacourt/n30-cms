<p>{$clang.LOGOUTSTORY}</p>
<form method="post">
<fieldset><legend>Logout form</legend>
<ul>
	<li><input type="radio" name="mode" value="thissession" checked />
	{$clang.LOGOUTTHISSESSION}</li>
	<li><input type="radio" name="mode" value="allsessions" />
	{$clang.LOGOUTALLSESSIONS}</li>
</ul>
<p><input type="submit" name="submit" value="{$clang.LOGOUT}" /><input
	type="hidden" name="action" value="logout" /></p>
</fieldset>
</form>