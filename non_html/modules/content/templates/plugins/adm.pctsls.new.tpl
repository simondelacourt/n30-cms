<dl>
	<dt><label for="expl">&nbsp;</label></dt>
	<dd>{$mlang.plugins.expl_pictureslideshow}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.directory}</label></dt>
	<dd>
	<div style="text-align: right;"></div>
	<select name="pdata[directory_id]" orient="vertical" sborient="vertical">
	{section name=ln loop=$dirs}
	<option value="{$dirs[ln].id}" {if $dirs[ln].id == $item.id}selected{/if}>{$dirs[ln].full_location|htmlspecialchars}</option>
	{/section}
	</select>
	</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.nextpicturetime}</label></dt>
	<dd><input type="text" name="pdata[picture_duration]" size="5" value="0"/>{$mlang.nextpicturetime_expl}</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.pictureheight}</label></dt>
	<dd><input type="text" name="pdata[picture_maxheight]" size="10" value="800"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.picturewidth}</label></dt>
	<dd><input type="text" name="pdata[picture_maxwidth]" size="10" value="800"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.picturestrip}</label></dt>
	<dd><input type="radio" name="pdata[picturestrip]" checked value="0" >{$mlang.no} <input type="radio" name="pdata[picturestrip]" value="1"> {$mlang.yes} </dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.thumbnailheight}</label></dt>
	<dd><input type="text" name="pdata[thumbnail_maxheight]" size="10" value="80"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.thumbnailwidth}</label></dt>
	<dd><input type="text" name="pdata[thumbnail_maxwidth]" size="10" value="80"/> px</dd>
</dl>