<?php 
/*
v.0.1 initial code
*/
function genPageTit($img=NULL,$tit,$des=NULL,$pullR=NULL,$pullL=NULL){//duotics_lib -> v.0.1
	$pageTit;
	$pageTit.='<h1>';
	if ($pullL) $pageTit.='<div class="pull-left">'.$pullL.'</div>';
	if ($img) $pageTit.=$img;
	$pageTit.=' ';
	$pageTit.=$tit;
	$pageTit.=' ';
	if ($des) $pageTit.='<small>'.$des.'</small>';
	if ($pullR) $pageTit.='<div class="pull-right">'.$pullR.'</div>';
	$pageTit.='</h1>';
	return $pageTit;
}
?>