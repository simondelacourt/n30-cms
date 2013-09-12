<?php /* Smarty version 2.6.19, created on 2008-10-30 18:08:54
         compiled from adm.news.edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'adm.news.edit.tpl', 16, false),array('modifier', 'htmlspecialchars', 'adm.news.edit.tpl', 19, false),array('modifier', 'stripslashes', 'adm.news.edit.tpl', 33, false),)), $this); ?>
<h2 class="bar"><span><?php echo $this->_tpl_vars['mlang']['news']['shortstory']; ?>
</span></h2>
<?php echo $this->_tpl_vars['w_short']; ?>

<h2 class="bar"><span><?php echo $this->_tpl_vars['mlang']['news']['fullstory']; ?>
</span></h2>
<?php echo $this->_tpl_vars['w_full']; ?>

<h2 class="bar"><span><input type="checkbox" name="pdata[allowreplies]" <?php if ($this->_tpl_vars['news']['replies_on'] == 'true'): ?>checked="checked"<?php endif; ?> value="true"/><?php echo $this->_tpl_vars['mlang']['news']['replies']; ?>
</span></h2>
<hp><input type="checkbox" name="pdata[allowguestreplies]" <?php if ($this->_tpl_vars['news']['replies_guests'] == 'true'): ?>checked="checked"<?php endif; ?> value="true"/><?php echo $this->_tpl_vars['mlang']['news']['guestreplies']; ?>
</p>
<h2 class="bar"><span><?php echo $this->_tpl_vars['mlang']['news']['groupreplies']; ?>
</span></h2>
<table id="list"style="width: 100%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['id']; ?>
</th>
		<th class="id">&nbsp;</th>
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
			<td class="id"><input type="checkbox" name="pdata[rgroups][]" value="<?php echo $this->_tpl_vars['groups'][$this->_sections['ln']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['groups'][$this->_sections['ln']['index']]['checked'] == true): ?>checked="checked"<?php endif; ?> /></td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['groups'][$this->_sections['ln']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
<h2 class="bar"><span><?php echo $this->_tpl_vars['mlang']['news']['repliesinthread']; ?>
</span></h2>
<ul id="posts">
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['replies']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<li class="<?php echo smarty_function_cycle(array('values' => "li1,li2"), $this);?>
">
<?php if ($this->_tpl_vars['replies'][$this->_sections['ln']['index']]['mode'] == 'guest'): ?>
<h4><input type="checkbox" name="pdata[delrep][]" value="<?php echo $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['id']; ?>
" /> <?php echo $this->_tpl_vars['mlang']['news']['delete']; ?>
 - <?php if (! empty ( $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_email'] )): ?><a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_email'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"><?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
<?php if (! empty ( $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_email'] )): ?></a> (<?php echo $this->_tpl_vars['mlang']['news']['guest']; ?>
)<?php endif; ?> (<?php echo $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['message_crdate']; ?>
)</h4>
<?php else: ?>
<h4><input type="checkbox" name="pdata[delrep][]" value="<?php echo $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['id']; ?>
" /> <?php echo $this->_tpl_vars['mlang']['news']['delete']; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
 (<?php echo $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['message_crdate']; ?>
)</h4>
<?php endif; ?>
<p><?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['message_processed'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</p>
</li>
<?php endfor; endif; ?>
</ul>