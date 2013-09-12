<?php /* Smarty version 2.6.19, created on 2008-08-28 17:48:46
         compiled from newdir.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'newdir.tpl', 6, false),array('function', 'html_select_date', 'newdir.tpl', 25, false),array('function', 'cycle', 'newdir.tpl', 39, false),)), $this); ?>
<h2 class="ttitle"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/folder.png" /> <?php echo $this->_tpl_vars['mlang']['newdir']; ?>
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
	<dd><input type="text" name="title" size="60"/></dd>
</dl>
<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['mlang']['newdir']; ?>
"/>
<h2 class="ttitle2"><a href="#" id="viewadvanced"><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-down.png" alt="." id="next-image"/><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/icons/small/go-up.png" alt="." id="up-image" style="display: none;"/></a> <?php echo $this->_tpl_vars['mlang']['advancedoptions']; ?>
 </h2>
<div id="advanced" style="display: none;">
<fieldset class="extra">
<legend><input type="checkbox" name="showindexes" checked/><?php echo $this->_tpl_vars['mlang']['showindexes']; ?>
</legend>
<p><?php echo $this->_tpl_vars['mlang']['showindexesexpl']; ?>
</p>
</fieldset>
<fieldset class="extra">
<legend><input type="checkbox" name="excludefromnav" /><?php echo $this->_tpl_vars['mlang']['excludefromnav']; ?>
</legend>
<p><?php echo $this->_tpl_vars['mlang']['excludefromnavexpl']; ?>
</p>
</fieldset>
<fieldset class="extra">
<legend><input type="checkbox" name="visibledate" /><?php echo $this->_tpl_vars['mlang']['visiblefromto']; ?>
</legend>
<p><?php echo $this->_tpl_vars['mlang']['from']; ?>
 <?php echo smarty_function_html_select_date(array('end_year' => '+10','field_array' => 'visiblefrom'), $this);?>
</p>
<p><?php echo $this->_tpl_vars['mlang']['to']; ?>
 <?php echo smarty_function_html_select_date(array('end_year' => '+10','field_array' => 'visibleto'), $this);?>
</p>
</fieldset>
<fieldset class="extra">
<legend><?php echo $this->_tpl_vars['mlang']['visiblefor']; ?>
</legend>
<p><input type="checkbox" name="visibleguest" checked/><?php echo $this->_tpl_vars['mlang']['visibleexpl']; ?>
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
			<td class="id"><input type="checkbox" name="visgroup[]" checked value="<?php echo $this->_tpl_vars['groups'][$this->_sections['ls']['index']]['id']; ?>
" /></td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['groups'][$this->_sections['ls']['index']]['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
</table>
</fieldset>
</div>
<input type="hidden" name="action" value="adddir" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" />
</form>