<table id="list" style="width: 100%">
	<tr>
		<th class="id">{$lang.admincms.id}</th>
		<th>{$lang.admincms.title}</th>
		<th>{$lang.admincms.default}</th>
		<th>{$lang.admincms.installed}</th>
		<th class="buttons"></th>
	</tr>
	<tbody>
		{section name=ls loop=$languages}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$languages[ls].id}</td>
			<td><a href="{$users[ls].link}">{$languages[ls].title|htmlspecialchars}</a></td>
			<td>{if $languages[ls].default == 'true'}<img src="{$baseurl}/admin/style/icons/small/weather-clear.png" alt="default"/>{/if}</td>
			<td>
				{if $languages[ls].installed == 1}
				{$lang.admincms.installedok}
				{else}
				<a href="{$languages[ls].installurl}">{$lang.admincms.install}</a>
				{/if}
			
			</td>
			<td class="buttons">
			{if $languages[ls].default == 'false' AND $languages[ls].installed == 1}
			<a href="{$languages[ls].setdefaulturl}"><img src="{$baseurl}/admin/style/icons/small/weather-clear.png" alt="default"/></a>
			{/if}
			{if $languages[ls].installed == 1}
			<a href="{$languages[ls].uninstallurl}"><img src="{$baseurl}/admin/style/icons/small/process-stop.png" alt="{$lang.admincms.setasdefault}"/></a>
			{else}
			
			{/if}
			
			</td>
		</tr>
		{/section}
	</tbody>
</table>
