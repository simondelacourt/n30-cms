<h2>{$lang.adminusers.usergroups}</h2>
<table id="list" style="width: 99%">
	<tr>
		<th class="id">{$lang.adminusers.id}</th>
		<th>{$lang.adminusers.usergroup}</th>
		<th>&nbsp;</th>
	</tr>
	<tbody>
		{section name=ls loop=$groups}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$groups[ls].id}</td>
			<td><a href="{$groups[ls].link}">{$groups[ls].title}</a></td>
			<td class="image"><a href="{$groups[ls].deletelink}"><img src="{$baseurl}/admin/style/icons/small/process-stop.png" alt="{$lang.adminusers.delete}" /></a></td>
		</tr>
		{/section}
	</tbody>
</table>
<h2>{$lang.adminusers.addnewgroup}</h2>
<form method="post" action="">
<fieldset><legend>{$group.title|htmlspecialchars}</legend>
<dl>
	<dt><label for="title">{$lang.adminusers.group}</label></dt>
	<dd><input type="text" name="title" size="40" /></dd>
</dl>
<dl>
	<dt><label for="default">{$lang.adminusers.default}</label></dt>
	<dd><input type="radio" name="default" value="false" checked/> {$lang.adminusers.false} <input type="radio" name="default" value="true"/> {$lang.adminusers.true}</dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="submit" name="submit" value="{$lang.adminusers.addnewgroup}" />
	<input type="hidden" name="action" value="addnewgroup" />
	</dd>
</dl>
</fieldset>
</form>