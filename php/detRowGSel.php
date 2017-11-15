<?php 
//SELECT PARA UN GENERARSELECT
// Select para un Listado Form HTML
//v1.0
function detRowGSel($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v1.0
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s %s',
	SSQL($fieldVal,''),
	SSQL($fieldID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

/*HOW TO USE*/
//detRowGSel('table','field_id','field_nom','field_status','1','field_nom');
detRowGSel('table','field_id','field_val','field_cond','cond',TRUE,'field_order','ASC'){

//Used with genSelect
echo genSelect('name_select', detRowGSel('table','field_id','field_nom','field_status','1','field_nom'), $valSel, 'form-control input-sm '); ?>