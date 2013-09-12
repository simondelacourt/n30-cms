<?php /* Smarty version 2.6.19, created on 2008-05-20 22:16:47
         compiled from usernotes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'usernotes.tpl', 1, false),array('modifier', 'nl2br', 'usernotes.tpl', 6, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['lang']['adminusers']['usernotes']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
<ul id="notes">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['notes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<p class="info"><?php echo ((is_array($_tmp=$this->_tpl_vars['notes'][$this->_sections['ln']['index']]['usernamecreator'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
 - <?php echo $this->_tpl_vars['notes'][$this->_sections['ln']['index']]['crdate']; ?>
:</p>
<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['notes'][$this->_sections['ln']['index']]['note'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p>
<form method="post">
<input type="hidden" name="action" value="deleteusernote" /> 
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['notes'][$this->_sections['ln']['index']]['id']; ?>
" /> 
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['delete']; ?>
" />
</form>
</li>
<?php endfor; endif; ?>
</ul>
<form method="post" action="" id="addnote">
<textarea name="note"></textarea>
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['lang']['adminusers']['addusernote']; ?>
" />
<input type="hidden" name="action" value="addusernote" /> 
<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']['id']; ?>
" /> 
</form>