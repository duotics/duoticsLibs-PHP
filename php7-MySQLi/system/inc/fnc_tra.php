<?php

function insTratTer($id,$det){
	$qryDEL=sprintf('DELETE FROM db_terapias_vs_tratamientos WHERE id_ter=%s',
	SSQL($id,'int'));
	if(mysql_query($qryDEL)){
		$contELE=count($det['TN']);
		$contEB=0;
		do{
			$qry=sprintf('INSERT INTO db_terapias_vs_tratamientos (id_trat,id_ter,des) VALUES (%s,%s,%s)',
			SSQL($det['TN'][$contEB],'int'),
			SSQL($id,'int'),
			SSQL($det['TO'][$contEB],'text'));
			if(!mysql_query($qry)){
				$LOG.='<h4>Error al Guardar Tratamientos</h4>';
				$vP=FALSE;
			}
		$contEB++;
		}while($contEB<$contELE);
	}else{
		$vP=FALSE;
	}
	$RES['RES']=$vP;
	$RES['LOG']=$LOG;
	return $RES;
}



//Verifico la Reserva para Eliminarla
function verifyRESid($id){
	$detRes=detRow('db_fullcalendar','id',$id);
	if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
		SSQL('2', "text"),
		SSQL($id, "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}else{
			$LOG.='<p>Error al Actualizar Reserva</p>';
		}
	}
	return $LOG;
}

//Verifico la Reserva para Eliminarla el dia actual
function verifyREShis($idp){
	//$qry=sprintf('SELECT * FROM ');
	//$detRes=detRow('db_fullcalendar','id',$id);
	//if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE pac_cod=%s AND fechai=%s AND est=1 LIMIT 1',
		SSQL('2', "text"),
		SSQL($idp, "int"),
		SSQL($GLOBALS['sdate'], "date"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}
		
		return $LOG;
		//else{
			//$LOG.='<p>Error al Actualizar Reserva</p>';
		//}
	//}
}



//Verifico la Reserva para Eliminarla
function verifyRES($idp){
	$detRes=detRow2P('db_fullcalendar','pac_cod',$idp,'est','1',' AND ');
	if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
		SSQL('2', "text"),
		SSQL($detRes['id'], "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}else{
			$LOG.='<p>Error al Actualizar Reserva</p>';
		}
	}
}

//Verifico La Existencia de GINECOLOGIA
function verifyGIN($idp,$data){
	$detGIN=detRow('db_ginecologia','pac_cod',$idp);
	if($detGIN){
		$qryUpd=sprintf('UPDATE db_ginecologia SET 
		gin_men=%s, gin_fun=%s, gin_ges=%s, gin_pnor=%s, gin_pces=%s, gin_abo=%s, gin_hviv=%s, gin_hmue=%s, gin_mes=%s, gin_obs=%s 
		WHERE gin_id=%s',
		SSQL($data['gin_men'], "text"),
		SSQL($data['gin_fun'], "date"),
		SSQL($data['gin_ges'], "int"),
		SSQL($data['gin_pnor'], "int"),
		SSQL($data['gin_pces'], "int"),
		SSQL($data['gin_abo'], "int"),
		SSQL($data['gin_hviv'], "int"),
		SSQL($data['gin_hmue'], "int"),
		SSQL($data['gin_mes'], "int"),
		SSQL($data['gin_obs'], "text"),
		SSQL($detGIN['gin_id'], "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Registro Ginecologico Actualizado</p>';
		}else{
			$LOG.='<p>Error al Actualizar Registro Ginecologico</p>';
		}
	}else{
		$qryIns=sprintf('INSERT INTO db_ginecologia 
		(pac_cod, gin_men, gin_fun, gin_ges, gin_pnor, gin_pces, gin_abo, gin_hviv, gin_hmue, gin_mes, gin_obs) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($idp, "int"),
		SSQL($data['gin_men'], "text"),
		SSQL($data['gin_fun'], "date"),
		SSQL($data['gin_ges'], "int"),
		SSQL($data['gin_pnor'], "int"),
		SSQL($data['gin_pces'], "int"),
		SSQL($data['gin_abo'], "int"),
		SSQL($data['gin_hviv'], "int"),
		SSQL($data['gin_hmue'], "int"),
		SSQL($data['gin_mes'], "int"),
		SSQL($data['gin_obs'], "text"));
		if(mysql_query($qryIns)){
			$LOG.= '<p>Registro Ginecologico Creado</p>';
		}else{
			$LOG.= '<p>Error al Crear Registro Ginecologico</p>';
		}
	}
	$LOG.=mysql_error();
	return ($LOG);
}

//Verifico La Existencia de Historia Clinica
function verifyHC($idp,$data){
	$detHC=detRow('db_paciente_hc','pac_cod',$idp);
	if($detHC){
		$qryUpd=sprintf('UPDATE db_paciente_hc SET hc_cir_pre=%s, hc_antf=%s, hc_antf=%s, hc_antp=%s, hc_hab=%s, hc_ale=%s, hc_cau_inf=%s, hc_cic_ra=%s, hc_obs=%s WHERE hc_id=%s',
		SSQL($data['hc_cir_pre'], "text"),
		SSQL($data['hc_antf'], "text"),
		SSQL($data['hc_antf'], "text"),
		SSQL($data['hc_antp'], "text"),
		SSQL($data['hc_hab'], "text"),
		SSQL($data['hc_ale'], "text"),
		SSQL($data['hc_cau_inf'], "text"),
		SSQL($data['hc_cic_ra'], "text"),
		SSQL($data['hc_obs'], "text"),
		SSQL($detHC['hc_id'], "int"));
		//echo $qryUpd;
		if(mysql_query($qryUpd)){
			$LOG.= '<p>Historia Clinica Actualizado</p>';
		}else{
			$LOG.= '<p>Error al Actualizar Historia Clinica</p>';
		}
	}else{
		$qryIns=sprintf('INSERT INTO db_paciente_hc (pac_cod,hc_cir_pre,hc_antf,hc_antp,hc_hab,hc_ale,hc_cau_inf,hc_cic_ra,hc_obs) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($idp, "int"),
		SSQL($data['hc_cir_pre'], "text"),
		SSQL($data['hc_antf'], "text"),
		SSQL($data['hc_antp'], "text"),
		SSQL($data['hc_hab'], "text"),
		SSQL($data['hc_ale'], "text"),
		SSQL($data['hc_cau_inf'], "text"),
		SSQL($data['hc_cic_ra'], "text"),
		SSQL($data['hc_obs'], "text"));
		//echo $qryIns;
		if(mysql_query($qryIns)){
			$LOG.= '<h4>Crear Historia Clinica</h4>';
		}else{
			$LOG.= '<h4>Error Crear Historia Clinica</h4>';
		}
	}
	$LOG.=mysql_error();
	return ($LOG);
}
//FUNCION AUDITORIA
function AUD($id=NULL,$des=NULL,$eve=NULL){
	//Generación Descrición ($des), dependiendo del Evento ($eve)
	switch ($eve) {
    	case 'sysacc':{
			$_SESSION['data_access']=$GLOBALS['sdatet'];
			$des='IP. '.getRealIP();
			break;
		}
		default:{
			
		}
	}
	
	//Pregunto si existe id_aud ($id)
	if($id){
		//Pregunto Si db_auditoria Existente
		$detAud=detRow('db_auditoria','id_aud',$id);
		if($detAud){
			$id_aud=$detAud['id_aud'];
			//INSERTO db_auditoria_Detalle
			$qry=sprintf('INSERT INTO db_auditoria_detalle (id_aud, usr_id, audd_datet, audd_eve, audd_des) 
			VALUES (%s,%s,%s,%s,%s)',
			SSQL($id,'int'),
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($GLOBALS['sdatet'],'text'),
			SSQL($eve,'text'),
			SSQL($des,'text'));
			@mysql_query($qry);
		}
	}else{
		//INSERT db_auditoria
		$qryAud=sprintf('INSERT INTO db_auditoria (aud_datet) 
		VALUES (%s)',
		SSQL($GLOBALS['sdatet'],'text'));
		@mysql_query($qryAud);
		$id_aud=mysql_insert_id();
		
		//INSERT db_auditoria_detalle
		$qryAudDet=sprintf('INSERT INTO db_auditoria_detalle (id_aud, usr_id, audd_datet, audd_eve, audd_des) 
		VALUES (%s,%s,%s,%s,%s)',
		SSQL($id_aud,'int'),
		SSQL($_SESSION['MM_UserID'],'int'),
		SSQL($GLOBALS['sdatet'],'text'),
		SSQL($eve,'text'),
		SSQL($des,'text'));
		@mysql_query($qryAudDet);
	}
	return($id_aud);
}
?>