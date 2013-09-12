<?php /* Smarty version 2.6.19, created on 2008-05-28 16:39:08
         compiled from uploadtop.tpl */ ?>
<form action="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/files.php" target="upload_iframe" method="post" enctype="multipart/form-data">
<input type="hidden" name="fileframe" value="true">
<dl>
	<dt><label for="dir"><?php echo $this->_tpl_vars['lang']['adminfiles']['file']; ?>
: </label></dt>
	<dd><input type="file" name="file" id="file" onChange="jsUpload(this)"></dd>
</dl>
</form>
			