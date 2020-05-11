<?php 
/*
Breadcrumb Generate
*/
function genBreadcrumb($type,$id,$sel=NULL){//v.2.1
	$ret_lil=null;
	$ret_li='<li class="breadcrumb-item"><a href="'.$GLOBALS['RAIZ'].'">Inicio</a></li>';
	//BREADCRUMB CATALOG
	if(($type=='item')||($type=='cat')){
		if($type=='item'){
			$detI=detRow('db_items','item_id',$id);
			$ret_lil='<li class="breadcrumb-item">'.$detI['item_cod'].'</li>';
			$detIC=detRow('db_items_type_vs','item_id',$id);
			$id=$detIC['typID'];
		}
		$loop=TRUE;
		$cloop=0;
		$detC_idp=$id;
		do{
			$detC=detRow('db_items_type','typID',$detC_idp);
			$detC_id=$detC['typID'];
			$detC_nom=$detC['typNom'];
			$detC_idp=$detC['typIDp'];
			if($detC_id==0) $detC_nom='Productos';
			$ret_lil='<li class="breadcrumb-item"><a href="'.$GLOBALS['RAIZ'].'c/'.$detC['typUrl'].'">'.$detC_nom.'</a></li>'.$ret_lil;
			if(($detC_idp==NULL)||($cloop>='100')) $loop=FALSE;
			$cloop++;
		}while($loop==TRUE);
	}
	
	if($type=='gall'){
		$ret_li.='<li class="breadcrumb-item"><a href="'.$GLOBALS['RAIZ'].'g">Gallery</a></li>';
	}
	
	//BREADCRUMB OTHER
	if($sel)$ret_li.='<li class="breadcrumb-item active">'.$sel.'</li>';
	//CONCAT BREADCRUMB
	$ret='<nav aria-label="breadcrumb">';
	$ret.='<ol class="breadcrumb">';
	$ret.=$ret_li;
	$ret.=$ret_lil;
	$ret.='</ol>';
	$ret.='</nav>';
	return $ret;
}
?>