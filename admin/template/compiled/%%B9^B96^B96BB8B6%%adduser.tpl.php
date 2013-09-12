<?php /* Smarty version 2.6.19, created on 2008-04-29 20:53:19
         compiled from adduser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'adduser.tpl', 43, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['addnewuser']; ?>
</h2>
<form method="post" action="">
<dl>
	<dt><label for="username"><?php echo $this->_tpl_vars['lang']['adminusers']['username']; ?>
</label></dt>
	<dd><input type="text" name="username" size="40" /></dd>
</dl>
<dl>
	<dt><label for="email"><?php echo $this->_tpl_vars['lang']['adminusers']['email']; ?>
</label></dt>
	<dd><input type="text" name="email" size="40" /></dd>
</dl>
<dl>
	<dt><label for="email"><?php echo $this->_tpl_vars['lang']['adminusers']['password']; ?>
</label></dt>
	<dd><input type="password" name="password" size="40" /></dd>
</dl>
<dl>
	<dt><label for="unid"><?php echo $this->_tpl_vars['lang']['adminusers']['unid']; ?>
</label></dt>
	<dd><?php echo $this->_tpl_vars['unid']; ?>
&nbsp;</dd>
</dl>
<dl>
	<dt><label for="templates"><?php echo $this->_tpl_vars['lang']['adminusers']['templates']; ?>
</label></dt>
	<dd>
	<select name="templates">
	<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['templates']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<option value="<?php echo $this->_tpl_vars['templates'][$this->_sections['ln']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['templates'][$this->_sections['ln']['index']]['title']; ?>
</option>
	<?php endfor; endif; ?>
	</select>
	</dd>
</dl>
<dl>
	<dt><label for="languages"><?php echo $this->_tpl_vars['lang']['adminusers']['languages']; ?>
</label></dt>
	<dd>
	<select name="languages">
	<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['languages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<option value="<?php echo $this->_tpl_vars['languages'][$this->_sections['ln']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['languages'][$this->_sections['ln']['index']]['title']; ?>
</option>
	<?php endfor; endif; ?>
	</select></dd>
</dl>
<dl>
	<dt><label for="languages">Groups</label></dt>
	<dd>
	<ul id="grouplist">
	<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<li><input type="checkbox" name="groups[]" value="<?php echo $this->_tpl_vars['groups'][$this->_sections['ln']['index']]['id']; ?>
" /> <?php echo ((is_array($_tmp=$this->_tpl_vars['groups'][$this->_sections['ln']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</li>
	<?php endfor; endif; ?>
	</ul>
	</dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="hidden" name="action" value="adduser" /><input type="hidden" name="unid" value="<?php echo $this->_tpl_vars['unid']; ?>
" /><input type="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['addnewuser']; ?>
" /></dd>
</dl>
</form>