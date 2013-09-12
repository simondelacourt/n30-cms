<p>{$lang.adminusers.users}</p>
<form method="post" action="">
<input type="text" name="filter" value="{$filter}"/> <input type="submit" value="{$lang.adminusers.finduser}"/>
</form>
<ul class="plinks">
	{section name=ln loop=$plinks}
	<li><a href="{$plinks[ln].link}">{$plinks[ln].title}</a></li>
	{/section}
</ul>
<table id="list" style="width: 100%">
	<tr>
		<th class="id">{$lang.adminusers.id}</th>
		<th>{$lang.adminusers.username}</th>
	</tr>
	<tbody>
		{section name=ls loop=$users}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$users[ls].id}</td>
			<td><a href="{$users[ls].link}">{$users[ls].username|htmlspecialchars}</a></td>
		</tr>
		{/section}
	</tbody>
</table>
<ul class="plinks">
	{section name=ln loop=$plinks}
	<li><a href="{$plinks[ln].link}">{$plinks[ln].title}</a></li>
	{/section}
</ul>