<?php
/* SI LOS PROCESOS SON BUCLES ENTONCES EL FALSE INICIALMENTE ES TRUE Y SE PONE FALSE CUANDO HAY UN ERROR DENTRO DEL BUCLE MAS UN BREAK*/
/* SI LOS PROCESOS SON ACCIONES NORMALES SE INICIA CON UN FALSE Y SE PONE TRUE CUANDO LA EJECUCION SE REALIZA SIN PROBLEMAS */
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion
//PROCESAMIENTO DATOS
//VERIFICA SI EL PROCESAMIENTO CORRECTO -> COMMIT :: ELSE ROLLBACK 
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysql_error();
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
?>