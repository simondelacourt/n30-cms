<?php /* Smarty version 2.6.19, created on 2008-10-04 15:25:27
         compiled from pctgl.show.tpl */ ?>
<h4><?php echo $this->_tpl_vars['currentpicture']['full_title']; ?>
</h4>
<img src="<?php echo $this->_tpl_vars['currentpicture']['viewurl']; ?>
" /><br />
<?php if (isset ( $this->_tpl_vars['nav']['prev'] )): ?><a href="<?php echo $this->_tpl_vars['nav']['prev']; ?>
">Previous</a><?php endif; ?> <?php if (isset ( $this->_tpl_vars['nav']['next'] )): ?><a href="<?php echo $this->_tpl_vars['nav']['next']; ?>
">Next</a><?php endif; ?> 