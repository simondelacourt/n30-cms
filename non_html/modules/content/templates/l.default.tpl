<ul>
	{section name=ln loop=$list}
	<li><a href="{$list[ln].link}">{$list[ln].full_title|htmlspecialchars}</a></li>
	{/section}
</ul>