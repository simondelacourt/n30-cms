<?php /* Smarty version 2.6.19, created on 2008-06-25 20:58:29
         compiled from usergroups.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'usergroups.tpl', 10, false),array('modifier', 'htmlspecialchars', 'usergroups.tpl', 20, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['usergroups']; ?>
</h2>
<table id="list" style="width: 99%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['id']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['adminusers']['usergroup']; ?>
</th>
		<th>&nbsp;</th>
	</tr>
	<tbody>
		<?php unset($this->_sections['ls']);
$this->_sections['ls']['name'] = 'ls';
$this->_sections['ls']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			<td class="id"><?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['id']; ?>
</td>
			<td><a href="<?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['link']; ?>
"><?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['title']; ?>
</a></td>
			<td class="image"><a href="<?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['deletelink']; ?>
"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/process-stop.png" alt="<?php echo $this->_tpl_vars['lang']['adminusers']['delete']; ?>
" /></a></td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['addnewgroup']; ?>
</h2>
<form method="post" action="">
<fieldset><legend><?php echo ((is_array($_tmp=$this->_tpl_vars['group']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</legend>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['lang']['adminusers']['group']; ?>
</label></dt>
	<dd><input type="text" name="title" size="40" /></dd>
</dl>
<dl>
	<dt><label for="default"><?php echo $this->_tpl_vars['lang']['adminusers']['default']; ?>
</label></dt>
	<dd><input type="radio" name="default" value="false" checked/> <?php echo $this->_tpl_vars['lang']['adminusers']['false']; ?>
 <input type="radio" name="default" value="true"/> <?php echo $this->_tpl_vars['lang']['adminusers']['true']; ?>
</dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['addnewgroup']; ?>
" />
	<input type="hidden" name="action" value="addnewgroup" />
	</dd>
</dl>
</fieldset>
</form>