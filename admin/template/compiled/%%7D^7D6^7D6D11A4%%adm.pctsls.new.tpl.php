<?php /* Smarty version 2.6.19, created on 2008-10-04 16:56:59
         compiled from adm.pctsls.new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'adm.pctsls.new.tpl', 11, false),)), $this); ?>
<dl>
	<dt><label for="expl">&nbsp;</label></dt>
	<dd><?php echo $this->_tpl_vars['mlang']['plugins']['expl_pictureslideshow']; ?>
</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['directory']; ?>
</label></dt>
	<dd>
	<div style="text-align: right;"></div>
	<select name="pdata[directory_id]" orient="vertical" sborient="vertical">
	<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['dirs']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ln']['show'] = true;
$this->_sections['ln']['max'] = $this->_sections['ln']['loop'];
$this->_sections['ln']['step'] = 1;
$this->_sections['ln']['start'] = $this->_sections['ln']['step'] > 0 ? 0 : $this->_sections['ln']['loop']-1;
if ($this->_sections['ln']['show']) {
    $this->_sections['ln']['total'] = $this->_sections['ln']['loop'];
    if ($this->_sections['ln']['total'] == 0)
        $this->_sections['ln']['show'] = false;
} else
    $this->_sections['ln']['total'] = 0;
if ($this->_sections['ln']['show']):

            for ($this->_sections['ln']['index'] = $this->_sections['ln']['start'], $this->_sections['ln']['iteration'] = 1;
                 $this->_sections['ln']['iteration'] <= $this->_sections['ln']['total'];
                 $this->_sections['ln']['index'] += $this->_sections['ln']['step'], $this->_sections['ln']['iteration']++):
$this->_sections['ln']['rownum'] = $this->_sections['ln']['iteration'];
$this->_sections['ln']['index_prev'] = $this->_sections['ln']['index'] - $this->_sections['ln']['step'];
$this->_sections['ln']['index_next'] = $this->_sections['ln']['index'] + $this->_sections['ln']['step'];
$this->_sections['ln']['first']      = ($this->_sections['ln']['iteration'] == 1);
$this->_sections['ln']['last']       = ($this->_sections['ln']['iteration'] == $this->_sections['ln']['total']);
?>
	<option value="<?php echo $this->_tpl_vars['dirs'][$this->_sections['ln']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['dirs'][$this->_sections['ln']['index']]['id'] == $this->_tpl_vars['item']['id']): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['dirs'][$this->_sections['ln']['index']]['full_location'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</option>
	<?php endfor; endif; ?>
	</select>
	</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['nextpicturetime']; ?>
</label></dt>
	<dd><input type="text" name="pdata[picture_duration]" size="5" value="0"/><?php echo $this->_tpl_vars['mlang']['nextpicturetime_expl']; ?>
</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['pictureheight']; ?>
</label></dt>
	<dd><input type="text" name="pdata[picture_maxheight]" size="10" value="800"/> px</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['picturewidth']; ?>
</label></dt>
	<dd><input type="text" name="pdata[picture_maxwidth]" size="10" value="800"/> px</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['picturestrip']; ?>
</label></dt>
	<dd><input type="radio" name="pdata[picturestrip]" checked value="0" ><?php echo $this->_tpl_vars['mlang']['no']; ?>
 <input type="radio" name="pdata[picturestrip]" value="1"> <?php echo $this->_tpl_vars['mlang']['yes']; ?>
 </dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['thumbnailheight']; ?>
</label></dt>
	<dd><input type="text" name="pdata[thumbnail_maxheight]" size="10" value="80"/> px</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['thumbnailwidth']; ?>
</label></dt>
	<dd><input type="text" name="pdata[thumbnail_maxwidth]" size="10" value="80"/> px</dd>
</dl>