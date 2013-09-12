<?php /* Smarty version 2.6.19, created on 2008-05-28 16:54:56
         compiled from uploadform.tpl */ ?>
<?php echo '
<script type="text/javascript">
/* This function is called when user selects file in file dialog */
function jsUpload(upload_field)
{
	'; ?>
<?php if ($this->_tpl_vars['checks'] == true): ?><?php echo '
	var re_text = '; ?>
<?php echo $this->_tpl_vars['checkinput']; ?>
<?php echo '; /* /\\.txt|\\.xml|\\.zip/i/ */ 
    var filename = upload_field.value;

    /* Checking file type */
    if (filename.search(re_text) == -1)
    {
        alert("File does not have text(txt, xml, zip) extension");
        upload_field.form.reset();
        return false;
    }
    '; ?>
<?php endif; ?><?php echo '
    upload_field.form.submit();
    document.getElementById(\'upload_status\').value = "uploading file...";
    upload_field.disabled = true;
    return true;
}
'; ?>

</script>
<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;">
</iframe>
<dl>
	<dt><label for="dir"><?php echo $this->_tpl_vars['lang']['adminfiles']['uploadstatus']; ?>
: </label></dt>
	<dd><input type="text" name="upload_status" id="upload_status" 
       value="not uploaded" size="64" disabled></dd>
</dl>
<dl>
	<dt><label for="dir"><?php echo $this->_tpl_vars['lang']['adminfiles']['filename']; ?>
: </label></dt>
	<dd><input type="text" name="filenamei" id="filenamei" value="none" disabled></dd>
</dl>
<input type="hidden" name="<?php echo $this->_tpl_vars['filenamefield']; ?>
" id="filename">
