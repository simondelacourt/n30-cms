<h2>{$lang.adminusers.addnewuser}</h2>
<form method="post" action="">
<dl>
	<dt><label for="username">{$lang.adminusers.username}</label></dt>
	<dd><input type="text" name="username" size="40" /></dd>
</dl>
<dl>
	<dt><label for="email">{$lang.adminusers.email}</label></dt>
	<dd><input type="text" name="email" size="40" /></dd>
</dl>
<dl>
	<dt><label for="email">{$lang.adminusers.password}</label></dt>
	<dd><input type="password" name="password" size="40" /></dd>
</dl>
<dl>
	<dt><label for="unid">{$lang.adminusers.unid}</label></dt>
	<dd>{$unid}&nbsp;</dd>
</dl>
<dl>
	<dt><label for="templates">{$lang.adminusers.templates}</label></dt>
	<dd>
	<select name="templates">
	{section name=ln loop=$templates}
	<option value="{$templates[ln].id}">{$templates[ln].title}</option>
	{/section}
	</select>
	</dd>
</dl>
<dl>
	<dt><label for="languages">{$lang.adminusers.languages}</label></dt>
	<dd>
	<select name="languages">
	{section name=ln loop=$languages}
	<option value="{$languages[ln].id}">{$languages[ln].title}</option>
	{/section}
	</select></dd>
</dl>
<dl>
	<dt><label for="languages">Groups</label></dt>
	<dd>
	<ul id="grouplist">
	{section name=ln loop=$groups}
	<li><input type="checkbox" name="groups[]" value="{$groups[ln].id}" /> {$groups[ln].title|htmlspecialchars}</li>
	{/section}
	</ul>
	</dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="hidden" name="action" value="adduser" /><input type="hidden" name="unid" value="{$unid}" /><input type="submit" value="{$lang.adminusers.addnewuser}" /></dd>
</dl>
</form>
