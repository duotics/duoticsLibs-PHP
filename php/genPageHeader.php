<?php //FUNCTION -genTit- GENERATE PAGE HEADER MODULE COMPONENT
/*
v.0.1 initial code original name genPageHead
v.0.2 function name changed to genPageHeader
v.0.3 function name changed to genPageHead
v.0.4 function name changed to genPageHeader
v.0.5 add param $tip to type of header manage in switch case
v.0.6 upgrade bootstrap version css to 4.4
v.0.7 $ret=null; fix bug php 7
v.0.8 upgrade call function from detMod() to detCom -> Obtain detaills from database table db_components
v.0.9 20200617 : add default $tag value
v.0.10 20200617 : change order float deploy
*/
function genPageHeader($MOD, $tip='page-header', $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL,$floatL=NULL,$floatR=NULL){//duotics_lib->v.0.10
	if(!isset($tag)||($tag=='')) $tag='h1';
	$banMod=FALSE;
	if($MOD){
		$dM=detCom($MOD);
		if($dM) $banMod=TRUE;
	}
	if(!$banMod){
		$dM['mod_nom']=$tit;
		$dM['mod_cod']=$id;
		$dM['mod_des']=$des;
		$dM['mod_icon']=$icon;
	}
	$ret=null;
	switch($tip){
		case 'page-header':
			$ret.='<div class="page-header">';
			if ($floatL) $ret.='<div class="float-left">'.$floatL.'</div>';
			if ($floatR) $ret.='<div class="float-right">'.$floatR.'</div>';
			$ret.='<'.$tag.'>';
			if($dM['mod_icon']) $ret.=' <i class="'.$dM['mod_icon'].'"></i> ';
			if($id) $ret.=' <span class="badge badge-primary">'.$dM['mod_cod'].'</span> ';
			$ret.=$dM['mod_nom'];
			$ret.=' <small>'.$dM['mod_des'].'</small>';
			$ret.='</'.$tag.'>';
			$ret.='</div>';
		break;
		case 'navbar':
			$ret.='<nav class="navbar navbar-secondary">';
			$ret.='<div class="container-fluid">';
			$ret.='<div class="navbar-header">';
			$ret.='<a class="navbar-brand" href="#">'.$dM['mod_nom'];
			$ret.=' <small class="badge badge-secondary">'.$dM['mod_des'].'</small></a>';
			$ret.='</div>';
			$ret.='</div></nav>';
		break;
		default:
			$ret.='<div>';
			if($id) $ret.=' <span class="badge badge-secondary">'.$dM['mod_cod'].'</span> ';
			$ret.=$dM['mod_nom'];
			$ret.='<div>';
		break;
	}
	return $ret;
}
?>