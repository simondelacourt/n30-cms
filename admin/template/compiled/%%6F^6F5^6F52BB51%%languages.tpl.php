<?php /* Smarty version 2.6.19, created on 2008-08-16 17:16:24
         compiled from languages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'languages.tpl', 11, false),array('modifier', 'htmlspecialchars', 'languages.tpl', 13, false),)), $this); ?>
<table id="list" style="width: 100%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['lang']['admincms']['id']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['admincms']['title']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['admincms']['default']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['admincms']['installed']; ?>
</th>
		<th class="buttons"></th>
	</tr>
	<tbody>
		<?php unset($this->_sections['ls']);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['languages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			<td class="id"><?php echo $this->_tpl_vars['languages'][$this->_sections['ls']['index']]['id']; ?>
</td>
			<td><a href="<?php echo $this->_tpl_vars['users'][$this->_sections['ls']['index']]['link']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['languages'][$this->_sections['ls']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</a></td>
			<td><?php if ($this->_tpl_vars['languages'][$this->_sections['ls']['index']]['default'] == 'true'): ?><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/weather-clear.png" alt="default"/><?php endif; ?></td>
			<td>
				<?php if ($this->_tpl_vars['languages'][$this->_sections['ls']['index']]['installed'] == 1): ?>
				<?php echo $this->_tpl_vars['lang']['admincms']['installedok']; ?>

				<?php else: ?>
				<a href="<?php echo $this->_tpl_vars['languages'][$this->_sections['ls']['index']]['installurl']; ?>
"><?php echo $this->_tpl_vars['lang']['admincms']['install']; ?>
</a>
				<?php endif; ?>
			
			</td>
			<td class="buttons">
			<?php if ($this->_tpl_vars['languages'][$this->_sections['ls']['index']]['default'] == 'false' && $this->_tpl_vars['languages'][$this->_sections['ls']['index']]['installed'] == 1): ?>
			<a href="<?php echo $this->_tpl_vars['languages'][$this->_sections['ls']['index']]['setdefaulturl']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/weather-clear.png" alt="default"/></a>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['languages'][$this->_sections['ls']['index']]['installed'] == 1): ?>
			<a href="<?php echo $this->_tpl_vars['languages'][$this->_sections['ls']['index']]['uninstallurl']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/process-stop.png" alt="<?php echo $this->_tpl_vars['lang']['admincms']['setasdefault']; ?>
"/></a>
			<?php else: ?>
			
			<?php endif; ?>
			
			</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>