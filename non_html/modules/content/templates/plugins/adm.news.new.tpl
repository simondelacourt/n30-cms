<h2 class="bar"><span>{$mlang.news.shortstory}</span></h2>
{$w_short}
<h2 class="bar"><span>{$mlang.news.fullstory}</span></h2>
{$w_full}
<h2 class="bar"><span><input type="checkbox" name="pdata[allowreplies]" checked="checked" value="true"/>{$mlang.news.replies}</span></h2>
<hp><input type="checkbox" name="pdata[allowguestreplies]" />{$mlang.news.guestreplies}</p>
<h2 class="bar"><span>{$mlang.news.groupreplies}</span></h2>
<table id="list"style="width: 100%">
	<tr>
		<th class="id">{$lang.adminusers.id}</th>
		<th class="id">&nbsp;</th>
		<th>{$lang.adminusers.group}</th>
	</tr>
	<tbody>
	{section name=ln loop=$groups}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$groups[ln].id}</td>
			<td class="id"><input type="checkbox" name="pdata[rgroups][]" value="{$groups[ln].id}" checked /></td>
			<td>{$groups[ln].title|htmlspecialchars}</td>
		</tr>
		{/section}
	</tbody>
</table>
