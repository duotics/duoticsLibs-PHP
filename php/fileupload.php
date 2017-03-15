<?php 
//FILE UPLOAD
// v.1.2 2017-03-15
function uploadfile($file, $params){
	$code = md5($sdatet);
	$prefijo = $params['pre'].'_'.$code;
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	// Verifica si la extension es valida
	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';
	else{ // Verifica el tamaño maximo
		if(filesize($file['tmp_name']) > $params['size']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['size']/1024/1024).' MB</h4>';
		else{ // Verifica Permisos de Carpeta, Si Carpeta Existe.
			if(!is_writable($params['pat'])) $LOG.='<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>';
			else{// Mueve el archivo a su lugar correpondiente.
				if(!move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $LOG.='<h4>Error al Cargar el Archivo</h4>';
				else{
					$aux_grab=TRUE;
					$LOG.='<p>Archivo Cargado Correctamente</p>';
				}
			}
		}
	}
	$auxres['LOG']=$LOG;
	$auxres['EST']=$aux_grab;
	$auxres['FILE']=$filename;
	return $auxres; 
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/*HOW TO USE*/

if(($_FILES['userfile']['name'])){
	$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg'),"size"=>2097152,"pat"=>RAIZ0.'images/types/',"pre"=>"cat");
	$dFU=uploadfile($_FILES['userfile'], $paramsF);
	if($dFU['EST']==TRUE){
		if($_POST['imagea']){
			$LOG.=deleteFile($paramF['pat'],$valImg,TRUE,'t_');
		}
		$valImg=$dFU['FILE'];
		fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 175, 175);
	}
	$LOG.=$dFU['LOG'];
}
?>