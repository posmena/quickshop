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

	$src = $params['src'];
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
	
	return '<img src="'.$url.'" alt="'.$alt.'" width="'.$width.'" height="'.$height.'" style="max-width: 120px;">';
	
  //return "hello";

}


function php_echo($text) {
	return 'echo "' . addslashes($text) . "\";";
}

function smarty_function_image($tag_attrs, &$smarty) {
	return build_image($tag_attrs, &$smarty);
}
?>
