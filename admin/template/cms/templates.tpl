<table id="list" style="width: 100%">
	<tr>
		<th class="id">{$lang.admincms.id}</th>
		<th>{$lang.admincms.title}</th>
		<th>{$lang.admincms.default}</th>
		<th>{$lang.admincms.installed}</th>
		<th class="buttons"></th>
	</tr>
	<tbody>
		{section name=ls loop=$templates}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$templates[ls].id}</td>
			<td><a href="{$users[ls].link}">{$templates[ls].title|htmlspecialchars}</a></td>
			<td>{if $templates[ls].default == 'true'}<img src="{$baseurl}/admin/style/icons/small/weather-clear.png" alt="default"/>{/if}</td>
			<td>
				{if $templates[ls].installed == 1}
				{$lang.admincms.installedok}
				{else}
				<a href="{$templates[ls].installurl}">{$lang.admincms.install}</a>
				{/if}
			
			</td>
			<td class="buttons">
			{if $templates[ls].default == 'false' AND $templates[ls].installed == 1}
			<a href="{$templates[ls].setdefaulturl}"><img src="{$baseurl}/admin/style/icons/small/weather-clear.png" alt="default"/></a>
			{/if}
			{if $templates[ls].installed == 1}
			<a href="{$templates[ls].uninstallurl}"><img src="{$baseurl}/admin/style/icons/small/process-stop.png" alt="{$lang.admincms.setasdefault}"/></a>
			{else}
			
			{/if}
			
			</td>
		</tr>
		{/section}
	</tbody>
</table>
