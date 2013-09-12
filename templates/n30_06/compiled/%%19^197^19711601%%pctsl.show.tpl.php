<?php /* Smarty version 2.6.19, created on 2008-10-04 17:06:03
         compiled from pctsl.show.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'pctsl.show.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['sinfo']['showimagestrip'] == 1): ?>
<div id="imgstrip">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['pictures']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php if ($this->_tpl_vars['pictures'][$this->_sections['ln']['index']]['active']): ?><b>active</b><?php endif; ?>
<a href="<?php echo $this->_tpl_vars['pictures'][$this->_sections['ln']['index']]['slink']; ?>
"><img src="<?php echo $this->_tpl_vars['pictures'][$this->_sections['ln']['index']]['thumbnail']; ?>
" /></a>
<?php endfor; endif; ?>
</div>
<?php endif; ?>
<div id="sshow"><?php if (isset ( $this->_tpl_vars['nav']['next'] )): ?><a href="<?php echo $this->_tpl_vars['nav']['next']; ?>
" id="plink"><?php endif; ?><img src="<?php echo $this->_tpl_vars['currentpicture']['viewurl']; ?>
" alt="<?php echo $this->_tpl_vars['currentpicture']['full_title']; ?>
"/><?php if (isset ( $this->_tpl_vars['nav']['next'] )): ?></a><?php endif; ?><br /></div>
<div id="pinfo">
		<div id="comments">		
			<h2><?php echo $this->_tpl_vars['info']['full_title']; ?>
</h2>
			<?php if (! empty ( $this->_tpl_vars['currentpicture']['description'] )): ?><p class="info"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentpicture']['description'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</p><?php else: ?><br /><?php endif; ?>
		
		<p class="buttons">	
			<span class="prev"><?php if (isset ( $this->_tpl_vars['nav']['prev'] )): ?><a href="<?php echo $this->_tpl_vars['nav']['prev']; ?>
"><?php endif; ?>&#60;<?php if (isset ( $this->_tpl_vars['nav']['prev'] )): ?></a><?php endif; ?></span>
			<span class="next"><?php if (isset ( $this->_tpl_vars['nav']['next'] )): ?><a href="<?php echo $this->_tpl_vars['nav']['next']; ?>
"><?php endif; ?>&#62;<?php if (isset ( $this->_tpl_vars['nav']['next'] )): ?></a><?php endif; ?></span>
		</p>
		</div>
		<br style="clear: both;"/>
</div>