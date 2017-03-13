<?php 
//Detalle completo Auditoria
//v.1.0
function dataAud($param1,$ord){
	if (!$ord) $ord='DESC';
	$query_RS_datos = sprintf('SELECT * FROM db_auditoria_detalle 
	LEFT JOIN tbl_usuario ON db_auditoria_detalle.usr_id=db_auditoria_detalle.usr_id 
	INNER JOIN db_empleados ON tbl_usuario.emp_cod=db_empleados.emp_cod 
	WHERE db_auditoria_detalle.id_aud=%s ORDER BY db_auditoria_detalle.id %s LIMIT 1',
	SSQL($param1,'text'),
	SSQL($ord,''));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}

//Funcion Auditoria
//v.1.0
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

//Datos Auditoria
//v.1.0
function infAud($id){
	$detAudi=dataAud($id,'ASC');
	$detAudi_id=$detAudi['id'];
	$detAudi_user=$detAudi['emp_nom'].' '.$detAudi['emp_ape'];
	$detAudi_inf='<small>'.$detAudi_user.' '.$detAudi['audd_datet'].'</small>';

	$detAudf=dataAud($id,'DESC');
	$detAudf_id=$detAudf['id'];
	
	if($detAudi_id!=$detAudf_id){
		$detAudf_user=$detAudf['emp_nom'].' '.$detAudf['emp_ape'];
		$detAudf_inf="Actualización. ".$detAudf_user.' '.$detAudf['audd_datet'];
	}
	
	$infAud='<span title="'.$detAudf_inf.'" class="tooltips">'.$detAudi_inf.'</span>';
return $infAud;
}

?>