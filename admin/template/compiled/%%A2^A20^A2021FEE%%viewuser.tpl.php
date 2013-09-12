<?php /* Smarty version 2.6.19, created on 2008-06-25 21:01:03
         compiled from viewuser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'viewuser.tpl', 1, false),array('function', 'cycle', 'viewuser.tpl', 115, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['edituser']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
<?php if (isset ( $this->_tpl_vars['messages']['edituser'] )): ?>
<ul class="emessage">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['messages']['edituser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<li>
<?php if ($this->_tpl_vars['messages']['edituser'][$this->_sections['ln']['index']] == 'template'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['template']; ?>

<?php elseif ($this->_tpl_vars['messages']['edituser'][$this->_sections['ln']['index']] == 'nosuchuser'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['language']; ?>

<?php elseif ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'language'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['language']; ?>

<?php elseif ($this->_tpl_vars['messages']['edituser'][$this->_sections['ln']['index']] == 'email'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['email']; ?>

<?php elseif ($this->_tpl_vars['messages']['edituser'][$this->_sections['ln']['index']] == 'password'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['password']; ?>

<?php elseif ($this->_tpl_vars['messages']['edituser'][$this->_sections['ln']['index']] == 'username'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['username']; ?>

<?php elseif ($this->_tpl_vars['messages']['edituser'][$this->_sections['ln']['index']] == 'avatar'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['avatar']; ?>

<?php endif; ?></li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form method="post" action="">
<fieldset><legend><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</legend>
<dl>
	<dt><label for="username"><?php echo $this->_tpl_vars['lang']['adminusers']['username']; ?>
</label></dt>
	<dd><input type="text" name="username" size="40" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="email"><?php echo $this->_tpl_vars['lang']['adminusers']['email']; ?>
</label></dt>
	<dd><input type="text" name="email" size="40" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['email'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="avatar"><?php echo $this->_tpl_vars['lang']['adminusers']['avatar']; ?>
</label></dt>
	<dd><input type="text" name="avatar" size="40" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['avatar'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<dl>
	<dt><label for="signature"><?php echo $this->_tpl_vars['lang']['adminusers']['signature']; ?>
</label></dt>
	<dd><textarea name="signature" class="signature"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['signature'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</textarea></dd>
</dl>
<dl>
	<dt><label for="unid"><?php echo $this->_tpl_vars['lang']['adminusers']['unid']; ?>
</label></dt>
	<dd><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['unid'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
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
"<?php if ($this->_tpl_vars['user']['template'] == $this->_tpl_vars['templates'][$this->_sections['ln']['index']]['id']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['templates'][$this->_sections['ln']['index']]['title']; ?>
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
"<?php if ($this->_tpl_vars['user']['lang'] == $this->_tpl_vars['languages'][$this->_sections['ln']['index']]['id']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['languages'][$this->_sections['ln']['index']]['title']; ?>
</option>
	<?php endfor; endif; ?>
	</select></dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="hidden" name="action" value="edituser" /><input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
" /><input type="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['edituser']; ?>
" /></dd>
</dl>
</fieldset>
</form>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['editpassword']; ?>
</h2>
<?php if (isset ( $this->_tpl_vars['messages']['editpassword'] )): ?>
<ul class="emessage">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['messages']['editpassword']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<li>
<?php if ($this->_tpl_vars['messages']['editpassword'][$this->_sections['ln']['index']] == 'passwordnomatch'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['passwordnomatch']; ?>

<?php elseif ($this->_tpl_vars['messages']['editpassword'][$this->_sections['ln']['index']] == 'passwordshort'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['password']; ?>

<?php elseif ($this->_tpl_vars['messages']['editpassword'][$this->_sections['ln']['index']] == 'passwordok'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['passwordedited']; ?>

<?php endif; ?></li>
<?php endfor; endif; ?>
</ul>
<?php endif; ?>
<form method="post" action="">
	<fieldset><legend><?php echo $this->_tpl_vars['lang']['adminusers']['editpassword']; ?>
</legend>
	<dl>
		<dt><label for="password1"><?php echo $this->_tpl_vars['lang']['adminusers']['password']; ?>
</label></dt>
		<dd><input type="password" name="password1" size="40" /></dd>
	</dl>
	<dl>
		<dt><label for="password2"><?php echo $this->_tpl_vars['lang']['adminusers']['password']; ?>
</label></dt>
		<dd><input type="password" name="password2" size="40" /></dd>
	</dl>
	<dl>
		<dt><label for="submit">&nbsp;</label></dt>
		<dd>
		<input type="hidden" name="action" value="editpassword" />
		<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
" />
		<input type="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['editpassword']; ?>
" /></dd>
	</dl>
</form>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['editusergroups']; ?>
</h2>
<form method="post" action="">
<table id="list"style="width: 100%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['id']; ?>
</th>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['default']; ?>
</th>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['delete']; ?>
</th>
		<th><?php echo $this->_tpl_vars['lang']['adminusers']['group']; ?>
</th>
	</tr>
	<tbody>
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
		<tr class="<?php echo smarty_function_cycle(array('values' => "td1,td2"), $this);?>
">
			<td class="id"><?php echo $this->_tpl_vars['groups'][$this->_sections['ln']['index']]['id']; ?>
</td>
			<td class="id"><input type="radio" name="listdefault" value="<?php echo $this->_tpl_vars['groups'][$this->_sections['ln']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['groups'][$this->_sections['ln']['index']]['default'] == 'true'): ?> checked<?php endif; ?> /></td>
			<td class="id"><input type="checkbox" name="delete[]" value="<?php echo $this->_tpl_vars['groups'][$this->_sections['ln']['index']]['id']; ?>
" /></td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['groups'][$this->_sections['ln']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
" /> 
<input type="hidden" name="action" value="editusergroups" /> 
<p><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['editusergroups']; ?>
" /></p>
</form>
<?php if (isset ( $this->_tpl_vars['ugroups'][0] )): ?>
<form method="post" target="">
<select name="group">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['ugroups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value="<?php echo $this->_tpl_vars['ugroups'][$this->_sections['ln']['index']]['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['ugroups'][$this->_sections['ln']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</option>
<?php endfor; endif; ?>
</select>
<input type="hidden" name="action" value="addusertogroup" /> 
<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
" /> 
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['addgroup']; ?>
" />
</form><?php endif; ?>