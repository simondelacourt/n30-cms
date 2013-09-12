<?php /* Smarty version 2.6.19, created on 2008-08-28 11:55:13
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'login.tpl', 33, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>n30 cms admin - <?php echo $this->_tpl_vars['pagetitle']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['baseurl']; ?>
/admin/style/default.css" rel="stylesheet"
	type="text/css" />
<?php unset($this->_sections['ln']);
$this->_sections['ln']['name'] = 'ln';
$this->_sections['ln']['loop'] = is_array($_loop=$this->_tpl_vars['javascriptloads']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?><script type="text/javascript" src="<?php echo $this->_tpl_vars['javascriptloads'][$this->_sections['ln']['index']]; ?>
"></script> <?php endfor; endif; ?>
</head>
<body>
<div id="wrapper">
<div id="top">&nbsp;</div>
<div id="head"><h1><span>N30-CMS</span></h1></div>
<div id="main">
	<?php if (! empty ( $this->_tpl_vars['pagetitle'] )): ?><h2><?php echo $this->_tpl_vars['pagetitle']; ?>
</h2><?php endif; ?>
	<?php if ($this->_tpl_vars['error']): ?><p><?php echo $this->_tpl_vars['lang']['adminuser']['LOGINERROR']; ?>
</p><?php endif; ?>
	<form method="post">
<fieldset><legend>Login form</legend>
<dl>
	<dt><label for="nickname"><?php echo $this->_tpl_vars['lang']['adminuser']['USERNAME']; ?>
</label></dt>
	<dd><input type="text" name="nickname" size="24" /></dd>
	<dt><label for="password"><?php echo $this->_tpl_vars['lang']['adminuser']['PASSWORD']; ?>
</label></dt>
	<dd><input type="password" name="password" size="30" /></dd>
	<dd><input type="submit" name="submit"
		value="<?php echo $this->_tpl_vars['lang']['adminuser']['LOGINBUTTON']; ?>
" /><input type="hidden" name="action"
		value="login" /></dd>
</dl>
</fieldset>
</form>
	
	
</div>
	<div class="copyright">&copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
 <a href="http://ctstudios.nl">CT.Studios</a></div>
		
<div id="footer">&nbsp;</div>
</div>
</body>
</html>