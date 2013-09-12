<?php /* Smarty version 2.6.19, created on 2008-10-30 17:18:24
         compiled from /Applications/MAMP/htdocs/n30_06/non_html/modules/content/templates/plugins/news.show.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', '/Applications/MAMP/htdocs/n30_06/non_html/modules/content/templates/plugins/news.show.tpl', 1, false),array('modifier', 'htmlspecialchars', '/Applications/MAMP/htdocs/n30_06/non_html/modules/content/templates/plugins/news.show.tpl', 7, false),)), $this); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['news']['news_full'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>

<?php if ($this->_tpl_vars['news']['replies_on'] == 'true'): ?>
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
<li>
<?php if ($this->_tpl_vars['replies'][$this->_sections['ln']['index']]['mode'] == 'guest'): ?>
<h4><?php if (! empty ( $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_email'] )): ?><a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_email'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"><?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
<?php if (! empty ( $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_email'] )): ?></a> (<?php echo $this->_tpl_vars['mlang']['news']['guest']; ?>
)<?php endif; ?> (<?php echo $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['message_crdate']; ?>
)</h4>
<?php else: ?>
<h4><?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['poster_name'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
 (<?php echo $this->_tpl_vars['replies'][$this->_sections['ln']['index']]['message_crdate']; ?>
)</h4>
<?php endif; ?>
<p><?php echo ((is_array($_tmp=$this->_tpl_vars['replies'][$this->_sections['ln']['index']]['message_processed'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</p>
</li>
<?php endfor; endif; ?>
</ul>
<?php if ($this->_tpl_vars['replyok']): ?>
<h2><?php echo $this->_tpl_vars['mlang']['news']['postreply']; ?>
</h2>
<form method="post">
<?php if ($this->_tpl_vars['replymode'] == 'guest'): ?>
<dl>
	<dt><label for="name"><?php echo $this->_tpl_vars['mlang']['news']['name']; ?>
</label></dt>
	<dd><input type="text" name="name" size="60" /></dd>
</dl>
<dl>
	<dt><label for="email"><?php echo $this->_tpl_vars['mlang']['news']['email']; ?>
</label></dt>
	<dd><input type="text" name="email" size="60" /></dd>
</dl>
<dl>
	<dt><label for="url"><?php echo $this->_tpl_vars['mlang']['news']['url']; ?>
</label></dt>
	<dd><input type="text" name="url" size="60" /></dd>
</dl>
<?php endif; ?>
<dl>
	<dt><label for="message"><?php echo $this->_tpl_vars['mlang']['news']['message']; ?>
</label></dt>
	<dd><textarea name="message"></textarea></dd>
</dl>
<dl>
	<dt><label for="submit">&nbsp;</label></dt>
	<dd><input type="submit" name="submit" value="<?php echo $this->_tpl_vars['mlang']['news']['postreply']; ?>
" /></dd>
</dl>
</form>
<?php endif; ?>
<?php endif; ?>