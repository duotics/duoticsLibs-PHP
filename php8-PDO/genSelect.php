<?php
//FUNCTION -genSelect- TO GENERATE SELECT (FORM html)
/* Documentation
	//PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
*/
/* version history PHP 8.1
	v.0.1 updated to PDO and PHP 8, add $ret var to concat and return result; $RS para move to first (optional parameters after)
*/
function genSelect($RS, $nom=NULL, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Select"){//duotics_lib-> php8 v.0.1
	global $dbh;
	$dRS=null;
	$grpAct=null;
	$grpSel=null;
	$banG=false;
	$ret=null;
	if($RS){
		$tRS = $RS -> rowCount();
		if(!isset($id))$id=$nom;
		if (!$nom) $nom="select";
		$ret.= "<select name='$nom' id='$id' class='$class' data-placeholder='$placeHolder' $opt >";
		//Show Ini Value
		if($showIni==TRUE){
			$ret.= "<option value='$valIni'";
			if (!$sel) $ret.= "selected='selected'";
			$ret.= ">$nomIni</option>";	
		}
		if($tRS){
			while($dRS = $RS->fetch()){
				if(isset($dRS['sGRUP'])) $grpAct=$dRS['sGRUP'];
				if(($grpSel!=$grpAct)&&(isset($grpAct))){		
					if($banG==true) $ret.= "</optgroup>"; 
					$ret.= "<optgroup label='$dRS[sGRUP]'>";
					$grpSel=$grpAct;
					$banG=true;
				}
				$ret.= "<option value='$dRS[sID]'"; 
				if(is_array($sel)){ 
					if(in_array($dRS['sID'],$sel)){ 
						$ret.= "selected='selected'";
					}
				}else{
					if(isset($sel)){
						if (!(strcmp($dRS['sID'], $sel))) {
							$ret.= "selected='selected'";
						}
					}
				}
				$ret.= ">$dRS[sVAL]</option>";
			}//END WHILE
			if($banG==true) $ret.= "</optgroup>";
		}
		$ret.= '</select>';
		//$RS->closeCursor();
	}else{
		$ret.= '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
	return $ret;
}

/* HOW TO USE
Depends on> function detRowGSel()
*/
genSelect(detRowGSel('tbl_prov','prov_id','prov_nom','1','1'), 'txtProv', $detA['prov_id'], $class='form-control', 'required', 'txtProv', 'Seleccionar Provincia', TRUE,NULL,'Seleccione') 

?>