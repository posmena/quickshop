<?php /* Smarty version 2.6.9, created on 2011-10-09 00:04:17
         compiled from quickshop.tpl.html */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->_tpl_vars['shop']['title']; ?>
</title>
	<link rel="stylesheet" type="text/css" href="/style.css" media="screen, projection" />
	<script src="/min/?g=sitebuilderjs&amp;1274021140"></script>
	<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
</head>

<body>

<div id="wrapper">

	<div class="header">
		<h1><?php echo $this->_tpl_vars['shop']['name']; ?>
</h1>
		<div class="menu">
			<ul>
			<?php $this->assign('counter', 0); ?>
			<?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
				<li><a href="<?php echo $this->_tpl_vars['domain']; ?>
/<?php echo $this->_tpl_vars['page']['slug'];  if ($this->_tpl_vars['counter'] > 0): ?>.html<?php endif; ?>"><?php echo $this->_tpl_vars['page']['text']; ?>
</a></li>
				<?php $this->assign('counter', $this->_tpl_vars['counter']+1); ?>
			<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	</div>

	<div class="body clearfix">
	<div class="content">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
		<div class="navigation">
			<div class="group">
				<span class="heading">Categories</span>
				<ul>
					<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category']):
?>
					<li><a href="<?php echo $this->_tpl_vars['domain']; ?>
/<?php echo $this->_tpl_vars['category']['slug']; ?>
.html"><?php echo $this->_tpl_vars['category']['text']; ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
		</div>
		
	</div>

	<div class="footer">
		&copy; Electronic Dictionaries 2011
	</div>
	
</div>

</body>


</html>