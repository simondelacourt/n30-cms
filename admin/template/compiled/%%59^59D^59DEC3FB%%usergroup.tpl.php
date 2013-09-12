<?php /* Smarty version 2.6.19, created on 2008-04-30 17:07:34
         compiled from usergroup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'usergroup.tpl', 3, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['usergroup']; ?>
: <?php echo $this->_tpl_vars['group']['title']; ?>
</h2>
<form method="post" action="">
<fieldset><legend><?php echo ((is_array($_tmp=$this->_tpl_vars['group']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</legend>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['lang']['adminusers']['group']; ?>
</label></dt>
	<dd><input type="text" name="title" size="40" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['group']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="default"><?php echo $this->_tpl_vars['lang']['adminusers']['default']; ?>
</label></dt>
	<dd><input type="radio" name="default" value="false" <?php if ($this->_tpl_vars['group']['default'] == 'false'): ?>checked<?php endif; ?>/> <?php echo $this->_tpl_vars['lang']['adminusers']['false']; ?>
 <input type="radio" name="default" value="true" <?php if ($this->_tpl_vars['group']['default'] == 'true'): ?>checked<?php endif; ?>/> <?php echo $this->_tpl_vars['lang']['adminusers']['true']; ?>
</dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['edit']; ?>
" />
	<input type="hidden" name="action" value="editgroup" />
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['group']['id']; ?>
" />
	</dd>
</dl>
</fieldset>
</form>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['rights']; ?>
</h2>
<form method="post" action="">
<table id="list" style="width: 100%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['id']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['adminusers']['type']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['adminusers']['accessto']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['adminusers']['delete']; ?>
</th>
	</tr>
	<tbody>
		<?php unset($this->_sections['ls']);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['rights']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ls']['show'] = true;
$this->_sections['ls']['max'] = $this->_sections['ls']['loop'];
$this->_sections['ls']['step'] = 1;
$this->_sections['ls']['start'] = $this->_sections['ls']['step'] > 0 ? 0 : $this->_sections['ls']['loop']-1;
if ($this->_sections['ls']['show']) {
    $this->_sections['ls']['total'] = $this->_sections['ls']['loop'];
    if ($this->_sections['ls']['total'] == 0)
        $this->_sections['ls']['show'] = false;
} else
    $this->_sections['ls']['total'] = 0;
if ($this->_sections['ls']['show']):

            for ($this->_sections['ls']['index'] = $this->_sections['ls']['start'], $this->_sections['ls']['iteration'] = 1;
                 $this->_sections['ls']['iteration'] <= $this->_sections['ls']['total'];
                 $this->_sections['ls']['index'] += $this->_sections['ls']['step'], $this->_sections['ls']['iteration']++):
$this->_sections['ls']['rownum'] = $this->_sections['ls']['iteration'];
$this->_sections['ls']['index_prev'] = $this->_sections['ls']['index'] - $this->_sections['ls']['step'];
$this->_sections['ls']['index_next'] = $this->_sections['ls']['index'] + $this->_sections['ls']['step'];
$this->_sections['ls']['first']      = ($this->_sections['ls']['iteration'] == 1);
$this->_sections['ls']['last']       = ($this->_sections['ls']['iteration'] == $this->_sections['ls']['total']);
?>
		<tr>
			<td class="id"><?php echo $this->_tpl_vars['rights'][$this->_sections['ls']['index']]['id']; ?>
</td>
			<td><?php echo $this->_tpl_vars['rights'][$this->_sections['ls']['index']]['type']; ?>
</td>
			<td>
			<?php if ($this->_tpl_vars['rights'][$this->_sections['ls']['index']]['type'] == 'mod' && $this->_tpl_vars['rights'][$this->_sections['ls']['index']]['mod'] != 'all'): ?>
		<?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['module']; ?>
 <strong><?php echo $this->_tpl_vars['rights'][$this->_sections['ls']['index']]['mod']; ?>
</strong>.
		<?php elseif ($this->_tpl_vars['rights'][$this->_sections['ls']['index']]['type'] == 'admin'): ?>
		<?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['admin']; ?>

		<?php elseif ($this->_tpl_vars['rights'][$this->_sections['ls']['index']]['type'] == 'mod' && $this->_tpl_vars['rights'][$this->_sections['ls']['index']]['mod'] == 'all'): ?>
		<?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['all']; ?>

		<?php endif; ?>
			</td>
			<td><input type="checkbox" name="delete[]" value="<?php echo $this->_tpl_vars['rights'][$this->_sections['ls']['index']]['id']; ?>
" /></td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
<input type="hidden" name="action" value="deleterights" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['group']['id']; ?>
" />
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['delete']; ?>
" />
</form>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['addright']; ?>
</h2>
<form method="post" action="">
<h4><input type="radio" name="type" value="admin" checked/> <?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['admin']; ?>
</h4>
<p><?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['admin_info']; ?>
</p>
<h4><input type="radio" name="type" value="all"/> <?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['all']; ?>
</h4>
<p><?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['all_info']; ?>
</p>
<h4><input type="radio" name="type" value="mod" id="mod"/> <?php echo $this->_tpl_vars['lang']['adminusers']['rightsinfo']['amodule']; ?>
</h4>
<p>
<select name="module"  onclick="document.getElementById('mod').checked = true;">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['modules']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value="<?php echo $this->_tpl_vars['modules'][$this->_sections['ln']['index']]; ?>
"><?php echo $this->_tpl_vars['modules'][$this->_sections['ln']['index']]; ?>
</option>
<?php endfor; endif; ?>
</select>
</p>
<input type="hidden" name="action" value="addright" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['group']['id']; ?>
" />
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['addright']; ?>
" />
</form>