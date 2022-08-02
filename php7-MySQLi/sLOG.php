<?php
//sLOG() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
//v.2.0 de la función sLOG (2016-05-17 05:57)
//v.2.1 corregido la visualizacion expontanea
//v.2.2 agregado titulo a visualizacion alert
//v.2.3 fixed issues
//v.2.4 add case 't' -> for toast bootstrap
function sLOG($type=NULL, $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){//v.2.4
	$LOG=NULL;
	$vrfVL=TRUE; //var para setear $LOG
	if($msg_m){
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else {
		if(isset($_SESSION['LOG'])) $LOG=$_SESSION['LOG'];
	}
	
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
			case 't':
				//echo 'case t<br>';
				$rLog='<div class="toast" style="position: absolute; bottom: 25px; right: 25px; z-index: 999" data-delay="3000">
				<div class="toast-header">
				  <img src="'.$LOG['i'].'" class="img-fluid img-xs rounded mr-2" alt="...">
				  <strong class="mr-auto">'.$LOG['t'].'</strong>
				  <!--<small>11 mins ago</small>-->
				  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="toast-body">
				  '.$LOG['m'].'
				</div>
			  </div>';
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