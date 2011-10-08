<?php /* Smarty version 2.6.9, created on 2011-10-08 21:42:23
         compiled from product.tpl.html */ ?>
<div class="product">

Product View

<?php echo $this->_tpl_vars['product']['Name']; ?>


<br /><br />

<img src="<?php echo $this->_tpl_vars['product']['LargeImage']; ?>
" />

<br />

<a href="<?php echo $this->_tpl_vars['domain']; ?>
/cart/add/<?php echo $this->_tpl_vars['product']['ProductID']; ?>
">Add To Cart</a>

<br />

</div>