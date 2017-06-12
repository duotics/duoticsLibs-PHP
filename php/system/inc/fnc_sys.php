<?php
function detRowGSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v0.1
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal){
				$lP.=sprintf('%s %s %s %s',
							SSQL($xVal['cond'],''),
							SSQL($xVal['field'],''),
							SSQL($xVal['comp'],''),
							SSQL($xVal['val'],'text'));
			}
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP.' %s',
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	//SSQL($lP,''),
	SSQL($orderBy,''));
	//echo $qry;
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

function getParamSQLA($params){
	if($params){
		foreach($params as $val){
			if(!$val[3]) $val[3]=' AND ';
			$qryParam.=$val[3].' '.$val[0].' '.$val[1].' "'.$val[2].'"';
		}
	}
	return $qryParam;
}

//TOT ROWS table
function totRowsTabP($table,$param=NULL){
	$qry = sprintf('SELECT * FROM %s WHERE 1=1 ',
	SSQL($table,''));
	$qry.=$param;
	//echo '<hr>'.$qry.'<hr>';
	//echo "<hr>-TRTP. ".$qry."<hr>";
	$RS = mysql_query($qry) or die(mysql_error());
	//echo '<hr>ERROR RS ?<hr>';
	$dRS = mysql_fetch_assoc($RS);
	//echo '<hr>ERROR dRS ?<hr>';
	$trRS = mysql_num_rows($RS);
	//echo '<hr>ERROR trRS ?<hr>';
	//echo "<hr>* TR. ".$trRS.'<hr>';
	return ($trRS);
	
}

function fnc_image_exist($RAIZ,$ruta,$nombre){
	if ((!(isset($nombre)))||($nombre=="")) $nombre="error.jpg";
	if (file_exists(RAIZ0.$ruta.$nombre)) return $RAIZ.$ruta.$nombre;
	else return $GLOBALS['RAIZa'].'images/struct/no_image.jpg';
}

//v1.4 2017-04-01 -> add $imgRet['s'] to return status of function
function vImg($ruta,$nombre,$thumb=TRUE,$pthumb='_t'){
	//$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
	//$nombre. Nombre del Archivo
	//$thumb. TRUE o FALSE en caso de querer recuperar thumb
	$pthumb='t_';//$pthumb PREFIJO de Thumb
	$imgRet['n']=$GLOBALS['RAIZi'].'struct/no_image.jpg';
	$imgRet['t']=$imgRet['n'];
	$imgRet['s']=FALSE;//Verify if file exist is default FALSE
	if($nombre){
		//echo '<hr>RAIZ0. '.RAIZ0.$ruta.$nombre;
		//echo '<hr>$RAIZ0. '.$RAIZ.$ruta.$nombre;
		if (file_exists(RAIZ0.$ruta.$nombre)){
			$imgRet['s']=TRUE;//FILE EXIST RETURN TRUE AND ALL DATA (link normal, link thumb, file name original)
			$imgRet['f']=$nombre;
			$imgRet['n']=$GLOBALS['RAIZ0'].$ruta.$nombre;
			$imgRet['t']=$imgRet['n'];
			if ($thumb==TRUE){
				if (file_exists(RAIZ0.$ruta.$pthumb.$nombre)){
					$imgRet['t']=$GLOBALS['RAIZ0'].$ruta.$pthumb.$nombre;
				}
			}
		}
	}
	return $imgRet;
}

function uploadfile($file, $params){// v.1.3
	$code = md5($GLOBALS['sdatet']);
	$prefijo = $params['pre'].'_'.$code;
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	// Verifica si la extension es valida
	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';
	else{ // Verifica el tamaño maximo
		if(filesize($file['tmp_name']) > $params['size']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['size']/1024/1024).' MB</h4>';
		else{ // Verifica Permisos de Carpeta, Si Carpeta Existe.
			if(!is_writable($params['pat'])) $LOG.='<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>';
			else{// Mueve el archivo a su lugar correpondiente.
				if(!move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $LOG.='<h4>Error al Cargar el Archivo</h4>';
				else{
					$aux_grab=TRUE;
					$LOG.='<p>Archivo Cargado Correctamente</p>';
				}
			}
		}
	}
	$auxres['LOG']=$LOG;
	$auxres['EST']=$aux_grab;
	$auxres['FILE']=$filename;
	return $auxres; 
}

function fsendPhpMailer($data){
	//echo 'FNC fsendPhpMaile<hr>';
	//var_dump($data);
	//echo '<hr>';
	
	$estSM=FALSE;
	
	date_default_timezone_set('America/Guayaquil');
	$mail = new PHPMailer(true);
	$mail->IsSMTP();//telling the class to use SMTP
	try {
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = 'desarrollo@duotics.com';
		$mail->Password = 'desduotics2012.*';
		
		//$mail->CharSet = "UTF­8";
		//$mail->Encoding = "quoted­printable";
		
		/*************** MAIL TO COMPANY ****************/
		//$mail->AddAddress('soporte@ecorutajuvenil.org', 'ECO RUTA JUVENIL');
		$mail->AddAddress('desarrollo@duotics.com', 'DUOTICS Desarrollo Web');
		$mail->AddAddress($data['datMail'], $data['datName']);
		//echo 'Send to Mail . '.$data['datMail'].' - Name mail. '.$data['datName'];
		$mail->SetFrom('soporte@ecorutajuvenil.net', 'ECO RUTA JUVENIL');
		$mail->Subject = $data['subject'];
		$mail->AltBody = $data['altbody'];
		$mail->MsgHTML($data['msg']);
		$mail->Send();
		/*************** MAIL TO CLIENT *****************/
/*
		$mail->ClearAddresses();
		$mail->AddAddress($data['datMail'], $data['datName']);
		$mail->SetFrom('soporte@ecorutajuvenil.net', 'ECO RUTA JUVENIL - SOPORTE');
  		$mail->Subject = $data['subjectC'];
		$mail->AltBody = $data['altbodyC'];
	  	$mail->MsgHTML($data['msgC']);
  		$mail->Send();
*/		
		switch ($data['txtType']) {
			case "mAct":
				$msgResp='<h4><i class="fa fa-life-ring fa-lg"></i>  Mensaje de Activacion enviado</h4>';
				break;
			default:
				$msgResp='<h4>Mensaje enviado</h4>';
		}
		$estSM=TRUE;
		$LOG.='<p>Mensaje de estado, enviado correctamente al usuario <strong>'.$data['datMail'].'</strong></p>';
		//sysmsg($msgResp,"success","1");
	} catch (phpmailerException $e) {
	  $e->errorMessage(); //Pretty error messages from PHPMailer
	  //echo 'error.'.$e->errorMessage().'<hr>';
	  $LOG.='<p><strong>Error de PHP Mailer</strong> '.$e.'<p>';
	  //sysmsg($e,"danger","1");
	} catch (Exception $e) {
	  $e->getMessage(); //Boring error messages from anything else!
	  //echo 'error.'.$e->getMessage().'<hr>';
	  $LOG.='<p><strong>Error del Sistema</strong> '.$e.'<p>';
	  //sysmsg($e,"danger","1");
	}
	$LOG.=$e;
	$ret['LOG']=$LOG;
	$ret['EST']=$estSM;
	return($ret);
}

function verifyCheckUserMenu($idm,$idu){
	$qry=sprintf('SELECT * FROM db_menu_usuario WHERE men_id=%s AND usr_id=%s',
	SSQL($idm,'int'),
	SSQL($idu,'int'));
	$RS=mysql_query($qry);
	$tRS=mysql_num_rows($RS);
	if($tRS>0) return 'checked';
	else return NULL;
}
function genMenu($refMC,$css=NULL,$vrfUL=TRUE){
	//
	if($_SESSION['dU']['LEVEL']=='0'){
		//Consulta para Menus Principales //SUPERUSER
		//echo('SUPERUSER');
		$qry=sprintf("SELECT * FROM db_menus_items 
		INNER JOIN db_menus on db_menus_items.men_idc=db_menus.id 
		WHERE db_menus.ref = %s 
		AND db_menus_items.men_padre = %s 
		AND db_menus_items.men_stat = %s 
		ORDER BY men_orden ASC",
		SSQL($refMC,'text'),
		SSQL('0','int'),
		SSQL('1','text'));
	}else{
		//Consulta para Menus Principales
		$qry=sprintf("SELECT * FROM db_menus_items 
		INNER JOIN db_menu_usuario ON db_menus_items.men_id = db_menu_usuario.men_id 
		INNER JOIN db_menus on db_menus_items.men_idc=db_menus.id 
		WHERE db_menus.ref = %s 
		AND db_menus_items.men_padre = %s AND db_menu_usuario.usr_id = %s 
		AND db_menus_items.men_stat = %s 
		ORDER BY men_orden ASC",
		SSQL($refMC,'text'),
		SSQL('0','int'),
		SSQL($_SESSION['dU']['usr_id'],'int'),
		SSQL('1','text'));
	}
	$RSmp = mysql_query($qry) or die(mysql_error());
	$dRSmp = mysql_fetch_assoc($RSmp);
	$tRSmp = mysql_num_rows($RSmp);
	if($tRSmp > 0){
		do{
			//Consulta para Submenus
			$qry2 = sprintf("SELECT * FROM db_menus_items 
			INNER JOIN db_menu_usuario ON db_menus_items.men_id = db_menu_usuario.men_id 
			WHERE db_menus_items.men_padre = %s AND db_menu_usuario.usr_id = %s AND db_menus_items.men_stat = %s 
			ORDER BY men_orden ASC",
			SSQL($dRSmp['men_id'],'int'),
			SSQL($_SESSION['dU']['usr_id'],'int'),
			SSQL(1,'int'));
			$RSmi = mysql_query($qry2) or die(mysql_error());
			$dRSmi = mysql_fetch_assoc($RSmi);
			$tRSmi = mysql_num_rows($RSmi);
			if($tRSmi>0) $cssSM="dropdown"; 
			else $cssSM="";
			if($dRSmp['men_link']) $link = $GLOBALS['RAIZc'].$dRSmp['men_link'];
			else $link = "#";
			if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
			$ret.='<li class="'.$cssSM.'">'; 
			if($tRSmi > 0){
				$ret.='<a href="'.$link.'" class="dropdown-toggle"';
				if($tRSmi > 0){ $ret.='data-toggle="dropdown"';
			}
			$ret.='>';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'];
			if($tRSmi > 0){
				$ret.=' <b class="caret"></b>';
			}
			$ret.='</a>';
			$ret.='<ul class="dropdown-menu">';
			do{
				if($dRSmi['men_link']){ 
					$link = $GLOBALS['RAIZc'].$dRSmi['men_link'];
				}else{
					$link = "#"; 
				}
			if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
			$ret.='<li><a href="'.$link.'">';
			if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
			$ret.=$dRSmi['men_tit'].'</a></li>';
			if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];
			}while($dRSmi = mysql_fetch_assoc($RSmi));
			mysql_free_result($RSmi);
			$ret.='</ul>';
		}else{
			
			$ret.='<a href="'.$link.'">';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'].'</a>';
		}                             	                    
		$ret.='</li>';
		if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
	}while($dRSmp = mysql_fetch_assoc($RSmp));
	mysql_free_result($RSmp);
	}else{
		$ret.='<li><a><i class="fa fa-ban" aria-hidden="true"></i></a></li>';//<strong>'.$refMC.'</strong></li>';
	}
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}

function detNumConAct($idc,$idp){
	if($idc) $param ='AND con_num<=%s';
	$qryRTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s '.$param,
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSRtot=mysql_query($qryRTot);
	$row_RSRtot=mysql_fetch_assoc($RSRtot);
	$numRTot=mysql_num_rows($RSRtot);
	if(!$idc) $numRTot++;
	return $numRTot;
}
function gebBtnHis($idc,$idp){
	$qryTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s',
	SSQL($idp,'int'));
	$RStot=mysql_query($qryTot);
	$row_RStot=mysql_fetch_assoc($RStot);
	$numTot=mysql_num_rows($RStot);
	
	$qryRTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<=%s',
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSRtot=mysql_query($qryRTot);
	$row_RSRtot=mysql_fetch_assoc($RSRtot);
	$numRTot=mysql_num_rows($RSRtot);
	
	$qryIni=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num ASC LIMIT 1',
	SSQL($idp,'int'));
	$RSini=mysql_query($qryIni);
	$row_RSini=mysql_fetch_assoc($RSini);
	$idIni=$row_RSini['con_num'];
	
	$qryFin=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num DESC LIMIT 1',
	SSQL($idp,'int'));
	$RSfin=mysql_query($qryFin);
	$row_RSfin=mysql_fetch_assoc($RSfin);
	$idFin=$row_RSfin['con_num'];
	
	$qryAnt=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s and con_num<%s ORDER BY con_num DESC LIMIT 1',
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSant=mysql_query($qryAnt);
	$row_RSant=mysql_fetch_assoc($RSant);
	$idAnt=$row_RSant['con_num'];
	
	$qrySig=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s and con_num>%s ORDER BY con_num ASC LIMIT 1',
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSsig=mysql_query($qrySig);
	$row_RSsig=mysql_fetch_assoc($RSsig);
	$idSig=$row_RSsig['con_num'];

	if($idIni==$idc){
		$cssIni='disabled';
		$cssAnt='disabled';
	}else{
		$link_ini='form.php?idc='.$row_RSini['con_num'];
	}
	if($idFin==$idc){
		$cssFin='disabled';
		$cssSig='disabled';
	}else{
		$link_fin='form.php?idc='.$row_RSfin['con_num'];
	}

	$link_ant='form.php?idc='.$idAnt;
	$link_sig='form.php?idc='.$idSig;
	
	$btn_ini='<a href="'.$link_ini.'" class="btn btn-default btn-sm '.$cssIni.'"><i class="fa fa-fast-backward"></i>';
	$btn_ini.='</a>';
	$btn_fin='<a href="'.$link_fin.'" class="btn btn-default btn-sm '.$cssFin.'"><i class="fa fa-fast-forward"></i>';
	$btn_fin.='</a>';
	$btn_ant='<a href="'.$link_ant.'" class="btn btn-default btn-sm '.$cssAnt.'"><i class="fa fa-step-backward"></i>';
	$btn_ant.='</a>';
	$btn_sig='<a href="'.$link_sig.'" class="btn btn-default btn-sm '.$cssSig.'"><i class="fa fa-step-forward"></i>';
	$btn_sig.='</a>';
	echo $btn_ini.$btn_ant.'<span class="label label-default">'.$numRTot.' / '.$numTot.'</span>'.$btn_sig.$btn_fin;
}


function fnc_genthumb($path, $file, $pref, $mwidth, $mheight){
	$obj = new img_opt(); // Crear un objeto nuevo
	$obj->max_width($mwidth); // Decidir cual es el ancho maximo
	$obj->max_height($mheight); // Decidir el alto maximo
	$obj->image_path($path,$file,$pref); // Ruta, archivo, prefijo
	$obj->image_resize(); // Y finalmente cambiar el tamaño
}

function uplFile($FILE,$param,$img,$genThumb=TRUE,$delAnt=TRUE){
	/* v.1.0 (2016-03-15)
	FILE=archivo subido
	$param=Listado de Parametros para la carga como tipo tamaño folder
	$img=Imagen anterior, que al final cambia si se sube la nueva imagen
	$genThumb=Bandera Generacion Thumbnail
	$delAnt=Bandera Eliminar imagen anterior
	*/
	if($FILE['userfile']['name']){
		$upl=uplServer($param, $FILE['userfile']);
		$LOG.=$upl['LOG'];
		if($upl['EST']){
			if(($delAnt)&&($img)){
				$LOG.=deleteFile($param['pat'],$img);
				$LOG.=deleteFile($param['pat'],'t_'.$img);
			}
			$img=$upl['FILE'];
			if($genThumb) fnc_genthumb($param['pat'], $upl['FILE'], "t_", 24, 24);
		}
	}
	$retVal['img']=$img;
	$retVal['LOG']=$LOG;
	return $retVal;
}

function fncImgExist($ruta,$nombre){
	if (!(isset($nombre))) $nombre="error";
	if (file_exists(RAIZ.$ruta.$nombre)){
		$dirImg = $GLOBALS['RAIZ'].$ruta.$nombre;
	} else {
		$dirImg=$GLOBALS['RAIZa'].'images/struct/no_image.jpg';
	}
	return ($dirImg);	
} 

function deleteFile($path,$file,$vT=FALSE,$pT='t_'){ //v.1.1
$fileDel=$path.$file;
	if (file_exists($fileDel)) {
		if (unlink($fileDel)) $LOG.='<span>Imagen anterior eliminada</span>';
		else $LOG.='<span>Error al eliminar imagen anterior</span>';
	}else $LOG.='<span>Imagen anterior no Existe</span>';
	if($vT==TRUE){
		$fileDelT=$path.$pT.$file;
		if (file_exists($fileDelT)) {
			if (unlink($fileDelT)) $LOG.='<span>Imagen thumb anterior eliminada</span>';
			else $LOG.='<span>Error al eliminar imagen thumb anterior</span>';
		}else $LOG.='<span>Imagen thumb anterior no Existe</span>';
	}
return $LOG;
}

//uplServer() :: Carga de Archivos al Servidor
function uplServer($params, $file){
	$code = md5(uniqid(rand()));
	$prefijo = $params['pre'].'_'.$code;
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	// Verifica si la extension es valida
	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';
	else{ // Verifica el tamaño maximo
		if(filesize($file['tmp_name']) > $params['siz']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['siz']/1024/1024).' MB</h4>';
		else{ // Verifica Permisos de Carpeta, Si Carpeta Existe.
			if(!is_writable($params['pat'])) $LOG.='<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>'.$params['pat'];
			else{// Mueve el archivo a su lugar correpondiente.
				if(!move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $LOG.='<h4>Error al Cargar el Archivo</h4>';
				else{
					$aux_grab=TRUE;
					$LOG.='<p>Archivo Cargado Correctamente</p>';
				}
			}
		}
	}
	$auxres['LOG']=$LOG;
	$auxres['EST']=$aux_grab;
	$auxres['FILE']=$filename;
	return $auxres; 
}

function urlReturn($urlr,$urld=NULL){
//$urlr -> URL para retornar
//$urld -> URL defecto para el Modulo
	$urla=$_SESSION['urlp'];
	$urlc=$_SESSION['urlc'];
	if (($urlr)&&($urlr != $urlc)){
		$urlf=$urlr;
	}else if(($urla)&&($urla != $urlc)){
		$urlf=$urla;
	}else if(($urld)&&($urld != $urlc)){
		$urlf=$urld;
	}else { $urlf=$GLOBALS['RAIZ'].'com_index/'; }
	return $urlf;
}
/*
function vLOG(){
	session_start();
	if(isset($_SESSION['LOG'])) echo '<div id="log">
	<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	'.$_SESSION['LOG'].'</div></div>';
	unset($_SESSION['LOG']);
	unset($_SESSION['LOGr']);
}
*/
//fnc_log() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
function sLOG_ant($type='a', $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){
	//SESSION_LOG: Vector ['m']=Mensaje; ['t']=Titulo; ['c']=class, ['i']=imagen
	//echo '<hr>*** '.$_SESSION['LOG']['m'].'***<hr>';
	if($msg_m){
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else $LOG=$_SESSION['LOG'];
	if(!$LOG['c']) $LOG['c']='alert-warning';
	if((isset($LOG['m']))&&($LOG['m'])){
		if($type=='a'){
			$sLog='<div id="log">AAA ';
			$sLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
			$sLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
			$sLog.=$LOG['m'];
			$sLog.='</div></div>';
		}else if($type=='g'){
			if($LOG['m']){
			$sLog='<script type="text/javascript">
			logGritter("GGG '.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");</script>';
			}
		}else{
			$sLog='<div>NULL'.$LOG['m'].'</div>';
		}
		echo $sLog;
		unset($_SESSION['LOG']);
		unset($_SESSION['LOG']['m']);
	}
}

function sLOG($type=NULL, $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){//v.2.1
	$vrfVL=TRUE; //var para setear $LOG
	if($msg_m){
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else $LOG=$_SESSION['LOG'];
	
	if($LOG){
		if(!$LOG['c']) $LOG['c']='alert-info';
		switch ($type){
			case 'a':
				$rLog='<div id="log">';
				$rLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
				$rLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
				$rLog.=$LOG['m'];
				$rLog.='</div></div>';
			break;
			case 'g':
				$rLog='<script type="text/javascript">
				logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");
				</script>';
			break;
			case 's':
				$vrfVL=FALSE;
			break;
			default:
				$rLog='<div>'.$LOG['m'].'</div>';
			break;
		}
		echo $rLog;
	}
	if($vrfVL){//TRUE unset->LOG, FALSE $_SESSION LOG -> $LOG
		unset($_SESSION['LOG']);
	}else{
		$_SESSION['LOG']=$LOG;
	}
}

//FUNCTIONS ACCESS USERS
function vLogin($mSel=NULL){//,$accesscheck=FALSE){
	if($mSel){
		
		if($_SESSION['dU']['LEVEL']=='0'){
			//Consulta para Menus Principales //SUPERUSER
			//echo('SUPERUSER');
			$qry=sprintf('SELECT * FROM db_menus_items 
			LEFT JOIN db_componentes ON db_menus_items.mod_cod=db_componentes.mod_cod
			WHERE db_menus_items.men_nombre=%s',
			SSQL($mSel,'text'));
		}else{
			//OTHER LEVEL USERS
			$qry=sprintf('SELECT * FROM db_menus_items 
			INNER JOIN db_menu_usuario ON db_menus_items.men_id=db_menu_usuario.men_id
			LEFT JOIN db_componentes ON db_menus_items.mod_cod=db_componentes.mod_cod
			WHERE db_menu_usuario.usr_id=%s AND db_menus_items.men_nombre=%s',
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($mSel,'text'));
		}
		
		$RS=mysql_query($qry);
		$dRS=mysql_fetch_assoc($RS);
		$tRS=mysql_num_rows($RS);
		if($tRS>0) $vVM=TRUE;
		else $vVM=FALSE;
	}else $vVM=TRUE;
	$MM_authorizedUsers = "";
	$MM_donotCheckaccess = "true";
	$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
	if (!((isset($_SESSION['MM_Username'])) && ($vVM) && (isAuthorized($MM_authorizedUsers, $_SESSION['MM_Username'])))) {   
 
	  $MM_qsChar = "?";
	  $MM_referrer = $_SERVER['PHP_SELF'];
	  
	  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
	  
	  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	  header("Location: ". $MM_restrictGoTo); 
	  exit;
	}
	if($mSel) return($dRS);
}

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $UserName) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False;
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { $isValid = true; } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = true; } 
    if (($strUsers == "") && true) { $isValid = true; } 
  } 
  return $isValid; 
}

function login($username, $password, $accesscheck){
if (isset($username)) {
	$loginUsername=$username;
	$password=md5($password);
	
	if ($accesscheck) $MM_redLS = $accesscheck;
	else $MM_redLS = $GLOBALS['RAIZc']."com_index/";
	$MM_redLF = $GLOBALS['RAIZ']."index.php";
	$MM_redRF = true;
  	
	$qryLOGIN=sprintf("SELECT usr_id, user_email, usr_contrasena, usr_est as EST, user_level as LEVEL
	FROM db_usuario 
	WHERE user_email=%s AND usr_contrasena=%s",
	SSQL($loginUsername, "text"), 
	SSQL($password, "text"));
	
	$LoginRS = mysql_query($qryLOGIN) or die(mysql_error());
	$loginFoundUser = mysql_num_rows($LoginRS);
	$dLoginRS = mysql_fetch_assoc($LoginRS);
	if ($loginFoundUser) {
		if($dLoginRS['EST']==1){
			if(($dLoginRS['LEVEL']==0)||($dLoginRS['LEVEL']==1)||($dLoginRS['LEVEL']==2)){
				if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
				$_SESSION['autentificacion']=TRUE;
				$_SESSION['dU']=$dLoginRS;
				$_SESSION['MM_Username'] = $loginUsername;
				$_SESSION['MM_UserID'] = $dLoginRS['usr_id'];
				$_SESSION['MM_UserAUD'] = $dLoginRS['id_aud'];
				$_SESSION['bsTheme'] = $dLoginRS['user_theme'];
				$id_aud=AUD($_SESSION['MM_UserAUD'],NULL,'sysacc');
				$tLOG='Usuario Identificado';
				header("Location: ".$MM_redLS.'?LOG='.$tLOG);
			}else{
				$tLOG='<h4>Usuario NO Autorizado</h4>';
				header("Location: ".$MM_redLF.'?LOG='.$tLOG);
			}
		}else{
			$tLOG='<h4>Usuario Deshabilitado</h4>Comuniquese con el Administrador';
			header("Location: ".$MM_redLF.'?LOG='.$tLOG);
		}
	}else{
		$tLOG='<h4>Error de Nombre de Usuario - Contraseña</h4>Intente de nuevo';
		header("Location: ".$MM_redLF.'?LOG='.$tLOG);
	}
	
}//END IF username
}//END FUNCTION LOGIN

//SI EL USUARIO NO SE HA LOGEADO REDIRECCIONA A wrong-access.php
function fnc_autentificacion(){
	if(!$_SESSION['autentificacion'])
		header('Location: '.$MM_redirectLoginFailed);		 
}

//Funcion Validar URL
function fnc_datURLv($urlactual,$usr_id){
	//include(RUTAcon.'conexion-mysql.php');
	$sql = sprintf('SELECT * FROM db_menus 
	inner join db_menu_usuario on db_menus.men_id=db_menu_usuario.men_id
	where usr_id =%s and men_link LIKE  %s',
	SSQL($usr_id,'int'),
	SSQL("%".$urlactual,"text"));
	$query = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($query);
	return $row;
	mysql_free_result($query);

}





?>