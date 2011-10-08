<?php

define('appBase', '/Users/bobbeh/Sites/quickshop/');
require_once (appBase.'_private/smarty/Smarty.class.php');
//error_reporting(E_ALL);
class template extends Smarty
{
   function template($Skin)
   {
      $this->Smarty();
      $this->template_dir = appBase.'public_html/skins/'.$Skin.'/templates/';
      $this->compile_dir = appBase.'public_html/skins/'.$Skin.'/templates_c/';
      $this->config_dir = appBase.'public_html/skins/'.$Skin.'/configs/';
      $this->cache_dir = appBase.'public_html/skins/'.$Skin.'/cache/';

      $this->caching = false;
//			$this->clear_all_cache();
//			$this->clear_compiled_tpl();
   }

   public function getTemplatePath()
   {
   		return $this->template_dir;
   }

	public function fetch_template($resource_name){
		
		$temp = str_replace('tpl.html', $_SESSION['language'].'.tpl.html', $resource_name);
		echo $temp;
		if($this->template_exists($temp)){
			echo "replaced;";
			$resource_name = $temp;
		}
		
		return $this->fetch($resource_name, $cache_id = null, $compile_id = null, $display = false);
	}
}
?>
