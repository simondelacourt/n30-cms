<?php /* Smarty version 2.6.19, created on 2008-10-14 20:26:36
         compiled from adm.pctov.new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'adm.pctov.new.tpl', 11, false),)), $this); ?>
<dl>
	<dt><label for="expl">&nbsp;</label></dt>
	<dd><?php echo $this->_tpl_vars['mlang']['plugins']['expl_pictureoverview']; ?>
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
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['ppline']; ?>
</label></dt>
	<dd><input type="text" name="pdata[picture_perline]" size="5" value="4"/></dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['pictureheight']; ?>
</label></dt>
	<dd><input type="text" name="pdata[picture_maxheight]" size="10" value="100"/> px</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['picturewidth']; ?>
</label></dt>
	<dd><input type="text" name="pdata[picture_maxwidth]" size="10" value="100"/> px</dd>
</dl>