<h2>{$lang.adminusers.edituser} {$user.username|htmlspecialchars}</h2>
{if isset($messages.edituser)}
<ul class="emessage">
{section name=ln loop=$messages.edituser}
<li>
{if $messages.edituser[ln] == 'template'}
{$lang.adminusers.errors.template}
{elseif $messages.edituser[ln] == 'nosuchuser'}
{$lang.adminusers.errors.language}
{elseif $messages.adduser[ln] == 'language'}
{$lang.adminusers.errors.language}
{elseif $messages.edituser[ln] == 'email'}
{$lang.adminusers.errors.email}
{elseif $messages.edituser[ln] == 'password'}
{$lang.adminusers.errors.password}
{elseif $messages.edituser[ln] == 'username'}
{$lang.adminusers.errors.username}
{elseif $messages.edituser[ln] == 'avatar'}
{$lang.adminusers.errors.avatar}
{/if}</li>
{/section}
</ul>
{/if}
<form method="post" action="">
<fieldset><legend>{$user.username|htmlspecialchars}</legend>
<dl>
	<dt><label for="username">{$lang.adminusers.username}</label></dt>
	<dd><input type="text" name="username" size="40" value="{$user.username|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="email">{$lang.adminusers.email}</label></dt>
	<dd><input type="text" name="email" size="40" value="{$user.email|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="avatar">{$lang.adminusers.avatar}</label></dt>
	<dd><input type="text" name="avatar" size="40" value="{$user.avatar|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="signature">{$lang.adminusers.signature}</label></dt>
	<dd><textarea name="signature" class="signature">{$user.signature|htmlspecialchars}</textarea></dd>
</dl>
<dl>
	<dt><label for="unid">{$lang.adminusers.unid}</label></dt>
	<dd>{$user.unid|htmlspecialchars}&nbsp;</dd>
</dl>
<dl>
	<dt><label for="templates">{$lang.adminusers.templates}</label></dt>
	<dd>
	<select name="templates">
	{section name=ln loop=$templates}
	<option value="{$templates[ln].id}"{if $user.template == $templates[ln].id} selected{/if}>{$templates[ln].title}</option>
	{/section}
	</select>
	</dd>
</dl>
<dl>
	<dt><label for="languages">{$lang.adminusers.languages}</label></dt>
	<dd>
	<select name="languages">
	{section name=ln loop=$languages}
	<option value="{$languages[ln].id}"{if $user.lang == $languages[ln].id} selected{/if}>{$languages[ln].title}</option>
	{/section}
	</select></dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="hidden" name="action" value="edituser" /><input type="hidden" name="userid" value="{$user.id}" /><input type="submit" value="{$lang.adminusers.edituser}" /></dd>
</dl>
</fieldset>
</form>
<h2>{$lang.adminusers.editpassword}</h2>
{if isset($messages.editpassword)}
<ul class="emessage">
{section name=ln loop=$messages.editpassword}
<li>
{if $messages.editpassword[ln] == 'passwordnomatch'}
{$lang.adminusers.errors.passwordnomatch}
{elseif $messages.editpassword[ln] == 'passwordshort'}
{$lang.adminusers.errors.password}
{elseif $messages.editpassword[ln] == 'passwordok'}
{$lang.adminusers.passwordedited}
{/if}</li>
{/section}
</ul>
{/if}
<form method="post" action="">
	<fieldset><legend>{$lang.adminusers.editpassword}</legend>
	<dl>
		<dt><label for="password1">{$lang.adminusers.password}</label></dt>
		<dd><input type="password" name="password1" size="40" /></dd>
	</dl>
	<dl>
		<dt><label for="password2">{$lang.adminusers.password}</label></dt>
		<dd><input type="password" name="password2" size="40" /></dd>
	</dl>
	<dl>
		<dt><label for="submit">&nbsp;</label></dt>
		<dd>
		<input type="hidden" name="action" value="editpassword" />
		<input type="hidden" name="userid" value="{$user.id}" />
		<input type="submit" value="{$lang.adminusers.editpassword}" /></dd>
	</dl>
</form>
<h2>{$lang.adminusers.editusergroups}</h2>
<form method="post" action="">
<table id="list"style="width: 100%">
	<tr>
		<th class="id">{$lang.adminusers.id}</th>
		<th class="id">{$lang.adminusers.default}</th>
		<th class="id">{$lang.adminusers.delete}</th>
		<th>{$lang.adminusers.group}</th>
	</tr>
	<tbody>
	{section name=ln loop=$groups}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$groups[ln].id}</td>
			<td class="id"><input type="radio" name="listdefault" value="{$groups[ln].id}" {if $groups[ln].default == 'true'} checked{/if} /></td>
			<td class="id"><input type="checkbox" name="delete[]" value="{$groups[ln].id}" /></td>
			<td>{$groups[ln].title|htmlspecialchars}</td>
		</tr>
		{/section}
	</tbody>
</table>
<input type="hidden" name="userid" value="{$user.id}" /> 
<input type="hidden" name="action" value="editusergroups" /> 
<p><input type="submit" name="submit" value="{$lang.adminusers.editusergroups}" /></p>
</form>
{if isset($ugroups[0])}
<form method="post" target="">
<select name="group">
{section name=ln loop=$ugroups}
<option value="{$ugroups[ln].id}">{$ugroups[ln].title|htmlspecialchars}</option>
{/section}
</select>
<input type="hidden" name="action" value="addusertogroup" /> 
<input type="hidden" name="userid" value="{$user.id}" /> 
<input type="submit" name="submit" value="{$lang.adminusers.addgroup}" />
</form>{/if}
