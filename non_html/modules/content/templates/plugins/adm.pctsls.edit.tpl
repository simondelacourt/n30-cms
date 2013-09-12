<dl>
	<dt><label for="expl">&nbsp;</label></dt>
	<dd>{$mlang.plugins.expl_pictureslideshow}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.directory}</label></dt>
	<dd><select name="pdata[directory_id]">
	{section name=ln loop=$dirs}
	<option value="{$dirs[ln].id}" {if $dirs[ln].id == $slideshow.directory_id}selected{/if}>{$dirs[ln].full_location|htmlspecialchars}</option>
	{/section}
	</select>
	</dd>
</dl>

<dl>
	<dt><label for="title">{$mlang.nextpicturetime}</label></dt>
	<dd><input type="text" name="pdata[picture_duration]" size="5" value="{$slideshow.duration|intval}"/>{$mlang.nextpicturetime_expl}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.pictureheight}</label></dt>
	<dd><input type="text" name="pdata[picture_maxheight]" size="10" value="{$slideshow.picture_maxheight|intval}"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.picturewidth}</label></dt>
	<dd><input type="text" name="pdata[picture_maxwidth]" size="10" value="{$slideshow.picture_maxwidth|intval}"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.picturestrip}</label></dt>
	<dd><input type="radio" name="pdata[picturestrip]" {if $slideshow.show_imgstrip == 0}checked{/if} value="0" >{$mlang.no} <input type="radio" name="pdata[picturestrip]" {if $slideshow.show_imgstrip == 1}checked{/if} value="1"> {$mlang.yes} </dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.thumbnailheight}</label></dt>
	<dd><input type="text" name="pdata[thumbnail_maxheight]" size="10" value="{$slideshow.thumbnail_maxheight|intval}"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.thumbnailwidth}</label></dt>
	<dd><input type="text" name="pdata[thumbnail_maxwidth]" size="10" value="{$slideshow.thumbnail_maxwidth|intval}"/> px</dd>
</dl>