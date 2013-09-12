<h2>{$lang.adminusers.usergroup}: {$group.title}</h2>
<form method="post" action="">
<fieldset><legend>{$group.title|htmlspecialchars}</legend>
<dl>
	<dt><label for="title">{$lang.adminusers.group}</label></dt>
	<dd><input type="text" name="title" size="40" value="{$group.title|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="default">{$lang.adminusers.default}</label></dt>
	<dd><input type="radio" name="default" value="false" {if $group.default=='false'}checked{/if}/> {$lang.adminusers.false} <input type="radio" name="default" value="true" {if $group.default=='true'}checked{/if}/> {$lang.adminusers.true}</dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="submit" name="submit" value="{$lang.adminusers.edit}" />
	<input type="hidden" name="action" value="editgroup" />
	<input type="hidden" name="id" value="{$group.id}" />
	</dd>
</dl>
</fieldset>
</form>
<h2>{$lang.adminusers.rights}</h2>
<form method="post" action="">
<table id="list" style="width: 100%">
	<tr>
		<th class="id">{$lang.adminusers.id}</th>
		<th>{$lang.adminusers.type}</th>
		<th>{$lang.adminusers.accessto}</th>
		<th>{$lang.adminusers.delete}</th>
	</tr>
	<tbody>
		{section name=ls loop=$rights}
		<tr>
			<td class="id">{$rights[ls].id}</td>
			<td>{$rights[ls].type}</td>
			<td>
			{if $rights[ls].type == 'mod' AND $rights[ls].mod != 'all'}
		{$lang.adminusers.rightsinfo.module} <strong>{$rights[ls].mod}</strong>.
		{elseif $rights[ls].type == 'admin'}
		{$lang.adminusers.rightsinfo.admin}
		{elseif $rights[ls].type == 'mod' AND $rights[ls].mod == 'all'}
		{$lang.adminusers.rightsinfo.all}
		{/if}
			</td>
			<td><input type="checkbox" name="delete[]" value="{$rights[ls].id}" /></td>
		</tr>
		{/section}
	</tbody>
</table>
<input type="hidden" name="action" value="deleterights" />
<input type="hidden" name="id" value="{$group.id}" />
<input type="submit" name="submit" value="{$lang.adminusers.delete}" />
</form>
<h2>{$lang.adminusers.addright}</h2>
<form method="post" action="">
<h4><input type="radio" name="type" value="admin" checked/> {$lang.adminusers.rightsinfo.admin}</h4>
<p>{$lang.adminusers.rightsinfo.admin_info}</p>
<h4><input type="radio" name="type" value="all"/> {$lang.adminusers.rightsinfo.all}</h4>
<p>{$lang.adminusers.rightsinfo.all_info}</p>
<h4><input type="radio" name="type" value="mod" id="mod"/> {$lang.adminusers.rightsinfo.amodule}</h4>
<p>
<select name="module"  onclick="document.getElementById('mod').checked = true;">
{section name=ln loop=$modules}
<option value="{$modules[ln]}">{$modules[ln]}</option>
{/section}
</select>
</p>
<input type="hidden" name="action" value="addright" />
<input type="hidden" name="id" value="{$group.id}" />
<input type="submit" name="submit" value="{$lang.adminusers.addright}" />
</form>