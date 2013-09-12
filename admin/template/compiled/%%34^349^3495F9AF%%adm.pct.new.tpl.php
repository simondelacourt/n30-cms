<?php /* Smarty version 2.6.19, created on 2009-03-15 17:01:47
         compiled from adm.pct.new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'adm.pct.new.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['multiupload'] && count ( $this->_tpl_vars['mupload'] ) > 0): ?>
<h3><input type="radio" name="pdata[uploadmethod]" value="multiupload" onclick="document.getElementById('itemtitle').value = 'multiupload'"/> Multiupload</h3>
<p>Load the images into the multiupload directory. Select the images you want to upload.</p>
<table id="list" style="width: 100%">
<?php $_from = $this->_tpl_vars['mupload']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
<tr>
<td><input type="checkbox" name="pdata[multi][]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['file'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" /><?php echo ((is_array($_tmp=$this->_tpl_vars['file'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>
<h3><input type="radio" name="pdata[uploadmethod]" value="regularupload" checked="checked" />Regular upload</h3>
<?php echo $this->_tpl_vars['upload']; ?>

<h3><?php echo $this->_tpl_vars['mlang']['pictureinformation']; ?>
</h3>
<dl>
	<dt><label for="ref"><?php echo $this->_tpl_vars['mlang']['ref']; ?>
</label></dt>
	<dd><input type="text" name="pdata[ref]" size="30"/></dd>
</dl>
<dl>
	<dt><label for="artist"><?php echo $this->_tpl_vars['mlang']['artist']; ?>
</label></dt>
	<dd><input type="text" name="pdata[artist]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="copyright"><?php echo $this->_tpl_vars['mlang']['copyright']; ?>
</label></dt>
	<dd><input type="text" name="pdata[copyright]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="date"><?php echo $this->_tpl_vars['mlang']['date']; ?>
</label></dt>
	<dd><input type="text" name="pdata[date]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="country"><?php echo $this->_tpl_vars['mlang']['country']; ?>
</label></dt>
	<dd><input type="text" name="pdata[country]" size="60"/></dd>
</dl>
<dl>
	<dt><label for="location"><?php echo $this->_tpl_vars['mlang']['location']; ?>
</label></dt>
	<dd><input type="text" name="pdata[location]" size="60"/></dd>
</dl>
<h3><?php echo $this->_tpl_vars['mlang']['picturesize']; ?>
</h3>
<dl>
	<dt><label for="height"><?php echo $this->_tpl_vars['mlang']['showheight']; ?>
</label></dt>
	<dd><input type="text" name="pdata[showheight]" size="10" value="800"/> px</dd>
</dl>
<dl>
	<dt><label for="width"><?php echo $this->_tpl_vars['mlang']['showwidth']; ?>
</label></dt>
	<dd><input type="text" name="pdata[showwidth]" size="10" value="800"/> px</dd>
</dl>