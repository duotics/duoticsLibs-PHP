<?php
//FUNCTION -genSelectManual-  TO GENERATE SELECT (FORM html) - Manual data = array (not recordset)
/*
v.3.0 show ini supported
v.3.1 (Añadido params $valIni, $nomIni : para valores por defecto del option inicial)
v.3.2 fix bug
*/
function genSelectManual($nom=NULL, $data, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni='Select'){//v.3.2 
	/* PARAMS
	$nom. attrib 'name' for <select>
	$data. Data Recordset
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
	*/
	if($data){	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$valIni.'</option>';	
	}
	foreach($data as $xid => $xval){
		echo '<option value="'.$xval.'"'; 
		if(is_array($sel)){ if(in_array($xval,$sel)) echo 'selected="selected"'; }
		else{ if (!(strcmp($xval, $sel))) echo 'selected="selected"'; }
		echo '>'.$xid.'</option>';
	}
	echo '</select>';
	}else{
		echo '<span class="label label-danger">Error genSelectManual : '.$nom.'</span>';
	}
}
// how to use

$data=array("PRE"=>"P", "DEF"=>"D");
genSelectManual('diagTIP', $data, $dRSd['tip'], 'form-control', NULL, NULL, NULL, TRUE, NULL, 'Seleccione'); ?>