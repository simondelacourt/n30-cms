<p id="location">
	<img src="{$baseurl}/admin/style/icons/small/go-next.png" alt="."/>
	<span>
	{section name=ln loop=$breadcrumbs}
	{if !empty($breadcrumbs[ln].link)}<a href="{$breadcrumbs[ln].link}">{/if}{$breadcrumbs[ln].title|htmlspecialchars}{if !empty($breadcrumbs[ln].link)}</a>{/if}  > 
	{/section}
	</span>
</p>