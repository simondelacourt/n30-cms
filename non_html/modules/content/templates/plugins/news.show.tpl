{$news.news_full|stripslashes}
{if $news.replies_on == 'true'}
<ul id="posts">
{section name=ln loop=$replies}
<li>
{if $replies[ln].mode == 'guest'}
<h4>{if !empty($replies[ln].poster_email)}<a href="mailto:{$replies[ln].poster_email|htmlspecialchars}">{/if}{$replies[ln].poster_name|htmlspecialchars}{if !empty($replies[ln].poster_email)}</a> ({$mlang.news.guest}){/if} ({$replies[ln].message_crdate})</h4>
{else}
<h4>{$replies[ln].poster_name|htmlspecialchars} ({$replies[ln].message_crdate})</h4>
{/if}
<p>{$replies[ln].message_processed|stripslashes}</p>
</li>
{/section}
</ul>
{if $replyok}
<h2>{$mlang.news.postreply}</h2>
<form method="post">
{if $replymode == 'guest'}
<dl>
	<dt><label for="name">{$mlang.news.name}</label></dt>
	<dd><input type="text" name="name" size="60" /></dd>
</dl>
<dl>
	<dt><label for="email">{$mlang.news.email}</label></dt>
	<dd><input type="text" name="email" size="60" /></dd>
</dl>
<dl>
	<dt><label for="url">{$mlang.news.url}</label></dt>
	<dd><input type="text" name="url" size="60" /></dd>
</dl>
{/if}
<dl>
	<dt><label for="message">{$mlang.news.message}</label></dt>
	<dd><textarea name="message"></textarea></dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="submit" name="submit" value="{$mlang.news.postreply}" /></dd>
</dl>
</form>
{/if}
{/if}