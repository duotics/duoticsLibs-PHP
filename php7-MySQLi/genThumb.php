<?php
/*Function Generate Thumb
v.1.0 => 2017-03-28*/
function genThumb($path, $file, $pref, $mwidth, $mheight){//v.1.0
	//$path
	$obj = new img_opt(); // Crear un objeto nuevo
	$obj->max_width($mwidth); // Decidir cual es el ancho maximo
	$obj->max_height($mheight); // Decidir el alto maximo
	$obj->image_path($path,$file,$pref); // Ruta, archivo, prefijo
	$obj->image_resize(); // Y finalmente cambiar el tamaño
}
/*HOW TO USE*/
//RAIZ0 -> path filesystem
//$file => file upload or file exist
$pat=RAIZ0.'images/types/';
$file=$_FILES['userfile'];
genThumb($pat, $file, "t_", 175, 175);
?>