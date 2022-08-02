<?php 
/*Funcion Auditoria
v.1.0
v.2.0 -> mysqli updated
v.2.1 -> return array of values
*/
function AUD($id=NULL,$des=NULL,$eve=NULL){//duotics_lib v.2.1
	global $conn;
	$vP=FALSE;
	$LOG=null;
	switch ($eve) {//Generación Descrición ($des), dependiendo del Evento ($eve)
    	case 'sysacc':{
			$_SESSION['data_access']=$GLOBALS['sdatet'];
			$des='IP. '.getRealIP();
			break;
		}
		default:{ }
	}
	//Pregunto si existe id_aud ($id)
	if($id){
		$detAud=detRow('db_auditoria','id_aud',$id);//Pregunto Si db_auditoria Existente
		if($detAud){
			$idA=$detAud['id_aud'];
			//INSERTO db_auditoria_Detalle
			$qry=sprintf('INSERT INTO db_auditoria_detalle (id_aud, user_id, audd_datet, audd_eve, audd_des) VALUES (%s,%s,%s,%s,%s)',
			SSQL($idA,'int'),
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($GLOBALS['sdatet'],'text'),
			SSQL($eve,'text'),
			SSQL($des,'text'));
			if(mysqli_query($conn,$qry)){
				$LOG.='<p>Detalle Auditoria ingresado</p>';
				$vP=TRUE;
			}else{
				$LOG.='<p>Error al ingresar el detalle auditoria IDA</p>'.mysqli_error($conn);
			}
		}
	}else{ //INSERT db_auditoria
		$qryAud=sprintf('INSERT INTO db_auditoria (aud_datet) VALUES (%s)',
		SSQL($GLOBALS['sdatet'],'text'));
		if(mysqli_query($conn,$qryAud)){
			$idA=mysqli_insert_id($conn);
			//INSERT db_auditoria_detalle
			$qryAudDet=sprintf('INSERT INTO db_auditoria_detalle (id_aud, user_id, audd_datet, audd_eve, audd_des) VALUES (%s,%s,%s,%s,%s)',
			SSQL($idA,'int'),
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($GLOBALS['sdatet'],'text'),
			SSQL($eve,'text'),
			SSQL($des,'text'));
			if(mysqli_query($conn,$qryAudDet)){
				$vP=TRUE;
			}else{
				$LOG.='<p>Error al ingresar detalle auditoria NO IDA</p>'.mysqli_error($conn);
			}
		}else{
			$LOG.='<p>Error al ingresar auditoria</p>'.mysqli_error($conn);
		}
	}
	$AUD['est']=$vP;
	$AUD['id']=$idA;
	$AUD['log']=$LOG;
	return($AUD);
}

/*
Detalle completo Auditoria
v.1.0
v.2.0 mysqli update
v.2.1 wrong database query left join
v.2.2 add condition if param exits
*/
function dataAud($param1,$ord='DESC'){//duotics_lib v.2.2
	global $conn;
	$dA=null;
	if($param1){
	$q = sprintf('SELECT * FROM db_auditoria_detalle 
	LEFT JOIN tbl_usuario ON db_auditoria_detalle.usr_id=tbl_usuario.usr_id 
	INNER JOIN db_empleados ON tbl_usuario.emp_cod=db_empleados.emp_cod 
	WHERE db_auditoria_detalle.id_aud=%s ORDER BY db_auditoria_detalle.id %s LIMIT 1',
	SSQL($param1,'text'),
	SSQL($ord,''));
	$RS = mysqli_query($conn,$q) or die(mysqli_error($conn));
	$dA = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);	
	}
	return ($dA);	
}

/*
Datos Auditoria
v.1.0
v.2.0 -> 20210420 :: added functions
*/
function infAud($id){//duotics_lib v.2.0
	$infAud=null;
	if($id){//Verifico si existe parametro de $idA -> ID AUDITORIA
		$detAudi=dataAud($id,'ASC');
		if($detAudi){//Verifico si encuentra el registro de auditoria
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
		} else $infAud='<div>No existe detalles aun</div>';
	}else $infAud='<div>No existe registro de auditoria relacionado</div>';
return $infAud;
}
?>