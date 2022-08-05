<?php
/*sLOG() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
20220803 v.0.1 ->   upgrade to php8 bootstrap5.2
                    function parameter message change to array 
                        msg=array('m'=>'message','t'=>'title','c'=>'class','i'=>'image.jpg');
                    add var $persist = null
                        1=TRUE -> Do not delete session $_SESSION['LOG']
                        0=FALSE -> Default delete session LOG
                        null=FALSE -> Default delete session LOG
20220804 v.0.2 ->	Change asignment way data from $msg or $_SESSION['LOG'] to var $LOG show in alert
20220804 v.0.3 ->	Toast notification add two variantes, 1) with header, 2)without header - custom css
						- With Header Toast -> require $_SESSION['LOG']['t']
						- Without Header Toast (custom style) -> use $_SESSION['LOG']['ct'] -> for style -> value defined in config.ini

*/
function sLOG($type=NULL, $msg=NULL, $persist=0){//duoticsLib php8 v.0.3
	$LOG=NULL;
	$vrfVL=TRUE;
	if(isset($msg)) $LOG=array("m"=>$msg['m'] ?? null, "t"=>$msg['t'] ?? null, "i"=>$msg['i'] ?? null, "l"=>$msg['l'] ?? null, "c"=>$msg['c'] ?? null);
	else if(isset($_SESSION['LOG'])) $LOG=array("m"=>$_SESSION['LOG']['m'], "t"=>$_SESSION['LOG']['t'] ?? null, "i"=>$_SESSION['LOG']['i'] ?? null, "l"=>$_SESSION['LOG']['l'] ?? null, "c"=>$_SESSION['LOG']['c'] ?? null);
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
				$rLog="<div class='toast-container p-3 bottom-0 end-0' id='toastPlacement'>
					<div class='toast fade show $LOG[c]' data-bs-delay='3000'>";
				if(isset($LOG['t'])){
				$rLog.="<div class='toast-header'>
						<img src='$LOG[i]' class='img-fluid img-xxs me-2' alt=''>
						<strong class='me-auto'>$LOG[t]</strong>
						<small>$LOG[l]</small>
						<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
						</div>";
				}
				$rLog.="<div class='toast-body'>$LOG[m]</div>
					</div>
			  	</div>";
			break;
			default:
				$rLog='<div>'.$LOG['m'].'</div>';
			break;
		}
		echo $rLog;
	}
    if(($vrfVL)&&(!($persist))) unset($_SESSION['LOG']);
	else $_SESSION['LOG']=$LOG;
}
/*
HOW TO USE
*/
sLOG('a');//Show LOG in div.alert alert-
sLOG('t');//Show LOG in toast bs plugin
sLOG('');//Show LOG in div
sLOG('s');//SET $_SESSION LOG

sLOG('t',null,1);//third parameter determine if SESSION LOG is unset -> 0 or null=unset session ; 1=persist SESSION LOG

?>