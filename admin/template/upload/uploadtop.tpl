<form action="{$baseurl}/admin/files.php" target="upload_iframe" method="post" enctype="multipart/form-data">
<input type="hidden" name="fileframe" value="true">
<dl>
	<dt><label for="dir">{$lang.adminfiles.file}: </label></dt>
	<dd><input type="file" name="file" id="file" onChange="jsUpload(this)"></dd>
</dl>
</form>
			