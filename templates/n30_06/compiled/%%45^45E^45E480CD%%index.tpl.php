<?php /* Smarty version 2.6.18, created on 2008-03-25 21:06:24
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms - <?php echo $this->_tpl_vars['version']; ?>
 - <?php echo $this->_tpl_vars['pagetitle']; ?>
</title>
<link
	href="<?php echo $this->_tpl_vars['baseurl']; ?>
/templates/n30_06/style/default.css"
	rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<h1>n30 cms - <?php echo $this->_tpl_vars['version']; ?>
 - <?php echo $this->_tpl_vars['pagetitle']; ?>
</h1>
<ul id="mainmenu">
		<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['mainmenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<li
		<?php if ($this->_tpl_vars['mainmenu'][$this->_sections['ln']['index']]['active'] == 'true'): ?>
		class="opened" <?php endif; ?>><a
		href="<?php echo $this->_tpl_vars['mainmenu'][$this->_sections['ln']['index']]['link']; ?>
"><span><?php echo $this->_tpl_vars['mainmenu'][$this->_sections['ln']['index']]['full_title']; ?>
</span></a></li>
		<?php endfor; endif; ?>
	</ul>
	<?php if (isset ( $this->_tpl_vars['submenu'][0] )): ?>
	<ul id="submenu">
		<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['submenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<li
		<?php if ($this->_tpl_vars['submenu'][$this->_sections['ln']['index']]['active'] == 'true'): ?>
		class="opened" <?php endif; ?>><a
		href="<?php echo $this->_tpl_vars['submenu'][$this->_sections['ln']['index']]['link']; ?>
"><span><?php echo $this->_tpl_vars['submenu'][$this->_sections['ln']['index']]['full_title']; ?>
</span></a></li>
		<?php endfor; endif; ?>
	</ul>
	<?php endif; ?>
	<div id="content">
<h2><?php echo $this->_tpl_vars['pagetitle']; ?>
</h2>
		<?php if (isset ( $this->_tpl_vars['contextmenu'][0] )): ?>
		<ul id="contentmenu">
	<li class="head">menu</li>
		<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['contextmenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<li
		<?php if ($this->_tpl_vars['context'][$this->_sections['ln']['index']]['active'] == 'true'): ?>
		class="opened" <?php endif; ?>><a
		href="<?php echo $this->_tpl_vars['contextmenu'][$this->_sections['ln']['index']]['link']; ?>
"><span><?php echo $this->_tpl_vars['contextmenu'][$this->_sections['ln']['index']]['full_title']; ?>
</span></a></li>
		<?php endfor; endif; ?>
		</ul>
		<?php endif; ?>
		<?php echo $this->_tpl_vars['mod']; ?>

		<span style="clear: both;" /></div>
</div>
</body>
</html>