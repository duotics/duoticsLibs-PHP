<?php

//Verificacion de existencia de una imagen en una ruta del sistema
//v1.1 2017-03-15
//v1.2 2017-03-15
//v1.3 2017-04-01 -> add $imgRet['f'] to return original filename
//v1.4 2017-04-01 -> add $imgRet['s'] to return status of function
//v1.5 2017-04-11 -> add $retHtml to return html code img/a

/*DOCUMENTATION
	$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
	//$nombre. Nombre del Archivo
	//$thumb. TRUE o FALSE en caso de querer recuperar thumb
	//$pthumb PREFIJO de Thumb
	//RAIZ must be named RAIZ0 depends the root folder
*/
function vImg($ruta,$nombre,$thumb=TRUE,$pthumb='t_',$retHtml=FALSE){//v1.5
	$imgRet['n']=$GLOBALS['RAIZi'].'struct/no_image.jpg';
	$imgRet['t']=$imgRet['n'];
	$imgRet['s']=FALSE;//Verify if file exist is default FALSE
	$imgRet['f']=$nombre;
	if($nombre){

		if (file_exists(RAIZ.$ruta.$nombre)){
			$imgRet['s']=TRUE;//FILE EXIST RETURN TRUE AND ALL DATA (link normal, link thumb, file name original)
			$imgRet['f']=$nombre;
			$imgRet['n']=$GLOBALS['RAIZ'].$ruta.$nombre;
			$imgRet['t']=$imgRet['n'];
			if ($thumb==TRUE){
				if (file_exists(RAIZ.$ruta.$pthumb.$nombre)){
					$imgRet['t']=$GLOBALS['RAIZ'].$ruta.$pthumb.$nombre;
				}
			}
		}
	}
	//Direct Return HTML Code *********** TERMINAR ESTE CODIGO
	if($retHtml){
		foreach($retHtml as $key => $valor){
			if($key!='tip') $paramCode=' '.$key.' = '.'"'.$valor.'"';
		}
		switch($retHtml['tip']){
			case 'imgn':
				$imgRet['code']='<img src="'.$imgRet['n'].'" '.$paramCode.'>';
			break;
			case 'imgt':
				$imgRet['code']='<img src="'.$imgRet['t'].'" '.$paramCode.'>';
			break;
			case 'aimg':
				$imgRet['code']='<a href="'.$imgRet['n'].'" '.$paramCode.'><img src="'.$imgRet['t'].'"></a>';
			break;
		}
		
	}
	return $imgRet;
}
/*HOW TO USE*/
$item_img=vImg('images/items/',$detItem['item_img'],TRUE,'_t');
?>
<div class="form-group">
<a href="<?php echo $item_img['n'] ?>" class="fancybox">
<img src="<?php echo $item_img['t'] ?>" class="img-thumbnail"/></a>
<input name="userfile" type="file" id="userfile"/>
<input name="imagea" type="hidden" id="imagea" value="<?php echo $item_image ?>">
</div>