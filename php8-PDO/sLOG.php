<?php
/*sLOG() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
20220803 v.0.1 ->   upgrade to php8 bootstrap5.2
                    function parameter message change to array 
                        msg=array('m'=>'message','t'=>'title','c'=>'class','i'=>'image.jpg');
                    add var $persist = null
                        1=TRUE -> Do not delete session $_SESSION['LOG']
                        0=FALSE -> Default delete session LOG
                        null=FALSE -> Default delete session LOG


*/
function sLOG($type=NULL, $msg=NULL, $persist){//duoticsLib php8 v.0.1
	$LOG=NULL;
	$vrfVL=TRUE; //var para setear $LOG
    //Verify if LOG data is set from function parameter else LOG data obtain from SESSION LOG
	if(isset($msg['m'])&&($msg)) $LOG=$msg;
	else $LOG=$_SESSION['LOG'] ?? null;
	//BEG IF $LOG -> data exists
	if($LOG){
		if(!$LOG['c']) $LOG['c']='alert-info';
        $rLog=null;
		switch ($type){
			case 'a':
				$rLog='<div id="log">';
				$rLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
				$rLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
				if($LOG['t']) $rLog.='<h3>'.$LOG['t'].'</h3>';
				$rLog.=$LOG['m'];
				$rLog.='</div></div>';
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
    //END IF DATA EXISTS
	if(($vrfVL)&&(!($persist))){//TRUE unset->LOG, FALSE $_SESSION LOG -> $LOG
		unset($_SESSION['LOG']);
	}else{
		$_SESSION['LOG']=$LOG;
	}
}
/*HOW TO USE*/
sLOG('a');//Show LOG in div.alert alert-
sLOG('t');//Show LOG in toast bs plugin
sLOG('');//Show LOG in div
sLOG('s');//SET $_SESSION LOG

sLOG('t',null,1);//third parameter determine if SESSION LOG is unset -> 0 or null=unset session ; 1=persist SESSION LOG

?>