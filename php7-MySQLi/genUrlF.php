<?php
function genUrlFriendly($url) {
	$url = strtolower($url);// Tranformamos todo a minusculas
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);//Rememplazamos caracteres especiales latinos
	$find = array(' ', '&', '\r\n', '\n', '+'); 
	$url = str_replace ($find, '-', $url);// Añaadimos los guiones
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);// Eliminamos y Reemplazamos demás caracteres especiales
	return $url;
}

$furl=genUrlFriendly($data['txt_nom']);
?>