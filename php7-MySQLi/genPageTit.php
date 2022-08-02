<?php 
/*
v.0.1	initial code
v.1.0	add $tag for main tag
		add $css for class tag
*/
function genPageTit($img=null,$tit,$des=null,$pullR=null,$pullL=null,$tag=null,$css="my-4 border-bottom pb-4"){//duotics_lib -> v.1.0
	$pageTit=null;
	if(!($tag)) $tag="h1";//If not tag param, default tag is h1
	$pageTit.='<'.$tag.' class="'.$css.'">';
	if ($pullL) $pageTit.='<div class="pull-left">'.$pullL.'</div>';
	if ($img) $pageTit.=$img;
	$pageTit.=' ';
	$pageTit.=$tit;
	$pageTit.=' ';
	if ($des) $pageTit.='<small>'.$des.'</small>';
	if ($pullR) $pageTit.='<div class="pull-right">'.$pullR.'</div>';
	$pageTit.='</'.$tag.'>';
	return $pageTit;
}
?>