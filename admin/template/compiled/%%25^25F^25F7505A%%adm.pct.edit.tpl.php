<?php /* Smarty version 2.6.19, created on 2008-08-19 13:18:13
         compiled from adm.pct.edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'adm.pct.edit.tpl', 4, false),array('modifier', 'intval', 'adm.pct.edit.tpl', 29, false),)), $this); ?>
<h3><?php echo $this->_tpl_vars['mlang']['pictureinformation']; ?>
</h3>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['ref']; ?>
</label></dt>
	<dd><input type="text" name="pdata[ref]" size="30"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_ref'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['artist']; ?>
</label></dt>
	<dd><input type="text" name="pdata[artist]" size="60"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_artist'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['copyright']; ?>
</label></dt>
	<dd><input type="text" name="pdata[copyright]" size="60"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_copyright'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['date']; ?>
</label></dt>
	<dd><input type="text" name="pdata[date]" size="60" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_date'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['country']; ?>
</label></dt>
	<dd><input type="text" name="pdata[country]" size="60"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_country'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['location']; ?>
</label></dt>
	<dd><input type="text" name="pdata[location]" size="60" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_location'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<h3><?php echo $this->_tpl_vars['mlang']['picturesize']; ?>
</h3>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['showheight']; ?>
</label></dt>
	<dd><input type="text" name="pdata[showheight]" size="10" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_showheight'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)); ?>
"/> px</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['showwidth']; ?>
</label></dt>
	<dd><input type="text" name="pdata[showwidth]" size="10" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_showwidth'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)); ?>
"/> px</dd>
</dl>
<h3><?php echo $this->_tpl_vars['mlang']['plugins']['picture']; ?>
</h3>
<p>
<img src="<?php echo $this->_tpl_vars['picture']['viewurl']; ?>
" alt="<?php echo $this->_tpl_vars['mlang']['plugins']['picture']; ?>
" />
</p>