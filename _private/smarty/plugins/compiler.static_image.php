<?php

function build_params($tag_attrs, &$smarty)
{
  $args = $smarty->_parse_attrs($tag_attrs);
  $ret = array();
  foreach ($args as $k => $v) {
    $ret[$k] = $smarty->_dequote($v);
  }
  return $ret;
}


function build_image($params, &$smarty) {

	if (!is_array($params)) {
		$params = build_params($params, &$smarty);
	}
	
	$src = $smarty->_tpl_vars['image_url'];
	die(print_r($params));
	if (!isset($src)) {
		return "[No src to image]";
	}
	$file = $src;

	$height = $params['height'];
	if (!isset($height)) {
		$size = getimagesize($file);
		$height = $size[1];
	}
	$width = $params['width'];
	if (!isset($width)) {
		if (!isset($size)) {
		  $size = getimagesize($file);
		}
		$width = $size[0];
	}
	$alt = htmlspecialchars($params['alt']);
	$url = htmlspecialchars($src);
	
	return '<img alt="'.$alt.'" src="'.$url.'" width="'.$width.'" height="'.$height.'" $attribs>';
	
  //return "hello";

}


function php_echo($text) {
	return 'echo "' . addslashes($text) . "\";";
}

function smarty_compiler_static_image($tag_attrs, &$smarty) {
	$args = $smarty->_parse_attrs($tag_attrs);
	die(print_r($args));
	return php_echo(build_image($tag_attrs, &$smarty));
}
?>
