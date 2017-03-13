<?php 
//SELECT PARA UN GENERARSELECT
// Select para un Listado Form HTML
//v1.0
function detRowGSel($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE %s=%s %s',
	GetSQLValueString($fieldID,''),
	GetSQLValueString($fieldVal,''),
	GetSQLValueString($table,''),
	GetSQLValueString($field,''),
	GetSQLValueString($param,'text'),
	GetSQLValueString($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}
?>