<?php
//FUNCTION TO GENERATE FRIENDLY URL
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

/*HOW TO USE*/
/*******************************/
//EXAMPLE WITH VERIFY DUPLICATE IN DATABASE
//BEG GENERATE URL FRIENDLY
if(!$data['txt_alias']){
	$data['txt_alias']=genUrlFriendly($data['txt_nom']);
}
//BUSCO SI EXISTE UNA URL AMIGABLE SIMILAR
$paramsN[]=array(
	array("cond"=>"AND","field"=>"item_aliasurl","comp"=>"=","val"=>$data['txt_alias']),
	array("cond"=>"AND","field"=>"item_id","comp"=>'<>',"val"=>$ids)
);//CONDICIONES CAMPO URL e ID tabla
$dFindUrlF=detRowNP('tbl_items',$paramsN);
//Si encontro un parecido agrego un distintivo al final
if($dFindUrlF) $data['txt_alias'].='-1';
//END GENERATE URL FRIENDLY
/*******************************/

?>