<h2 class="ttitle"><img src="{$baseurl}/non_html/modules/content/plugins/{$plugin}.png" alt="{$plugin}"/> {$title}</h2>
{include file="breadcrumbs.tpl"}
{$pluginextra}
<form method="post" action="" id="page">
<dl>
	<dt><label for="dir">{$mlang.directory}: </label></dt>
	<dd>{$item.full_location|htmlspecialchars}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.title} </label></dt>
	<dd><input type="text" name="title" size="60" id="itemtitle"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.desc} </label></dt>
	<dd><textarea name="desc" class="desc"></textarea></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.thumbnail} </label></dt>
	<dd><input type="text" name="thumbnail" size="90" id="thumbnail"/></dd>
</dl>
{$pluginform}
<input type="submit" name="submit" value="{$save}" id="submitbutton"/>
<h2 class="ttitle2"><a href="#" id="viewadvanced"><img src="{$baseurl}/admin/style/icons/small/go-down.png" alt="." id="next-image"/><img src="{$baseurl}/admin/style/icons/small/go-up.png" alt="." id="up-image" style="display: none;"/></a> {$mlang.advancedoptions} </h2>
<div id="advanced" style="display: none;">
<fieldset class="extra">
<legend><input type="checkbox" name="excludefromnav" />{$mlang.excludefromnav}</legend>
<p>{$mlang.excludefromnavexpl}</p>
</fieldset>
<fieldset class="extra">
<legend><input type="checkbox" name="visibledate" {if $item.visible_date == 'true'}checked{/if}/>{$mlang.visiblefromto}</legend>
<p>{$mlang.from} {html_select_date end_year='+10' field_array='visiblefrom' time=$item.visible_from}</p>
<p>{$mlang.to} {html_select_date end_year='+10' field_array='visibleto' time=$item.visible_from}</p>
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
<textarea name="tags" class="tags">
</textarea>
</fieldset>
<input type="submit" name="submit" value="{$title}" id="submitbutton"/>
</div>
<input type="hidden" name="action" value="additem" />
<input type="hidden" name="plugin" value="{$plugin|htmlspecialchars}" />
<input type="hidden" name="id" value="{$id|intval}" />
</form>
