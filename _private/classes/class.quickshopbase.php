<?php

class quickshop extends config
{
	private $db;
	private $template = 'home.tpl.html';
	private $ms;
	private $qs;
	private $user;
	private $personal_info;
	private $save_result = array('message', false);
	private $step;
	private $selected_site;
	private $products = array();
	private $product;
	private $cart;
	private $categoryid;
	private $categoryTop;
	private $categoryBottom;
	private $currentcat;
	public $domain;

	public function __construct()
	{
		$this->setup();
		//$this->db = new database;
		//$this->ms = new membership($this->db);
		//$this->fn = new sitebuilder_functions($this->db);
		$this->qs = $_GET;
		foreach($_POST as $key => $value)
		{
			$this->qs[$key] = $value;
		}

		//$this->db->connection("chops_compare");

		$this->tplBase = new Template($this->theme);
		//$this->global_minified_js = Minify_groupUri('sitebuilderjs');
		//$this->global_minified_css = Minify_groupUri('sitebuildercss');
	}

	public function slugify($string) {
		$slug = preg_replace("/[^a-zA-Z0-9 ]/", "", $string);
		$slug = strtolower(str_replace(" ", "-", $slug));

		return $slug;
	}

	public function direct()
	{

		$conn = new Mongo('localhost');
		$mdb = $conn->quickshop;
		$collection = $mdb->atsproducts;

		$this->urls = array();
	

		foreach ($this->cats as $catId => $category) {
			$this->categories[$catId]['slug'] = $this->slugify($category);
			$this->categories[$catId]['text'] = $category;
			
			$this->slugs[$this->categories[$catId]['slug']]['type'] = 'category';
			$this->slugs[$this->categories[$catId]['slug']]['id'] = $catId;
			//$this->urls[$this->categories[$catId]['slug']]['info'] = $this->categori;
		}

		foreach ($this->menu as $id => $page) {
			$slug = $this->slugify($page);
			$this->pages[$slug]['slug'] = $this->slugify($page);
			if ($id == 0) {
				$this->pages[$slug]['slug'] = '';
			}
			
			$this->pages[$slug]['text'] = $page;

			$this->slugs[$this->pages[$slug]['slug']]['type'] = 'page';
			$this->slugs[$this->pages[$slug]['slug']]['id'] = $id;
		}

		

		if (true === isset($this->qs['action'])) {
			switch ($this->qs['action']) {
				case 'sitemap':
				{
					$sm = new sitemap;

					foreach ($this->slugs as $slug => $vals) {
						$sm->addItem($this->domain . '/' . $slug . '.html');
					}

					foreach ($this->categories as $cid => $category) {
						$cid .= '';
						$products = $collection->find(array('CategoryID' => $cid));
						//$products = $collection->find()->limit(1);

						foreach($products as $key => $product) {
							$sm->addItem($this->domain . '/' . $this->slugify($product['Name']) . '/' . $product['ProductID'] . '.html');
						}
					}

					print $sm->getSitemap();
					exit;
				}
				case 'productpresentation':
				{
					$this->template = 'product.tpl.html';

					$pParts = explode('/', $this->qs['productid']);
					$productId = str_replace('.html', '', $pParts[1]);

					$product = $collection->find(array('ProductID' => $productId));

					foreach($product as $meh) {
						$this->product = $meh;
					}
						

					break;
				}
				case 'removefromcart':
				{
					$this->qs['productid'] = str_replace('cart/remove/', '', $this->qs['productid']);
					unset($_SESSION['cart']['items'][$this->qs['productid']]);

					$basketTotal = 0;
					$paypalItem = '';
					foreach($_SESSION['cart']['items'] as $pid => $item) {
						$itemTotal = $item['qty'] * $item['price'];
						$_SESSION['cart']['items'][$pid]['itemtotal'] = $itemTotal;
						$basketTotal += $itemTotal;
						$paypalItem .= 'asd'.$pid . '(' . $item['qty'] . '), '; 
					}
					
					$_SESSION['cart']['paypalitem'] = $paypalItem;
					$_SESSION['cart']['total'] = $basketTotal;
					
					header('Location: /cart/view');
					break;
					
				}
				case 'addtocart':
				{
					//$_SESSION['cart'] = array();
					$this->qs['productid'] = str_replace('cart/add/', '', $this->qs['productid']);
					//$_SESSION['cart'] = array();
					if (false === isset($this->qs['productid'])) {
						// no product to add
						die('Invalid Product ID');
					}

					if (false === isset($_SESSION['cart']['items'][$this->qs['productid']])) {
						// product doesnt exist in cart yet, so lets get product
						$productId = $this->qs['productid'] . '';
						$product = $collection->find(array('ProductID' => $productId));

						foreach($product as $meh) {
							$product = $meh;
						}
						
						$price = (float) $product['DropshipPrice'];
						$name = $product['Name'];
						$_SESSION['cart']['items'][$this->qs['productid']]['id'] = $this->qs['productid'];
						$_SESSION['cart']['items'][$this->qs['productid']]['qty'] = 1;
						$_SESSION['cart']['items'][$this->qs['productid']]['price'] = $price;
						$_SESSION['cart']['items'][$this->qs['productid']]['name'] = $name;
						$_SESSION['cart']['items'][$this->qs['productid']]['slug'] = $this->slugify($name);
					} else {
						$_SESSION['cart']['items'][$this->qs['productid']]['qty']++;
					}

					$basketTotal = 0;
					$paypalItem = '';
					foreach($_SESSION['cart']['items'] as $pid => $item) {
						$itemTotal = $item['qty'] * $item['price'];
						$_SESSION['cart']['items'][$pid]['itemtotal'] = $itemTotal;
						$basketTotal += $itemTotal;
						$paypalItem .= $pid . '(' . $item['qty'] . '), '; 
					}
					
					$_SESSION['cart']['paypalitem'] = $paypalItem;
					$_SESSION['cart']['total'] = $basketTotal;

					/*
					print "<pre>";
					print_r($_SESSION);
					print "</pre>";
					*/
					header('Location: /cart/view');
					break;
				}

				case 'viewcart':
				{
					$this->template = 'viewcart.tpl.html';
					$this->cart = $_SESSION['cart'];

				}
			}
		}

		

		if (true === isset($this->qs['slug'])) {
			if (true === array_key_exists($this->qs['slug'], $this->slugs)) {
				$this->page = $this->slugs[$this->qs['slug']];
				switch($this->page['type']) {
					case 'category':
					{
						$this->template = 'category.tpl.html';
						$catId = $this->page['id'];
						$this->categoryid = $catId;
						// get products
						$this->currentcat = $this->categories[$catId];
						
							
						$catId = $catId . '';
						$products = $collection->find(array('CategoryID' => $catId));
						//$products = $collection->find()->limit(1);

						foreach($products as $key => $product) {
							$newProducts[$key] = $product;
							$newProducts[$key]['slug'] = $this->slugify($product['Name']);
						}
						
						$this->products = $newProducts;
						
						$categoryTop = $this->tplBase->getTemplatePath().'categories/'.$catId.'_top.tpl.html';
						$categoryBottom = $this->tplBase->getTemplatePath().'categories/'.$catId.'_bottom.tpl.html';
						if(file_exists($categoryTop)) {
							$this->categoryTop = $categoryTop;
						}

						if(file_exists($categoryBottom)) {
							$this->categoryBottom = $categoryBottom;
						}
						
						break;
					}
					case 'page':
					{
						$this->template = 'pages/' . $this->qs['slug'] . '.tpl.html';
						break;
					}
				}
			}
		} else {
			// home
			if (isset($this->homecat)) {
				
				$products = $collection->find(array('CategoryID' => $this->homecat));
						//$products = $collection->find()->limit(1);

				foreach($products as $key => $product) {
					$newProducts[$key] = $product;
					$newProducts[$key]['slug'] = $this->slugify($product['Name']);
				}
				
				$this->products = $newProducts;
				
			}
		}
	}

	public function draw($ajax = false)
	{
		$shop['title'] = $this->title;
		$shop['name'] = $this->name;
		$this->tplBase->assign('content', $this->template);
		$this->tplBase->assign('domain', $this->domain);
		$this->tplBase->assign('current_url', '');
		$this->tplBase->assign('categories', $this->categories);
		$this->tplBase->assign('currentcat', $this->currentcat);
		$this->tplBase->assign('pages', $this->pages);
		$this->tplBase->assign('products', $this->products);
		$this->tplBase->assign('product', $this->product);
		$this->tplBase->assign('categoryid', $this->categoryid);
		$this->tplBase->assign('homecat', $this->homecat);
		$this->tplBase->assign('cart', $this->cart);
		$this->tplBase->assign('categoryTop', $this->categoryTop);
		$this->tplBase->assign('categoryBottom', $this->categoryBottom);
		$this->tplBase->assign('shop', $shop);

		if($ajax)
		{
			$this->tplBase->display($this->template);
		}
		else
		{
			//$this->tplBase->display('sitebuilder.tpl.html');
			//$mhtml = new Minify_HTML($this->tplBase->fetch('sitebuilder.tpl.html'));
			//$output = $mhtml->minify($this->tplBase->fetch('sitebuilder.tpl.html'));
			//$this->tplBase->assign('output', $output);
			//$this->tplBase->display('minifiedhtml.tpl.html');
			$this->tplBase->display('quickshop.tpl.html');
		}
	}
}