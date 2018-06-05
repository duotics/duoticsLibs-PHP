<?php
function genUrlFriendly($url) {
	$url = strtolower($url);// Tranformamos todo a minusculas
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);//Rememplazamos caracteres especiales latinos
	$find = array(' ', '&', '\r\n', '\n', '+'); 
	$url = str_replace ($find, '-', $url);// Añaadimos los guiones
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);// Eliminamos y Reemplazamos demás caracteres especiales
	return $url;
}
function generate_aliasurl($string){
	$string='--'.$string;
	$string=strtolower($string);
	$string=clearString($string);
	$string=cleanString($string);
	if (substr($string, -1)=='-')
		$string=substr_replace($string, '',-1);
	return $string;
}
function clearString($string){ //Funciona OK
	$string = preg_replace('([^A-Za-z0-9])', '-', $string);
	return $string;
}
function cleanString($string){
    $string = trim($string);
    $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
    $string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
    $string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
    $string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
    $string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
    $string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "--", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."), '',
        $string
    );
    return $string;
}

function clsRO($val){
			$valFin=eregi_replace("[\n|\r|\n\r]", " ", $val);
			return $valFin;
		}
		function datefRO($val){
			$newDate = date("Y-m-d", strtotime($val));
			return($newDate);
		}

function calcIMC($IMC=NULL, $pesoKG=NULL, $talla=NULL){
	$talla=$talla/100;
	if((!$IMC)||($IMC==NULL)||($IMC==0)){
		if(($talla>0)&&($pesoKG>0)){
			$IMC=$pesoKG / ($talla*$talla);
		}
	}

	if($IMC<=0) $infIMC='<span class="label label-default"> No Determinado </span>';
	if(($IMC>0)&&($IMC<18)){$infIMC='<span class="label label-danger">Peso Bajo</span>';}
	if(($IMC>=18)&&($IMC<25)){$infIMC='<span class="label label-info">Normal</span>';}
	if(($IMC>=25)&&($IMC<30)){$infIMC='<span class="label label-success">Sobrepeso</span>';}
	if(($IMC>=30)&&($IMC<35)){$infIMC='<span class="label label-warning">Obesidad grado I</span>';}
	if(($IMC>=35)&&($IMC<40)){$infIMC='<span class="label label-warning">Obesidad grado II</span>';}
	if($IMC>=40){$infIMC='<span class="label label-danger"> Obesidad grado III</span>';}

	$retIMC['val']=number_format($IMC,2);
	$retIMC['inf']=$infIMC;
	
	return $retIMC;
}

function genSelectG($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL){
	//$nom. name selselector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales	
	
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	if (!$nom) $nom="select";		
	echo '<select name="'.$nom.'" id="'.$nom.'" class="'.$class.'" '.$opt.'>';
	echo '<option value=""';	
	if (!(strcmp(-1, $sel))) {echo "selected=\"selected\"";} ?>	
	<?php echo '>- Seleccione -</option>';	
	if ($totalRows_RS_datos>0){	
		$grpSel=NULL; $banG=false;
		do {
			$grpAct=$row_RS_datos['sGRUP'];
			if($grpSel!=$grpAct){		
				if($banG==true) echo '</optgroup>'; 
				echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
				$grpSel=$grpAct;
				$banG=true;
			}
			echo '<option value="'.$row_RS_datos['sID'].'"';	
			if (!(strcmp($row_RS_datos['sID'], $sel))) {echo "selected=\"selected\"";} ?>	
			<?php echo '>'.$row_RS_datos['sVAL'].'</option>';	
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
		if($banG==true) echo '</optgroup>';
	}	
	$rows = mysql_num_rows($RS_datos);	
	if($rows > 0) {	
		mysql_data_seek($RS_datos, 0);	
		$row_RSe = mysql_fetch_assoc($RS_datos);	
	}
	echo '</select>';	
	mysql_free_result($RS_datos);
	
}

function genSelect($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Select"){//v.4.0
	/* PARAMS
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
	if($RS){
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
		
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value="'.$valIni.'"';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$nomIni.'</option>';	
	}
	
	if($tRS>0){
	do {
		$grpAct=$dRS['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$dRS['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$dRS['sID'].'"'; 
		if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$dRS['sVAL'].'</option>';
	} while ($dRS = mysqli_fetch_assoc($RS));
	if($banG==true) echo '</optgroup>';
	$rows = mysqli_num_rows($RS);
	if($rows > 0) {
		mysqli_data_seek($RS, 0);
		$dRSe = mysqli_fetch_assoc($RS);
	}
	}
	echo '</select>';
	
	mysqli_free_result($RS);
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}

function genSelect_old($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Seleccione"){
	//Version 3.3.1
	/* PARAMS
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
	if($RS){
	$dRS = mysql_fetch_assoc($RS);
	$tRS = mysql_num_rows($RS);
		
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value="'.$valIni.'"';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$nomIni.'</option>';	
	}
	
	if($tRS>0){
	do {
		$grpAct=$dRS['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$dRS['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$dRS['sID'].'"'; 
		if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$dRS['sVAL'].'</option>';
	} while ($dRS = mysql_fetch_assoc($RS));
	if($banG==true) echo '</optgroup>';
	$rows = mysql_num_rows($RS);
	if($rows > 0) {
		mysql_data_seek($RS, 0);
		$dRSe = mysql_fetch_assoc($RS);
	}
	}
	echo '</select>';
	
	mysql_free_result($RS);
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}
//FUNCTION TO GENERATE SELECT (FORM html)
function genSelectManual($nom=NULL, $datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni='- Seleccione -'){
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	if($datos){	
	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$valIni.'</option>';	
	}
	foreach($datos as $xid => $xval){
		echo '<option value="'.$xval.'"'; 
		if(is_array($sel)){ if(in_array($xval,$sel)) echo 'selected="selected"'; }
		else{ if (!(strcmp($xval, $sel))) echo 'selected="selected"'; }
		echo '>'.$xid.'</option>';
	}
	
	
	
	
	echo '</select>';
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}
?>