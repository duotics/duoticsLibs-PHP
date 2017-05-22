<?php //Datos de una TABLA con N Parametros
//v1.0
function detRowNP($table,$params){ //v1.0
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	$qry = sprintf("SELECT * FROM %s WHERE 1=1 ".$lP,
	SSQL($table, ''));
	$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS);
	mysql_free_result($RS);
	return ($dRS);
}
/*HOW TO USE
$paramsN[] -> Params to detRowNP, 
$paramsN[] :: important => '[]' after the array name '$paramsN'
PARAMS.
	cond -> CONDICION EACH PARAM (OR / AND)
	field -> field in 'table' of database
	comp -> comparation (= / <>)
	val -> value for parameter
*/
$paramsN[]=array(
	array("cond"=>"AND","field"=>"fiel_db","comp"=>"=","val"=>$val1),
	array("cond"=>"AND","field"=>"fiel_db","comp"=>'=',"val"=>$val1)
);
$det=detRowNP('table',$paramsN);
?>

/******************************************************************/
<?php 
//SELECT PARA UN GENERARSELECT WITH N PARAMS
// Select para un Listado Form HTML
//v0.1
function detRowGSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v1.0
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP,
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

/*HOW TO USE*/
$paramsN[]=array(
	array("cond"=>"AND","field"=>"fiel_db","comp"=>"=","val"=>$val1),
	array("cond"=>"AND","field"=>"fiel_db","comp"=>'=',"val"=>$val1)
);
$RS=detRowGSelNP('table','field_id','field_nom',$paramsN,TRUE,'field_ord','ASC');
//Used with function genSelect
echo genSelect('name_select', $RS, $valSel, 'form-control input-sm '); ?>