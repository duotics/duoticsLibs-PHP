<?php
/*Funcion para visualizar status
v.2.0 -> 2017-06-02 :: Buton Estado Gen
v.3.0 -> 2019-11-13 :: Modify to DROP GLAPHICON AND CHANGE FOR fontawesome default
v.3.1 -> add param icons
v.3.2 -> change btn-xs -> to -> btn-sm
v.4.0 -> agregado array de iconos como alternativa a iconos por defecto
v.4.1 -> upgrade to boostrap 4.4 : change btn-xs -> to -> btn-sm
			upgrade to fontawesome
v.4.2 -> add $lP=null fix bug php 7
v.4.3 -> upgrade bootstrap 4.5
v.4.4 -> wrong error php7
*/
function genStatus($dest,$params,$css=NULL,$icons=NULL){//duotics_lib->v.4.4
	$lP=null;
	$firstP=TRUE;
	foreach($params as $x => $xVal) {
		if($x=='val'){
			if(!$icons){
				if($xVal==1){
					$xVal=0;
					$cssST='btn btn-success btn-sm';
					if(isset($icons[1])) $txtST=$icons[1];
					else $txtST='<i class="fas fa-check"></i>';
				}else{
					$xVal=1;
					$cssST='btn btn-warning btn-sm';
					if(isset($icons[1])) $txtST=$icons[1];
					else $txtST='<i class="fas fa-times"></i>';
				}
			}else{
				foreach($icons as $y => $yVal){
					if($xVal==$yVal['id']){
						$cssST=$yVal['css'];
						$txtST=$yVal['icon'];
					}
				}
			}
		}
		if($firstP==TRUE){
			$lP.='?'.$x.'='.$xVal;
			$firstP=FALSE;
		}else $lP.='&'.$x.'='.$xVal;
	}
	if($dest) $st='<a href="'.$dest.$lP.'" class="'.$cssST.' '.$css.'">'.$txtST.'</a>';
	else $st='<span class="'.$cssST.' '.$css.'">'.$txtST.'</span>';
	return $st;
}
/*HOW TO USE*/
$btnStat=genStatus('_fncts.php',array('ids'=>$ids, 'val'=>$dRS['typEst'],'acc'=>md5('STc'),"url"=>$urlc),NULL,NULL);//Without custom icons
//With array icons
$icons=array(
	array("id"=>0,'css'=>'btn btn-success btn-sm',"icon"=>'<i class="fas fa-star"></i>'),
	array("id"=>1,'css'=>'btn btn-warning btn-sm',"icon"=>'<i class="fas fa-star"></i>'),
);
$btnStat=genStatus('_fncts.php',array('ids'=>$ids, 'val'=>$dRS['typEst'],'acc'=>md5('STc'),"url"=>$urlc),NULL,$icons);//With custom icons
?>