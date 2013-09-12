<h2 class="bar"><span>{$mlang.news.shortstory}</span></h2>
{$w_short}
<h2 class="bar"><span>{$mlang.news.fullstory}</span></h2>
{$w_full}
<h2 class="bar"><span><input type="checkbox" name="pdata[allowreplies]" {if $news.replies_on == 'true'}checked="checked"{/if} value="true"/>{$mlang.news.replies}</span></h2>
<hp><input type="checkbox" name="pdata[allowguestreplies]" {if $news.replies_guests == 'true'}checked="checked"{/if} value="true"/>{$mlang.news.guestreplies}</p>
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
			<td class="id"><input type="checkbox" name="pdata[rgroups][]" value="{$groups[ln].id}" {if $groups[ln].checked == true}checked="checked"{/if} /></td>
			<td>{$groups[ln].title|htmlspecialchars}</td>
		</tr>
		{/section}
	</tbody>
</table>
<h2 class="bar"><span>{$mlang.news.repliesinthread}</span></h2>
<ul id="posts">
{section name=ln loop=$replies}
<li class="{cycle values="li1,li2"}">
{if $replies[ln].mode == 'guest'}
<h4><input type="checkbox" name="pdata[delrep][]" value="{$replies[ln].id}" /> {$mlang.news.delete} - {if !empty($replies[ln].poster_email)}<a href="mailto:{$replies[ln].poster_email|htmlspecialchars}">{/if}{$replies[ln].poster_name|htmlspecialchars}{if !empty($replies[ln].poster_email)}</a> ({$mlang.news.guest}){/if} ({$replies[ln].message_crdate})</h4>
{else}
<h4><input type="checkbox" name="pdata[delrep][]" value="{$replies[ln].id}" /> {$mlang.news.delete} - {$replies[ln].poster_name|htmlspecialchars} ({$replies[ln].message_crdate})</h4>
{/if}
<p>{$replies[ln].message_processed|stripslashes}</p>
</li>
{/section}
</ul>