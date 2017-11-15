<?php
//sLOG() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
//v.2.0 de la función sLOG (2016-05-17 05:57)
//v.2.1 corregido la visualizacion expontanea
//v.2.2 agregado titulo a visualizacion alert
function sLOG($type=NULL, $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){//v.2.2
	$vrfVL=TRUE; //var para setear $LOG
	if($msg_m){
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else $LOG=$_SESSION['LOG'];
	
	if($LOG){
		if(!$LOG['c']) $LOG['c']='alert-info';
		switch ($type){
			case 'a':
				$rLog='<div id="log">';
				$rLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
				$rLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
				if($LOG['t']) $rLog.='<h3>'.$LOG['t'].'</h3>';
				$rLog.=$LOG['m'];
				$rLog.='</div></div>';
			break;
			case 'g':
				$rLog='<script type="text/javascript">
				logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");
				</script>';
			break;
			case 's':
				$vrfVL=FALSE;
			break;
			default:
				$rLog='<div>'.$LOG['m'].'</div>';
			break;
		}
		echo $rLog;
	}
	if($vrfVL){//TRUE unset->LOG, FALSE $_SESSION LOG -> $LOG
		unset($_SESSION['LOG']);
	}else{
		$_SESSION['LOG']=$LOG;
	}
}
/*HOW TO USE*/
sLOG('a');//Show LOG in div.alert alert-
sLOG('g');//Show LOG in gritter plugin
sLOG('');//Show LOG in div
sLOG('s');//SET $_SESSION LOG
?>