<?php 
//Detalle completo Auditoria
//v.1.0
//v.2.0 mysqli update
//v.2.1 wrong database query left join
function dataAud($param1,$ord='DESC'){//duotics_lib v.2.1
	global $conn;
	$q = sprintf('SELECT * FROM db_auditoria_detalle 
	LEFT JOIN tbl_usuario ON db_auditoria_detalle.usr_id=tbl_usuario.usr_id 
	INNER JOIN db_empleados ON tbl_usuario.emp_cod=db_empleados.emp_cod 
	WHERE db_auditoria_detalle.id_aud=%s ORDER BY db_auditoria_detalle.id %s LIMIT 1',
	SSQL($param1,'text'),
	SSQL($ord,''));
	$RS = mysqli_query($conn,$q) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	return ($dRS);
	mysqli_free_result($RS);
}

//Funcion Auditoria
//v.1.0
//v.2.0 -> mysqli updated
function AUD($id=NULL,$des=NULL,$eve=NULL){//duotics_lib v.2.0
	global $conn; //Generación Descrición ($des), dependiendo del Evento ($eve)
	switch ($eve) {
    	case 'sysacc':{
			$_SESSION['data_access']=$GLOBALS['sdatet'];
			$des='IP. '.getRealIP();
			break;
		}
		default:{}
	}
	//Pregunto si existe id_aud ($id)
	if($id){ //Pregunto Si db_auditoria Existente
		$detAud=detRow('db_auditoria','id_aud',$id);
		if($detAud){
			$id_aud=$detAud['id_aud'];
			//INSERTO db_auditoria_Detalle
			$qry=sprintf('INSERT INTO db_auditoria_detalle (id_aud, usr_id, audd_datet, audd_eve, audd_des) VALUES (%s,%s,%s,%s,%s)',
			SSQL($id,'int'),
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($GLOBALS['sdatet'],'text'),
			SSQL($eve,'text'),
			SSQL($des,'text'));
			mysqli_query($conn,$qry) or die (mysqli_error($conn));
		}
	}else{ //INSERT db_auditoria
		$qryAud=sprintf('INSERT INTO db_auditoria (aud_datet) VALUES (%s)',
		SSQL($GLOBALS['sdatet'],'text'));
		mysqli_query($conn,$qryAud);
		$id_aud=mysqli_insert_id($conn);
		//INSERT db_auditoria_detalle
		$qryAudDet=sprintf('INSERT INTO db_auditoria_detalle (id_aud, usr_id, audd_datet, audd_eve, audd_des) VALUES (%s,%s,%s,%s,%s)',
		SSQL($id_aud,'int'),
		SSQL($_SESSION['MM_UserID'],'int'),
		SSQL($GLOBALS['sdatet'],'text'),
		SSQL($eve,'text'),
		SSQL($des,'text'));
		mysqli_query($conn,$qryAudDet) or die (mysqli_error($conn));
	}
	return($id_aud);
}

//Datos Auditoria
//v.1.0
function infAud($id){//duotics_lib v.1.0
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