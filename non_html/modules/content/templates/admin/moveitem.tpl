<h2 class="ttitle">{$mlang.move} {$item.full_title|htmlspecialchars}</h2>
{include file='breadcrumbs.tpl'}
<form method="post" action="">
<dl>
	<dt><label for="dir">{$mlang.currentlocation}: </label></dt>
	<dd>{$item.full_location|htmlspecialchars}</dd>
</dl>
<h3 class="ttitle">{$mlang.targetlocation}:</h3>
<table id="list" style="width: 100%">
	<tr>
		<th class="id">{$mlang.id}</th>
		<th class="id">&nbsp;</th>
		<th>{$mlang.location}</th>
	</tr>
	<tbody>
		{section name=ln loop=$moveto}
		<tr>
			<td class="id">{$moveto[ln].id}</td>
			<td class="id"><input type="radio" name="moveto"  value="{$moveto[ln].id}" onclick="document.getElementById('submit').disabled = false; "/></td>
			<td><strong>{$moveto[ln].full_location|htmlspecialchars}</strong></td>
		</tr>
		{/section}
	</tbody>
</table>
<input type="hidden" name="action" value="move" />
<input type="hidden" name="id" value="{$item.id|intval}" />
<input type="submit" name="submit" value="{$mlang.move}" disabled id="submit"/>
</form>