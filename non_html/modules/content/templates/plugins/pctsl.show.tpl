{if $sinfo.showimagestrip == 1}
<div id="imgstrip">
{section name=ln loop=$pictures}
<a href="{$pictures[ln].slink}"><img src="{$pictures[ln].thumbnail}" /></a> 
{/section}
</div>
{/if}
<div id="sshow">{if isset($nav.next)}<a href="{$nav.next}" id="plink">{/if}<img src="{$currentpicture.viewurl}" alt="{$currentpicture.full_title}"/>{if isset($nav.next)}</a>{/if}<br /></div>
<div id="pinfo">
		<div id="comments">		
			<h2>{$info.full_title}</h2>
			{if !empty($currentpicture.description)}<p class="info">{$currentpicture.description|stripslashes}</p>{else}<br />{/if}
		
		<p class="buttons">	
			<span class="prev">{if isset($nav.prev)}<a href="{$nav.prev}">{/if}&#60;{if isset($nav.prev)}</a>{/if}</span> ({$picture_current} / {$picture_count})
			<span class="next">{if isset($nav.next)}<a href="{$nav.next}">{/if}&#62;{if isset($nav.next)}</a>{/if}</span>
		</p>
		</div>
		<br style="clear: both;"/>
</div>