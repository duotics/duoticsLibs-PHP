<?php
/*Funcion para visualizar status
v.2.0 -> 2017-06-02 :: Buton Estado Gen
*/
function genStatus($dest,$params,$css=NULL){//v.2.0
$firstP=TRUE;
foreach($params as $x => $xVal) {
    if($x=='val'){
		if($xVal==1){
			$xVal=0;
			$cssST='btn btn-success btn-xs';
			$txtST='<span class="glyphicon glyphicon-ok"></span>';
		}else{
			$xVal=1;
			$cssST='btn btn-warning btn-xs';
			$txtST='<span class="glyphicon glyphicon-remove"></span>';
		}
	}
	if($firstP==TRUE){
		$lP.='?'.$x.'='.$xVal;
		$firstP=FALSE;
	}else $lP.='&'.$x.'='.$xVal;
}
$st='<a href="'.$dest.$lP.'" class="'.$cssST.' '.$css.'">'.$txtST.'</a>';
return $st;
}
/*HOW TO USE*/
$btnStat=genStatus('_fncts.php',array('ids'=>$ids, 'val'=>$dRS['typEst'],'acc'=>md5('STc'),"url"=>$urlc));
?>