<?php
/*DELETE FILE FROM SERVER
v.1.0 -> Receive params and delete File
v.1.1 -> Option ($vT) delete thumb ($pT = subfix of thumb)
v.1.2 -> $LOG declare
*/
function deleteFile($path,$file,$vT=FALSE,$pT='t_'){ //v.1.2
	$LOG=null;
	$fileDel=$path.$file;
	if (file_exists($fileDel)) {
		if (unlink($fileDel)) $LOG.='<span>Imagen anterior eliminada</span>';
		else $LOG.='<span>Error al eliminar imagen anterior</span>';
	}else $LOG.='<span>Imagen anterior no Existe</span>';
	if($vT==TRUE){
		$fileDelT=$path.$pT.$file;
		if (file_exists($fileDelT)) {
			if (unlink($fileDelT)) $LOG.='<span>Thumb Imagen anterior eliminada</span>';
			else $LOG.='<span>Error al eliminar Thumb imagen anterior</span>';
		}else $LOG.='<span>Thumb  Imagen anterior no Existe</span>';
	}
return $LOG;
}
/*HOW TO USE*/
$LOG.=deleteFile($paramF['pat'],$valImg,TRUE,'t_');
?>