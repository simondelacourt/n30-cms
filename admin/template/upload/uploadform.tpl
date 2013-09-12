{literal}
<script type="text/javascript">
/* This function is called when user selects file in file dialog */
function jsUpload(upload_field)
{
	{/literal}{if $checks == true}{literal}
	var re_text = {/literal}{$checkinput}{literal}; /* /\.txt|\.xml|\.zip/i/ */ 
    var filename = upload_field.value;

    /* Checking file type */
    if (filename.search(re_text) == -1)
    {
        alert("File does not have text(txt, xml, zip) extension");
        upload_field.form.reset();
        return false;
    }
    {/literal}{/if}{literal}
    upload_field.form.submit();
    document.getElementById('upload_status').value = "uploading file...";
    upload_field.disabled = true;
    return true;
}
{/literal}
</script>
<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;">
</iframe>
<dl>
	<dt><label for="dir">{$lang.adminfiles.uploadstatus}: </label></dt>
	<dd><input type="text" name="upload_status" id="upload_status" 
       value="not uploaded" size="64" disabled></dd>
</dl>
<dl>
	<dt><label for="dir">{$lang.adminfiles.filename}: </label></dt>
	<dd><input type="text" name="filenamei" id="filenamei" value="none" disabled></dd>
</dl>
<input type="hidden" name="{$filenamefield}" id="filename">

