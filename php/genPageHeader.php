<?php //FUNCTION -genTit- GENERATE PAGE HEADER MODULE COMPONENT
/*
v.0.1 initial code original name genPageHead
v.0.2 function name changed to genPageHeader
v.0.3 function name changed to genPageHead
v.0.4 function name changed to genPageHeader
v.0.5 add param $tip to type of header manage in switch case
*/
function genPageHeader($MOD, $tip='page-header', $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL,$pullL=NULL,$pullR=NULL){//duotics_lib->v.0.5
	$banMod=FALSE;
	if($MOD){
		$dM=detMod($MOD);
		if($dM) $banMod=TRUE;
	}
	if(!$banMod){
		$dM['mod_nom']=$tit;
		$dM['mod_cod']=$id;
		$dM['mod_des']=$des;
		$dM['mod_icon']=$icon;
	}
	$ret;
	switch($tip){
		case 'page-header':
			$ret.='<div class="page-header">';
			if ($pullL) $ret.='<div class="pull-left">'.$pullL.'</div>';
			$ret.='<'.$tag.'>';
			if($dM['mod_icon']) $ret.=' <i class="'.$dM['mod_icon'].'"></i> ';
			if($id) $ret.=' <span class="label label-primary">'.$dM['mod_cod'].'</span> ';
			$ret.=$dM['mod_nom'];
			$ret.=' <small>'.$dM['mod_des'].'</small>';
			$ret.='</'.$tag.'>';
			if ($pullR) $ret.='<div class="pull-right">'.$pullR.'</div>';
			$ret.='</div>';
		break;
		case 'navbar':
			$ret.='<nav class="navbar navbar-default">';
			$ret.='<div class="container-fluid">';
			$ret.='<div class="navbar-header">';
			$ret.='<a class="navbar-brand" href="#">'.$dM['mod_nom'];
			$ret.=' <small class="label label-default">'.$dM['mod_des'].'</small></a>';
			$ret.='</div>';
			$ret.='</div></nav>';
		break;
		default:
			$ret.='<div>';
			if($id) $ret.=' <span class="label label-default">'.$dM['mod_cod'].'</span> ';
			$ret.=$dM['mod_nom'];
			$ret.='<div>';
		break;
	}
	return $ret;
}
?>