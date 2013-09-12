<?php /* Smarty version 2.6.19, created on 2008-10-14 20:35:42
         compiled from directory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'directory.tpl', 3, false),array('function', 'cycle', 'directory.tpl', 35, false),)), $this); ?>
<form method="post" id="new">
<div class="ttitle">
<a href="<?php echo $this->_tpl_vars['direditlink']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/accessories-text-editor.png" /></a> <?php echo ((is_array($_tmp=$this->_tpl_vars['directory']['full_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>

<input type="hidden" name="action" value="newitem"> 
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['directory']['id']; ?>
" />
<select name="plugin" onchange="doAction();" id="newlist">
<option value="none"><?php echo $this->_tpl_vars['mlang']['new']; ?>
</option>
<?php $_from = $this->_tpl_vars['plugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['plugin']):
?>
<?php if ($this->_tpl_vars['plugin']['name'] == 'none'): ?>
<?php unset($this->_sections['lg']);
$this->_sections['lg']['name'] = 'lg';
$this->_sections['lg']['loop'] = is_array($_loop=$this->_tpl_vars['plugin']['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['lg']['show'] = true;
$this->_sections['lg']['max'] = $this->_sections['lg']['loop'];
$this->_sections['lg']['step'] = 1;
$this->_sections['lg']['start'] = $this->_sections['lg']['step'] > 0 ? 0 : $this->_sections['lg']['loop']-1;
if ($this->_sections['lg']['show']) {
    $this->_sections['lg']['total'] = $this->_sections['lg']['loop'];
    if ($this->_sections['lg']['total'] == 0)
        $this->_sections['lg']['show'] = false;
} else
    $this->_sections['lg']['total'] = 0;
if ($this->_sections['lg']['show']):

            for ($this->_sections['lg']['index'] = $this->_sections['lg']['start'], $this->_sections['lg']['iteration'] = 1;
                 $this->_sections['lg']['iteration'] <= $this->_sections['lg']['total'];
                 $this->_sections['lg']['index'] += $this->_sections['lg']['step'], $this->_sections['lg']['iteration']++):
$this->_sections['lg']['rownum'] = $this->_sections['lg']['iteration'];
$this->_sections['lg']['index_prev'] = $this->_sections['lg']['index'] - $this->_sections['lg']['step'];
$this->_sections['lg']['index_next'] = $this->_sections['lg']['index'] + $this->_sections['lg']['step'];
$this->_sections['lg']['first']      = ($this->_sections['lg']['iteration'] == 1);
$this->_sections['lg']['last']       = ($this->_sections['lg']['iteration'] == $this->_sections['lg']['total']);
?>
<option value="<?php echo $this->_tpl_vars['plugin']['items'][$this->_sections['lg']['index']]['type']; ?>
"><?php echo $this->_tpl_vars['plugin']['items'][$this->_sections['lg']['index']]['new']; ?>
</option>
<?php endfor; endif; ?>
<?php else: ?>
<optgroup label="<?php echo $this->_tpl_vars['plugin']['title']; ?>
">
<?php unset($this->_sections['lg']);
$this->_sections['lg']['name'] = 'lg';
$this->_sections['lg']['loop'] = is_array($_loop=$this->_tpl_vars['plugin']['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['lg']['show'] = true;
$this->_sections['lg']['max'] = $this->_sections['lg']['loop'];
$this->_sections['lg']['step'] = 1;
$this->_sections['lg']['start'] = $this->_sections['lg']['step'] > 0 ? 0 : $this->_sections['lg']['loop']-1;
if ($this->_sections['lg']['show']) {
    $this->_sections['lg']['total'] = $this->_sections['lg']['loop'];
    if ($this->_sections['lg']['total'] == 0)
        $this->_sections['lg']['show'] = false;
} else
    $this->_sections['lg']['total'] = 0;
if ($this->_sections['lg']['show']):

            for ($this->_sections['lg']['index'] = $this->_sections['lg']['start'], $this->_sections['lg']['iteration'] = 1;
                 $this->_sections['lg']['iteration'] <= $this->_sections['lg']['total'];
                 $this->_sections['lg']['index'] += $this->_sections['lg']['step'], $this->_sections['lg']['iteration']++):
$this->_sections['lg']['rownum'] = $this->_sections['lg']['iteration'];
$this->_sections['lg']['index_prev'] = $this->_sections['lg']['index'] - $this->_sections['lg']['step'];
$this->_sections['lg']['index_next'] = $this->_sections['lg']['index'] + $this->_sections['lg']['step'];
$this->_sections['lg']['first']      = ($this->_sections['lg']['iteration'] == 1);
$this->_sections['lg']['last']       = ($this->_sections['lg']['iteration'] == $this->_sections['lg']['total']);
?>
<option value="<?php echo $this->_tpl_vars['plugin']['items'][$this->_sections['lg']['index']]['type']; ?>
"><?php echo $this->_tpl_vars['plugin']['items'][$this->_sections['lg']['index']]['new']; ?>
</option>
<?php endfor; endif; ?>
</optgroup>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<option value="directory"><?php echo $this->_tpl_vars['mlang']['newdir']; ?>
</option>
</select>
</div>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'breadcrumbs.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table id="list" style="width: 100%">
	<tr>
		<th class="image">&nbsp;</th>
		<th class="id"><?php echo $this->_tpl_vars['mlang']['id']; ?>
</th>
		<th><?php echo $this->_tpl_vars['mlang']['title']; ?>
</th>
		<th class="buttons">&nbsp;</th>
	</tr>
	<tbody>
		<?php unset($this->_sections['ls']);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<tr class="<?php echo smarty_function_cycle(array('values' => "td1,td2"), $this);?>
">
			<?php if ($this->_tpl_vars['items'][$this->_sections['ls']['index']]['str_type'] == 'plugin'): ?>
			<td class="image"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/non_html/modules/content/plugins/<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['str_plugin']; ?>
.png" alt="document"/></td>
			<?php else: ?>
			<td class="image"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/folder.png" alt="directory"/></td>
			<?php endif; ?>
			<td class="id"><?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['id']; ?>
</td>
			<td><a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['items'][$this->_sections['ls']['index']]['full_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</a></td>
			<td class="buttons">
				<?php if ($this->_tpl_vars['items'][$this->_sections['ls']['index']]['str_type'] == 'plugin'): ?>
				<a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/accessories-text-editor.png" alt="move"/></a>
				<a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link_move']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/edit-redo.png" alt="move"/></a>
				<?php else: ?>
				<a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link_editdir']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/accessories-text-editor.png" alt="move"/></a>
				<?php endif; ?>
				<?php if (! $this->_sections['ls']['first']): ?>
				<a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link_moveup']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-up.png" alt="up"/></a>
				<?php else: ?>
				<img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-up_off.png" alt="up"/>
				<?php endif; ?>
				<?php if (! $this->_sections['ls']['last']): ?>
				<a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link_movedown']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-down.png" alt="down"/></a>
				<?php else: ?>
				<img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-down_off.png" alt="down"/>
				<?php endif; ?>
				<a href="<?php echo $this->_tpl_vars['items'][$this->_sections['ls']['index']]['link_delete']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/process-stop.png" alt="delete"/></a>
			</td>
		</tr>
		<?php endfor; else: ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong><?php echo $this->_tpl_vars['mlang']['dirempty']; ?>
</strong></td>
			<td>&nbsp;</td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>