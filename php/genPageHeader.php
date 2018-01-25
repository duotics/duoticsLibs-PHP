<?php //FUNCTION -genTit- GENERATE PAGE HEADER MODULE COMPONENT
/*
v.0.1 initial code original name genPageHead
v.0.2 function name changed to genPageHeader
*/
function genPageHeader($MOD, $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL){//v.0.2
	$banMod=FALSE;
	if($MOD){
		$rowMod=detMod($MOD);
		if($rowMod){$banMod=TRUE;}
	}
	if ($banMod==FALSE){
		$rowMod['mod_nom']=$tit;
		$rowMod['mod_cod']=$id;
		$rowMod['mod_des']=$des;
		$rowMod['mod_icon']=$icon;
	}
	$returnTit;
	$returnTit.='<div class="page-header">';
    $returnTit.='<'.$tag.'>';
	if($rowMod['mod_icon']){ $returnTit.=' <i class="'.$rowMod['mod_icon'].'"></i> ';	}
	if($id){ $returnTit.=' <span class="label label-primary">'.$rowMod['mod_cod'].'</span> ';	}
	$returnTit.=$rowMod['mod_nom'];
    $returnTit.=' <small>'.$rowMod['mod_des'].'</small>';
	$returnTit.='</'.$tag.'>';
	$returnTit.='</div>';
	
	return $returnTit;
}
?>