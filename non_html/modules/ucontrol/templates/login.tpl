<form method="post">
<fieldset><legend>Login form</legend>
<dl>
	<dt><label for="nickname">{$clang.USERNAME}</label></dt>
	<dd><input type="text" name="nickname" size="24" /></dd>
	<dt><label for="password">{$clang.PASSWORD}</label></dt>
	<dd><input type="password" name="password" size="30" /></dd>
	<dd><input type="submit" name="submit"
		value="{$clang.LOGINBUTTON}" /><input type="hidden" name="action"
		value="login" /></dd>
</dl>
</fieldset>
</form>