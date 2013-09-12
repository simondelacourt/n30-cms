<h3>{$mlang.pictureinformation}</h3>
<dl>
	<dt><label for="title">{$mlang.ref}</label></dt>
	<dd><input type="text" name="pdata[ref]" size="30"  value="{$picture.picture_ref|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.artist}</label></dt>
	<dd><input type="text" name="pdata[artist]" size="60"  value="{$picture.picture_artist|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.copyright}</label></dt>
	<dd><input type="text" name="pdata[copyright]" size="60"  value="{$picture.picture_copyright|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.date}</label></dt>
	<dd><input type="text" name="pdata[date]" size="60" value="{$picture.picture_date|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.country}</label></dt>
	<dd><input type="text" name="pdata[country]" size="60"  value="{$picture.picture_country|htmlspecialchars}"/></dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.location}</label></dt>
	<dd><input type="text" name="pdata[location]" size="60" value="{$picture.picture_location|htmlspecialchars}"/></dd>
</dl>
<h3>{$mlang.picturesize}</h3>
<dl>
	<dt><label for="title">{$mlang.showheight}</label></dt>
	<dd><input type="text" name="pdata[showheight]" size="10" value="{$picture.picture_showheight|intval}"/> px</dd>
</dl>
<dl>
	<dt><label for="title">{$mlang.showwidth}</label></dt>
	<dd><input type="text" name="pdata[showwidth]" size="10" value="{$picture.picture_showwidth|intval}"/> px</dd>
</dl>
<h3>{$mlang.plugins.picture}</h3>
<p>
<img src="{$picture.viewurl}" alt="{$mlang.plugins.picture}" />
</p>