<?php /* Smarty version 2.6.9, created on 2011-10-08 23:41:34
         compiled from viewcart.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'viewcart.tpl.html', 4, false),)), $this); ?>
View cart:

<div class="cart">
	<?php if (count($this->_tpl_vars['cart']['items']) > 0): ?>
	<table width="100%">
	<tr>
		<th>&nbsp;</th>
	   <th>ID</th>
	   <th width="300">Name</th>
	   <th>Qty.</th>
	   <th>@Price</th>
	   <th>Total</th>
	</tr>
	<?php $this->assign('items', ""); ?>
	<?php $_from = $this->_tpl_vars['cart']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<tr>
			<td><a href="<?php echo $this->_tpl_vars['domain']; ?>
/cart/remove/<?php echo $this->_tpl_vars['item']['id']; ?>
">[x]</a></td>
			<td><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
			<td><a href="<?php echo $this->_tpl_vars['domain']; ?>
/<?php echo $this->_tpl_vars['item']['slug']; ?>
/<?php echo $this->_tpl_vars['item']['id']; ?>
.html"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></td>
			<td><?php echo $this->_tpl_vars['item']['qty']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['itemtotal']; ?>
</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	<tr>
		<td colspan="4">&nbsp;</td>
		<td><?php echo $this->_tpl_vars['cart']['total']; ?>
</td>
	</tr>
	</table>
	<div style="float: right">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
		<!-- Identify your business so that you can collect the payments. --> 
		<input type="hidden" name="business" value="sales@posmena.co.uk"> 
		<!-- Specify a Buy Now button. --> 
		<input type="hidden" name="cmd" value="_xclick"> 
		<!-- Specify details about the item that buyers will purchase. --> 
		<input type="hidden" name="item_name" value="<?php echo $this->_tpl_vars['item']['name']; ?>
: <?php echo $this->_tpl_vars['cart']['paypalitem']; ?>
"> 
		<input type="hidden" name="amount" value="0.01"> 
		<input type="hidden" name="currency_code" value="GBP"> 
		<input type="hidden" name="return" value="http://electronicdictionary.org.uk/"> 

		<!-- Display the payment button. --> 
		<input type="image" name="submit" border="0" 
		src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" 
		alt="PayPal - The safer, easier way to pay online"> 
		<img alt="" border="0" width="1" height="1" 
		src="https://www.paypal.com/en_US/i/scr/pixel.gif" > 
		</form> 
	</div>
	<?php else: ?>
		Your cart is empty! 
	<?php endif; ?>
</div>