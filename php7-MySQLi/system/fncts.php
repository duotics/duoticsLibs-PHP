<?php
include_once('inc/phplot610/phplot.php');
include_once('inc/enLetras.class.php');
include_once('inc/paginator.class.php');
include_once('inc/class.image-resize.php');
include_once('inc/html2pdf_v4.03/html2pdf.class.php');

require_once('inc/class.phpmailer.php');
require_once('inc/class.smtp.php');

//FUNCIONES SISTEMA
require_once('inc/fnc_data.php');
require_once('inc/fnc_sys.php');
require_once('inc/fnc_gen.php');
require_once('inc/fnc_tra.php');

function genPageNavbar($MOD, $tit=NULL, $des=NULL,$icon=NULL,$css='navbar-fixed-top'){
	$banMod=FALSE;
	if($MOD){
		$rowMod=detMod($MOD);
		if($rowMod){$banMod=TRUE;}
	}
	if ($banMod==FALSE){
		$rowMod['mod_nom']=$tit;
		$rowMod['mod_des']=$des;
		$rowMod['mod_icon']=$icon;
	}
	$returnTit;
	$returnTit.='<nav class="navbar navbar-default">';
	$returnTit.='<div class="container-fluid">';
	$returnTit.='<div class="navbar-header">';
    $returnTit.='<a class="navbar-brand" href="#">'.$rowMod['mod_nom'];
	$returnTit.=' <small class="label label-default">'.$rowMod['mod_des'].'</small></a>';
	$returnTit.='</div>';
    $returnTit.='</div></nav>';
	return $returnTit;
}


function genPageHead($MOD, $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL,$other=NULL){
	$banMod=FALSE;
	if($MOD){
		$rowMod=detMod($MOD);
		if($rowMod){$banMod=TRUE;}
	}
	if ($banMod==FALSE){
		$rowMod['mod_nom']=$tit;
		$rowMod['mod_cod']=$id;
		$rowMod['mod_des']=$des;
		$rowMod['mod_icon']=$icon;
	}
	$returnTit;
	$returnTit.='<div class="page-header">';
    $returnTit.='<'.$tag.'>';
	if($rowMod['mod_icon']){ $returnTit.=' <i class="'.$rowMod['mod_icon'].'"></i> ';	}
	if($id){ $returnTit.=' <span class="label label-primary">'.$rowMod['mod_cod'].'</span> ';	}
	$returnTit.=$rowMod['mod_nom'];
    $returnTit.=' <small>'.$rowMod['mod_des'].'</small>';
	$returnTit.=$other;
	$returnTit.='</'.$tag.'>';
	$returnTit.='</div>';
	
	return $returnTit;
}

function gen_pageTit($MOD,$tit=NULL, $id=NULL, $des=NULL,$icon=NULL){
	$banMod=FALSE;
	if($MOD){
		$rowMod=detMod($MOD);
		if($rowMod){$banMod=TRUE;}
	}
	if ($banMod==FALSE){
		$rowMod['mod_nom']=$tit;
		$rowMod['mod_cod']=$id;
		$rowMod['mod_des']=$des;
		$rowMod['mod_icon']=$icon;
	}
	$returnTit;
	$returnTit.='<div class="page-header">';
    $returnTit.='<h2>';
	if($rowMod['mod_icon']){ $returnTit.=' <i class="'.$rowMod['mod_icon'].'"></i> ';	}
	if($id){ $returnTit.=' <span class="label label-primary">'.$rowMod['mod_cod'].'</span> ';	}
	$returnTit.=$rowMod['mod_nom'];
    $returnTit.=' <small>'.$rowMod['mod_des'].'</small>';
	$returnTit.='</h2>';
	$returnTit.='</div>';
	
	return $returnTit;
}
//Deshabilitar Reservas
function disable_reserv($con_fin,$pac_fin){
	if(@mysql_result(@mysql_query("SELECT * FROM db_consultas_reserva WHERE con_num='$con_fin' AND pac_cod='$pac_fin'"),'cons_res_num'))
	{
		if(@mysql_query("DELETE FROM db_consultas_reserva WHERE con_num='$con_fin' AND pac_cod='$pac_fin'")or($res_fun=mysql_error()))
			$res_fun.="Eliminada Reserva";
		else
			$res_fun.="Falla Eliminación Reserva";
	}
	return $res_fun;
}	
/*
// Calcula la edad (formato: año/mes/dia)
function edad($edad){
if($edad){
list($anio,$mes,$dia) = explode("-",$edad);
$anio_dif = date("Y") - $anio; $mes_dif = date("m") - $mes; $dia_dif = date("d") - $dia;
if ($dia_dif < 0 || $mes_dif < 0) $anio_dif--;
return $anio_dif.' Años';
}else return '-';
}*/

// Calcula la edad (formato: año/mes/dia)
function edad($edad){
	if($edad){
		list($Y,$m,$d) = explode("-",$edad);
		return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}else return '-';
}
//Sesiones Pendientes de Tratamiento de una Terapia
function fnc_ses_pen($ter_num){
	if(@mysql_query("SELECT * FROM tbl_sesiones WHERE ses_status='0' AND ter_num='$ter_num'")){
		$all_RS_ter_pen = mysql_query("SELECT * FROM tbl_sesiones WHERE ses_status='0' AND ter_num='$ter_num'");
  		$res = mysql_num_rows($all_RS_ter_pen);
	}else $res=0;
	return $res;
}
//Sesiones Realizadas (Tratadas) de una Terapia
function fnc_ses_real($ter_num){
	if(@mysql_query("SELECT * FROM tbl_sesiones WHERE ses_status='0' AND ter_num='$ter_num'")){
		$all_RS_ter_pen = mysql_query("SELECT * FROM tbl_sesiones WHERE ses_status='1' AND ter_num='$ter_num'");
  		$res = mysql_num_rows($all_RS_ter_pen);
	}else $res=0;
	return $res;}



//Verifica Diagnostico Existe en Consulta
function fnc_numdiagcon($param1){
	$query_RS_datos = sprintf('SELECT COUNT(*) AS CDIAG FROM `db_consultas` WHERE `con_diagd`=%s',
	SSQL($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	return ($row_RS_datos['CDIAG']);
	mysql_free_result($RS_datos);
}

//Numero de Factura mas alto
function fnc_datafacnum(){
	$query_RS_datos = "SELECT max(fac_num) as num FROM tbl_factura";
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}

function exam_numimg($param1){
	$query_RS_datos = sprintf('SELECT COUNT(*) AS IMGE FROM `tbl_examenes_img` WHERE `idexamen`=%s',
	SSQL($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	return ($row_RS_datos['IMGE']);
	mysql_free_result($RS_datos);
}


function uplServer_ant($params, $file){
	$code = substr(md5(uniqid(rand())),0,6).'_'; $prefijo = '_'.$code.'_';
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$params['pac'].$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=0;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	if(!in_array($ext,$params['ext']))// Verifica si la extension es valida
	{	$resultado.=':: Archivo no Valido (permitido: '.$params['ext'].') ::<br />'; $aux_grab=1;
	}else{ if(filesize($file['tmp_name']) > $params['siz'])// Verifica el tamaño maximo
		{	$resultado.=':: Archivo Demasiado Grande :: maximo '.($params['siz']/1024/1024).' MB<br />'; $aux_grab=1;	
		}else{ if(!is_writable($params['pat']))// Verifica permisos.
			{	$resultado.=':: Permisos Folder Insuficientes, contacte al Administrador del Sistema ::<br />';$aux_grab=1;
			}else{// Mueve el archivo a su lugar correpondiente.
				if(move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $archivo=$params['pat'].$filename; else{ $resultado.=':: Error al cargar el archivo ::<br />';$aux_grab=1; }
			}
		}
	}
	$auxres[0]=$resultado; $auxres[1]=$aux_grab; $auxres[2]=$filename;
	return $auxres;}

function fnc_maxnumcons($idp){
$idp_ct_RS_cons_tot = "-1";
if (isset($idp)) {
  $idp_ct_RS_cons_tot = $idp;
}
$query_RS_cons_tot = 'SELECT MAX(con_num) as maxnumcons FROM db_consultas WHERE pac_cod='.$idp_ct_RS_cons_tot;
$RS_cons_tot = mysql_query($query_RS_cons_tot) or die(mysql_error());
$row_RS_cons_tot = mysql_fetch_assoc($RS_cons_tot);
$totalRows_RS_cons_tot = mysql_num_rows($RS_cons_tot);
return $row_RS_cons_tot['maxnumcons'];
mysql_free_result($RS_cons_tot);
}



function vParam($nompar, $pget, $ppost, $revsess=NULL){
	/*
	$nompar. Nombre del parametro a verificar.
	$pget. Obtenemos parametros GET.
	$ppost. Obtenemos parametros POST.
	$revsess. TRUE o FALSE para confirmar si recuperamos valor desde la $_SESSION
	*/
	session_start();
	if(isset($pget)) {$id_ret=$pget;}
	else if (isset($ppost)){$id_ret=$ppost;}
	else if ($revsess==TRUE) $id_ret=$_SESSION[$nompar];
	return $id_ret;
	}
//CREAR TABLA TEMPORAL PARA BUSQUEDA DE PACIENTES
function fnc_create_temp_pac(){
$query_create_table = "CREATE TEMPORARY TABLE db_pacientes_temp (id int(11) NOT NULL auto_increment, cod_pac int(6), fullname varchar(100), fulltext(fullname), PRIMARY KEY (id))ENGINE = MYISAM;";
if (mysql_query($query_create_table)){}
else {echo mysql_error();}
$query_datos_pac='SELECT pac_cod, pac_nom, pac_ape FROM db_pacientes';
$RS_datos_pac = mysql_query($query_datos_pac);
$row_RS_datos_pac = mysql_fetch_assoc($RS_datos_pac);
$totalRows_RS_datos_pac = mysql_num_rows($RS_datos_pac);
if ($totalRows_RS_datos_pac > 0)
{	do 
	{	$nom = $row_RS_datos_pac['pac_nom'].' '.$row_RS_datos_pac['pac_ape'];
		$query_insert_temp='INSERT INTO db_pacientes_temp (cod_pac, fullname) VALUES ("'.$row_RS_datos_pac['pac_cod'].'" ,"'.$nom.'")';
		mysql_query($query_insert_temp)or die(mysql_error());
	}while ($row_RS_datos_pac = mysql_fetch_assoc($RS_datos_pac));
//echo "Tabla temporal Creada con ".$totalRows_RS_datos_pac."registros";
}else{echo '<div class="alert alert-error"><h4>No Existen Pacientes</h4></div>';}
}

function fnc_cutblanck($bus){
	if (substr($bus,0,1)==' ') $bus=substr($bus,1,strlen($bus));
	if (substr($bus,strlen($bus) - 1,1)==' ') $bus=substr($bus, 0, strlen($bus) - 1);
	return($bus);
}
function fnc_gencad_search(){
  session_start();
  $busqueda=fnc_cutblanck($_SESSION['sBr']);
  $trozos=explode(" ",$busqueda);
  $numero=count($trozos);
  if ($numero==1) $cadbusca='SELECT * FROM db_pacientes_temp where fullname LIKE "%'.$busqueda.'%" ORDER BY cod_pac DESC'; 
  if ($numero>1)$cadbusca='SELECT cod_pac, fullname, MATCH (fullname) AGAINST ("'.$busqueda.'") AS Score FROM db_pacientes_temp WHERE MATCH (fullname) AGAINST ("'.$busqueda.'") ORDER BY Score DESC';
  return $cadbusca;
}
function tableExists($table_name){
	$Table = mysql_query("show tables like '" . $table_name . "'"); 
	if(mysql_fetch_row($Table) === false) return("0");
	else return("1");
}
function fnc_cadsearch($busqueda){
	session_start();
	//SI EXISTE CADENA DE BUSQUEDA	
	if((isset($busqueda))&&($busqueda!="")){
		$msg_sys.="Existe Cadena *$busqueda* - ";
		$msg_sys.="TBL.".tableExists("db_pacientes_temp")."//";
		if(tableExists("db_pacientes_temp")==0){
			$msg_sys.="Tabla Existe - ";
			if($busqueda!=$_SESSION['sBr']){
				$msg_sys.="Busqueda *$busqueda* diferente a la sesion *".$_SESSION['sBr']."*";
				$_SESSION['sBr']=$busqueda;
				mysql_query('DROP TABLE db_pacientes_temp');
				$msg_sys.="Tabla Borrada - ";
				fnc_create_temp_pac();
				$msg_sys.="Creada Tabla";
			}else{
				$msg_sys.=$_SESSION['sBr'];
				mysql_query('DROP TABLE db_pacientes_temp');
				$msg_sys.="Tabla Borrada - ";
				fnc_create_temp_pac();
				$msg_sys.="Creada Tabla";
			}
			
		}else{
			$_SESSION['sBr']=$busqueda;
			$msg_sys.="la tabla no existe";
			fnc_create_temp_pac();
			$msg_sys.="Tabla Creada";
		}
	}
	//echo $msg_sys;
}

function fncStat($dest,$params,$css=NULL){
//Funcion para visualizar status v.2.0
$firstP=TRUE;
foreach($params as $x => $xVal) {
    if($x=='val'){
		if($xVal==1){
			$xVal=0;
			$cssST='btn btn-success btn-xs';
			$txtST='<span class="glyphicon glyphicon-ok"></span>';
		}else{
			$xVal=1;
			$cssST='btn btn-warning btn-xs';
			$txtST='<span class="glyphicon glyphicon-remove"></span>';
		}
	}
	if($firstP==TRUE){
		$lP.='?'.$x.'='.$xVal;
		$firstP=FALSE;
	}else $lP.='&'.$x.'='.$xVal;
}
$st='<a href="'.$dest.$lP.'" class="'.$cssST.' '.$css.'">'.$txtST.'</a>';
return $st;
}

function fnc_status($id, $stat){
if ($stat=="1")
	echo "<a onClick="."cont_panel("."'"."_fncts.php?id_sel=".$id."&stat=0"."'".',false)>'."<img src='".$GLOBALS['RAIZ']."images/struct/tick.png' border='0' />"."</a>";
if(($stat=="0")||($stat!="1"))
	echo "<a onClick="."cont_panel("."'"."_fncts.php?id_sel=".$id."&stat=1"."'".',false)>'."<img src='".$GLOBALS['RAIZ']."images/struct/publish_x.png' border='0' />"."</a>";
}

//OBTENER IP
function getRealIP(){
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ){
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            : ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               : "unknown" );
      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR
      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
      reset($entries);
      while (list(, $entry) = each($entries)){
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)){
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
            if ($client_ip != $found_ip){ $client_ip = $found_ip; break;
            }
         }
      }
   }else{
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            : ((!empty($_ENV['REMOTE_ADDR'])) ?
               $_ENV['REMOTE_ADDR']
               : "unknown" );
   }
   return $client_ip;
}
//FUNCION REGISTRA ACCESO DE USUARIOS
function fnc_acces_usersys($param1){
	$accessDate=date('Y-m-d H:i:s',time() - 3600);
	$_SESSION['data_access']=$accessDate;
	$accessIp=getRealIP();
	$qryINS=sprintf('INSERT INTO db_user_access (usr_id, access_datet, access_ip) VALUES (%s, %s, %s)',
	SSQL($param1,'int'),
	SSQL($accessDate,'text'),
	SSQL($accessIp,'text'));
	mysql_query($qryINS)or die(mysql_error());
}
//Detalle factura
function fnc_datacons($param1, $param2){
	$query_RS_datos = sprintf("SELECT * FROM db_consultas INNER JOIN db_pacientes ON db_consultas.pac_cod=db_pacientes.pac_cod WHERE db_consultas.con_num=%s AND db_consultas.pac_cod=%s", 
		SSQL($param1, "int"),
		SSQL($param2, "int"));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}
//Ultima Consulta
function fnc_lastcons($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_consultas WHERE db_consultas.pac_cod=%s ORDER BY db_consultas.con_num DESC",
		SSQL($param1, "int"));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}
function fnc_dataTerPacCons($param1, $param2){
	$query_RS_datos = sprintf("SELECT * FROM tbl_terapias WHERE con_num = %s AND pac_cod=%s", 
		SSQL($param1, "int"),
		SSQL($param2, "int"));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}

function listatipos($nom=NULL, $typ, $sel=NULL, $class=NULL,$var=NULL){
//Función para la creación automatica de un SELECT (lista desplegable) obteniedo datos de la tabla tipos
	//$nom: Nombre que se va a dar al select
	//$tip: Parametro del typ_ref que se va a obtener
	//$sel: Parametro previamente seleccionado
$query_RSe = "SELECT * FROM db_types WHERE typ_ref='".$typ."' AND typ_stat='1'";
$RSe = mysql_query($query_RSe) or die(mysql_error());
$row_RSe = mysql_fetch_assoc($RSe);
$totalRows_RSe = mysql_num_rows($RSe);
if (!$nom) $nom="select";
echo '<select name="'.$nom.'" id="'.$nom.'" class="'.$class.'" '.$var.'>';
	echo '<option value=""';
	if (!(strcmp(-1, $sel))) {echo "selected=\"selected\"";} ?>
    <?php echo '>- Seleccione -</option>';
do {
	echo '<option value="'.$row_RSe['typ_cod'].'"';
	if (!(strcmp($row_RSe['typ_cod'], $sel))) {echo "selected=\"selected\"";} ?>
    <?php echo '>'.$row_RSe['typ_val'].'</option>';
} while ($row_RSe = mysql_fetch_assoc($RSe));
$rows = mysql_num_rows($RSe);
if($rows > 0) {
	mysql_data_seek($RSe, 0);
	$row_RSe = mysql_fetch_assoc($RSe);
}
echo '</select>';
mysql_free_result($RSe);
}

function date_ame2euro($date=NULL){
if(!$date) $datef=date('d-m-Y');
else $datef=date("d-m-Y",strtotime($date));
return $datef;
}

function dias_transcurridos($FUM,$FACT){
	$dias = (strtotime($FUM)-strtotime($FACT))/86400;
	$dias = abs($dias); $dias = floor($dias);		
	return $dias;
}
function fnc_obst_fpp($FUM){
	return date ('Y-M-d',strtotime ('+8 days, -3 month, +1 year',strtotime($FUM)));
}
function fnc_obst_semges($FUM,$sdate){
	if($FUM<=$sdate) return number_format((dias_transcurridos($FUM,$sdate)/7), 1);
	else {return "Error"; }
}

function fnc_obst_mesesvida($fIni,$fFin){

	$fIni = new DateTime($fIni);
	$fFin = new DateTime($fFin);

	$diferencia = $fIni->diff($fFin);
	$meses = ( $diferencia->y * 12 ) + $diferencia->m;
	
	return $meses;
}


function fnc_totpac(){
	$query_RS_datos = sprintf("SELECT * FROM db_pacientes");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function fnc_totCons(){
	$query_RS_datos = sprintf("SELECT * FROM db_consultas");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

//Validar URL Retorno
function urlr($urlf=NULL){
	//$urlf :: URL proveniente de un FORM
	//$urla :: URL anterior proveniente de una Session declarada en el Header $_SESSION['urlp']
	//$urlc :: URL actual de el archivo que solicita la validacion de url
//echo '<h4>entra a verurlr</h4>';
$urlp=$_SESSION['urlp'];//URL Previa
$urlc=$_SESSION['urlc'];//URL Actual
//Verifico si tengo una URL retorno de formulario (urlf)
if(isset($urlf)){ $urlr=$urlf;
}else{//NO TENGO URL de FORM 
	//echo '<h4>No tengo URL de FORM</h4>';
	if((compUrl($urlc,$urlp))||(!isset($urlp))){ $urlr=$GLOBALS['RAIZ'];//Comparo si no son iguales la URL
	}else{ $urlr=$urlp; }
}
return $urlr;
}

if (!function_exists("SSQL")) {
function SSQL($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>