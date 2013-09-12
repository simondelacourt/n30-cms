<form method="post" id="new">
<div class="ttitle">
<a href="{$direditlink}"><img src="{$baseurl}/admin/style/icons/small/accessories-text-editor.png" /></a> {$directory.full_title|htmlspecialchars}
<input type="hidden" name="action" value="newitem"> 
<input type="hidden" name="id" value="{$directory.id}" />
<select name="plugin" onchange="doAction();" id="newlist">
<option value="none">{$mlang.new}</option>
{foreach from=$plugins item=plugin}
{if $plugin.name == 'none'}
{section name=lg loop=$plugin.items}
<option value="{$plugin.items[lg].type}">{$plugin.items[lg].new}</option>
{/section}
{else}
<optgroup label="{$plugin.title}">
{section name=lg loop=$plugin.items}
<option value="{$plugin.items[lg].type}">{$plugin.items[lg].new}</option>
{/section}
</optgroup>
{/if}
{/foreach}
<option value="directory">{$mlang.newdir}</option>
</select>
</div>
</form>
{include file='breadcrumbs.tpl'}
<table id="list" style="width: 100%">
	<tr>
		<th class="image">&nbsp;</th>
		<th class="id">{$mlang.id}</th>
		<th>{$mlang.title}</th>
		<th class="buttons">&nbsp;</th>
	</tr>
	<tbody>
		{section name=ls loop=$items}
		<tr class="{cycle values="td1,td2"}">
			{if $items[ls].str_type == 'plugin'}
			<td class="image"><img src="{$baseurl}/non_html/modules/content/plugins/{$items[ls].str_plugin}.png" alt="document"/></td>
			{else}
			<td class="image"><img src="{$baseurl}/admin/style/icons/small/folder.png" alt="directory"/></td>
			{/if}
			<td class="id">{$items[ls].id}</td>
			<td><a href="{$items[ls].link}">{$items[ls].full_title|htmlspecialchars}</a></td>
			<td class="buttons">
				{if $items[ls].str_type == 'plugin'}
				<a href="{$items[ls].link}"><img src="{$baseurl}/admin/style/icons/small/accessories-text-editor.png" alt="move"/></a>
				<a href="{$items[ls].link_move}"><img src="{$baseurl}/admin/style/icons/small/edit-redo.png" alt="move"/></a>
				{else}
				<a href="{$items[ls].link_editdir}"><img src="{$baseurl}/admin/style/icons/small/accessories-text-editor.png" alt="move"/></a>
				{/if}
				{if !$smarty.section.ls.first}
				<a href="{$items[ls].link_moveup}"><img src="{$baseurl}/admin/style/icons/small/go-up.png" alt="up"/></a>
				{else}
				<img src="{$baseurl}/admin/style/icons/small/go-up_off.png" alt="up"/>
				{/if}
				{if !$smarty.section.ls.last}
				<a href="{$items[ls].link_movedown}"><img src="{$baseurl}/admin/style/icons/small/go-down.png" alt="down"/></a>
				{else}
				<img src="{$baseurl}/admin/style/icons/small/go-down_off.png" alt="down"/>
				{/if}
				<a href="{$items[ls].link_delete}"><img src="{$baseurl}/admin/style/icons/small/process-stop.png" alt="delete"/></a>
			</td>
		</tr>
		{sectionelse}
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong>{$mlang.dirempty}</strong></td>
			<td>&nbsp;</td>
		</tr>
		{/section}
	</tbody>
</table>
