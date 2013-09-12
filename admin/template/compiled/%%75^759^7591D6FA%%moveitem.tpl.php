<?php /* Smarty version 2.6.19, created on 2008-06-29 19:53:27
         compiled from moveitem.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'moveitem.tpl', 1, false),array('modifier', 'intval', 'moveitem.tpl', 26, false),)), $this); ?>
<h2 class="ttitle"><?php echo $this->_tpl_vars['mlang']['move']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['full_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'breadcrumbs.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="post" action="">
<dl>
	<dt><label for="dir"><?php echo $this->_tpl_vars['mlang']['currentlocation']; ?>
: </label></dt>
	<dd><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['full_location'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</dd>
</dl>
<h3 class="ttitle"><?php echo $this->_tpl_vars['mlang']['targetlocation']; ?>
:</h3>
<table id="list" style="width: 100%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['mlang']['id']; ?>
</th>
		<th class="id">&nbsp;</th>
		<th><?php echo $this->_tpl_vars['mlang']['location']; ?>
</th>
	</tr>
	<tbody>
		<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['moveto']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<tr>
			<td class="id"><?php echo $this->_tpl_vars['moveto'][$this->_sections['ln']['index']]['id']; ?>
</td>
			<td class="id"><input type="radio" name="moveto"  value="<?php echo $this->_tpl_vars['moveto'][$this->_sections['ln']['index']]['id']; ?>
" onclick="document.getElementById('submit').disabled = false; "/></td>
			<td><strong><?php echo ((is_array($_tmp=$this->_tpl_vars['moveto'][$this->_sections['ln']['index']]['full_location'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</strong></td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
<input type="hidden" name="action" value="move" />
<input type="hidden" name="id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)); ?>
" />
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['mlang']['move']; ?>
" disabled id="submit"/>
</form>