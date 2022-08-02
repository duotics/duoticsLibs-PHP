<?php
/*Funcion para visualizar link/button
v.1.0 -> 2018-05-09 :: Buton Estado Gen
v.1.1 -> 2018-05-09 :: order params
*/
function genLink($link,$txt,$css=NULL,$params=NULL){//v.1.1 -> duotics-lib
	$firstP=TRUE;
	if($params){
		foreach($params as $x => $xVal) {
			if($firstP==TRUE){
				$lP.='?'.$x.'='.$xVal;
				$firstP=FALSE;
			}else $lP.='&'.$x.'='.$xVal;
		}
	}
	$st='<a href="'.$link.$lP.'" class="'.$css.'">'.$txt.'</a>';
	return $st;
}
/*HOW TO USE*/
$btn=genLink('_fncts.php','BOTON o LINK','btn btn-primary',array('ids'=>$ids, 'val'=>$dRS['typEst'],'acc'=>md5('STc'),"url"=>$urlc));
?>