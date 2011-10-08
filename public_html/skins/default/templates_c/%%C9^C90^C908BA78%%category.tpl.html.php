<?php /* Smarty version 2.6.9, created on 2011-10-08 21:55:00
         compiled from category.tpl.html */ ?>

<?php if ($this->_tpl_vars['categoryTop'] != ''): ?>
<div class="category_header">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['categoryTop'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php endif; ?>


<div class="category clearfix">
<?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
<div class="product">
	<a href="<?php echo $this->_tpl_vars['domain']; ?>
/<?php echo $this->_tpl_vars['product']['slug']; ?>
/<?php echo $this->_tpl_vars['product']['ProductID']; ?>
.html"><?php echo $this->_tpl_vars['product']['Name']; ?>
</a>
	<img src="<?php echo $this->_tpl_vars['product']['SmallImage']; ?>
" />
	<br />
	<a href="<?php echo $this->_tpl_vars['domain']; ?>
/cart/add/<?php echo $this->_tpl_vars['product']['ProductID']; ?>
">Add To Cart</a><br />
</div>
<?php endforeach; endif; unset($_from);  if ($this->_tpl_vars['categoryBottom'] != ''): ?>
<div class="category_footer">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['categoryBottom'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php endif; ?>
</div>
