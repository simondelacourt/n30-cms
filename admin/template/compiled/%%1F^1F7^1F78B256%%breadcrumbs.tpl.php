<?php /* Smarty version 2.6.19, created on 2008-06-29 17:02:26
         compiled from breadcrumbs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'breadcrumbs.tpl', 5, false),)), $this); ?>
<p id="location">
	<img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-next.png" alt="."/>
	<span>
	<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['breadcrumbs']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<?php if (! empty ( $this->_tpl_vars['breadcrumbs'][$this->_sections['ln']['index']]['link'] )): ?><a href="<?php echo $this->_tpl_vars['breadcrumbs'][$this->_sections['ln']['index']]['link']; ?>
"><?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['breadcrumbs'][$this->_sections['ln']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
<?php if (! empty ( $this->_tpl_vars['breadcrumbs'][$this->_sections['ln']['index']]['link'] )): ?></a><?php endif; ?>  > 
	<?php endfor; endif; ?>
	</span>
</p>