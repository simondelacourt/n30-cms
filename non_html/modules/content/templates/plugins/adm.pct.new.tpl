{if $multiupload and count($mupload) > 0}
<h3><input type="radio" name="pdata[uploadmethod]" value="multiupload" onclick="document.getElementById('itemtitle').value = 'multiupload'"/> Multiupload</h3>
<p>Load the images into the multiupload directory. Select the images you want to upload.</p>
<table id="list" style="width: 100%">
{foreach from=$mupload item=file}
<tr>
<td><input type="checkbox" name="pdata[multi][]" value="{$file|htmlspecialchars}" />{$file|htmlspecialchars}</td>
</tr>
{/foreach}
</table>
{/if}
<h3><input type="radio" name="pdata[uploadmethod]" value="regularupload" checked="checked" />Regular upload</h3>
{$upload}
<h3>{$mlang.pictureinformation}</h3>
<dl>
	<dt><label for="ref">{$mlang.ref}</label></dt>
	<dd><input type="text" name="pdata[ref]" size="30"/></dd>
</dl>
<dl>
	<dt><label for="artist">{$mlang.artist}</label></dt>
	<dd><input type="text" name="pdata[artist]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="copyright">{$mlang.copyright}</label></dt>
	<dd><input type="text" name="pdata[copyright]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="date">{$mlang.date}</label></dt>
	<dd><input type="text" name="pdata[date]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="country">{$mlang.country}</label></dt>
	<dd><input type="text" name="pdata[country]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="location">{$mlang.location}</label></dt>
	<dd><input type="text" name="pdata[location]" size="60"/></dd>
</dl>
<h3>{$mlang.picturesize}</h3>
<dl>
	<dt><label for="height">{$mlang.showheight}</label></dt>
	<dd><input type="text" name="pdata[showheight]" size="10" value="800"/> px</dd>
</dl>
<dl>
	<dt><label for="width">{$mlang.showwidth}</label></dt>
	<dd><input type="text" name="pdata[showwidth]" size="10" value="800"/> px</dd>
</dl>