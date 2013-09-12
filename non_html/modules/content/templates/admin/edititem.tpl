<h2 class="ttitle"><img src="{$baseurl}/non_html/modules/content/plugins/{$item.str_plugin|htmlspecialchars}.png" alt="{$item.str_plugin|htmlspecialchars}"/> {$mlang.edit}: {$item.full_title|htmlspecialchars}</h2>
{include file="breadcrumbs.tpl"}
<form method="post" action="" id="page">
<dl>
	<dt><label for="dir">{$mlang.location}: </label></dt>
	<dd>{$item.full_location|htmlspecialchars}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.title} </label></dt>
	<dd><input type="text" name="title" size="60" value="{$item.full_title|htmlspecialchars|stripslashes}"/></dd>
</dl>
<dl>
	<dt><label for="desc">{$mlang.desc} </label></dt>
	<dd><textarea name="desc" class="desc">{$item.description|htmlspecialchars|stripslashes}</textarea></dd>
</dl>
<dl>
	<dt><label for="thumbnail">{$mlang.thumbnail} </label></dt>
	<dd><input type="text" name="thumbnail" size="90" id="thumbnail" value="{$item.thumbnail|htmlspecialchars}"/></dd>
</dl>
{$pluginform}
<input type="submit" name="submit" value="{$mlang.edit}"/>
<h2 class="ttitle2"><a href="#" id="viewadvanced"><img src="{$baseurl}/admin/style/icons/small/go-down.png" alt="." id="next-image"/><img src="{$baseurl}/admin/style/icons/small/go-up.png" alt="." id="up-image" style="display: none;"/></a> {$mlang.advancedoptions} </h2>
<div id="advanced" style="display: none;">
<fieldset class="extra">
<legend><input type="checkbox" name="excludefromnav" {if $item.excludefromnav == 'true'}checked{/if}/>{$mlang.excludefromnav}</legend>
<p>{$mlang.excludefromnavexpl}</p>
</fieldset>
<fieldset class="extra">
<legend><input type="checkbox" name="visibledate" {if $item.visible_date == 'true'}checked{/if}/>{$mlang.visiblefromto}</legend>
<p>{$mlang.from} {html_select_date end_year='+10' field_array='visiblefrom' time=$item.visible_from}</p>
<p>{$mlang.to} {html_select_date end_year='+10' field_array='visibleto' time=$item.visible_to}</p>
</fieldset>
<fieldset class="extra">
<legend>{$mlang.visiblefor}</legend>
<p><input type="checkbox" name="visibleguest" {if $item.visible_guest == 'yes'}checked{/if}/>{$mlang.visibleexpl}</p>
<table id="list" style="width: 100%">
	<tr>
		<th class="id">{$lang.adminusers.id}</th>
		<th class="id">&nbsp;</th>
		<th>{$lang.adminusers.usergroup}</th>
	</tr>
	<tbody>
		{section name=ls loop=$groups}
		<tr class="{cycle values="td1,td2"}">
			<td class="id">{$groups[ls].id}</td>
			<td class="id"><input type="checkbox" name="visgroup[]" {if $groups[ls].checked == 'true'}checked{/if} value="{$groups[ls].id}" /></td>
			<td>{$groups[ls].title}</td>
		</tr>
		{/section}
	</tbody>
</table>
</fieldset>
<fieldset class="extra">
<legend>{$mlang.tags}</legend>
<p>{$mlang.tagsexpl}</p>
<textarea name="tags" class="tags">{$item.tags|htmlspecialchars}
</textarea>
</fieldset>
<input type="submit" name="submit" value="{$mlang.edit}"/>
</div>
<input type="hidden" name="action" value="edititem" />
<input type="hidden" name="id" value="{$item.id|intval}" />
</form>