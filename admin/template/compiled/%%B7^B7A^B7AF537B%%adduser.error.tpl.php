<?php /* Smarty version 2.6.19, created on 2008-04-29 21:14:41
         compiled from adduser.error.tpl */ ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['error']; ?>
</h2>
<ul class="emessage">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['messages']['adduser']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php if ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'exists'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['exists']; ?>

<?php elseif ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'template'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['template']; ?>

<?php elseif ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'language'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['language']; ?>

<?php elseif ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'email'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['email']; ?>

<?php elseif ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'password'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['password']; ?>

<?php elseif ($this->_tpl_vars['messages']['adduser'][$this->_sections['ln']['index']] == 'username'): ?>
<?php echo $this->_tpl_vars['lang']['adminusers']['errors']['username']; ?>

<?php endif; ?></li>
<?php endfor; endif; ?>
</ul>