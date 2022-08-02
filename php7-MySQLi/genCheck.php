<?php
function genCheck($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL){
	/* Version 1.0.1
	PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected array list items selected in checkbox
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select> */
	if($RS){
		$dRS = mysql_fetch_assoc($RS);
		$tRS = mysql_num_rows($RS);
		$retVal.='<div>';
		if($tRS>0){
			do {
				echo ' <label class="checkbox-inline"><input type="checkbox" name="'.$nom.'" value="'.$dRS['sID'].'"'; 
				if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'checked="checked"'; }
				}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'checked="checked"';} }
				echo '> '.$dRS['sVAL'].' </label>';
			} while ($dRS = mysql_fetch_assoc($RS));
			$rows = mysql_num_rows($RS);
			if($rows > 0) {
				mysql_data_seek($RS, 0);
				$dRSe = mysql_fetch_assoc($RS);
			}
		}	
		mysql_free_result($RS);
		$retVal.='</div>';
	
	}else{
		$retVal.='<span class="label label-danger">Error genCheck : '.$nom.'</span>';
	}
	return($retVal);
}

//APLICACION DE LA FUNCION

$valList=detRowGSel('tbl_types','typ_cod','typ_val','typ_ref','RIESS-AF');//VALORES PARA GENERAR EL CHECKBOX MULTIPLE

$valDB='100,102,108';//DATOS PROVENIENTES DE LA BASE DE DATOS
$valSel=explode(",", $valDB);//GENERACION DEL ARRAY DE VALORES SELECCIONADOS 

echo genCheck("valSel[]",$valList,$valSel,'form-control', NULL, NULL);

?>