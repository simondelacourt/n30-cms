<table id="list" style="width: 100%">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{$lang.admincms.category}</th>
		<th>{$lang.admincms.title}</th>
		<th>{$lang.admincms.value}</th>
	</tr>
	<tbody>
		{section name=ls loop=$settings}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$templates[ls].id}</td>
			<td><a href="{$settings[ls].link}">{$settings[ls].category_name|htmlspecialchars}</a></td>
			<td><a href="{$settings[ls].link}">{$settings[ls].name|htmlspecialchars}</a></td>
			<td><a href="{$settings[ls].link}">{$settings[ls].reg_value|htmlspecialchars}</a></td>
		</tr>
		{/section}
	</tbody>
</table>
