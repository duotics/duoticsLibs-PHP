<?php
/*
Datos de una TABLA / CAMPO / CONDICION
v1.1 2017-03-15
v1.2 2017-03-15
*/
function vImg($ruta,$nombre,$thumb=TRUE,$pthumb='_t'){
	//$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
	//$nombre. Nombre del Archivo
	//$thumb. TRUE o FALSE en caso de querer recuperar thumb
	$pthumb='t_';//$pthumb PREFIJO de Thumb
	$imgRet['n']=$GLOBALS['RAIZi'].'struct/no_image.jpg';
	$imgRet['t']=$imgRet['n'];
	if($nombre){
		//echo '<hr>RAIZ0. '.RAIZ0.$ruta.$nombre;
		//echo '<hr>$RAIZ0. '.$RAIZ.$ruta.$nombre;
	if (file_exists(RAIZ0.$ruta.$nombre)){
		//echo 'Existe';
		$imgRet['n']=$GLOBALS['RAIZ0'].$ruta.$nombre;
		$imgRet['t']=$imgRet['n'];
		if ($thumb==TRUE){
			if (file_exists(RAIZ0.$ruta.$pthumb.$nombre)){
				$imgRet['t']=$GLOBALS['RAIZ0'].$ruta.$pthumb.$nombre;
			}
		}
	}}
	return $imgRet;
}
/*HOW TO USE*/
$item_img=vImg('images/items/',$detItem['item_img']);
?>
<div class="form-group">
<a href="<?php echo $item_img['n'] ?>" class="fancybox">
<img src="<?php echo $item_img['t'] ?>" class="img-thumbnail"/></a>
<input name="userfile" type="file" id="userfile"/>
<input name="imagea" type="hidden" id="imagea" value="<?php echo $item_image ?>">
</div>