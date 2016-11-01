<?php
//FUNCTION TO GENERATE SELECT (FORM html) *NEW v.3.1 (Añadido params $valIni, $nomIni : para valores por defecto del option inicial)
function genSelect($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Select"){
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	if($RS_datos){
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value="'.$valIni.'"';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$nomIni.'</option>';	
	}
	
	if($totalRows_RS_datos>0){
	do {
		$grpAct=$row_RS_datos['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$row_RS_datos['sID'].'"'; 
		if(is_array($sel)){ if(in_array($row_RS_datos['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($row_RS_datos['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$row_RS_datos['sVAL'].'</option>';
	} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	if($banG==true) echo '</optgroup>';
	$rows = mysql_num_rows($RS_datos);
	if($rows > 0) {
		mysql_data_seek($RS_datos, 0);
		$row_RSe = mysql_fetch_assoc($RS_datos);
	}
	}
	echo '</select>';
	
	mysql_free_result($RS_datos);
	}else{
		echo '<span class="label label-danger">Error generarSelect : '.$nom.'</span>';
	}
}

?>