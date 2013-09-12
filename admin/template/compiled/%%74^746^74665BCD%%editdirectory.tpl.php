<?php /* Smarty version 2.6.19, created on 2008-10-14 20:32:46
         compiled from editdirectory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'editdirectory.tpl', 6, false),array('function', 'html_select_date', 'editdirectory.tpl', 36, false),array('function', 'cycle', 'editdirectory.tpl', 50, false),)), $this); ?>
<h2 class="ttitle"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/folder.png" /> <?php echo $this->_tpl_vars['mlang']['editdir']; ?>
</h2>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "breadcrumbs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="post" action="" id="page">
<dl>
	<dt><label for="dir"><?php echo $this->_tpl_vars['mlang']['directory']; ?>
: </label></dt>
	<dd><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['full_location'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</dd>
</dl>
<dl>
	<dt><label for="title"><?php echo $this->_tpl_vars['mlang']['title']; ?>
 </label></dt>
	<dd><input type="text" name="title" size="60" <?php if ($this->_tpl_vars['item']['full_location'] == '/'): ?>disabled<?php endif; ?> value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['full_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"/></dd>
</dl>
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['mlang']['editdir']; ?>
"/>
<h2 class="ttitle2"><a href="#" id="viewadvanced"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-down.png" alt="." id="next-image"/><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-up.png" alt="." id="up-image" style="display: none;"/></a> <?php echo $this->_tpl_vars['mlang']['advancedoptions']; ?>
 </h2>
<div id="advanced" style="display: none;">
<fieldset class="extra">
<legend><input type="checkbox" name="showindexes" <?php if ($this->_tpl_vars['item']['dir_indexes'] == 'true'): ?>checked <?php endif; ?>/><?php echo $this->_tpl_vars['mlang']['showindexes']; ?>
</legend>
<p><?php echo $this->_tpl_vars['mlang']['showindexesexpl']; ?>
</p>
</fieldset>
<fieldset class="extra">
<legend><?php echo $this->_tpl_vars['mlang']['indexitem']; ?>
</legend>
<p>
<select name="indexfile">
<option value="0" <?php if ($this->_tpl_vars['item']['dir_indexfile'] == 0): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['mlang']['none']; ?>
</option>
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['indexfiles']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value="<?php echo $this->_tpl_vars['indexfiles'][$this->_sections['ln']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['item']['dir_indexfile'] == $this->_tpl_vars['indexfiles'][$this->_sections['ln']['index']]['id']): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['indexfiles'][$this->_sections['ln']['index']]['full_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</option>
<?php endfor; endif; ?>
</select>
</p>
</fieldset>
<fieldset class="extra">
<legend><input type="checkbox" name="excludefromnav" <?php if ($this->_tpl_vars['item']['excludefromnav'] == 'true'): ?>checked<?php endif; ?> <?php if ($this->_tpl_vars['item']['full_location'] == '/'): ?>disabled<?php endif; ?> /><?php echo $this->_tpl_vars['mlang']['excludefromnav']; ?>
</legend>
<p><?php echo $this->_tpl_vars['mlang']['excludefromnavexpl']; ?>
</p>
</fieldset>
<fieldset class="extra">
<legend><input type="checkbox" name="visibledate" <?php if ($this->_tpl_vars['item']['visible_date'] == 'true'): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['mlang']['visiblefromto']; ?>
</legend>
<p><?php echo $this->_tpl_vars['mlang']['from']; ?>
 <?php echo smarty_function_html_select_date(array('end_year' => '+10','field_array' => 'visiblefrom','time' => $this->_tpl_vars['item']['visible_from']), $this);?>
</p>
<p><?php echo $this->_tpl_vars['mlang']['to']; ?>
 <?php echo smarty_function_html_select_date(array('end_year' => '+10','field_array' => 'visibleto','time' => $this->_tpl_vars['item']['visible_to']), $this);?>
</p>
</fieldset>
<fieldset class="extra">
<legend><?php echo $this->_tpl_vars['mlang']['visiblefor']; ?>
</legend>
<p><input type="checkbox" name="visibleguest" <?php if ($this->_tpl_vars['item']['visible_guest'] == 'yes'): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['mlang']['visibleexpl']; ?>
</p>
<table id="list" style="width: 100%">
	<tr>
		<th class="id"><?php echo $this->_tpl_vars['lang']['adminusers']['id']; ?>
</th>
		<th class="id">&nbsp;</th>
		<th><?php echo $this->_tpl_vars['lang']['adminusers']['usergroup']; ?>
</th>
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
			<td class="id"><input type="checkbox" name="visgroup[]" <?php if ($this->_tpl_vars['groups'][$this->_sections['ls']['index']]['checked'] == 'true'): ?>checked<?php endif; ?> value="<?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['id']; ?>
" /></td>
			<td><?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['title']; ?>
</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
</fieldset>
</div>
<input type="hidden" name="action" value="editdir" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" />
</form>