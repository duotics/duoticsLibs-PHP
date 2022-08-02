<?php include('../../init.php');
$showDebug=FALSE;
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
$qryU=sprintf('UPDATE table SET val=%s WHERE id=%s',
	SSQL($data['nom'], "text"),
	SSQL($id, "int"));
if(@mysql_query($qryU)){
	$vP=TRUE;
	$LOG.=$_SESSION['conf']['p']['p-upd-true'];
}else{
	$LOG.=$_SESSION['conf']['p']['p-ins-false'].mysql_error();
}
$qryI=sprintf('INSERT INTO db_items
(item_cod,item_nom,item_ref,item_des,item_price,item_price2,item_aliasurl,item_date,brand_id,item_status,item_img)
VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
SSQL($data['txt_cod'], "text"));
if(@mysql_query($qryI)){
	$vP=TRUE;
	$ids=mysql_insert_id();
	$LOG.=$_SESSION['conf']['p']['p-ins-true'];
}else{
	$LOG.=$_SESSION['conf']['p']['p-ins-false'].mysql_error();
}

$qryU=sprintf('UPDATE db_items_type SET typEst=%s WHERE md5(typID)=%s LIMIT 1',
	SSQL($val,'int'),
	SSQL($ids,'text'));
	$LOGd.=$qry.'<br>';
if(@mysql_query($qryU)){
	$vP=TRUE;
	$LOG.=$_SESSION['conf']['p']['p-est-true'];
}else{
	$LOG.=$_SESSION['conf']['p']['p-est-false'].mysql_error();
}

$det=detRow('table','id',$id);
if($det){
	$qry=sprintf('INSERT INTO tables (val) VALUES (%s)',
	SSQL($det['val'],'text'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$ids=@mysql_insert_id();
		$LOG.=$_SESSION['conf']['p']['p-clon-true'];
	}else $LOG.=$_SESSION['conf']['p']['p-clon-false'].mysql_error();
}else{
	$LOG.='<h4>No se encuentra elemento a clonar</h4>'.mysql_error();
}

/****************************************************************/
/****************************************************************/
/****************************************************************/
$goTo.='?ids='.$ids.$GotoPar;
$LOG.=mysql_error();
if($showDebug==TRUE) $LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt=$_SESSION['conf']['p']['m-ok'];
	$LOGc=$_SESSION['conf']['p']['c-ok'];
	$LOGi=$RAIZa.$_SESSION['conf']['p']['i-ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt=$_SESSION['conf']['p']['m-fail'];
	$LOGc=$_SESSION['conf']['p']['c-fail'];
	$LOGi=$RAIZa.$_SESSION['conf']['p']['i-fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>