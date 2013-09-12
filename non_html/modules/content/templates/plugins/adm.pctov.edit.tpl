<dl>
	<dt><label for="expl">&nbsp;</label></dt>
	<dd>{$mlang.plugins.expl_pictureoverview}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.directory}</label></dt>
	<dd><select name="pdata[directory_id]">
	{section name=ln loop=$dirs}
	<option value="{$dirs[ln].id}" {if $dirs[ln].id == $overview.directory_id}selected{/if}>{$dirs[ln].full_location|htmlspecialchars}</option>
	{/section}
	</select>
	</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.ppline}</label></dt>
	<dd><input type="text" name="pdata[picture_perline]" size="5" value="{$overview.picture_perline}"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.pictureheight}</label></dt>
	<dd><input type="text" name="pdata[picture_maxheight]" size="10" value="{$overview.picture_maxheight}"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.picturewidth}</label></dt>
	<dd><input type="text" name="pdata[picture_maxwidth]" size="10" value="{$overview.picture_maxwidth}"/> px</dd>
</dl>